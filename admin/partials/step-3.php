<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$sitetype = get_option('slogin_sitetype', '');

if($sitetype == 'main-site'){
    $main_site_secret_key = !empty(get_option('slogin_main_site_secret_key')) ? get_option('slogin_main_site_secret_key') : Share_Login_Helper::generateRandomString(50);
    $sync_site_url = !empty(get_option('slogin_sync_site_url')) ? get_option('slogin_sync_site_url') : '';
}elseif($sitetype == 'sync-login'){

    $main_site_url = !empty(get_option('slogin_main_site_url')) ? get_option('slogin_main_site_url') : '';
    $main_site_secret_key = !empty(get_option('slogin_main_site_secret_key')) ? get_option('slogin_main_site_secret_key') : '';

}
?>

<div class="ui bottom attached red tiny message hidden" id="error-message">
    <i class="close icon"></i>
    <div class="header">
        Site Settings Saved Failed.
    </div>
</div>
<form method="POST" id='step-3-form'>

    <?php if($sitetype == 'main-site'):?>

    <div class="ui form">
        <div class="grouped fields">  
            <div class="field">
                <label>Main Site Secret Key</label>
                <input type="text" placeholder="Enter secret key" name="main_site_secret_key" value="<?php echo esc_attr($main_site_secret_key); ?>">
            </div>  
            <div class="field">
                <label>Sync Site URL</label>
                <input type="text" placeholder="Enter Sync Site URL" name="sync_site_url" value="<?php echo esc_attr($sync_site_url); ?>">
            </div>  
        </div>
    </div>

    <?php elseif($sitetype == 'sync-login'):?>

    <div class="ui form">
        <div class="grouped fields">
            <div class="field">
                <label>Main Site URL</label>
                <input type="text" placeholder="Enter Main Site URL" name="main_site_url" value="<?php echo esc_attr($main_site_url); ?>">
            </div>  
            <div class="field">
                <label>Main Site Secret Key</label>
                <input type="text" placeholder="Enter secret key" name="main_site_secret_key" value="<?php echo esc_attr($main_site_secret_key); ?>">
            </div>  
        </div>
    </div>

    <?php endif;?>

    <button class="ui inverted green button mt-2" id="prev-button" data-step="3">Previous</button>
    <button class="ui inverted green button mt-2" id="next-button" data-step="3">Finish</button>
</form>


