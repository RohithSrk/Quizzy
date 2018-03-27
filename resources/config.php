<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Configuration file to set application evironment
 * @package: Quizzy
 * @version: 0.1
 */

/** Application database name */
define('DB_NAME', 'quizzy');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123456');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** DEFINE directory paths */
defined('INCLUDES_PATH') or define('INCLUDES_PATH', realpath(dirname(__FILE__) . '/includes'));

/** DEFINE BASE URL */
defined('BASE_URL') or define('BASE_URL', 'http://localhost:63342/Quizzy_php/');

/**
 * Turn on error reporting and logging
 * Turn these off on production evironment
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');