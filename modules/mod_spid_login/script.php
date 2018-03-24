<?php
/**
 * @package		SPiD
 * @subpackage	mod_spid_login
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

// no direct access
defined('_JEXEC') or die;

/**
 * Script file of SPiD module
 *
 * @version		3.8.0
 */
class mod_spid_loginInstallerScript
{
	/**
	 * Method to run after an install/update/uninstall method
	 * $parent is the class calling this method
	 * $type is the type of change (install, update or discover_install)
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		JLog::add(new JLogEntry(__METHOD__, JLOG::DEBUG, 'mod_spid_login'));

		if (($type == 'install') || ($type == 'update'))
		{
			if (file_exists($metadata_file = JPATH_ROOT.'/simplespidphp/metadata/saml20-idp-remote.php'))
			{
				JLog::add(new JLogEntry('Updating SPiD IDP\'s metadata: saml20-idp-remote.php', JLOG::DEBUG, 'mod_spid_login'));
				// Copy idp metadata file
				JFile::copy(__DIR__.'/saml20-idp-remote.php', $metadata_file);
			}
			elseif (file_exists($metadata_file = JPATH_ROOT.'/../simplespidphp/metadata/saml20-idp-remote.php'))
			{
				JLog::add(new JLogEntry('Updating SPiD IDP\'s metadata: saml20-idp-remote.php', JLOG::DEBUG, 'mod_spid_login'));
				// Copy idp metadata file
				JFile::copy(__DIR__.'/saml20-idp-remote.php', $metadata_file);
			}
			elseif (file_exists($metadata_file = JPATH_LIBRARIES.'/pasw/simplespidphp/metadata/saml20-idp-remote.php'))
			{
				JLog::add(new JLogEntry('Updating SPiD IDP\'s metadata: saml20-idp-remote.php', JLOG::DEBUG, 'mod_spid_login'));
				// Copy idp metadata file
				JFile::copy(__DIR__.'/saml20-idp-remote.php', $metadata_file);
			}
			else
			{
				JLog::add(new JLogEntry('Impossible to update SPiD IDP\'s metadata: saml20-idp-remote.php', JLOG::WARNING, 'mod_spid_login'));
			}
		}
	}
}