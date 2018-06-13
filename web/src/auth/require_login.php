<?php
/**
 * PHP-script for requiring login for pages this is included on
 */

require_once('../global.php');
require_once('auth.php');

function logged_in ()
{
    if (isset($_SESSION['username'], $_SESSION['login_string']))
    {
        global $db;
        $username = $_SESSION['username'];
        $login_string = $_SESSION['login_string'];

        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $db->prepare("SELECT pw_hash FROM users WHERE username = ? LIMIT 1"))
        {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1)
            {
                $stmt->bind_result($db_pw_hash);
                $stmt->fetch();
                $login_check = hash('sha512', $db_pw_hash . $user_browser);

                if (hash_equals($login_check, $login_string))
                {
                    return true;
                }
            }
        }
    }
    return false;
}

if (!logged_in())
{
    header("Location: /auth/login.php");
}