<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WIF_Admin {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_scripts'] );
        add_action( 'add_meta_boxes', [$this, 'add_meta_boxes'] );
        add_action( 'save_post_wif-filter', [$this, 'save_filter_post'] );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'wif-plugin-admin', WIF_URL . 'assets/css/admin.css' );
        wp_enqueue_script( 'wif-plugin-admin', WIF_URL . 'assets/js/admin.js', ['jquery'] );
    }

    public function add_meta_boxes() {
        add_meta_box( 
            'wif-filter-settings', 
            __( 'Filter settings' ), 
            [$this, 'filter_settings_metabox_callback'], 
            'wif-filter', 
            'advanced', 
            'high' 
        );
    }

    public function save_filter_post( $post_id ) {

        if ( isset( $_POST['filter_structure'] ) ) {
            update_post_meta( $post_id, 'filter_structure', $_POST['filter_structure'] );
        }

        if ( isset( $_POST['filter_category_mode'] ) ) {
            update_post_meta( $post_id, 'filter_category_mode', $_POST['filter_category_mode'] );
        }

        if ( isset( $_POST['filter_default_product_cat'] ) ) {
            update_post_meta( $post_id, 'filter_default_product_cat', $_POST['filter_default_product_cat'] );
        }

        if ( isset( $_POST['filter_product_cat_selection'] ) ) {
            update_post_meta( $post_id, 'filter_product_cat_selection', $_POST['filter_product_cat_selection'] );
        } else {
            delete_post_meta( $post_id, 'filter_product_cat_selection' );
        }
    }

    public function filter_settings_metabox_callback( $post ) { 
        
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        $filter_structure = get_post_meta( $post->ID, 'filter_structure', true );
        $product_cats = get_terms( ['taxonomy' => 'product_cat'] );
        $category_mode = get_post_meta( $post->ID, 'filter_category_mode', true );
        $default_product_cat = get_post_meta( $post->ID, 'filter_default_product_cat', true );
        $product_cat_selection = get_post_meta( $post->ID, 'filter_product_cat_selection', true );
        ?>

        <div class="wif-metabox-inner">
            <div class="wif-metabox-row mb">
                <div class="wif-editor">
                    <div class="wif-editor__panel">
                        <div class="wif-editor__panel-options">
                            <button class="button button-secondary wif-editor__panel-option js-panel-option-button js-panel-option-button-add" data-tool-type="product_cat">Add categories</button>
                            <button class="button button-secondary wif-editor__panel-option js-panel-option-button js-panel-option-button-opener" data-tool-type="attribute_taxonomy">Add attribute taxonomy</button>
                        </div>
                        <div class="js-panel-tools">
                            <div class="wif-editor__panel-tool js-panel-tool js-panel-tool-attribute_taxonomy" data-tool-type="attribute_taxonomy" style="display: none;">  
                                <div class="wif-editor__panel-tool-col">
                                    <select class="js-panel-tool-dropdown">
                                        <option>-- <?php _e( 'Select attribute taxonomy' ); ?> --</option>
                                        <?php 
                                        if ( $attribute_taxonomies ) {
                                            foreach ( $attribute_taxonomies as $taxonomy ) {
                                                echo '<option value="' . $taxonomy->attribute_name . '">' . $taxonomy->attribute_label . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>  
                                <div class="wif-editor__panel-tool-col">
                                    <button class="button button-primary js-panel-tool-add-button"><?php _e( 'Add' ); ?></button>
                                </div> 
                            </div>    
                        </div>    
                    </div>
                    <textarea class="wif-editor-textarea js-editor-textarea" name="filter_structure" placeholder="<?php _e( 'Filter structure..' ); ?>"><?php echo $filter_structure; ?></textarea>
                </div>    
            </div>
            <div class="wif-metabox-row mb">
                <div class="mb">
                    <label class="d-block mb-1">
                        <strong><?php _e( 'Category mode' ); ?>:</strong>
                    </label>
                    <select name="filter_category_mode" class="js-category-mode-selector">
                        <option value="all" data-category-mode="all" <?php selected( $category_mode, 'all' ); ?>>All categories</option>
                        <option value="default" data-category-mode="default" <?php selected( $category_mode, 'default' ); ?>>Default category</option>
                        <option value="selection" data-category-mode="selection" <?php selected( $category_mode, 'selection' ); ?>>Selection of categories</option>
                    </select>
                </div>
                <div class="js-category-mode-element js-category-mode-default mb" <?php if ( $category_mode != "default" ) echo 'style="display: none;"'; ?>>
                    <label class="d-block mb-1">
                        <strong><?php _e( 'Default category' ); ?>:</strong>
                    </label>
                    <?php if ( $product_cats ) { ?>
                        <select name="filter_default_product_cat">
                            <option>-- Select --</option>
                            <?php foreach ( $product_cats as $term ) {
                                echo '<option value="' . $term->term_id . '" ' . selected( $default_product_cat, $term->term_id, false ) . '>' . $term->name . '</option>';
                            } 
                            ?>
                        </select>
                    <?php } ?>
                </div>
                <div class="js-category-mode-element js-category-mode-selection" <?php if ( $category_mode != "selection" ) echo 'style="display: none;"'; ?>>
                    <label class="d-block mb-1">
                        <strong><?php _e( 'Select categories' ); ?>:</strong>
                    </label>
                    <?php if ( $product_cats ) { ?>
                        <ul>
                            <?php foreach ( $product_cats as $term ) {
                                $checked = ! empty( $product_cat_selection ) ? in_array( $term->term_id, $product_cat_selection ) : false;
                                echo '<li><label><input type="checkbox" name="filter_product_cat_selection[]" ' . ( $checked ? 'checked' : '' ) . ' value="' . $term->term_id . '" />' . $term->name . '</label></li>';
                            }
                            ?>
                        </ul>
                    <?php } ?>    
                </div>
            </div>
            <hr class="mb">
            <div class="wif-metabox-row">
                <strong><?php _e( 'Shortcode', 'wif_plugin' ); ?>:</strong>
                <input type="text" disabled value='<?php echo '[wif_filter id="' . $post->ID . '"]'; ?>'>
            </div>
        </div>

        <?php    
    }
}

WIF_Admin::get_instance();