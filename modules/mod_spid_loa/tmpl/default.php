<?php
/**
 * @package		SPiD
 * @subpackage	mod_spid_loa
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
 */

// Load the authentication source from the session.
$loa = JFactory::getApplication()->getUserState('spid.loa');

if (!$loa)
{
	echo JText::_('MOD_SPID_LOA_NONE');
}
elseif (in_array($loa, array('SpidL1', 'SpidL2', 'SpidL3')))
{
	echo JText::sprintf('MOD_SPID_LOA_LEVELOFASSURANCE', $loa);
}
else
{
	echo JText::_('MOD_SPID_LOA_UNKNOWN');
}
