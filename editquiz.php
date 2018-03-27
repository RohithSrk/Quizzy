<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Edit an existing quiz page
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

//start session or resume
session_start();

$quizzy = new Quizzy();

//check login
if( !$quizzy->is_user_loggedin() ){
    //redirect to login
    header('location: /login.php');
    die();
}