<?php
$sitetype = get_option('sl_sitetype', 'main-site');
?>

<div class="ui bottom attached red tiny message hidden" id="error-message">
    <i class="close icon"></i>
    <div class="header">
        Site Settings Saved Failed.
    </div>
</div>
<form method="POST" id='step-1-form'>
    <div class="ui form">
        <div class="grouped fields">
            <h2 class="ui header mt-1">
                <!-- <i class="sitemap icon"></i> -->
                <div class="content">
                    Site Type
                    <div class="sub header">This plugin is to be configured for the main site or for sync login configuration.</div>
                </div>
            </h2>
            <div class="field">
                <div class="ui slider checkbox">
                    <input type="radio" name="sitetype" value="main-site" <?php echo checked($sitetype, 'main-site');?>>
                    <label>Main Site</label>
                </div>
            </div>
            <div class="field">
                <div class="ui slider checkbox">
                    <input type="radio" name="sitetype" value="sync-login" <?php echo checked($sitetype, 'sync-login');?>>
                    <label>Sync Login</label>
                </div>
            </div>
        </div>
    </div>
    <button class="ui inverted green button mt-2" id="next-button" data-step="1">Next</button>
</form>
