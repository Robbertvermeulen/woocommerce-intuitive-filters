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
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
        add_action( 'init', [$this, 'add_shortcodes'] );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'wif-plugin', WIF_URL . 'assets/css/main.css' );
    }

    public function add_shortcodes() {
        add_shortcode( 'wif_filter', [$this, 'wif_filter_shortcode_callback'] );
    }

    public function wif_filter_shortcode_callback( $atts ) {
        if ( empty( $atts['id'] ) ) return;
        $filter = new WIF_Filter( $atts['id'] );
        return $filter->get_html();
    }

}

WIF_Frontend::get_instance();