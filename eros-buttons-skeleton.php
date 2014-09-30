<?php
/**
 * Eros Netabox
 *
 * The Purpose of this Plugin is to Display
 * Buttons Information that has been collected.
 *
 * @package   Eros Buttons Skeleton
 * @author    Leo Gopal <leo@leogopal.com>
 * @license   GPL-2.0+
 * @link      http://leogopal.com
 * @copyright 2014 Eternal Smiles
 *
 * @wordpress-plugin
 * Plugin Name:       Eros Buttons Skeleton
 * Plugin URI:        http://leogopal.com/eros-buttonss
 * Description:       This is the Buttonss Plugin Revisted
 * Version:           1.0.0-alpha
 * Author:            Leo Gopal
 * Author URI:        http://leogopal.com/
 * Text Domain:       eros
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 * Eros-Buttons-Skeleton: v1.0.0-alpha
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * primary class for Eros Metabox
 *
 * @since 1.0.0
 */
class ErosButtonsSkeleton {
/**
 * Defining constants for later use
 */

	public function __construct() {

		// define plugin name
		define( 'EBSS_NAME', 'Eros Buttons Skeleton' );

		// define plugin version
		define( 'EBSS_VERSION', '1.0.0-alpha-3' );

		// define plugin directory
		define( 'EBSS_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		// define plugin root file
		define( 'EBSS_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/**
		 * Defining constants for later use
		 */

		define( 'EBSS_INCLUDES', EBSS_DIR . 'includes/' );
		define( 'EBSS_ASSETS', EBSS_URL . 'assets/' );
		define( 'EBSS_IMG', EBSS_ASSETS . 'img/' );
		define( 'EBSS_STYLES', EBSS_ASSETS . 'css/' );
		define( 'EBSS_SCRIPTS', EBSS_ASSETS . 'js/' );

		// load text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );

		// load admin scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'ebss_admin_assets' ) );

		// load frontend scripts and styles
		add_action( 'wp_enqueue_scripts', array( $this, 'ebss_load_frontend' ) );

		//add_filter( 'wp_default_scripts', array( $this, 'remove_jquery_migrate') );
		// require additional plugin files
		$this->includes();
	}

	/**
	 * load EWS textdomain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'eros', false, EBSS_DIR . 'languages/' );
	}

	/**
	 * Enqueueing scripts and styles in the admin
	 * @param  int $hook Current page hook
	 */
	public function ebss_admin_assets( $hook ) {
		global $post_type;

		if ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && ( 'eros-buttons' == $post_type ) ) {

			wp_register_style( 'ebss-admin-style', EBSS_STYLES . 'admin-style.css', false, '1.0.0', 'all' );

			wp_register_script( 'admin-scripts', EBSS_SCRIPTS . 'admin-script.js', array( 'jquery'), '1.0', true );
			wp_register_script( 'metabox-script', EBSS_SCRIPTS . 'metabox-script.js', array( 'jquery'), '1.0', true );

			wp_enqueue_script( 'metabox-script' );
			wp_enqueue_style( 'ebss-admin-style' );
			wp_enqueue_script( 'admin-scripts' );
		}
	}


	public function ebss_load_frontend() {

	 //    wp_deregister_script('jquery');
		// wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js", false, null);
		// wp_enqueue_script('jquery');

		wp_register_style( 'eros-frontend', EBSS_STYLES . 'frontend-style.css', false, '1.10.4', 'all' );
		//wp_register_style( 'magnific-popup-css', EBSS_STYLES . 'magnific-popup.css', false, '0.9.9', 'all' );

		//wp_register_script( 'magnific-popup-js', EBSS_SCRIPTS . 'magnific-popup.min.js', array( 'jquery' ),  '0.9.9', false);
		wp_register_script( 'frontend-scripts', EBSS_SCRIPTS . 'frontend-scripts.js', array( 'jquery'), '1.0', false );

		//wp_register_script( 'isotope-scripts', EBSS_SCRIPTS . 'isotope.min.js', array( 'jquery'), '1.0', false );

		wp_enqueue_style( 'eros-frontend' );
		//wp_enqueue_style ( 'magnific-popup-css' );

		//wp_enqueue_script ( 'magnific-popup-js' );
		//wp_enqueue_script ( 'isotope-scripts' );
		wp_enqueue_script ( 'frontend-scripts' );
	}



	// public function remove_jquery_migrate( &$scripts)
	// {
	//     if(!is_admin())
	//     {
	//         $scripts->remove( 'jquery');
	//         $scripts->add( 'jquery', false, array( 'jquery-core' ), '' );
	//     }
	// }


	/**
	 * require additional plugin files
	 */
	private function includes() {
		require_once( EBSS_INCLUDES . 'admin/register-cpt-tax.php' );		// register custom post type and taxonomy
		require_once( EBSS_INCLUDES . 'admin/register-metaboxes.php' );		// register metaboxes
		require_once( EBSS_INCLUDES . 'admin/register-shortcode.php' );		// register shortcode
		//require_once( EBSS_INCLUDES . 'admin/member-metaboxes.php' );
		require_once( EBSS_INCLUDES . 'admin/display-columns.php' );
		require_once( EBSS_INCLUDES . 'admin/duplicate-buttonss.php' );
		require_once( EBSS_INCLUDES . 'admin/register-cpt-messages.php' );
		//require_once( EBSS_INCLUDES . 'ROT13/encode-init.php' );
	}



}

new ErosButtonsSkeleton();

add_filter( 'ebss-plugin-installed', '__return_true' );
