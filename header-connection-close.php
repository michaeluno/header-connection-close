<?php
/**
 *	Plugin Name:    Header Connection Close
 *	Plugin URI:     http://en.michaeluno.jp/
 *	Description:    Boosts the site performance by closing the HTTP connection between the server and the client.
 *	Author:         Michael Uno
 *	Author URI:     http://michaeluno.jp
 *	Version:        1.0.0
 */

/**
 *
 */
class HeaderConnectionClose {

    public function __construct() {

        add_action( 'init', array( $this, 'startCapturing' ) );
        add_action( 'shutdown', array( $this, 'endCapturing' ), PHP_INT_MIN ); 

    }

    public function startCapturing() {
         ob_start();
    }

    /**
     * @remark      Should be called before `wp_ob_end_flush_all()`.
     */
    public function endCapturing() {

        $_iOutputBufferLength = ( integer ) ob_get_length();
        if ( ! headers_sent() ) {
            @header('Content-Length: ' . $_iOutputBufferLength ) ;
            @header('Connection: close' );
        }
        if ( $_iOutputBufferLength ) {
            ob_end_flush();
        }

    }

}
new HeaderConnectionClose;