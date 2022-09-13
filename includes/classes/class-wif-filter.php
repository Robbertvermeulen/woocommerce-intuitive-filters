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
            'hide_empty' => false
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

    public function get_text_html( array $element ) {
        $html = '';
        if ( ! empty( $element['content'] ) ) {
            $content = $element['content'];
            $html .= '<span class="wif-filter__text">' . $content . '</span>';
        }
        return $html;
    }

    public function get_dropdown_html( array $element ) {
        $html = '';
        if ( ! empty( $element['name'] ) && ! empty( $element['options'] ) ) {
            $name = $element['name'];
            $options = $element['options'];
            $options_html = ['<option disabled selected value></option>'];
            $options_html = array_merge( $options_html, array_map( function( $option ) {
                return '<option value="' . $option['value'] . '">' . strtolower( $option['label'] ) . '</option>';
            }, $options ) );
            $html .= '<select class="wif-filter__select" name="wif_filters[' . $name . ']">' . implode( "", $options_html ) . '</select>';
        }
        return $html;
    }

    public function get_html() {
        if ( empty( $this->_structure ) ) return;
        $html  = '<form class="wif-filter js-wif-form" method="post">';
        $html .= '<p class="wif-filter__content">';
        foreach ( $this->_structure as $element ) {
            switch ( $element['type'] ) {
                case 'text' :
                    $html .= $this->get_text_html( $element );
                    break;
                case 'dropdown' : 
                    $html .= $this->get_dropdown_html( $element );
                    break;
            }
        }
        $html .= '</p>';
        $html .= '<button class="wif-filter__submit js-wif-submit-button" name="wif_filter_submit" value="' . $this->_id . '" disabled>' . __( 'Bekijk resultaten', 'wif_plugin' ) . '</button>';
        $html .= '<span class="wif-filter__reset" style="display: none;">' . __( 'Begin opnieuw', 'wif_filter' ) . '</span>';
        $html .= '</form>';
        return $html;   
    }

}