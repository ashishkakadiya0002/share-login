<?php

class Share_Login_Ajax {

    public function __construct() {
    
    }

	public function save_step_1() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => 'Nonce verification failed']);
			return;
		}
		if(isset($_POST['formData'])) {
			$formData = wp_unslash($_POST['formData']);
			$formData = array_map('sanitize_text_field', $formData);
			if (!empty($formData['sitetype'])) {
				$site_type = $formData['sitetype'];
				update_option('sl_sitetype', $site_type);
				update_option('sl_setup_complete', false);
				wp_send_json_success(['status' => 'success', 'data' => $formData]);
			} else {
				wp_send_json_error(['status' => 'error', 'message' => 'Site type is required']);
			}
		}
	}

	public function template_step_1() {
		require_once SL_PLUGIN_PATH . 'admin/partials/step-1.php';
		wp_die();
	}

	public function save_step_2() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => 'Nonce verification failed']);
			return;
		}
		if(isset($_POST['formData'])) {
			$formData = wp_unslash($_POST['formData']);
			$formData = array_map('sanitize_text_field', $formData);
			if(get_option('sl_sitetype') == 'main-site'){
				update_option('sl_outgoing_logout', $formData['outgoing_logout']);
				update_option('sl_outgoing_user_creation', $formData['outgoing_user_creation']);
			}elseif(get_option('sl_sitetype') == 'sync-login'){
				update_option('sl_incomming_logout', $formData['incomming_logout']);
				update_option('sl_incomming_user_creation', $formData['incomming_user_creation']);
			}
			update_option('sl_setup_complete', false);
			wp_send_json_success(['status' => 'success', 'data' => $formData]);
		} else {
			wp_send_json_error(['status' => 'error', 'message' => 'Form data is required']);
		}
	}

	public function template_step_2() {
		require_once SL_PLUGIN_PATH . 'admin/partials/step-2.php';
		wp_die();
	}

	public function save_step_3() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => 'Nonce verification failed']);
			return;
		}
		if(isset($_POST['formData'])) {
			$formData = wp_unslash($_POST['formData']);
			$formData = array_map('sanitize_text_field', $formData);
			if(get_option('sl_sitetype') == 'main-site'){
				if(empty($formData['main_site_secret_key'])){
					wp_send_json_error(['status' => 'error', 'message' => 'Main site secret key is required']);
				}
				if(empty($formData['sync_site_url'])){
					wp_send_json_error(['status' => 'error', 'message' => 'Sync site url is required']);
				}
				update_option('sl_main_site_secret_key', $formData['main_site_secret_key']);
				update_option('sl_sync_site_url', $formData['sync_site_url']);
			}elseif(get_option('sl_sitetype') == 'sync-login'){
				if(empty($formData['main_site_url']) || empty($formData['main_site_secret_key'])){
					wp_send_json_error(['status' => 'error', 'message' => 'Main site url and secret key is required']);
				}
				update_option('sl_main_site_url', $formData['main_site_url']);
				update_option('sl_main_site_secret_key', $formData['main_site_secret_key']);
			}
			update_option('sl_setup_complete', true);
			wp_send_json_success(['status' => 'success', 'data' => $formData]);
		} else {
			wp_send_json_error(['status' => 'error', 'message' => 'Form data is required']);
		}
	}

	public function template_step_3() {
		require_once SL_PLUGIN_PATH . 'admin/partials/step-3.php';
		wp_die();
	}    

	public function save_sync_login_settings() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => 'Nonce verification failed']);
			return;
		}
		if(isset($_POST['formData'])) {
			$formData = wp_unslash($_POST['formData']);
			$formData = array_map('sanitize_text_field', $formData);
			if(empty($formData['main_site_url']) || empty($formData['main_site_secret_key'])){
				wp_send_json_error(['status' => 'error', 'message' => 'Main site url and secret key is required']);
			}
			update_option('sl_incomming_logout', $formData['incomming_logout']);
			update_option('sl_incomming_user_creation', $formData['incomming_user_creation']);		
			update_option('sl_main_site_url', $formData['main_site_url']);
			update_option('sl_main_site_secret_key', $formData['main_site_secret_key']);		
			wp_send_json_success(['status' => 'success', 'data' => $formData]);
		} else {
			wp_send_json_error(['status' => 'error', 'message' => 'Form data is required']);
		}
	}

	public function save_main_site_settings() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'share-login-nonce')) {
			wp_send_json_error(['status' => 'error', 'message' => 'Nonce verification failed']);
			return;
		}
		if(isset($_POST['formData'])) {
			$formData = wp_unslash($_POST['formData']);
			$formData = array_map('sanitize_text_field', $formData);
			if(empty($formData['main_site_secret_key'])){
				wp_send_json_error(['status' => 'error', 'message' => 'Main site secret key is required']);
			}
			update_option('sl_outgoing_logout', $formData['outgoing_logout']);
			update_option('sl_outgoing_user_creation', $formData['outgoing_user_creation']);
			update_option('sl_main_site_secret_key', $formData['main_site_secret_key']);
			wp_send_json_success(['status' => 'success', 'data' => $formData]);
		} else {
			wp_send_json_error(['status' => 'error', 'message' => 'Form data is required']);
		}
	}

}