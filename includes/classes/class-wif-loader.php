<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WIF_Loader {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->define_constants();
        add_action( 'plugins_loaded', [$this, 'load_plugin'] );
    }

    public function define_constants() {

        define( 'WIF_PLUGIN_VERSION', '1.0.0' );

        // Paths
        define( 'WIF_BASE', plugin_basename( WIF_FILE ) );
        define( 'WIF_DIR', plugin_dir_path( WIF_FILE ) );
        define( 'WIF_URL', plugins_url( '/', WIF_FILE ) );
    }

    public function load_plugin() {
        $this->load_core_files();
        do_action( 'wif_init' );
    }

    public function load_core_files() {
        include_once WIF_DIR . 'includes/classes/class-wif-frontend.php';
        if ( is_admin() ) {
            include_once WIF_DIR . 'includes/classes/class-wif-admin.php';
        }
    }
}

WIF_Loader::get_instance();
