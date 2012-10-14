<?php

class login
{
        function __construct()
        {
                if( session_id() == "" )
                {
                        session_start();// start up your PHP session!
                }
        }
        
        function checkuser($user,$pass)
        {
                global $username, $password;
                if( trim($user) == $username and trim($pass) == $password)
                {
                        $this->login();
                        return true;
                }else
                {
                        return false;
                }
        }
        
        function login()
        {
                $_SESSION['phprepoauth'] = 1; // store session data
        }
        
        function logout()
        {
                $_SESSION['phprepoauth'] = 0; // empty session data
                session_destroy();//del cookie
                header('Location: index.php');
        }
        
        function requirelogin()
        {
                if($this->checklogin() == false)
                {
                        header('Location: login.php');
                        exit("Need to login");
                }else
                {
                        return true;
                }
        }
        
        function checklogin()
        {
                if( @$_SESSION['phprepoauth'] == 1 )
                {
                        return true;

                }else
                {
                        return false;
                }
        }
}

?>
