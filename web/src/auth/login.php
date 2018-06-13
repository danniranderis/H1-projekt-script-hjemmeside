<?php
/**
 * PHP-script for logging in a user
 */

require_once('../global.php');
require_once('auth.php');

try
{
    if (!Auth::isLoggedIn() && $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $login = $_POST['username'];
        $pw = $_POST['pw'];
        $logged_in_ok = Auth::login($login, $pw);

        if ($logged_in_ok)
        {
            header("Location: /hemmeligt/");
        }
        else
        {
            $errormsg = "Forkert login";
        }
    }
}
catch (Exception $e)
{
    if ($e instanceof UserNotFoundException)
        $errormsg = "Forkert login";
    else
        $errormsg = "Fejl!: {$e->getMessage()}";
}




# Include the base header
include_once('../base_header.php');
?>

<form name="f" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <div class="box" style="width: 300px; float: middle; position: relative; left: 230px;">
        <h1>Login</h1>
        <p>
            <a href="/auth/forgotpassword.php">Glemt dit password, eller første login?</a>
        </p>
        <table>
            <tr><td colspan="2"><?php if (isset($errormsg)) {echo "<span style='color:red;'>".$errormsg."</span>";} ?></td></tr>
            <tr><td>Brugernavn:</td><td><input type="text" name="username" /></td></tr>
            <tr><td>Password:</td><td><input type="password" name="pw" /></td></tr>
            <tr><td colspan="2"><input type="submit" value="Login" /></td></tr>
        </table>
    </div>
</form>


<?php
# Include the base footer
include_once('../base_footer.php');
?>