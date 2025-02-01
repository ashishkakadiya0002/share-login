<?php
$sitetype = get_option('sl_sitetype', '');
if($sitetype == 'main-site'){
    $outgoing_logout = !empty(get_option('sl_outgoing_logout')) ? true : false;
    $outgoing_user_creation = !empty(get_option('sl_outgoing_user_creation')) ? true : false;
}elseif($sitetype == 'sync-login'){
    $incomming_logout = !empty(get_option('sl_incomming_logout')) ? true : false;
    $incomming_user_creation = !empty(get_option('sl_incomming_user_creation')) ? true : false;
}
?>

<div class="ui bottom attached red tiny message hidden" id="error-message">
    <i class="close icon"></i>
    <div class="header">
        Site Settings Saved Failed.
    </div>
</div>
<form method="POST" id='step-2-form'>

    <?php if($sitetype == 'main-site'): ?>

    <div class="ui form">
        <div class="grouped fields">
            <h2 class="ui header mt-1">
                <!-- <i class="user icon"></i> -->
                <div class="content">
                    Services
                    <div class="sub header">Select the services you want to Main Site.</div>
                </div>
            </h2>
            <div class="ui checkbox">
                <input type="checkbox" name="outgoing_logout" <?php echo checked($outgoing_logout, true);?>>
                <label>Outgoing Logout</label>
            </div>
            <br>
            <div class="ui checkbox">
                <input type="checkbox" name="outgoing_user_creation" <?php echo checked($outgoing_user_creation, true);?>>
                <label>Outgoing User Creation</label>
            </div>
        </div>
    </div>
    
    <?php elseif($sitetype == 'sync-login'): ?>
    
    <div class="ui form">
        <div class="grouped fields">
            <h2 class="ui header mt-1">
                <i class="user icon"></i>
                <div class="content">
                    Services
                    <div class="sub header">Select the services you want to Sync Login.</div>
                </div>
            </h2>
            <div class="ui checkbox">
                <input type="checkbox" name="incomming_logout" <?php echo checked($incomming_logout, true);?>>
                <label>Incomming Logout</label>
            </div>
            <br>
            <div class="ui checkbox">
                <input type="checkbox" name="incomming_user_creation" <?php echo checked($incomming_user_creation, true);?>>
                <label>Incomming User Creation</label>
            </div>
        </div>
    </div>    

    <?php endif; ?>

    <button class="ui inverted green button mt-2" id="prev-button" data-step="2">Previous</button>
    <button class="ui inverted green button mt-2" id="next-button" data-step="2">Next</button>
</form>

