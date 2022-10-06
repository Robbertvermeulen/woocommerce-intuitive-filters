<?php
class WIF_Filter { 

    protected $_id;
    protected $_structure;
    protected $_category_mode;
    protected $_default_product_cat;
    protected $_product_cat_selection;

    public function __construct( int $filter_id ) {
        $this->_id = $filter_id;
        $this->_structure = $this->get_structure_array();
        $this->_category_mode = get_post_meta( $filter_id, 'filter_category_mode', true );
        $this->_default_product_cat = get_post_meta( $filter_id, 'filter_default_product_cat', true );
        $this->_product_cat_selection = get_post_meta( $filter_id, 'filter_product_cat_selection', true );
    }

    public function get_structure() {
        return get_post_meta( $this->_id, 'filter_structure', true );
    }

    public function get_category_mode() {
        return $this->_category_mode;
    }

    public function get_default_product_cat() {
        return is_string( $this->_default_product_cat ) ? intval( $this->_default_product_cat ) : $this->_default_product_cat;
    }

    public function get_dropdown_options( $name ) {
        if ( empty( $name ) ) return;
        if ( $name === 'product_cat' ) {
            $taxonomy = $name;
        } else {
            $taxonomy = wc_attribute_taxonomy_name( $name );
        }
        
        $args = [
            'taxonomy' => $taxonomy,
            'hide_empty' => true
        ];

        if ( $name === 'product_cat' && $this->_category_mode ) {
            switch ( $this->_category_mode ) {
                case 'default' :
                    if ( $this->_default_product_cat ) {
                        $args['include'] = [$this->_default_product_cat];
                    }
                    break;
                case 'selection' :
                    if ( $this->_product_cat_selection ) {
                        $args['include'] = $this->_product_cat_selection;
                    }
                    break;    
                default:    
            }
        }

        $terms = get_terms( $args );

        if ( !is_wp_error( $terms ) ) {
            return array_map( function( $term ) {
                return [
                    'label' => $term->name,
                    'value' => $term->slug
                ];
            }, $terms );
        }
        return false;
    }

    public function get_structure_array() {
        $structure = $this->get_structure();
        if ( empty( $structure ) ) return;
        $result = [];
        $pattern = '/(\{\{[^}]*\}\})/';
        $lines = preg_split( $pattern, $structure, 0, PREG_SPLIT_DELIM_CAPTURE );
        foreach ( $lines as $line ) {
            preg_match( $pattern, $line, $matches );
            if ( $matches ) {
                $name = trim( str_replace( ['{{', '}}'], "", $line ) );
                $result[] = [
                    'type'    => 'dropdown',
                    'name'    => 'product_cat' != $name ? wc_attribute_taxonomy_name( $name ) : $name,
                    'options' => $this->get_dropdown_options( $name )
                ]; 
            } else {
                $result[] = [
                    'type' => "text",
                    'content' => trim( $line )
                ];
            }
        }
        return $result;
    }

    public function get_html() {
        global $wp_query;
        $data['filterId'] = $this->_id;
        $data['structure'] = $this->get_structure_array();
        // Product category
        if ( is_tax( 'product_cat' ) ) {
            $data['initialFilters']['product_cat'] = get_query_var( 'term' );
        }
        if ( ! empty( $_GET ) ) {
            foreach ( $_GET as $key => $value ) {
                // Looking for wc filters
                if ( str_contains( $key, 'pa_' ) ) {
                    $data['initialFilters'][$key] = $value;
                }
            }
        }
        $html  = '<script>var wif = ' . json_encode( $data ) . '</script>';
        $html .= '<div id="wif_filter"></div>';
        return $html;
    }

}