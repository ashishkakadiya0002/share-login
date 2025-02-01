<?php
$incomming_logout = !empty(get_option('sl_incomming_logout')) ? true : false;
$incomming_user_creation = !empty(get_option('sl_incomming_user_creation')) ? true : false;
?>
<div class='main-content mr-1 mt-2'>
    <div class="ui attached message">
        <div class="header">
            Welcome to One Login(Sync Login).
        </div>
        <p>If any changes are made, please fill out the form below and click the save button to save the changes. If you want to reset the site setup, <a href="<?php echo esc_url(admin_url('admin.php?page=share-login&setup=1')); ?>" class="ui inverted green">Reset</a></p>
    </div>
    <form class="ui form attached fluid segment" method="POST" id='sync-login-form'>
        <h4>Services</h4>
        <div class="ui checkbox">
            <input type="checkbox" name="incomming_logout" <?php echo checked($incomming_logout, true);?>>
            <label>Incomming Logout</label>
        </div>
        <br>
        <div class="ui checkbox">
            <input type="checkbox" name="incomming_user_creation" <?php echo checked($incomming_user_creation, true);?>>
            <label>Incomming User Creation</label>
        </div>

        <h4>Sync Login Settings</h4>
        <div class="ui labeled input">
        <div class="ui label">
            Main Site
        </div>
        <input type="text" name="main_site_url" value="<?php echo esc_attr(get_option('sl_main_site_url', '')); ?>">
        </div>
        <br>
        <div class="ui labeled input mt-1">
        <div class="ui label">
            Secret Key
        </div>
        <input type="text" name="main_site_secret_key" value="<?php echo esc_attr(get_option('sl_main_site_secret_key', '')); ?>">
        </div>

        <br>
        <button type="submit" class="ui inverted green button mt-2" id="save_sync_login_settings" href="">Save</button>
            
    </form>
    <div class="ui bottom attached green tiny message hidden" id="success-message">
        <i class="close icon"></i>
        <div class="header">
            Sync Login Settings Saved Successfully.
        </div>
    </div>
    <div class="ui bottom attached red tiny message hidden" id="error-message">
        <i class="close icon"></i>
        <div class="header">
            Sync Login Settings Saved Failed.
        </div>
    </div>
</div>
