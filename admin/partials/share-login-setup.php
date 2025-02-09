<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class='main-content mr-1 mt-2'>
  <div class="ui three top attached steps">
    <div class="active step" id="step-1">
      <i class="sitemap icon"></i>
      <div class="content">
        <div class="title">Step 1</div>
        <div class="description">Choose Your Site Type</div>
      </div>
    </div>
    <div class="step" id="step-2">
      <i class="list alternate icon"></i>
      <div class="content">
        <div class="title">Step 2</div>
        <div class="description">Choose Services</div>
      </div>
    </div>
    <div class="step" id="step-3">
      <i class="key icon"></i>
      <div class="content">
        <div class="title">Step 3</div>
        <div class="description">Secret Key</div>
      </div>
    </div>
  </div>
  <div class="ui active inline loader hidden" id="loader"></div>  
  <div class="ui attached segment" id="step-content">
    <?php require_once SLOGIN_PLUGIN_PATH . 'admin/partials/step-1.php'; ?>
  </div>

</div>