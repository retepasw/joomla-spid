<?php
/**
 * @version		3.7.2 plugins/user/spid/spid.php
 *
 * @package		SPiD
 * @subpackage	plg_user_spid
 * @since		3.7
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

class plgUserSpid extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.7
	 */
	protected $autoloadLanguage = true;

	/**
	 * Database object
	 *
	 * @var    JDatabaseDriver
	 * @since  3.7
	 */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param  object  $subject  The object to observe
	 * @param  array   $config   An array that holds the plugin configuration
	 * @since  3.7
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
	}

	/**
	 * Method to handle any logout logic and report back to the subject.
	 *
	 * @param   array  $user     Holds the user data.
	 * @param   array  $options  Array holding options (client, ...).
	 *
	 * @return  boolean  Always returns true.
	 *
	 * @since   3.7
	 */
	public function onUserLogout($user, $options = array())
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_user_spid'));

		// Load the authentication source from the session.
		$authsource = JFactory::getSession()->get('spid.authsource', 'default-sp');
		
		$as = new SimpleSAML_Auth_Simple($authsource);
		$as->logout();

		return true;
	}
}
