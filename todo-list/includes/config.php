<?php
define('INCLUDES', realpath(dirname(__DIR__ . "/../")));

// Database credentials
define('DB_HOST', 'm183-lb2-db');
define('DB_USER', 'root');
define('DB_PASS', 'Some.Real.Secr3t');
define('DB_NAME', 'm183_lb2');

error_reporting(E_ALL);
ini_set('display_errors', 1);
define('DEBUG',true);
// mysqli_report(MYSQLI_REPORT_ALL);
