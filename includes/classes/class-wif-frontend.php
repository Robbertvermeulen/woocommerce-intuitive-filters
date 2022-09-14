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
        add_action( 'init', [$this, 'handle_form_submit'] );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'wif-plugin', WIF_URL . 'assets/css/main.css' );
        wp_enqueue_script( 'wif-plugin', WIF_URL . 'assets/js/main.js', ['jquery', 'wp-element'], null, true );
    }

    public function add_shortcodes() {
        add_shortcode( 'wif_filter', [$this, 'wif_filter_shortcode_callback'] );
    }

    public function wif_filter_shortcode_callback( $atts ) {
        if ( empty( $atts['id'] ) ) return;
        $filter = new WIF_Filter( $atts['id'] );
        return $filter->get_html();
    }

    public function handle_form_submit() {

        if ( empty( $_POST['wif_filter_submit'] ) || empty( $_POST['wif_filters'] ) ) return;

        $filter_id = $_POST['wif_filter_submit'];
        $filters   = $_POST['wif_filters'];

        if ( ! empty( $filters['product_cat'] ) ) {
            $redirect_url = get_term_link( $filters['product_cat'], 'product_cat' );
            unset( $filters['product_cat'] );
        } else {
            $redirect_url = get_permalink( wc_get_page_id( 'shop' ) );
        }

        $redirect_url = add_query_arg( array_filter( $filters ), $redirect_url );
        wp_redirect( $redirect_url );
        exit;
    }

}

WIF_Frontend::get_instance();