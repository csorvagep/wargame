<?php

$msg = array();

try
{
    if(auth())
        tovabb("/fooldal");

    if(isset($_POST['login']) && $_POST['login'] == "Sign In")
    {
        if(!isset($_POST['username']) || empty($_POST['username']))
            $msg[] = "No username!";

        $username = htmlspecialchars($_POST['username']);

        if(!isset($_POST['pass']) || empty($_POST['pass']))
            $msg[] = "No password!";

        $pass = htmlspecialchars($_POST['pass']);

        if(!count($msg))
        {
            $tomb = rekord("users", "username", strtolower($username));
            if($tomb == 0)
                $msg[] = "User not exists!";
            else if($pass != $tomb['pass'])
                $msg[] = "Wrong password!";
            else
            {
                login($tomb['user_id']);
                if(isset($_POST['to']) && !empty($_POST['to']))
                    tovabb($_POST['to']);
                else
                    tovabb("/fooldal");
            }
        }
    }
}
catch(Exception $ex)
{
    $msg[] = $ex->getMessage();
}
$CSS = array();
$SCRIPT = array();
$SCRIPT[] = "/script/sha1.js";
$SCRIPT[] = "/script/login.js";

$TITLE = "Sign In";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");
?>
<div id="content">
	<h1>Sign In</h1>
	<div align="center">
		<form method="post" action="<?=$_SERVER['REQUEST_URI'] ?>" name="login" id="login">
			<?php
            foreach($msg as $h)
            {
                echo "<p class=\"warn\">$h</p>";
            }
			?>
			<table border="0">
			<tr>
			<td> Username:</td>
			<td><input type="text" name="username" <?php
                if(isset($username))
                    echo "value=\"" . $username . "\"";
 ?> id="username" /></td>
			</tr>
			<tr>
			<td>Password:</td>
			<td><input type="password" name="pass" <?php
                if(isset($pass))
                    echo "value=\"" . $pass . "\"";
 ?> id="password" /></td>
			</tr>
			<tr>
			<td align="center" colspan="2"><input type="submit" name="login" value="Sign In" /></td>
			</tr>
			</table>
			<?php
                if(isset($_GET['to']))
                    echo "<input type=\"hidden\" name=\"to\" value=\"" . $_GET['to'] . "\" />";
			?>
		</form>
	</div>
</div>
<?php
require ("content/common/site_footer.php");
?>