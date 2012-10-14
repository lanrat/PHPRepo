<?php

class construct
{
	function __construct()
    {
        include_once("config.php");
        require_once("class/login.class.php");
        global $login, $require_login, $islogin, $guest, $loginpage;
        $login = new login;
        if( $require_login == "yes" or $guest == 0 )
        {
            if( $loginpage !== 1 )
            {
                $login->requirelogin();
            }
        }
    }
    
    function pagestart()
	{
        $this->header();
        $this->sidebar();
        echo '<div id="content">';
	}
	
    function pageend()
    {
        echo '<br /><br /></div>';
        $this->footer();
        $this->htmlend();
    }
    
    function header()
    {
        include_once("data/header.php");
    }
    
    
    function footer()
    {
        include_once("data/footer.php"); 
    }
    
    function sidebar()
    {
        include_once("data/sidebar.php"); 
    }
    
    function htmlend()
    {
        echo '</div></body></html>';
    }
    
    function error($msg = "Error")
    {
        echo "<strong>$msg</strong>";
        $this->pageend();
        die();
    }
}

?>
