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
 * @version		3.8.4
 * @since		3.7
 */

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JHtml::_('behavior.framework');
JHtml::_('jquery.framework');
JHtml::_('script', 'mod_spid_login/spid-sp-access-button.min.js', false, true);
JHtml::_('stylesheet', 'mod_spid_login/spid-sp-access-button.min.css', array(), true);

$mod_spid_login = 'mod-spid-login-' . $module->id;
?>

<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="<?php echo $mod_spid_login; ?>-form" class="form-inline">
	<?php if ($params->get('pretext')) : ?>
		<div class="pretext">
			<p><?php echo $params->get('pretext'); ?></p>
		</div>
	<?php endif; ?>
	<div class="spidlogin<?php echo $moduleclass_sfx; ?>">
		<div class="control-group">
			<div class="controls">
				<input type="hidden" name="modspid-idp" id="<?php echo $mod_spid_login; ?>-idp" />
				<input type="hidden" name="modspid-authsource" value="<?php echo $params->get('authsource', 'default-sp'); ?>" />
				<input type="hidden" name="modspid-loa" value="<?php echo $params->get('loa', 'SpidL1'); ?>" />
			</div>
		</div>

	<?php
		$buttons = ['s' => 'small', 'm' => 'medium', 'l' => 'large', 'xl' => 'xlarge'];
		$size = $params->get('size', 'm');
		$button = $buttons[$size];
	?>
		<a href="#" class="italia-it-button italia-it-button-size-<?php echo $size; ?> button-spid" spid-idp-button="#<?php echo $mod_spid_login; ?>-get" aria-haspopup="true" aria-expanded="false">
			<span class="italia-it-button-icon"><img src="media/mod_spid_login/img/spid-ico-circle-bb.svg" onerror="this.src='media/mod_spid_login/img/spid-ico-circle-bb.png'; this.onerror=null;" alt="" /></span>
			<span class="italia-it-button-text"><?php echo JText::_('MOD_SPID_LOGIN_LOGIN'); ?></span>
		</a>

		<div id="<?php echo $mod_spid_login; ?>-get" class="spid-idp-button spid-idp-button-tip spid-idp-button-relative spid-idp-button-<?php echo $button ?>-get">
			<ul id="<?php echo $mod_spid_login; ?>-root-get" class="spid-idp-button-menu" aria-labelledby="spid-idp">

				<?php $idps = array(
					'arubaid' => 	'https://loginspid.aruba.it',
					'infocertid' => 'https://identity.infocert.it',
					'intesaid' => 	'https://spid.intesa.it',
					'namirialid' => 'https://idp.namirialtsp.com/idp',
					'posteid' => 	'https://posteid.poste.it',
					'sielteid' => 	'https://identity.sieltecloud.it',
					'spiditalia' => 'https://spid.register.it',
					'timid' => 		'https://login.id.tim.it/affwebservices/public/saml2sso'
					); ?>
				<?php foreach ($idps as $idp => $entityid) : ?>
				<?php
				if (!isset($metadata[$entityid]['description']))
				{
					$description = $id;
				}
				elseif(isset($metadata[$entityid]['description']['it']))
				{
					$description = $metadata[$entityid]['description']['it'];
				}
				elseif(isset($metadata[$entityid]['description']['en']))
				{
					$description = $metadata[$entityid]['description']['en'];
				}
				else
				{
					$description = $entityid;
				}
				?>
					<?php if ($params->get('show_' . $idp, 1)) : ?>
	            <li class="spid-idp-button-link" data-idp="<?php echo $idp; ?>">
	                <a href="#" onclick="document.getElementById('<?php echo $mod_spid_login; ?>-idp').value='<?php echo urlencode($entityid); ?>';Joomla.submitform(null, document.getElementById('<?php echo $mod_spid_login; ?>-form'));return false;"><span class="spid-sr-only"><?php echo $description; ?></span><img src="media/mod_spid_login/img/spid-idp-<?php echo $idp; ?>.svg" onerror="this.src='media/mod_spid_login/img/spid-idp-<?php echo $idp; ?>.png'; this.onerror=null;" alt="<?php echo $description; ?>" /></a>
	            </li>
		 			<?php endif; ?>
	 			<?php endforeach; ?>

				<?php if ($params->get('show_infolink', true)) : ?>
				<li class="spid-idp-support-link" data-spidlink="info">
					<a href="<?php echo $params->get('url_infolink', JText::_('MOD_SPID_LOGIN_FIELD_URL_INFOLINK_DEFAULT')); ?>"><?php echo JText::_('MOD_SPID_LOGIN_INFOLINK'); ?></a>
				</li>
				<?php endif; ?>
				<?php if ($params->get('show_registrationlink', true)) : ?>
				<li class="spid-idp-support-link" data-spidlink="rich">
					<a href="<?php echo $params->get('url_registrationlink', JText::_('MOD_SPID_LOGIN_FIELD_URL_REGISTRATIONLINK_DEFAULT')); ?>"><?php echo JText::_('MOD_SPID_LOGIN_REGISTRATIONLINK'); ?></a>
				</li>
				<?php endif; ?>
				<?php if ($params->get('show_helplink', true)) : ?>
				<li class="spid-idp-support-link" data-spidlink="help">
					<a href="<?php echo $params->get('url_helplink', JText::_('MOD_SPID_LOGIN_FIELD_URL_HELPLINK_DEFAULT')); ?>"><?php echo JText::_('MOD_SPID_LOGIN_HELPLINK'); ?></a>
				</li>
				<?php endif; ?>
	        </ul>
	    </div>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<?php if ($params->get('posttext')) : ?>
		<div class="posttext">
			<p><?php echo $params->get('posttext'); ?></p>
		</div>
	<?php endif; ?>
</form>

<?php
// Attach diff to document
JFactory::getDocument()->addScriptDeclaration("
	(function ($){
		$(document).ready(function (){
            var rootList = $('#" . $mod_spid_login . "-root-get');
            var idpList = rootList.children('.spid-idp-button-link');
            var lnkList = rootList.children('.spid-idp-support-link');
            while (idpList.length) {
                rootList.append(idpList.splice(Math.floor(Math.random() * idpList.length), 1)[0]);
            }
            rootList.append(lnkList);
		});
	})(jQuery);
	"
);
?>
