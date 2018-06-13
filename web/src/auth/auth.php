<?php
/**
 * Auth-module for dealing with authentications
 **/


class UserNotFoundException extends Exception
{
}

class NoPasswordException extends Exception
{
}

class Auth
{
    /** Class for handling all authentication operations **/

    protected static $instance;
    protected $user_id, $username, $full_name, $short_name, $email, $db_pw_hash;
    protected static $password_options = [
        'cost' => 12
    ];

    protected function __construct($username)
    {
        $_SESSION['auth'] = $this;
        $this->username = $username;
        $this->loadDbValues();
    }


    protected static function HashPassword($pw)
    {
        /* Hash the given string and return it */
        return password_hash($pw, PASSWORD_DEFAULT, self::$password_options);
    }

    protected function SavePassword($hash)
    {
        /* Save the password-hash to the db */
        global $db;
        if ($user = $db->prepare("UPDATE users SET pw_hash = ? WHERE user_id = ?")) {
            $user->bind_param('si', $hash, $this->user_id);
            $user->execute();
            return true;
        }
        return false;
    }

    protected function VerifyPassword($pw, $db_pw_hash)
    {
        /* Validate that the provided password is the same as hash from db */
        if (password_verify($pw, $db_pw_hash))
            return true;
        return false;
    }

    protected function ReHashPassword($pw, $db_pw_hash)
    {
        if (password_needs_rehash($db_pw_hash, PASSWORD_DEFAULT))
            return self::SavePassword(self::HashPassword($pw));
        return false;
    }

    protected function LogLoginAttempt($user_id, $success)
    {
        /* Log a login-attempt in the db */
        global $db;
        if ($log = $db->prepare("INSERT INTO login_attempts(user_id, success) VALUES (?, ?)")) {
            $log->bind_param('ii', $user_id, $success);
            $log->execute();
            return true;
        }
        return false;
    }

    public function login($username, $pw)
    {
        /* Login or fail */
        global $db;

        // Try getting the user
        if ($user = $db->prepare("SELECT id, username, pw_hash FROM users WHERE username = ? LIMIT 1")) {
            $user->bind_param('s', $username);
            $user->execute();
            $user->store_result();

            // Get variables from the db-result
            $user->bind_result($user_id, $username, $db_pw_hash);
            $user->fetch();

            if ($user->num_rows == 1) {
                // Check validity
                if (self::VerifyPassword($pw, $db_pw_hash)) {
                    // Password is valid - log the user in
                    self::$instance = new Auth($username);
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $db_pw_hash . $user_browser);

                    // Save attempt log
                    self::LogLoginAttempt($user_id, true);

                    // Test if the password needs to be rehashed, and if so - do it
                    self::ReHashPassword($pw, $db_pw_hash);

                    return true;

                } else {
                    // Password is not correct - log the attempt
                    self::LogLoginAttempt($user_id, false);

                    throw new UserNotFoundException("Bruger ikke fundet!");
                }
            } else {
                return false;
            }
        }
    }

    public static function isLoggedIn()
    {
        return self::$instance != null;
    }

    public function logout()
    {
        self::$instance = null;
        unset($_SESSION['auth']);
    }

    protected function loadDbValues()
    {
        global $db;
        if ($user = $db->prepare("SELECT username, email, full_name, short_name, pw_hash FROM users WHERE id = ? LIMIT 1")) {
            $user->bind_param('i', $this->user_id);
            $user->execute();

            // Get variables from the db-result
            $user->bind_result($db_username, $db_email, $db_full_name, $db_short_name, $db_pw_hash);
            $user->fetch();

            $this->username = $db_username;
            $this->email = $db_email;
            $this->full_name = $db_full_name;
            $this->short_name = $db_short_name;
            $this->db_pw_hash = $db_pw_hash;
        }
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function getUsername()
    {
        $this->loadDbValues();
        return $this->username;
    }

    public function getFullName()
    {
        $this->loadDbValues();
        return $this->full_name;
    }

    public function getShortName()
    {
        $this->loadDbValues();
        return $this->short_name;
    }

    public function getEmail()
    {
        $this->loadDbValues();
        return $this->email;
    }
}







