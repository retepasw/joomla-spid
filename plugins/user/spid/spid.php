<?php
/**
 * @package		SPiD
 * @subpackage	plg_user_spid
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

/**
 * @version		3.8.5
 * @since		3.7
 */
class plgUserSpid extends JPlugin
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
	 * @var    boolean
	 */
	protected $autoloadLanguage = true;

	/**
	 * Database object
	 *
	 * @var    JDatabaseDriver
	 */
	protected $db;

	/**
	 * The authentication source
	 *
	 * @var string
	 */
	protected $authsource;

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
			JLog::addLogger(array('text_file' => $this->params->get('log', 'eshiol.log.php'), 'extension' => 'plg_user_spid_file'), JLog::ALL, array('plg_user_spid'));
		}
		JLog::addLogger(array('logger' => (null !== $this->params->get('logger')) ?$this->params->get('logger') : 'messagequeue', 'extension' => 'plg_user_spid'), JLOG::ALL & ~JLOG::DEBUG, array('plg_user_spid'));
		if ($this->params->get('phpconsole') && class_exists('JLogLoggerPhpconsole'))
		{
			JLog::addLogger(array('logger' => 'phpconsole', 'extension' => 'plg_user_spid_phpconsole'),  JLOG::DEBUG, array('plg_user_spid'));
		}
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

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
				JLog::add(new JLogEntry('Impossible to load SPiD IDP\'s library', JLog::DEBUG, 'plg_user_spid'));
			}
		}

		// Load the authentication source from the session.
		$this->authsource = $this->app->getUserState('spid.authsource');
	}

	/**
	 * This is where we logout SPiD
	 *
	 * @param   array  $options  Array holding options (length, timeToExpiration)
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.8.5
	 */
	public function onUserAfterLogout($options)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

		if (class_exists('\SimpleSAML_Auth_Simple') && $this->authsource)
		{
			$as = new \SimpleSAML_Auth_Simple($this->authsource);
			if ($as->isAuthenticated())
			{
				$as->logout();
			}
		}

		return true;
	}

	/**
	 * Method to handle
	 *
	 * @param   array  $user     Holds the user data.
	 * @param   array  $options  Array holding options (remember, autoregister, group).
	 *
	 * @return  boolean  True on success.
	 *
	 * @since	3.8.5
	 */
	public function onUserLogin($user, $options = array())
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

		if (isset($user['spid']))
		{
			$this->app->setUserState('spid.authsource', $user['spid']['authsource']);
			$this->app->setUserState('spid.loa', $user['spid']['loa']);
		}

		return true;
	}

	/**
	 * Called if user fails to be logged in.
	 *
	 * @param   array  $response  Array of response data.
	 *
	 * @return  void
	 *
	 * @since   3.8.5
	 */
	public function onUserLoginFailure($response)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));
		JLog::add(new JLogEntry(print_r($response, true), JLog::DEBUG, 'plg_user_spid'));

		if (isset($response['type']) && $response['type'] == 'SPiD')
		{
			$session = \JFactory::getSession();
			$session->set('application.queue', array(
					array('message' => $response['error_message'], 'type' => 'warning')
				));
		
			if (class_exists('\SimpleSAML_Auth_Simple') && isset($response['spid']) && isset($response['spid']['authsource']))
			{
				$as = new \SimpleSAML_Auth_Simple($response['spid']['authsource']);
				if ($as->isAuthenticated())
				{
					$as->logout();
				}
			}
		}
	}

	/**
	 * @param   string     $context  The context for the data
	 * @param   integer    $data     The user id
	 *
	 * @return  boolean
	 *
	 * @since   3.8.5
	 */
	public function onContentPrepareData($context, $data)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

		if (!$this->params->get('profile', false))
		{
			return;
		}

		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.profile', 'com_users.user', 'com_users.registration', 'com_admin.profile')))
		{
			return true;
		}

		if (is_object($data))
		{
			$userId = isset($data->id) ? $data->id : 0;

			if (!isset($data->profile) and $userId > 0)
			{
				// Load the profile data from the database.
				$db = JFactory::getDbo();
				$db->setQuery(
					'SELECT profile_key, profile_value FROM #__user_profiles' .
					' WHERE user_id = ' . (int) $userId . " AND profile_key LIKE 'profile.%'" .
					' ORDER BY ordering'
					);

				try
				{
					$results = $db->loadRowList();
				}
				catch (RuntimeException $e)
				{
					$this->_subject->setError($e->getMessage());
					return false;
				}

				// Merge the profile data.
				$data->profile = array();

				foreach ($results as $v)
				{
					$k = str_replace('profile.', '', $v[0]);
					$data->profile[$k] = json_decode($v[1], true);
					if ($data->profile[$k] === null)
					{
						$data->profile[$k] = $v[1];
					}
				}
			}
		}

		return true;
	}

	/**
	 * @param   JForm    $form    The form to be altered.
	 * @param   array    $data    The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   3.8.5
	 */
	public function onContentPrepareForm($form, $data)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

		if (!$this->params->get('profile', false))
		{
			return;
		}

		if ($this->app->isSite())
		{
			return;
		}

		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}

		// Check we are manipulating a valid form.
		$name = $form->getName();
		if (!in_array($name, array('com_admin.profile', 'com_users.user', 'com_users.profile', 'com_users.registration')))
		{
			return true;
		}

		// Add the registration fields to the form.
		JForm::addFormPath(__DIR__ . '/profiles');
		$form->loadFile('profile', false);

		return true;
	}

	/**
	 * Utility method to act on a user after it has been saved.
	 *
	 * @param   array    $user     Holds the new data.
	 * @param   boolean  $isnew    True if a new is stored.
	 * @param   boolean  $success  True if data was successfully stored in the database.
	 * @param   string   $msg      Message.
	 *
	 * @return  void
	 *
	 * @since   3.8.5
	 */
	public function onUserAfterSave($data, $isnew, $success, $msg)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

		$userId = JArrayHelper::getValue($data, 'id', 0, 'int');

		if ($userId && $success && isset($data['profile']) && (count($data['profile'])))
		{
			try
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true)
					->delete($db->qn('#__user_profiles'))
					->where($db->qn('user_id') . ' = ' . (int) $userId)
					->where($db->qn('profile_key') . ' LIKE ' . $db->q('profile.%'));
				$db->setQuery($query);
				$db->execute();

				$tuples = array();
				$order = 1;

				foreach ($data['profile'] as $k => $v)
				{
					$tuples[] = '(' . $userId . ', ' . $db->q('profile.' . $k) . ', ' . $db->q(json_encode($v)) . ', ' . $order++ . ')';
				}

				$db->setQuery('INSERT INTO #__user_profiles VALUES ' . implode(', ', $tuples));
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}

		return true;
	}

	/**
	 * Remove all user profile information for the given user ID
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param   array    $user     Holds the user data
	 * @param   boolean  $success  True if user was succesfully stored in the database
	 * @param   string   $msg      Message
	 *
	 * @return  boolean
	 * 
	 * @since   3.8.5
	 */
	public function onUserAfterDelete($user, $success, $msg)
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

		if (!$success)
		{
			return false;
		}

		$userId = JArrayHelper::getValue($user, 'id', 0, 'int');

		if ($userId)
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = ' . $userId .
					" AND profile_key LIKE 'profile.%'"
					);

				$db->execute();
			}
			catch (Exception $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}

		return true;
	}
}
