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

    public function get_structure_array() {
        $structure = $this->get_structure();
        if ( empty( $structure ) ) return;
        return explode( "{{", $structure );
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
            $options_html = array_map( function( $option ) {
                return '<option value="' . $option['value'] . '">' . $option['label'] . '</option>';
            }, $options );
            $html = '<select name="' . $name . '">' . $options_html . '</select>';
        }
        return $html;
    }

    public function get_html() {
        // if ( empty( $this->_structure ) ) return;
        // $html = '';
        // foreach ( $this->structure as $element ) {
        //     switch ( $element['type'] ) {
        //         case 'text' :
        //             $html .= $this->get_text_html( $element );
        //             break;
        //         case 'dropdown' : 
        //             $html .= $this->get_dropdown_html( $element );
        //             break;
        //     }
        // }
        // return $html;   
        var_dump( $this->_structure );
    }

}