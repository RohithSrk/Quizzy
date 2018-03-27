<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Add contents through ajax
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

//start session or resume
session_start();

//check if its an ajax request, exit if not
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    if( strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' ) {
        //exit script outputting json data
        $output = json_encode( array( 'type' => 'error', 'text' => 'Request must come from Ajax' ));
        die($output);
    }

} else {
    //exit script outputting json data
    $output = json_encode( array( 'type' => 'error', 'text' => 'Request must come from Ajax' ));
    die($output);
}

$quizzy = new Quizzy();

//Check whether user is logged in and has add privilege else redirec to home
if( $quizzy->is_user_loggedin() ){
    if( !($_SESSION['add_content'] == 'Y') ) {

        //exit script outputting json data
        $output = json_encode( array( 'type' => 'error', 'text' => 'You don\'t have enough privileges to make this request.' ));
        die($output);
    }
} else {
    //exit script outputting json data
    $output = json_encode( array( 'type' => 'error', 'text' => 'You need to login to make this request' ));
    die($output);
}

//Handle Ajax Add Content request
if( isset($_POST['type']) ){

    //Handle Add Topic Ajax Requests
    if($_POST['type'] == 'topic'){

        if( $new_topic_id = $quizzy->add_topic( $_POST['topic_name'], $_POST['category_id'] ) ) {

            //On successfully inserting new topic_name output topic item with new topic's id
            $output = json_encode( array( 'type' => 'success',
                'new_topic' => sprintf( '<li class="topic"><a href="/topic.php?id=%d">%s<span class="label label-default">0</span></a></li>',
                    $new_topic_id, $_POST['topic_name']) ));

            //sleep(1);
            die($output);

        } else {
            $output = json_encode( array( 'type' => 'error', 'text' => 'Your data can\'t be validated.' ));
            die($output);
        }
    }

    //TODO: Handle Add Category Ajax Requests
    if($_POST['type'] == 'category'){

        if( $new_category_id = $quizzy->add_category( $_POST['category_name'] ) ){

            //On successfully inserting new category_name output category item with new id
            $output = json_encode( array( 'type' => 'success', 'new_category_id' => $new_category_id ));
//            sleep(1);
            die($output);

        } else {
            $output = json_encode( array( 'type' => 'error', 'text' => 'Your data can\'t be validated.' ));
            die($output);
        }
    }

}else{
    $output = json_encode(array('type'=>'error', 'text' => 'One/more of required fields are empty.'));
    die($output);
}