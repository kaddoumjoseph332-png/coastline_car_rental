<?php
session_start();

// Use an empty string when the web server points directly at public/.
define('PUBLIC_PATH', '/car_rental_demo/public');
mysqli_report(MYSQLI_REPORT_OFF);

require_once("db_credentials.php");
require_once("database.php");
require_once("functions.php");
require_once("validation_functions.php");
require_once("query_functions.php");

$db = db_connect();
if (!mysqli_set_charset($db, 'utf8')) {
    exit('Could not set the database character set.');
}
