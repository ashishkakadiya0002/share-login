var maxStep = 3;
function dataSave(step, formData) {
    jQuery.ajax({
        url: shareLogin.ajaxurl, // Provided by WordPress for AJAX calls
        type: 'POST',
        data: {action: 'save_step_'+step, nonce: shareLogin.nonce, formData: formData},
        beforeSend: function () {
            jQuery('#loader').removeClass('hidden');
            jQuery('#step-content').addClass('hidden');
        },        
        success: function (response) {
            console.log(response);
            if (response.data.status === 'success') {
                if(step+1 <= maxStep) {
                    templateRender(step+1);
                } else {
                    window.location.href = shareLogin.plugin_dashboard_url;
                }
            } else {
                jQuery('#loader').addClass('hidden');
                jQuery('#step-content').removeClass('hidden');
                jQuery('#error-message .header').text(response.data.message);
                jQuery('#error-message').removeClass('hidden');
            }
        },
        error: function (response) {
            console.log(response);
            jQuery('#loader').addClass('hidden');
            jQuery('#step-content').removeClass('hidden');
            jQuery('#error-message .header').text('An error occurred while saving the data.');
            jQuery('#error-message').removeClass('hidden');
        }
    });
}

function templateRender(step) {
    if(step <= maxStep) {
        action = 'template_step_'+step;
    } else {
        action = 'template_step_1';
    }
    jQuery.ajax({
        url: shareLogin.ajaxurl, // Provided by WordPress for AJAX calls
        type: 'POST',
        data: {
            action: action,
        },
        beforeSend: function () {
          jQuery('#loader').removeClass('hidden');
          jQuery('#step-content').addClass('hidden');
        },
        success: function (response) {
            console.log(response);
            jQuery('#step-content').html(response);
            jQuery('#loader').addClass('hidden');
            jQuery('#step-content').removeClass('hidden');
        },
        error: function () {
            jQuery('#loader').addClass('hidden');
            jQuery('#step-content').removeClass('hidden');
            jQuery('#error-message .header').text('An error occurred while loading the step.');
            jQuery('#error-message').removeClass('hidden');
        }
    });
}

jQuery(document).ready(function () {
    
    jQuery('body').on('click', '.message .close', function() {
        jQuery(this).closest('.message').addClass('hidden');
    });

    jQuery('body').on('click', '#next-button', function (e) {
      
      e.preventDefault();
      
      var step = jQuery(this).data('step');
      var nextStep = step + 1;

      jQuery('#step-'+step).removeClass('active').addClass('completed');
      jQuery('#step-'+nextStep).addClass('active');
      var formData = new FormData(jQuery('#step-'+step+'-form')[0]);
      let formObj = Object.fromEntries(formData);
      dataSave(step, formObj);
    });

    jQuery('body').on('click', '#prev-button', function (e) {
      
        e.preventDefault();
      
      var step = jQuery(this).data('step');
      var prevStep = step - 1;
      jQuery('#step-'+step).removeClass('active').removeClass('completed');
      jQuery('#step-'+prevStep).addClass('active');

      templateRender(prevStep);
    });    
});

