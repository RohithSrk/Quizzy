<?php
/**
 * Quzzy Online Interactive Quiz Application
 * 404 Page
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

$page_title = "404 Page not found";

//Include Header
include_once( INCLUDES_PATH . "/header.php");
?>
We've no idea what you're looking for...
<br><a href="index.php">Go to Home</a>
<?php
include( INCLUDES_PATH . "/footer.php");
