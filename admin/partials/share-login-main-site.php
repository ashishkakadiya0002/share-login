<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$outgoing_logout = !empty(get_option('slogin_outgoing_logout')) ? true : false;
$outgoing_user_creation = !empty(get_option('slogin_outgoing_user_creation')) ? true : false;
$main_site_secret_key = !empty(get_option('slogin_main_site_secret_key')) ? get_option('slogin_main_site_secret_key') : '';
?>
<div class='main-content mr-1 mt-2'>
    <div class="ui attached message">
        <div class="header">
            Welcome to One Login(Main Site).
        </div>
        <p>If any changes are made, please fill out the form below and click the save button to save the changes. If you want to reset the site setup, <a href="<?php echo esc_url(admin_url('admin.php?page=share-login&setup=1')); ?>" class="ui inverted green">Reset</a></p>
    </div>
    <form class="ui form attached fluid segment" method="POST" id='main-site-form'>
        <div id="form-loader" class="hidden">    
            <div class="ui active inline loader"></div>
        </div>
        <h4>Services</h4>
        <div class="ui checkbox">
            <input type="checkbox" name="outgoing_logout" <?php echo checked($outgoing_logout, true);?>>
            <label>Outgoing Logout</label>
        </div>
        <br>
        <div class="ui checkbox">
            <input type="checkbox" name="outgoing_user_creation" <?php echo checked($outgoing_user_creation, true);?>>
            <label>Outgoing User Creation</label>
        </div>

        <h4>Main Site Settings</h4>
        <div class="ui right labeled input">
            <label for="amount" class="ui label">Secret Key</label>
            <input type="text" name="main_site_secret_key" value="<?php echo esc_attr($main_site_secret_key); ?>">
            <button style="cursor: pointer;" class="ui basic label" id="copy_secret_key"><i class="copy outline icon"></i></button>
        </div>
        <br>
        <br>
        <button type="submit" class="ui inverted green button mt-2" id="save_main_site_settings" href="">Save</button>
            
    </form>
    <div class="ui bottom attached green tiny message hidden" id="success-message">
        <i class="close icon"></i>
        <div class="header">
            Main Site Settings Saved Successfully.
        </div>
    </div>
    <div class="ui bottom attached red tiny message hidden" id="error-message">
        <i class="close icon"></i>
        <div class="header">
            Main Site Settings Saved Failed.
        </div>
    </div>
</div>
