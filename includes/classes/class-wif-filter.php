<?php
class WIF_Filter { 

    protected $_id;
    protected $_structure;

    public function __construct( int $filter_id ) {
        $this->_id = $filter_id;
        $this->_structure = $this->get_structure_array();
    }

    public function get_structure() {
        return get_post_meta( $this->_id, 'filter_structure', true );
    }

    public function get_dropdown_options( $name ) {
        if ( empty( $name ) ) return;
        if ( $name === "product_cat" ) {
            $taxonomy = $name;
        } else {
            $taxonomy = wc_attribute_taxonomy_name( $name );
        }
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false // Set later to true
        ]);
        return array_map( function( $term ) {
            return [
                'label' => $term->name,
                'value' => $term->slug
            ];
        }, $terms );
    }

    public function get_structure_array() {
        $structure = $this->get_structure();
        if ( empty( $structure ) ) return;
        $result = [];
        $pattern = '/(\{\{[^}]*\}\})/';
        $lines = preg_split( $pattern, $structure, null, PREG_SPLIT_DELIM_CAPTURE );
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