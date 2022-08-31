<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WIF_Frontend {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'init', [$this, 'add_shortcodes'] );
    }

    public function add_shortcodes() {
        add_shortcode( 'wif_filter', [$this, 'wif_filter_shortcode_callback'] );
    }

    public function wif_filter_shortcode_callback( $atts ) {
        $template_path = WIF_DIR . 'templates/filter.php';
        if ( file_exists( $template_path ) ) {
            ob_start();
            include_once( $template_path );
            $html = ob_get_clean();
        }
        return $html;
    }

}

WIF_Frontend::get_instance();