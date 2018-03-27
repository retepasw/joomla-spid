<?php
/**
 * @package		SPiD
 * @subpackage	plg_system_spid
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
 */
class plgSystemSpid extends JPlugin
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
			JLog::addLogger(array('text_file' => $this->params->get('log', 'eshiol.log.php'), 'extension' => 'plg_system_spid_file'), JLog::ALL, array('plg_system_spid'));
		}
		JLog::addLogger(array('logger' => (null !== $this->params->get('logger')) ?$this->params->get('logger') : 'messagequeue', 'extension' => 'plg_system_spid'), JLOG::ALL & ~JLOG::DEBUG, array('plg_system_spid'));
		if ($this->params->get('phpconsole') && class_exists('JLogLoggerPhpconsole'))
		{
			JLog::addLogger(array('logger' => 'phpconsole', 'extension' => 'plg_system_spid_phpconsole'),  JLOG::DEBUG, array('plg_system_spid'));
		}
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_system_spid'));

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
				JLog::add(new JLogEntry('Impossible to load SPiD IDP\'s library', JLog::DEBUG, 'plg_system_spid'));
			}
		}
	}

	/**
	 * 
	 *
	 * @return  void
	 *
	 * @since   3.8.5
	 */
	public function onAfterInitialise()
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_system_spid'));

		if (array_key_exists('SimpleSAML_Auth_State_exceptionId', $_REQUEST) && !empty($_REQUEST['SimpleSAML_Auth_State_exceptionId']))
		{
			$id = $_REQUEST['SimpleSAML_Auth_State_exceptionId'];
			$s = \SimpleSAML_Auth_State::loadExceptionState($id);
			$e = $s['SimpleSAML_Auth_State.exceptionData'];
			JLog::add(new JLogEntry(print_r($e, true), JLog::DEBUG, 'plg_system_spid'));
//			JLog::add(new JLogEntry($e->getStatus(), JLog::WARNING, 'plg_system_spid'));
//			JLog::add(new JLogEntry($e->getSubStatus(), JLog::WARNING, 'plg_system_spid'));
//			JLog::add(new JLogEntry($e->getStatusMessage(), JLog::WARNING, 'plg_system_spid'));

			$lang    = JFactory::getLanguage();
			$message = $e->getStatusMessage();
			$key     = 'PLG_SYSTEM_SPID_'.str_replace(' ', '_', strtoupper($message));
			JLog::add(new JLogEntry($lang->hasKey($key) ? JText::_($key) : JText::sprint_f('PLG_SYSTEM_SPID_ERRORCODE_UNKNOWN', $message), JLog::WARNING, 'plg_system_spid'));
		}
	}
}
