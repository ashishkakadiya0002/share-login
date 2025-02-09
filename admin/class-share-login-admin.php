<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Share_Login
 * @subpackage Share_Login/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Share_Login
 * @subpackage Share_Login/admin
 * @author     ashishkakadiya0002
 */
class Share_Login_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function share_login_add_admin_menu() {
		add_menu_page(
			'Share-Login', // Page title
			'Share-Login',          // Menu title
			'manage_options',     // Capability
			'share-login', // Menu slug
			[$this, 'share_login_page'], // Callback function
			'dashicons-lock',     // Icon
			20                    // Position
		);

	}

	public function share_login_page() {
		if(isset($_GET['setup'])) {
			require_once SLOGIN_PLUGIN_PATH . 'admin/partials/share-login-setup.php';
		} else {
			require_once SLOGIN_PLUGIN_PATH . 'admin/partials/share-login-page.php';
		}
		wp_die();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {
		if($hook == 'toplevel_page_share-login') {
			wp_enqueue_style( $this->plugin_name . '-admin', SLOGIN_PLUGIN_URL . 'admin/css/share-login-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-semantic', SLOGIN_PLUGIN_URL . 'admin/semantic/semantic.min.css', array(), $this->version, 'all' );
		}
	}

	public function login_admin_scripts() {
		wp_enqueue_script( $this->plugin_name . '-admin', SLOGIN_PLUGIN_URL . 'admin/js/share-login.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . '-admin', 'shareLogin', Share_Login_Helper::localize_data() );

		wp_enqueue_script( $this->plugin_name . 'cross-storage-client', SLOGIN_PLUGIN_URL . 'public/js/cross-storage/client.min.js', array( 'jquery' ), $this->version, false );

		if(SLOGIN_SITETYPE == 'main-site') {
			wp_enqueue_script( $this->plugin_name . '-client1', SLOGIN_PLUGIN_URL . 'public/js/share-login-client1.js', array( 'jquery' ), $this->version, false );
		}elseif(SLOGIN_SITETYPE == 'sync-login') {
			wp_enqueue_script( $this->plugin_name . '-client2', SLOGIN_PLUGIN_URL . 'public/js/share-login-client2.js', array( 'jquery' ), $this->version, false );
		}
	}
	
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$this->login_admin_scripts();
		wp_enqueue_script( $this->plugin_name . '-semantic', SLOGIN_PLUGIN_URL . 'admin/semantic/semantic.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-setup', SLOGIN_PLUGIN_URL . 'admin/js/share-login-setup.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-page', SLOGIN_PLUGIN_URL . 'admin/js/share-login-page.js', array( 'jquery' ), $this->version, false );
	}

	public function login_enqueue_scripts() {
		$this->login_admin_scripts();
	}
}
