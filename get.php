<?php
/**
 * Quzzy Online Interactive Quiz Application
 * JSON Data Provider
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

if( isset($_REQUEST['type']) ){

    $quizzy = new Quizzy();

    //Handle Topic data requests
    if( $_REQUEST['type'] == 'topics' and isset( $_REQUEST['cid'] ) ){

        //validate category id
        if( preg_match( "/^\d+$/", $_REQUEST['cid'] ) ){

            if( $topic_details = $quizzy->get_topics( $_REQUEST['cid'] ) ){

                $output = json_encode( $topic_details );
                die($output);

            }

        }

    }

    //TODO: Handle Category data requests
    if( $_REQUEST['type'] == 'categories' ){

    }

}