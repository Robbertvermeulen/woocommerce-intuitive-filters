<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WIF_Core {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'init', [$this, 'register_post_types'] );
    }

    public function register_post_types() {

        $labels = array(
            'name'                  => _x( 'Filters', 'Post Type General Name', 'wif_plugin' ),
            'singular_name'         => _x( 'Filter', 'Post Type Singular Name', 'wif_plugin' ),
            'menu_name'             => __( 'Intuitive filters', 'wif_plugin' ),
            'name_admin_bar'        => __( 'Filter', 'wif_plugin' ),
            'archives'              => __( 'Item Filters', 'wif_plugin' ),
            'attributes'            => __( 'Item Filters', 'wif_plugin' ),
            'parent_item_colon'     => __( 'Parent Filter:', 'wif_plugin' ),
            'all_items'             => __( 'All Filters', 'wif_plugin' ),
            'add_new_item'          => __( 'Add New Filter', 'wif_plugin' ),
            'add_new'               => __( 'Add New', 'wif_plugin' ),
            'new_item'              => __( 'New Filter', 'wif_plugin' ),
            'edit_item'             => __( 'Edit Filter', 'wif_plugin' ),
            'update_item'           => __( 'Update Filter', 'wif_plugin' ),
            'view_item'             => __( 'View Filter', 'wif_plugin' ),
            'view_items'            => __( 'View Filters', 'wif_plugin' ),
            'search_items'          => __( 'Search Filter', 'wif_plugin' ),
            'not_found'             => __( 'Not found', 'wif_plugin' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'wif_plugin' ),
            'featured_image'        => __( 'Featured Image', 'wif_plugin' ),
            'set_featured_image'    => __( 'Set featured image', 'wif_plugin' ),
            'remove_featured_image' => __( 'Remove featured image', 'wif_plugin' ),
            'use_featured_image'    => __( 'Use as featured image', 'wif_plugin' ),
            'insert_into_item'      => __( 'Insert into item', 'wif_plugin' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'wif_plugin' ),
            'items_list'            => __( 'Filters list', 'wif_plugin' ),
            'items_list_navigation' => __( 'Filters list navigation', 'wif_plugin' ),
            'filter_items_list'     => __( 'Filter Filters list', 'wif_plugin' ),
        );
        $args = array(
            'label'                 => __( 'Filter', 'wif_plugin' ),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 58,
            'menu_icon'             => 'dashicons-filter',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'wif-filter', $args );
    }
}

WIF_Core::get_instance();