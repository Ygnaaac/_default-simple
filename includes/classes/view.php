<?php
class View {
    protected $filename;
    protected $data;
    protected $prepend;
    protected $append;
    protected $header;
    protected $footer;

    function __construct( $filename ) {
        $this->filename = $filename;
        $this->prepend = '';
        $this->append = '';
        $this->header = '';
        $this->footer = '';
    }

    function escape( $str ) {
        return htmlspecialchars( $str ); //for example
    }

    function setHeader( $filename ) {
        $this->header .= $this->render(false, $filename);
    }

    function setFooter( $filename ) {
        $this->footer .= $this->render(false, $filename);
    }

    function append( $filename ) {
        $this->append .= $this->render(false, $filename);
    }

    function prepend( $filename ) {
        $this->prepend .= $this->render(false, $filename);
    }

    function __get( $name ) {
        if ( isset( $this->data[$name] ) ) {
            return $this->data[$name];
        }
        return false;
    }

    function __set( $name, $value ) {
        $this->data[$name] = $value;
    }

    function render( $print = true, $filename = false ) {
        ob_start();
        if ( !$filename )
            $filename = $this->filename;
        include ( $filename );
        $rendered = ob_get_clean();
        if ( $print ) {
            echo $rendered;
            return;
        }
        return $rendered;
    }

    function __toString() {
        return $this->header . $this->prepend . $this->render(false) . $this->append . $this->footer;
    }
}