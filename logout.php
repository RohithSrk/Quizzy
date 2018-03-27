<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Quizzy Logout page
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

//start session or resume
session_start();

//destroy active sessions
if(PHP_SESSION_ACTIVE){
    session_destroy();
}

//Redirec to home
header('location: /');
die();
