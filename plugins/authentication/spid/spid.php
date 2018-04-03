<?php
/**
 * @package		SPiD
 * @subpackage	plg_authentication_spid
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2017, 2018 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * SPiD for Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License
 * or other free or open source software licenses.
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * @version		3.8.5
 * @since		3.7
 */
class plgAuthenticationSpid extends JPlugin
{
	/**
	 * Application object.
	 *
	 * @var    JApplicationCms
	 * @since  3.8.5
	 */
	protected $app;

	/**
	 * Load the language file on instantiation.
	 *
	 * @var	boolean
	 */
	protected $autoloadLanguage = true;

	/**
	 * Constructor
	 *
	 * @param  object  $subject  The object to observe
	 * @param  array   $config   An array that holds the plugin configuration
	 */
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		if ($this->params->get('debug') || defined('JDEBUG') && JDEBUG)
		{
			JLog::addLogger(array('text_file' => $this->params->get('log', 'eshiol.log.php'), 'extension' => 'plg_authentication_spid_file'), JLog::ALL, array('plg_authentication_spid'));
		}
		JLog::addLogger(array('logger' => (null !== $this->params->get('logger')) ?$this->params->get('logger') : 'messagequeue', 'extension' => 'plg_authentication_spid'), JLOG::ALL & ~JLOG::DEBUG, array('plg_authentication_spid'));
		if ($this->params->get('phpconsole') && class_exists('JLogLoggerPhpconsole'))
		{
			JLog::addLogger(array('logger' => 'phpconsole', 'extension' => 'plg_authentication_spid_phpconsole'),  JLOG::DEBUG, array('plg_authentication_spid'));
		}
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_authentication_spid'));

		// Use Composers autoloading
		if (!class_exists('SimpleSAML'))
		{
			if (file_exists($metadata_file = JPATH_ROOT.'/simplespidphp/lib/_autoload.php'))
			{
				require $metadata_file;
			}
			elseif (file_exists($metadata_file = JPATH_ROOT.'/../simplespidphp/lib/_autoload.php'))
			{
				require $metadata_file;
			}
			elseif (file_exists($metadata_file = JPATH_LIBRARIES.'/retepasw/simplespidphp/lib/_autoload.php'))
			{
				require $metadata_file;
			}
			else
			{
				JLog::add(new JLogEntry('Impossible to load SPiD IDP\'s library', JLog::DEBUG, 'plg_authentication_spid'));
			}
		}
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @param   array   $credentials  Array holding the user credentials
	 * @param   array   $options	  Array of extra options
	 * @param   object  &$response	Authentication response object
	 *
	 * @return  boolean
	 */
	public function onUserAuthenticate($credentials, $options, &$response)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_authentication_spid'));

		if (!class_exists('\SimpleSAML_Auth_Simple')) return true;

		$input  = $this->app->input;
		$method = $input->getMethod();

		$idp = $input->$method->get('modspid-idp', '', 'RAW');
		if (empty($idp))
		{
			return;
		}

		$response->type = 'SPiD';

		$options = array();
		$options['saml:idp'] = urldecode($idp);

		$authsource = $input->$method->get('modspid-authsource', 'default-sp', 'RAW');
		$loa        = $input->$method->get('modspid-loa', 'SpidL1', 'RAW');

		// Require the user to be authenticated.
		$options['ErrorURL'] = JUri::root();
		$options['saml:AuthnContextClassRef'] = 'https://www.spid.gov.it/' . $loa;

		JLog::add(new JLogEntry('Authenticating...', JLog::DEBUG, 'plg_authentication_spid'));
		JLog::add(new JLogEntry($authsource, JLog::DEBUG, 'plg_authentication_spid'));
		JLog::add(new JLogEntry(print_r($options, true), JLog::DEBUG, 'plg_authentication_spid'));

		$as = new SimpleSAML_Auth_Simple($authsource);
		$as->requireAuth($options);

		if ($as->isAuthenticated())
		{
			JLog::add(new JLogEntry('User is authenticated', JLog::DEBUG, 'plg_authentication_spid'));
			$this->app->setUserState('spid.authsource', $authsource);
			$attributes = $as->getAttributes();
			JLog::add(new JLogEntry(print_r($attributes, true), JLog::DEBUG, 'plg_authentication_spid'));

			if (!isset($attributes['fiscalNumber']))
			{
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::sprintf('PLG_AUTHENTICATION_SPID_ATTRIBUTE_ERROR', 'fiscalNumber');
				
				return;
			}

			if (!isset($attributes['name']))
			{
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::sprintf('PLG_AUTHENTICATION_SPID_ATTRIBUTE_ERROR', 'name');
				
				return;
			}

			if (!isset($attributes['familyName']))
			{
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::sprintf('PLG_AUTHENTICATION_SPID_ATTRIBUTE_ERROR', 'familyName');
				
				return;
			}

			if ($this->params->get('removeTINPrefix', true))
			{
				if( ($i = strpos($attributes['fiscalNumber'][0], '-')) !== false)
				{
					$attributes['fiscalNumber'][0] = substr($attributes['fiscalNumber'][0], $i + 1);
				}
			}
			$username = $attributes['fiscalNumber'][0];
			$uparams = JComponentHelper::getParams('com_users');

			require_once __DIR__ . '/fiscalnumber.php';
			$fiscalNumber = new FiscalNumber((($i = strpos($attributes['fiscalNumber'][0], '-')) !== false) 
				? substr($attributes['fiscalNumber'][0], $i + 1) 
				: $attributes['fiscalNumber'][0]);
			
			$spid_response = array(
				'loa'          => $loa,
				'authsource'   => $authsource,
//				'spidCode'     => $attributes['spidCode'][0],
				'fiscalNumber' => $fiscalNumber->getFiscalNumber(),
				'firstName'    => $attributes['name'][0],
				'lastName'     => $attributes['familyName'][0],
				'gender'       => isset($attributes['gender']) 
					? $attributes['gender'][0] 
					: $fiscalNumber->getGender(),
				'dob'          => isset($attributes['dateOfBirth']) 
					? date("d-m-Y", strtotime($attributes['dateOfBirth'][0]))
					: $fiscalNumber->getBirthDate(),
				'birthPlace'   => isset($attributes['placeOfBirth'])
					? $attributes['placeOfBirth'][0]
					: $fiscalNumber->getBirthPlace(),
				'email'        => $attributes['email'][0],
			);
			JLog::add(new JLogEntry(print_r($spid_response, true), JLog::DEBUG, 'plg_authentication_spid'));

			if (JUser::getInstance($username)->id)
			{
				$response->spid = $spid_response;

				$minimumLoA     = $this->getProfile(JUser::getInstance($username)->id, 'loa', $this->params->get('loa', 'SpidL1'));

				if ($loa < $minimumLoA)
				{
					$response->status        = JAuthentication::STATUS_FAILURE;
					$response->error_message = JText::sprintf('PLG_AUTHENTICATION_SPID_LOA_ERROR', $loa, $minimumLoA);

					return;
				}

				$response->status    = JAuthentication::STATUS_SUCCESS;
				$response->username  = $username;
				$response->email     = JStringPunycode::emailToPunycode($spid_response['email']);
				$response->fullname  = $spid_response['firstName'] . ' ' . $spid_response['lastName'];
				$response->gender    = $spid_response['gender'];
				$response->birthdate = $spid_response['dob'];
			}
			else
			{
				if ($allowEmailAuthentication = $this->params->get('allowEmailAuthentication', false))
				{
					// Get the database object and a new query object.
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);

					// Build the query.
					$query->select('username')
						->from('#__users')
						->where('email = ' . $db->q(JStringPunycode::emailToPunycode($spid_response['email'])));

					// Set and query the database.
					$db->setQuery($query);
					$username_new = $db->loadResult();

					if ($username_new)
					{
						$response->spid = $spid_response;

						$minimumLoA = $this->getProfile(JUser::getInstance($username_new)->id, 'loa') ?: $this->params->get('loa', 'SpidL1');

						if ($loa < $minimumLoA)
						{
							$response->status        = JAuthentication::STATUS_FAILURE;
							$response->error_message = JText::sprintf('PLG_AUTHENTICATION_SPID_LOA_ERROR', $loa, $minimumLoA);

							return;
						}

						if ($allowEmailAuthentication == 2)
						{
							$query = $db->getQuery(true);

							// Build the query.
							$query->update('#__users')
								->set('username = ' . $db->q($spid_response['fiscalNumber']))
								->where('email = ' . $db->q(JStringPunycode::emailToPunycode($spid_response['email'])));

							// Set and query the database.
							$db->setQuery($query);

							try
							{
								$db->execute();
								$username_new = $spid_response['fiscalNumber'];
								$this->app->enqueueMessage(JText::sprintf('PLG_AUTHENTICATION_SPID_PROFILE_UPDATE_SUCCESS', $username), 'notice');
							}
							catch (Exception $e)
							{
							}
						}

						$response->status    = JAuthentication::STATUS_SUCCESS;
						$response->username  = $username_new;
						$response->email     = JStringPunycode::emailToPunycode($spid_response['email']);
						$response->fullname  = $spid_response['firstName'] . ' ' . $spid_response['lastName'];
						$response->gender    = $spid_response['gender'];
						$response->birthdate = $spid_response['dob'];

						return true;
					}
				}

				if ($this->params->get('allowUserRegistration', $uparams->get('allowUserRegistration')))
				{
					// user data
					$data['name']     = $spid_response['firstName'] . ' ' . $spid_response['lastName'];
					$data['username'] = $username;
					$data['email']    = $data['email1']    = $data['email2']    = JStringPunycode::emailToPunycode($spid_response['email']);
					$data['password'] = $data['password1'] = $data['password2'] = JUserHelper::genRandomPassword();

					$data['profile']['spid'] = true;
					foreach (array('fiscalNumber', 'firstName', 'lastName', 'gender', 'birthPlace', 'dob') as $k)
					{
						$data['profile'][$k] = $spid_response[$k];
					}

					// Get the model and validate the data.
					jimport('joomla.application.component.model');
					require_once JPATH_BASE . '/components/com_users/models/registration.php';
					JModelLegacy::addIncludePath(__DIR__);
					$model = JModelLegacy::getInstance('Registration', 'SpidModel');

					$return = $model->register($data);

					if ($return === false)
					{
						$errors = $model->getErrors();
						$response->status = JAuthentication::STATUS_FAILURE;

						// Get the database object and a new query object.
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);

						// Build the query.
						$query->select('COUNT(*)')
							->from('#__users')
							->where('email = ' . $db->q($data['email']));

						// Set and query the database.
						$db->setQuery($query);
						$duplicate = (bool) $db->loadResult();

						$response->message = ($duplicate ? JText::_('PLG_AUTHENTICATION_SPID_REGISTER_EMAIL1_MESSAGE') : 'USER NOT EXISTS AND FAILED THE CREATION PROCESS');

						$login_url = JUri::getInstance();
						$this->app->redirect($login_url, $response->message, 'error');
					}

					$user = JUser::getInstance($username);
					if (($user->block == 0) && (!$user->activation))
					{
						$response->spid = $spid_response;

						$minimumLoA = $this->getProfile($user->id, 'loa') ?: $this->params->get('loa', 'SpidL1');

						if ($loa < $minimumLoA)
						{
							$response->status        = JAuthentication::STATUS_FAILURE;
							$response->error_message = JText::sprintf('PLG_AUTHENTICATION_SPID_LOA_ERROR', $loa, $minimumLoA);

							return;
						}

						$session = JFactory::getSession();
						$session->set('user', $user);

						$response->status         = JAuthentication::STATUS_SUCCESS;
						$response->username       = $username;
						$response->email          = $data['email'];
						$response->fullname       = $data['name'];
						$response->password_clear = $data['password'];
						$response->gender         = $spid_response['gender'];
						$response->birthdate      = $spid_response['dob'];
					}

					// Flush the data from the session.
					$this->app->setUserState('com_users.registration.data', null);

					// Redirect to the profile screen.
					JFactory::getLanguage()->load('com_users', JPATH_SITE);
					if ($return === 'adminactivate')
					{
						$this->app->enqueueMessage(JText::_('PLG_AUTHENTICATION_SPID_REGISTRATION_COMPLETE_VERIFY'));
						$this->app->redirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
					}
					elseif ($return === 'useractivate')
					{
						$this->app->enqueueMessage(JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));
						$this->app->redirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
					}
					else
					{
						$this->app->enqueueMessage(JText::_('COM_USERS_REGISTRATION_SAVE_SUCCESS'));
						$this->app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
					}
				}
				else
				{
					// Invalid user
					$response->status        = JAuthentication::STATUS_FAILURE;
					$response->error_message = JText::_('JGLOBAL_AUTH_NO_USER');
					JLog::add(new JLogEntry(JText::_('JGLOBAL_AUTH_NO_USER'), JLog::DEBUG, 'plg_authentication_spid'));
				}
			}

			return true;
		}
	}

	function generatePassword()
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
		$pwlen = 20;
		$pw = '';
		$bytes = openssl_random_pseudo_bytes($pwlen);
		for ($i = 0; $i < $pwlen; $i++) {
			$pw .= $chars[ord($bytes[$i]) % strlen($chars)];
		}
		return $pw;
	}

	/**
	 * @param   integer		$userid		The user id
	 * @param	string		$key		The profile key
	 * @param	string		$default	The default value
	 *
	 * @return  string
	 *
	 * @since   3.8.5
	 */
	private function getProfile($userid, $key, $default = '')
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_authentication_spid'));

		$value = '';
		$params = new Registry(JPluginHelper::getPlugin('user', 'spid')->params);
		if ($params->get('profile', false))
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select($db->qn('profile_value'))
				->from($db->qn('#__user_profiles'))
				->where($db->qn('user_id') . ' = ' . (int)$userid)
				->where($db->qn('profile_key') . ' = ' . $db->q('profile.' . $key));
			$db->setQuery($query);
			$value = json_decode($db->LoadResult());
		}

		return $value ?: $default;
	}
}
