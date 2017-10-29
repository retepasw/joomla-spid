<?php
/**
 * @version		3.7.5 modules/mod_spid_login/authsourcelist.php
 *
 * @package		SPiD
 * @subpackage	mod_spid_login
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
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

JFormHelper::loadFieldClass('list');

/**
 * Form Field class for the Joomla Platform.
 * Supports an HTML select list of categories
 *
 * @package     Joomla.Legacy
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldAuthsource extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.7.5
	 */
	public $type = 'Authsource';

	/**
	 * Flag to tell the field to always be in multiple values mode.
	 *
	 * @var    boolean
	 * @since  3.7.5
	 */
	protected $forceMultiple = false;

	/**
	 * Method to get the custom field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since  3.7.5
	 */
	protected function getOptions()
	{
	    JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'mod_spid_login'));

	    // Initialize variables.
	    $config = null;
	    $options = array();

		if (file_exists($metadata_file = JPATH_ROOT.'/simplespidphp/config/authsources.php'))
		{
		    require $metadata_file;
		    
		}
		elseif (file_exists($metadata_file = JPATH_ROOT.'/../simplespidphp/config/authsources.php'))
		{
		    require $metadata_file;
		}
		elseif (file_exists($metadata_file = JPATH_LIBRARIES.'/pasw/simplespidphp/config/authsources.php'))
		{
		    require $metadata_file;
		}

		if ($config)
		{
    		foreach($config as $authsource => $data)
    		{
    		    if ($data[0] == 'saml:SP')
    		    {
    		        $options[] = (object)array('value' => $authsource, 'text' => $authsource);
    		    }
    		}
		}

		if (count($options) == 0)
		{
		    $options[] = (object)array('value' => 'default-sp', 'text' => 'default-sp');
		}

		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}