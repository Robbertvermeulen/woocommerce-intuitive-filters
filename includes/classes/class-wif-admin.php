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
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'wif-plugin-admin', WIF_URL . 'assets/css/admin.css' );
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

    public function filter_settings_metabox_callback() { ?>

        <div class="wif-metabox-inner">
            <div class="wif-metabox-row">
                <div class="wif-editor">
                    <div class="wif-editor__panel">
                        <div class="wif-editor__panel-options">
                            <button class="button button-secondary wif-editor__panel-option js-panel-option-button">Add category</button>
                            <button class="button button-secondary wif-editor__panel-option js-panel-option-button">Add attribute</button>
                        </div>
                        <div class="js-panel-tools">
                            <div class="wif-editor__panel-tool js-panel-tool" style="display: none;">  
                                <div class="wif-editor__panel-tool-col">
                                    <select>
                                        <option>-- <?php _e( 'Select category' ); ?> --</option>
                                    </select>
                                </div>  
                                <div class="wif-editor__panel-tool-col">
                                    <button class="button button-primary"><?php _e( 'Add' ); ?></button>
                                </div> 
                            </div>
                            <div class="wif-editor__panel-tool js-panel-tool" style="display: none;">  
                                <div class="wif-editor__panel-tool-col">
                                    <select>
                                        <option>-- <?php _e( 'Select attribute' ); ?> --</option>
                                    </select>
                                </div>  
                                <div class="wif-editor__panel-tool-col">
                                    <button class="button button-primary"><?php _e( 'Add' ); ?></button>
                                </div> 
                            </div>    
                        </div>    
                    </div>
                    <textarea class="wif-editor-textarea" placeholder="<?php _e( 'Filter structure..' ); ?>"></textarea>
                </div>    
            </div>
        </div>

        <?php    
    }
}

WIF_Admin::get_instance();