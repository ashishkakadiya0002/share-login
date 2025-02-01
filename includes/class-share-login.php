<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://sharelogin.com
 * @since      1.0.0
 *
 * @package    Share_Login
 * @subpackage Share_Login/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Share_Login
 * @subpackage Share_Login/includes
 * @author     Ashish Kakadiya <ashishkakadiya0002@gmail.com>
 */
class Share_Login {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Share_Login_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SHARE_LOGIN_VERSION' ) ) {
			$this->version = SHARE_LOGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'share-login';

		$this->define_costants();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Share_Login_Loader. Orchestrates the hooks of the plugin.
	 * - Share_Login_i18n. Defines internationalization functionality.
	 * - Share_Login_Admin. Defines all hooks for the admin area.
	 * - Share_Login_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';

		/**
		 * The class responsible for helper functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-share-login-helper.php';
		
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-share-login-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-share-login-i18n.php';

		/**
		 * The class responsible for defining ajax functionality
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-share-login-ajax.php';
		
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-share-login-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-share-login-public.php';

		$this->loader = new Share_Login_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Share_Login_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Share_Login_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	public function define_costants() {
		define('SL_PLUGIN_URL', plugin_dir_url( dirname( __FILE__ ) ));
		define('SL_PLUGIN_PATH', plugin_dir_path( dirname( __FILE__ ) ));
		define('SL_SECRET_KEY', 'your_secret_key_here');
		define('SL_SITETYPE', get_option('sl_sitetype', ''));
		define('SL_MAIN_SITE_URL', get_option('sl_main_site_url', ''));
		define('SL_MAIN_SITE_SECRET_KEY', get_option('sl_main_site_secret_key', ''));
		define('SL_SYNC_SITE_URL', get_option('sl_sync_site_url', ''));
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Share_Login_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'login_enqueue_scripts', $plugin_admin, 'login_enqueue_scripts' );
		$this->loader->add_action('admin_menu', $plugin_admin, 'share_login_add_admin_menu');
		
		
		$plugin_ajax = new Share_Login_Ajax();
		
		$this->loader->add_action('wp_ajax_save_step_1', $plugin_ajax, 'save_step_1');
		$this->loader->add_action('wp_ajax_template_step_1', $plugin_ajax, 'template_step_1');

		$this->loader->add_action('wp_ajax_save_step_2', $plugin_ajax, 'save_step_2');
		$this->loader->add_action('wp_ajax_template_step_2', $plugin_ajax, 'template_step_2');

		$this->loader->add_action('wp_ajax_save_step_3', $plugin_ajax, 'save_step_3');
		$this->loader->add_action('wp_ajax_template_step_3', $plugin_ajax, 'template_step_3');

		$this->loader->add_action('wp_ajax_save_sync_login_settings', $plugin_ajax, 'save_sync_login_settings');
		$this->loader->add_action('wp_ajax_save_main_site_settings', $plugin_ajax, 'save_main_site_settings');

	}
	
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Share_Login_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		
		if(SL_SITETYPE == 'main-site'){
			$this->loader->add_action( 'wp_login', $plugin_public, 'sl_after_login', 10, 2 );
			$this->loader->add_action( 'wp_logout', $plugin_public, 'sl_after_logout', 10, 2 );
			$this->loader->add_action( 'rest_api_init', $plugin_public, 'sl_register_route', 10, 2 );
		} elseif(SL_SITETYPE == 'sync-login') {
			if(!empty(SL_MAIN_SITE_URL) && !empty(SL_MAIN_SITE_SECRET_KEY)){
				$this->loader->add_action('init', $plugin_public, 'sl_auto_login');
			}
		}
	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Share_Login_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
