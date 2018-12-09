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
 * @version		3.8.5
 * @since		3.7
 */

// Include the login functions only once
JLoader::register('ModLoginHelper', dirname(__DIR__) . '/mod_login/helper.php');

$moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$type               = ModLoginHelper::getType();
$return             = ModLoginHelper::getReturnUrl($params, $type);
$layout             = $params->get('layout', 'default');

if (file_exists(JPATH_ROOT.'/simplespidphp/metadata/saml20-idp-remote.php'))
{
	$basepath = JPATH_ROOT . '/simplespidphp';
}
elseif (file_exists(JPATH_ROOT.'/../simplespidphp/metadata/saml20-idp-remote.php'))
{
	$basepath = JPATH_ROOT . '/../simplespidphp';
}
elseif (file_exists(JPATH_LIBRARIES.'/pasw/simplespidphp/metadata/saml20-idp-remote.php'))
{
	$basepath = JPATH_LIBRARIES . '/pasw/simplespidphp';
}
else
{
	$basepath = '';
}

if ($basepath)
{
	include $basepath . '/config/authsources.php';
	
	if (file_exists($basepath . '/cert/' . $config['default-sp']['privatekey']))
	{
		require $basepath . '/metadata/saml20-idp-remote.php';
		require JModuleHelper::getLayoutPath('mod_spid_login', $layout);
	}
	else
	{
		JLog::add(new JLogEntry(JText::_('MOD_SPID_LOGIN_CERTNOTFOUND'), JLog::DEBUG, 'mod_spid_login'));
	}
} 
else
{
	JLog::add(new JLogEntry('MOD_SPID_LOGIN_METADATANOTFOUND', JLog::DEBUG, 'mod_spid_login'));
}
