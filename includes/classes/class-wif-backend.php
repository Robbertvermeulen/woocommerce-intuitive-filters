<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WIF_Backend {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'wp_ajax_handle_submit_filter', [$this, 'handle_ajax_submit_filter'] );
        add_action( 'wp_ajax_nopriv_handle_submit_filter', [$this, 'handle_ajax_submit_filter'] );
    }

    public function handle_ajax_submit_filter() {

        $response = [];

        if ( empty( $_POST['filter_id'] ) || empty( $_POST['filters'] ) ) wp_die();

        $filter_id = $_POST['filter_id'];
        $filters   = $_POST['filters'];

        if ( ! empty( $filters['product_cat'] ) ) {
            $redirect_url = get_term_link( $filters['product_cat'], 'product_cat' );
            unset( $filters['product_cat'] );
        } else {
            $filter = new WIF_Filter( $filter_id );
            if ( $filter->get_category_mode() == 'default' ) {
                $product_cat = $filter->get_default_product_cat();
                $redirect_url = get_term_link( $product_cat, 'product_cat' );
            } else {
                $redirect_url = get_permalink( wc_get_page_id( 'shop' ) );
            }
        }

        $response['redirect_url'] = add_query_arg( array_filter( $filters ), $redirect_url );
        wp_send_json( $response );
        wp_die();
    }

}

WIF_Backend::get_instance();