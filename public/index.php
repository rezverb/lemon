<?php

/**
 * Put configurations and other controls here.
 */

session_start();

/**
 * Serve USD Currency by default
 * Setting this here suppresses many warning logs on the server
 */
if(!isset($_SESSION['active_currency']))
{
    $_SESSION['active_currency'] = 'USD';
    $_SESSION['active_currency_symbol'] = '$';
}



// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
            ->run();



