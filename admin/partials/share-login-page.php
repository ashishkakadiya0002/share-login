<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$setup_complete = get_option('slogin_setup_complete', false);
$sitetype = $setup_complete ? get_option('slogin_sitetype', '') : '';
?>

<?php if(!$setup_complete || $sitetype == ''): ?>

<div class="main-content mt-2 mr-1">
    <div class="ui placeholder segment">
    <div class="ui icon header">
        <i class="pencil alternate icon"></i>
        Please complete your site setup.
    </div>
    <div class="inline">
        <a href="<?php echo esc_url(admin_url('admin.php?page=share-login&setup=1')); ?>" class="ui primary button">Setup</a>
    </div>
    </div>
</div>

<?php elseif($sitetype == 'main-site'): ?>

<?php require_once SLOGIN_PLUGIN_PATH . 'admin/partials/share-login-main-site.php'; ?>

<?php elseif($sitetype == 'sync-login'): ?>

<?php require_once SLOGIN_PLUGIN_PATH . 'admin/partials/share-login-sync-login.php'; ?>

<?php endif; ?>