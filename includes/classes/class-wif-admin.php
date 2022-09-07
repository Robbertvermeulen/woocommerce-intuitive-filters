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
    }

    public function filter_settings_metabox_callback( $post ) { 
        
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        $filter_structure = get_post_meta( $post->ID, 'filter_structure', true );
        ?>

        <div class="wif-metabox-inner">
            <div class="wif-metabox-row">
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
            <div class="wif-metabox-row">
                <strong><?php _e( 'Shortcode', 'wif_plugin' ); ?>:</strong>
                <input type="text" disabled value='<?php echo '[wif_filter id="' . $post->ID . '"]'; ?>'>
            </div>
        </div>

        <?php    
    }
}

WIF_Admin::get_instance();