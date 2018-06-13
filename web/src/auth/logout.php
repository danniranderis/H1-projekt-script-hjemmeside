<?php
/**
 * PHP-script for logging out a user
 */

require_once('../global.php');
require_once('auth.php');

Auth::logout();

header("Location: http://${_SERVER['HTTP_HOST']}");