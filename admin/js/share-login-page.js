jQuery(document).ready(function($) {

    jQuery('body').on('click', '#copy_secret_key', function(e) {
        e.preventDefault();
        var copyText = jQuery('input[name="main_site_secret_key"]');
        copyText.select();
        navigator.clipboard.writeText(copyText.val());

        jQuery('#copy_secret_key').find('.icon').removeClass('outline');
        setTimeout(function() {
            jQuery('#copy_secret_key').find('.icon').addClass('outline');
        }, 2000);
    });

    jQuery('body').on('click', '.message .close', function() {
      jQuery(this).closest('.message').addClass('hidden');
    });    

    jQuery('body').on('click', '#save_sync_login_settings', function(e) {
        e.preventDefault();
        var formData = new FormData(jQuery('#sync-login-form')[0]);
        let formObj = Object.fromEntries(formData);
        console.log(formObj);
        jQuery.ajax({
            url: shareLogin.ajaxurl,
            type: 'POST',
            data: { action: 'save_sync_login_settings', nonce: shareLogin.nonce, formData: formObj },
            beforeSend: function() {
                jQuery('#form-loader').removeClass('hidden');
            },
            success: function(response) {
                jQuery('#form-loader').addClass('hidden');
                console.log(response);
                if(response.data.status === 'success') {
                    jQuery('#success-message').removeClass('hidden');
                    jQuery('#error-message').addClass('hidden');
                }else{
                    jQuery('#success-message').addClass('hidden');
                    jQuery('#error-message .header').text(response.data.message);
                    jQuery('#error-message').removeClass('hidden');
                }
            }
        });
    });

    jQuery('body').on('click', '#save_main_site_settings', function(e) {
        e.preventDefault();
        var formData = new FormData(jQuery('#main-site-form')[0]);
        let formObj = Object.fromEntries(formData);
        console.log(formObj);
        jQuery.ajax({
            url: shareLogin.ajaxurl,
            type: 'POST',
            data: { action: 'save_main_site_settings', nonce: shareLogin.nonce, formData: formObj },
            beforeSend: function() {
                jQuery('#form-loader').removeClass('hidden');
            },
            success: function(response) {
                jQuery('#form-loader').addClass('hidden');
                console.log(response);
                if(response.data.status === 'success') {
                    jQuery('#success-message').removeClass('hidden');
                    jQuery('#error-message').addClass('hidden');
                }else{
                    jQuery('#success-message').addClass('hidden');
                    jQuery('#error-message .header').text(response.data.message);
                    jQuery('#error-message').removeClass('hidden');
                }
            }
        });
    });
});