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
defined('_JEXEC') or die();

/**
 *
 * @version 3.8.7
 */
class plgSystemSpid extends JPlugin
{

	/**
	 * Application object.
	 *
	 * @var JApplicationCms
	 * @since 3.8.6
	 */
	protected $app;

	/**
	 * The base path of the library
	 *
	 * @var string
	 * @since 3.8.6
	 */
	protected $basePath;

	/**
	 * Load the language file on instantiation.
	 *
	 * @var boolean
	 */
	protected $autoloadLanguage = true;

	/**
	 * Constructor
	 *
	 * @param object $subject
	 *        	The object to observe
	 * @param array $config
	 *        	An array that holds the plugin configuration
	 */
	function __construct (&$subject, $config)
	{
		parent::__construct($subject, $config);
		
		if ($this->params->get('debug') || defined('JDEBUG') && JDEBUG)
		{
			JLog::addLogger(
					array(
							'text_file' => $this->params->get('log', 'eshiol.log.php'),
							'extension' => 'plg_system_spid_file'
					), JLog::ALL, array(
							'plg_system_spid'
					));
		}
		JLog::addLogger(
				array(
						'logger' => (null !== $this->params->get('logger')) ? $this->params->get('logger') : 'messagequeue',
						'extension' => 'plg_system_spid'
				), JLOG::ALL & ~ JLOG::DEBUG, array(
						'plg_system_spid'
				));
		if ($this->params->get('phpconsole') && class_exists('JLogLoggerPhpconsole'))
		{
			JLog::addLogger(array(
					'logger' => 'phpconsole',
					'extension' => 'plg_system_spid_phpconsole'
			), JLOG::DEBUG, array(
					'plg_system_spid'
			));
		}
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_system_spid'));
		
		// Use Composers autoloading
		if (file_exists(JPATH_ROOT . '/simplespidphp/lib/_autoload.php'))
		{
			$this->basePath = JPATH_ROOT . '/simplespidphp';
		}
		elseif (file_exists(JPATH_ROOT . '/../simplespidphp/lib/_autoload.php'))
		{
			$this->basePath = JPATH_ROOT . '/../simplespidphp';
		}
		else
		{
			$this->basePath = null;
		}
		$isAdmin = JFactory::getApplication()->isClient('administrator') && ! JFactory::getUser()->guest;
		if ($this->basePath)
		{
			include $this->basePath . '/config/authsources.php';
			
			if (file_exists($this->basePath . '/cert/' . $config['default-sp']['privatekey']))
			{
				if (! class_exists('SimpleSAML'))
				{
					require $this->basePath . '/lib/_autoload.php';
				}
			}
			elseif ($isAdmin)
			{
				JLog::add(new JLogEntry(JText::_('PLG_SYSTEM_SPID_CERTNOTFOUND'), JLog::ERROR, 'plg_system_spid'));
			}
		}
		elseif ($isAdmin)
		{
			JLog::add(new JLogEntry(JText::_('PLG_SYSTEM_SPID_SIMPLESPIDPHPREQUIRED'), JLog::ERROR, 'plg_system_spid'));
		}
		
		$save = false;
		if (! $this->params->get('cert_cn'))
		{
			$this->params->set('cert_cn', $_SERVER['SERVER_NAME']);
			$save = true;
		}
		
		if (! $this->params->get('cert_o'))
		{
			$this->params->set('cert_o', JFactory::getConfig()->get('sitename'));
			$save = true;
		}
		
		if ($save)
		{
			// Save the parameters
			$table = JTable::getInstance('extension');
			$table->load(array(
					'name' => 'plg_system_spid'
			));
			$table->bind(array(
					'params' => $this->params->toString()
			));
			
			// check for error
			if (! $table->check())
			{
				echo $table->getError();
				return false;
			}
			
			// Save to database
			if (! $table->store())
			{
				echo $table->getError();
				return false;
			}
		}
	}

	/**
	 *
	 * @return void
	 *
	 * @since 3.8.5
	 */
	public function onAfterInitialise ()
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_system_spid'));
		
		if (array_key_exists('SimpleSAML_Auth_State_exceptionId', $_REQUEST) && ! empty($_REQUEST['SimpleSAML_Auth_State_exceptionId']))
		{
			$id = $_REQUEST['SimpleSAML_Auth_State_exceptionId'];
			$s = \SimpleSAML_Auth_State::loadExceptionState($id);
			$e = $s['SimpleSAML_Auth_State.exceptionData'];
			$lang = JFactory::getLanguage();
			$message = $e->getMessage();
			$m = str_replace(' ', '_', strtoupper($message));
			$esfx = (strpos($m, '_ERRORCODE_NR') !== false) ? substr($m, (strpos($m, '_ERRORCODE_NR') + 1)) : $m;
			$key = 'PLG_SYSTEM_SPID_' . $esfx;
			JLog::add(
					new JLogEntry($lang->hasKey($key) ? JText::_($key) : JText::sprintf('PLG_SYSTEM_SPID_ERRORCODE_UNKNOWN', $message), JLog::WARNING,
							'plg_system_spid'));
		}
	}

	public function onAjaxGenCertificate ()
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_system_spid'));
		
		$input = $this->app->input;
		$method = $input->getMethod();
		
		$dn = array();
		if ($input->$method->get('c'))
			$dn["countryName"] = $input->$method->get('c');
		if ($input->$method->get('st'))
			$dn["stateOrProvinceName"] = $input->$method->get('st');
		if ($input->$method->get('l'))
			$dn["localityName"] = $input->$method->get('l');
		if ($input->$method->get('o'))
			$dn["organizationName"] = $input->$method->get('o');
		if ($input->$method->get('ou'))
			$dn["organizationalUnitName"] = $input->$method->get('ou');
		if ($input->$method->get('cn'))
			$dn["commonName"] = $input->$method->get('cn');
		$dn["emailAddress"] = JFactory::getConfig()->get('mailfrom');
		
		// Generate a new private (and public) key pair
		$privkey = openssl_pkey_new(array(
				'private_key_bits' => 2048,
				'private_key_type' => OPENSSL_KEYTYPE_RSA
		));
		
		$response = array();
		$response["success"] = true;
		if ($privkey === false)
		{
			$response["success"] = false;
			while (($e = openssl_error_string()) !== false)
			{
				$response["messages"]["error"][] = array(
						$e
				);
			}
			
			echo json_encode($response);
			JFactory::getApplication()->close();
			return;
		}
		
		// Generate a certificate signing request
		$csr = openssl_csr_new($dn, $privkey, array(
				'digest_alg' => 'sha256'
		));
		JLog::add(new JLogEntry($csr, JLog::DEBUG, 'plg_system_spid'));
		
		if ($csr === false)
		{
			$response["success"] = false;
			while (($e = openssl_error_string()) !== false)
			{
				$response["messages"]["error"][] = array(
						$e
				);
			}
			
			echo json_encode($response);
			JFactory::getApplication()->close();
			return;
		}
		
		// Generate a self-signed cert, valid for 20 years
		$days = $input->$method->get('days', 7305);
		$x509 = openssl_csr_sign($csr, null, $privkey, $days, array(
				'digest_alg' => 'sha256'
		));
		
		// Save your private key, CSR and self-signed cert for later use
		openssl_csr_export($csr, $csrout);
		// ob_start(); var_dump($csrout); JLog::add(new
		// JLogEntry(ob_get_contents(), JLog::DEBUG, 'plg_system_spid'));
		// ob_end_clean();
		
		$path = $this->basePath . '/cert';
		$now = new JDate();
		$suffix = $now->format('YmdHis');
		if (JFile::exists($path . '/saml.crt'))
		{
			JFile::move('saml.crt', 'saml.' . $suffix . '.crt', $path);
		}
		openssl_x509_export($x509, $certout);
		// ob_start(); var_dump($certout); JLog::add(new
		// JLogEntry(ob_get_contents(), JLog::DEBUG, 'plg_system_spid'));
		// ob_end_clean();
		file_put_contents($path . '/saml.crt', $certout);
		
		if (JFile::exists($path . '/saml.pem'))
		{
			JFile::move('saml.pem', 'saml.' . $suffix . '.pem', $path);
		}
		// openssl_pkey_export($privkey, $pkeyout,
		// $input->$method->get('password'));
		openssl_pkey_export($privkey, $pkeyout);
		// ob_start(); var_dump($pkeyout); JLog::add(new
		// JLogEntry(ob_get_contents(), JLog::DEBUG, 'plg_system_spid'));
		// ob_end_clean();
		file_put_contents($path . '/saml.pem', $pkeyout);
		
		$response["messages"]["success"][] = JText::_('PLG_SYSTEM_SPID_CERT_OK');
		
		echo json_encode($response);
		JLog::add(new JLogEntry(json_encode($response), JLog::DEBUG, 'plg_system_spid'));
		
		// Close the application.
		JFactory::getApplication()->close();
	}
}
