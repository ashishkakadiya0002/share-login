<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sharelogin.com
 * @since      1.0.0
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
 * @author     Ashish Kakadiya <ashishkakadiya0002@gmail.com>
 */

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Share_Login_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
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
		return JWT::encode($payload, SL_SECRET_KEY, 'HS256');
	}

	public function sl_after_login($user_login, $user) {
		$jwt_token = $this->generate_jwt($user->user_login, 'login');
		setcookie('sl_token', $jwt_token, time() + 3600, '/', '');

		wp_redirect(home_url());
		exit;
	}

	public function sl_after_logout() {
		if (isset($_COOKIE['sl_token'])) {
			$user = wp_get_current_user();
			$jwt_token = $this->generate_jwt($user->user_login, 'logout');
			setcookie('sl_token', $jwt_token, time() + 3600, '/', '');
		}
	}

	public function sl_register_route() {
		register_rest_route('ol/v1', '/validate', [
			'methods' => 'POST',
			'callback' => [$this, 'sl_validate_token'],
		]);
	}

	public function sl_validate_token($request) {
		$token = $request['token'];
		$secret_key = $request['secret_key'];
		if($secret_key != SL_MAIN_SITE_SECRET_KEY){
			return new WP_Error('invalid_secret_key', 'Invalid secret key', ['status' => 401]);
		}
		try {
			$decoded = JWT::decode($token, new Key(SL_SECRET_KEY, 'HS256'));
			return [
				'status' => true, 
				'username' => $decoded->username,
				'action' => $decoded->action
			];
		} catch (Exception $e) {
			return ['status' => false];
		}
	}


	public function sl_auto_login() {
		
		if(!isset($_COOKIE['sl_token_recieved'])){
			return;
		}
		$token = wp_unslash($_COOKIE['sl_token_recieved']);

		$response = wp_remote_post(SL_MAIN_SITE_URL . '/wp-json/ol/v1/validate', [
			'body' => ['secret_key' => SL_MAIN_SITE_SECRET_KEY, 'token' => $token]
		]);
		$body = json_decode(wp_remote_retrieve_body($response), true);
		
		if(!isset($body['status']) || $body['status'] !== true){
			// $this->sl_logout();
			return;
		}
		
		if($body['action'] == 'login'){
			$this->sl_login($body['username']);
		}

		if($body['action'] == 'logout'){
			$this->sl_logout();
		}

	}

	public function sl_login($username){
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

	public function sl_logout(){
		wp_logout();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/share-login-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'js/share-login-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . '-public', 'shareLogin', Share_Login_Helper::localize_data() );
		
		wp_enqueue_script( $this->plugin_name . 'cross-storage-client', SL_PLUGIN_URL . 'public/js/client.min.js', array( 'jquery' ), $this->version, false );
		if(SL_SITETYPE == 'main-site') {
			wp_enqueue_script( $this->plugin_name . '-client1', SL_PLUGIN_URL . 'public/js/share-login-client1.js', array( 'jquery' ), $this->version, false );
		}elseif(SL_SITETYPE == 'sync-login') {
			wp_enqueue_script( $this->plugin_name . '-client2', SL_PLUGIN_URL . 'public/js/share-login-client2.js', array( 'jquery' ), $this->version, false );
		}		

	}

}
