<?php
/**
 * Plugin Name: Features for WordPress
 * Plugin URI:  https://raftaar1191.com/
 * Description: This plugin provided a extra features for WooCommerce
 * Author:      raftaar1191
 * Author URI:  https://profiles.wordpress.org/raftaar1191/
 * Version:     1.0.0
 * Text Domain: ffwp
 * Domain Path: /i18n/languages/
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ========================================================================
 * CONSTANTS
 * ========================================================================
 */

// Codebase version.
if ( ! defined( 'FFWP_PLUGIN_VERSION' ) ) {
	define( 'FFWP_PLUGIN_VERSION', '1.0.0' );
}

// Plugin Root File.
if ( ! defined( 'FFWP_PLUGIN_FILE' ) ) {
	define( 'FFWP_PLUGIN_FILE', __FILE__ );
}

// Directory.
if ( ! defined( 'FFWP_PLUGIN_DIR' ) ) {
	define( 'FFWP_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// URL.
if ( ! defined( 'FFWP_PLUGIN_URL' ) ) {
	define( 'FFWP_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

// Plugin Basename.
if ( ! defined( 'FFWP_PLUGIN_BASENAME' ) ) {
	define( 'FFWP_PLUGIN_BASENAME', plugin_basename( FFWP_PLUGIN_FILE ) );
}

// check if class exists.
if ( ! class_exists( 'Feature_For_WordPress' ) ) {
	/**
	 * Class Feature_For_WordPress
	 * Load the Feature_For_WooCommerce class
	 *
	 * Version:     1.0.0
	 */
	final class Feature_For_WordPress {
		/** Singleton *************************************************************/

		/**
		 * The single instance of the class.
		 *
		 * @var Feature_For_WordPress
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main Feature_For_WordPress Instance.
		 *
		 * Ensures only one instance of WooCommerce is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @see Feature_For_WordPress()
		 * @return Feature_For_WordPress - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 *
		 * @since 2.1
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'woocommerce' ), '2.1' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 2.1
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'woocommerce' ), '2.1' );
		}

		public function __construct() {
			$this->helper();
			$this->language();
			$this->loader();
			$this->hooks();

			do_action( 'ffwp_loaded' );
		}

		public function helper() {

		}

		public function hooks() {

			/**
			 * Register Script for plugin
			 */
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );

			/**
			 * Update plugin row
			 */
			add_filter(
				'network_admin_plugin_action_links_' . FFWP_PLUGIN_BASENAME,
				array(
					$this,
					'plugin_action_links',
				)
			);
			add_filter( 'plugin_action_links_' . FFWP_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
		}

		/**
		 * Plugins row action links
		 *
		 * @since 1.0.0
		 *
		 * @param array $actions An array of plugin action links.
		 *
		 * @return array An array of updated action links.
		 */
		public function plugin_action_links( $actions ) {

		}

		/**
		 * Add script
		 *
		 * @since 1.0.0
		 */
		public function enqueue_script() {

			if ( is_admin() ) {
				wp_register_script( 'FFWP_admin', FFWP_PLUGIN_URL . 'assets/js/admin.js', 'jquery', FFWP_PLUGIN_VERSION, true );

			}

			wp_register_script( 'FFWP_frontend', FFWP_PLUGIN_URL . 'assets/js/frontend.js', 'jquery', FFWP_PLUGIN_VERSION, true );

			$data = apply_filters(
				'ffwp_frontend_localize_script',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				)
			);

			// Localize the script with new data.
			wp_localize_script( 'ffwp_frontend', 'ffwp', $data );
			wp_localize_script( 'ffwp_admin', 'ffwp', $data );
		}

		public function language() {
			load_plugin_textdomain( 'ffwp', false, FFWP_PLUGIN_BASENAME . '/i18n/languages' );
		}

		public function loader() {

		}
	}


	/**
	 * Start Feature_For_WordPress
	 *
	 * The main function responsible for returning the one true Feature_For_WordPress instance to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $feature_for_wordpress = Feature_For_WordPress(); ?>
	 *
	 * @since 1.0
	 * @return object|Feature_For_WordPress
	 */
	function Feature_For_WordPress() {
		return Feature_For_WordPress::instance();
	}

	feature_for_wordpress();
}
