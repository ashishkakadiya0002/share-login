<?php

class Share_Login_Ajax {

    public function __construct() {
    
    }

	public function save_step_1() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Nonce verification failed', 'share-login')]);
			return;
		}
		if (!isset($_POST['formData']) || !is_array($_POST['formData'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Invalid form data', 'share-login')]);
			return;
		}
		$formData = map_deep(wp_unslash($_POST['formData']), 'sanitize_text_field');
		
		if (!empty($formData['sitetype'])) {
			$site_type = $formData['sitetype'];
			update_option('slogin_sitetype', $site_type);
			update_option('slogin_setup_complete', false);
			wp_send_json_success(['status' => 'success', 'data' => $formData]);
		} else {
			wp_send_json_error(['status' => 'error', 'message' => 'Site type is required']);
		}
	}

	public function template_step_1() {
		require_once SLOGIN_PLUGIN_PATH . 'admin/partials/step-1.php';
		wp_die();
	}

	public function save_step_2() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Nonce verification failed', 'share-login')]);
			return;
		}
		if (!isset($_POST['formData']) || !is_array($_POST['formData'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Invalid form data', 'share-login')]);
			return;
		}
		$form_data = map_deep(wp_unslash($_POST['formData']), 'sanitize_text_field');
		
		$site_type = get_option('slogin_sitetype');

		if ($site_type === 'main-site') {
			update_option('slogin_outgoing_logout', $form_data['outgoing_logout']);
			update_option('slogin_outgoing_user_creation', $form_data['outgoing_user_creation']);
		} elseif ($site_type === 'sync-login') {
			update_option('slogin_incomming_logout', $form_data['incomming_logout']);
			update_option('slogin_incomming_user_creation', $form_data['incomming_user_creation']);
		}

		update_option('slogin_setup_complete', false);
		wp_send_json_success(['status' => 'success', 'data' => $form_data]);
	}

	public function template_step_2() {
		require_once SLOGIN_PLUGIN_PATH . 'admin/partials/step-2.php';
		wp_die();
	}

	public function save_step_3() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Nonce verification failed', 'share-login')]);
			return;
		}
		if (!isset($_POST['formData']) || !is_array($_POST['formData'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Invalid form data', 'share-login')]);
			return;
		}
		$formData = map_deep(wp_unslash($_POST['formData']), 'sanitize_text_field');
		
		if(get_option('slogin_sitetype') == 'main-site'){
			if(empty($formData['main_site_secret_key'])){
				wp_send_json_error(['status' => 'error', 'message' => 'Main site secret key is required']);
			}
			if(empty($formData['sync_site_url'])){
				wp_send_json_error(['status' => 'error', 'message' => 'Sync site url is required']);
			}
			update_option('slogin_main_site_secret_key', $formData['main_site_secret_key']);
			update_option('slogin_sync_site_url', $formData['sync_site_url']);
		}elseif(get_option('slogin_sitetype') == 'sync-login'){
			if(empty($formData['main_site_url']) || empty($formData['main_site_secret_key'])){
				wp_send_json_error(['status' => 'error', 'message' => 'Main site url and secret key is required']);
			}
			update_option('slogin_main_site_url', $formData['main_site_url']);
			update_option('slogin_main_site_secret_key', $formData['main_site_secret_key']);
		}
		update_option('slogin_setup_complete', true);
		wp_send_json_success(['status' => 'success', 'data' => $formData]);
	}

	public function template_step_3() {
		require_once SLOGIN_PLUGIN_PATH . 'admin/partials/step-3.php';
		wp_die();
	}    

	public function save_sync_login_settings() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Nonce verification failed', 'share-login')]);
			return;
		}
		if (!isset($_POST['formData']) || !is_array($_POST['formData'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Invalid form data', 'share-login')]);
			return;
		}
		$form_data = map_deep(wp_unslash($_POST['formData']), 'sanitize_text_field');

		if (empty($form_data['main_site_url']) || !wp_http_validate_url($form_data['main_site_url'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Valid main site URL is required', 'share-login')]);
			return;
		}
		if (empty($form_data['main_site_secret_key'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Main site secret key is required', 'share-login')]);
			return;
		}

		update_option('slogin_incomming_logout', $form_data['incomming_logout']);
		update_option('slogin_incomming_user_creation', $form_data['incomming_user_creation']);		
		update_option('slogin_main_site_url', esc_url_raw($form_data['main_site_url']));
		update_option('slogin_main_site_secret_key', $form_data['main_site_secret_key']);		

		wp_send_json_success(['status' => 'success', 'data' => $form_data]);
	}

	public function save_main_site_settings() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Nonce verification failed', 'share-login')]);
			return;
		}
		if (!isset($_POST['formData']) || !is_array($_POST['formData'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Invalid form data', 'share-login')]);
			return;
		}
		$form_data = map_deep(wp_unslash($_POST['formData']), 'sanitize_text_field');

		if (empty($form_data['main_site_secret_key'])) {
			wp_send_json_error(['status' => 'error', 'message' => esc_html__('Main site secret key is required', 'share-login')]);
			return;
		}

		update_option('slogin_outgoing_logout', $form_data['outgoing_logout']);
		update_option('slogin_outgoing_user_creation', $form_data['outgoing_user_creation']);
		update_option('slogin_main_site_secret_key', $form_data['main_site_secret_key']);
		
		wp_send_json_success(['status' => 'success', 'data' => $form_data]);
	}

}