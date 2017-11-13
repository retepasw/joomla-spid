<?php
/**
 * @package		SPiD
 * @subpackage	plg_authentication_spid
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2017 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * SPiD for Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License
 * or other free or open source software licenses.
 */

defined('_JEXEC') or die;

/**
 * @version		3.8.0
 * @since		3.7
 */
class plgAuthenticationSpid extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
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
	 * @param   array   $options      Array of extra options
	 * @param   object  &$response    Authentication response object
	 *
	 * @return  boolean
	 */
	public function onUserAuthenticate($credentials, $options, &$response)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_authentication_spid'));

		$app    = JFactory::getApplication();
		$input  = $app->input;
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
		// Require the user to be authenticated.
		/**
		$options['saml:AuthnContextClassRef'] = 'https://www.spid.gov.it/SpidL1';
		$options['samlp:RequestedAuthnContext'] = array("Comparison" => "minimum");
		*/
		$options['ErrorURL'] = JUri::root();
		$as = new SimpleSAML_Auth_Simple($authsource);
		$as->requireAuth($options);

		if ($as->isAuthenticated())
		{
			JLog::add(new JLogEntry('User is authenticated', JLog::DEBUG, 'plg_authentication_spid'));
			$attributes = $as->getAttributes();
			$username = $attributes['fiscalNumber'][0];
			$uparams = JComponentHelper::getParams('com_users');

			if (JUser::getInstance($username)->id)
			{
				$response->status = JAuthentication::STATUS_SUCCESS;
				$response->username = $username;
				$response->email = JStringPunycode::emailToPunycode($attributes['email'][0]);
				$response->fullname = $attributes['name'][0].' '.$attributes['familyName'][0];

				// Save the authentication source in the session.
				JFactory::getSession()->set('spid.authsource', $authsource);
			}
			elseif (strtoupper(substr($username, 0, 6)) !== "TINIT-")
			{
			}
			elseif (JUser::getInstance($username = substr($username, 6))->id)
			{
				$response->status = JAuthentication::STATUS_SUCCESS;
				$response->username = $username;
				$response->email = JStringPunycode::emailToPunycode($attributes['email'][0]);
				$response->fullname = $attributes['name'][0].' '.$attributes['familyName'][0];

				// Save the authentication source in the session.
				JFactory::getSession()->set('spid.authsource', $authsource);
			}
			elseif ($this->params->get('allowUserRegistration', $uparams->get('allowUserRegistration')))
			{
				// user data
				$data['name'] = $attributes['name'][0].' '.$attributes['familyName'][0];
				$data['username'] = $username;
				$data['email'] = $data['email1'] = $data['email2'] = JStringPunycode::emailToPunycode($attributes['email'][0]);
				$data['password'] = $data['password1'] = $data['password2'] = JUserHelper::genRandomPassword();

				// Get the model and validate the data.
				jimport('joomla.application.component.model');
				require_once JPATH_BASE . '/components/com_users/models/registration.php';
				JModelLegacy::addIncludePath(__DIR__);
				$model = JModelLegacy::getInstance('Registration', 'SpidModel');

				$return = $model->register($data);

				if ($return === false) {
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
					$app->redirect($login_url, $response->message, 'error');
				}

				$user = JUser::getInstance($username);
				if (($user->block == 0) && (!$user->activation))
				{
					$session = JFactory::getSession();
					$session->set('user', $user);

					$response->status = JAuthentication::STATUS_SUCCESS;
					$response->username = $username;
					$response->email = $data['email'];
					$response->fullname = $data['name'];
					$response->password_clear = $data['password'];
				}

				// Flush the data from the session.
				$app->setUserState('com_users.registration.data', null);

				// Redirect to the profile screen.
				JFactory::getLanguage()->load('com_users', JPATH_SITE);
				if ($return === 'adminactivate')
				{
					$app->enqueueMessage(JText::_('PLG_AUTHENTICATION_SPID_REGISTRATION_COMPLETE_VERIFY'));
					$app->redirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
				}
				elseif ($return === 'useractivate')
				{
					$app->enqueueMessage(JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));
					$app->redirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
				}
				else
				{
					$app->enqueueMessage(JText::_('COM_USERS_REGISTRATION_SAVE_SUCCESS'));
					$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
				}
			}
			else
			{
				// Invalid user
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::_('JGLOBAL_AUTH_NO_USER');
				JLog::add(new JLogEntry(JText::_('JGLOBAL_AUTH_NO_USER'), JLog::DEBUG, 'plg_authentication_spid'));
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
}
