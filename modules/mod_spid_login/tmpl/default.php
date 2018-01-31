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
 * @version		3.8.0
 * @since		3.7
 */

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JHtml::_('behavior.framework');
JHtml::_('jquery.framework');
JHtml::_('script', 'mod_spid_login/spid-sp-access-button.min.js', false, true);
JHtml::_('stylesheet', 'mod_spid_login/spid-sp-access-button.min.css', array(), true);
?>

<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="adminForm" class="form-inline">
	<?php if ($params->get('pretext')) : ?>
		<div class="pretext">
			<p><?php echo $params->get('pretext'); ?></p>
		</div>
	<?php endif; ?>
	<div class="spidlogin<?php echo $moduleclass_sfx; ?>">
		<div id="form-login-idp" class="control-group">
			<div class="controls">
				<input id="modspid-idp" type="hidden" name="modspid-idp" />
				<input id="modspid-authsource" type="hidden" name="modspid-authsource" value="<?php echo $params->get('authsource', 'default-sp'); ?>" />
			</div>
		</div>

	<?php 
		$buttons = ['s' => 'small', 'm' => 'medium', 'l' => 'large', 'xl' => 'xlarge']; 
		$size = $params->get('size', 'm');
		$button = $buttons[$size];
	?>
		<a href="#" class="italia-it-button italia-it-button-size-<?php echo $size; ?> button-spid" spid-idp-button="#spid-idp-button-<?php echo $button; ?>-get" aria-haspopup="true" aria-expanded="false">
			<span class="italia-it-button-icon"><img src="media/mod_spid_login/img/spid-ico-circle-bb.svg" onerror="this.src='media/mod_spid_login/img/spid-ico-circle-bb.png'; this.onerror=null;" alt="" /></span>
			<span class="italia-it-button-text"><?php echo JText::_('MOD_SPID_LOGIN_LOGIN'); ?></span>
		</a>
		<div id="spid-idp-button-<?php echo $button; ?>-get" class="spid-idp-button spid-idp-button-tip spid-idp-button-relative">
			<ul id="spid-idp-list-<?php echo $button; ?>-root-get" class="spid-idp-button-menu" aria-labelledby="spid-idp">
				<?php foreach ($metadata as $data): 
				$parse = parse_url($data['entityid']);
				if (isset($parse['host']))
				{
					$id = $parse['host'];
				}
				else
				{
					$id = $parse['path'];
				}
				if (!isset($data['description']))
				{
					$description = $id;
				}
				elseif(isset($data['description']['it']))
				{
					$description = $data['description']['it'];
				}
				elseif(isset($data['description']['en']))
				{
					$description = $data['description']['en'];
				}
				else
				{
					$description = $id;
				}
				$id = str_replace('.', '', $id);
				if (!file_exists(JPATH_BASE . '/media/mod_spid_login/img/spid-idp-' . $id . '.svg'))
				{
				    continue;
				}
				?>
	            <li class="spid-idp-button-link" data-idp="<?php echo $id; ?>">
	                <a href="#" onclick="document.getElementById('modspid-idp').value='<?php echo urlencode($data['entityid']); ?>';Joomla.submitform();return false;"><span class="spid-sr-only"><?php echo $description; ?></span><img src="media/mod_spid_login/img/spid-idp-<?php echo $id; ?>.svg" onerror="this.src='media/mod_spid_login/img/spid-idp-<?php echo $id; ?>.png'; this.onerror=null;" alt="<?php echo $description; ?>" /></a>
	            </li>
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
            var rootList = $('#spid-idp-list-".$button."-root-get');
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
