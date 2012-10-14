<?php
global $islogin, $loginpage;
$loginpage = 1;
include_once("class/construct.class.php");
$construct = new construct;
$construct->pagestart();

@$user = $_POST['user'];
@$pass = $_POST['pass'];
@$action = $_GET['action'];

if( $action == "logout")
{
        $login->logout();
}

if(empty($user) == false or empty($pass) == false)
{
        if( $login->checkuser($user,$pass) != true )
        {
                $msg = "Bad username or password!";
        }
}

$islogin = $login->checklogin();

if($islogin == false)
{
?>
<h3 align="center">Please login</h3>
<form method="post">
<table align="center">
<tr>
        <td colspan="2"><h3 style="color: red;" align="center"><?php echo(@$msg); ?></h3></td>
</tr>
<tr>
        <td>Username:</td>
        <td><input name="user" size="20" type="text"></td>
</tr>
<tr>
        <td>Password:</td>
        <td><input name="pass" size="20" type="password"></td>
</tr>
<tr>
        <td></td>
        <td><input name="login" class="mainoption" value="Log in" type="submit"></td>
</tr>
</table>
</form>
<?php
}else
{
        header('Location: index.php');
}
$construct->pageend();
?>
