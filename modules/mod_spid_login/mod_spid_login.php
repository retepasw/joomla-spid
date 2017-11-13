<?php
/**
 * @package		SPiD
 * @subpackage	mod_spid_login
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

// no direct access
defined('_JEXEC') or die;

/**
 * @version		3.8.0
 * @since		3.7
 */

// Include the login functions only once
JLoader::register('ModLoginHelper', dirname(__DIR__) . '/mod_login/helper.php');

$moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$type               = ModLoginHelper::getType();
$return             = ModLoginHelper::getReturnUrl($params, $type);
$layout             = $params->get('layout', 'default');

if (file_exists($metadata_file = JPATH_ROOT.'/simplespidphp/metadata/saml20-idp-remote.php'))
{
	require $metadata_file;
	require JModuleHelper::getLayoutPath('mod_spid_login', $layout);
}
elseif (file_exists($metadata_file = JPATH_ROOT.'/../simplespidphp/metadata/saml20-idp-remote.php'))
{
	require $metadata_file;
	require JModuleHelper::getLayoutPath('mod_spid_login', $layout);
}
elseif (file_exists($metadata_file = JPATH_LIBRARIES.'/pasw/simplespidphp/metadata/saml20-idp-remote.php'))
{
	require $metadata_file;
	require JModuleHelper::getLayoutPath('mod_spid_login', $layout);
}
else
{
	JLog::add(new JLogEntry('Impossible to load SPiD IDP\'s metadata: saml20-idp-remote.php', JLog::DEBUG, 'mod_spid_login'));
}
