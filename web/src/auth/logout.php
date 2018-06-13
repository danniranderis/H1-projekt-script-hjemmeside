<?php
/**
 * PHP-script for logging out a user
 */

require_once('../global.php');
require_once('auth.php');
@session_start();

if (Auth::isLoggedIn())
    Auth::getInstance()->logout();

header("Location: http://${_SERVER['HTTP_HOST']}");