<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.1.0
 *
 * @package    Share_Login
 * @subpackage Share_Login/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Share_Login
 * @subpackage Share_Login/public
 * @author     ashishkakadiya0002
 */

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Share_Login_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function generate_jwt($username, $action) {
		$payload = [
			'username' => $username,
			'action' => $action,
			'exp' => time() + 3600 // 1 hour expiry
		];
		return JWT::encode($payload, SLOGIN_SECRET_KEY, 'HS256');
	}

	public function slogin_after_login($user_login, $user) {
		$jwt_token = $this->generate_jwt($user->user_login, 'login');
		setcookie('slogin_token', $jwt_token, time() + 3600, '/', '');

		wp_redirect(home_url());
		exit;
	}

	public function slogin_after_logout() {
		if (isset($_COOKIE['slogin_token'])) {
			$user = wp_get_current_user();
			$jwt_token = $this->generate_jwt($user->user_login, 'logout');
			setcookie('slogin_token', $jwt_token, time() + 3600, '/', '');
		}
	}

	public function slogin_register_route() {
		register_rest_route('ol/v1', '/validate', [
			'methods' => 'POST',
			'callback' => [$this, 'slogin_validate_token'],
			'permission_callback' => '__return_true'
		]);
	}

	public function slogin_validate_token($request) {
		$token = $request['token'];
		$secret_key = $request['secret_key'];
		if($secret_key != SLOGIN_MAIN_SITE_SECRET_KEY){
			return new WP_Error('invalid_secret_key', 'Invalid secret key', ['status' => 401]);
		}
		try {
			$decoded = JWT::decode($token, new Key(SLOGIN_SECRET_KEY, 'HS256'));
			return [
				'status' => true, 
				'username' => $decoded->username,
				'action' => $decoded->action
			];
		} catch (Exception $e) {
			return ['status' => false];
		}
	}


	public function slogin_auto_login() {
		if (!isset($_COOKIE['slogin_token_recieved'])) {
			return;
		}
		
		// Sanitize and validate the cookie value
		$token = sanitize_text_field(wp_unslash($_COOKIE['slogin_token_recieved']));
		if (empty($token)) {
			return;
		}

		$response = wp_remote_post(SLOGIN_MAIN_SITE_URL . '/wp-json/ol/v1/validate', [
			'body' => ['secret_key' => SLOGIN_MAIN_SITE_SECRET_KEY, 'token' => $token]
		]);
		$body = json_decode(wp_remote_retrieve_body($response), true);
		
		if(!isset($body['status']) || $body['status'] !== true){
			// $this->slogin_logout();
			return;
		}
		
		if($body['action'] == 'login'){
			$this->slogin_login($body['username']);
		}

		if($body['action'] == 'logout'){
			$this->slogin_logout();
		}

	}

	public function slogin_login($username){
		$user = get_user_by('login', $username);
		if(!$user){
			return;
		}
		if(!is_user_logged_in()){
			wp_set_current_user($user->ID);
			wp_set_auth_cookie($user->ID);
		} else {
			$current_user = wp_get_current_user();
			if ($current_user->ID !== $user->ID) {
				wp_set_current_user($user->ID);
				wp_set_auth_cookie($user->ID);
			}
		}
	}

	public function slogin_logout(){
		wp_logout();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function enqueue_styles() {


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'js/share-login-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . '-public', 'shareLogin', Share_Login_Helper::localize_data() );
		
		wp_enqueue_script( $this->plugin_name . 'cross-storage-client', SLOGIN_PLUGIN_URL . 'public/js/cross-storage/client.min.js', array( 'jquery' ), $this->version, false );
		if(SLOGIN_SITETYPE == 'main-site') {
			wp_enqueue_script( $this->plugin_name . '-client1', SLOGIN_PLUGIN_URL . 'public/js/share-login-client1.js', array( 'jquery' ), $this->version, false );
		}elseif(SLOGIN_SITETYPE == 'sync-login') {
			wp_enqueue_script( $this->plugin_name . '-client2', SLOGIN_PLUGIN_URL . 'public/js/share-login-client2.js', array( 'jquery' ), $this->version, false );
		}		

	}

}
