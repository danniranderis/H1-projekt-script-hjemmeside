<?php
/**
 * Initial global settings included on every page
 **/

// Set the absolute path for the project
$absolute_path = realpath(dirname(__FILE__)) . '/';

// Set the locale/timezone to danish
setlocale(LC_ALL, 'da_DK.utf8');
date_default_timezone_set('Europe/Copenhagen');

// Set up the connection to the database
$db_conf = parse_ini_file($absolute_path.'db_credentials.ini');
$db = new mysqli($db_conf['host'], $db_conf['user'], $db_conf['password'], $db_conf['database']);

// Set charset to utf8 to mitigate weirdness in strings back and forth
$db->set_charset('utf8');

// Test the db-connection
if ($db->connect_error) {
    die('Kan ikke forbinde til databasen. Fejl: (' . $db->connect_errno . ') ' . $db->connect_error);
}