<?php
class install
{
    function geninstall($package,$components)
    {
        $catalog = "repository";
        
        $url = $this->curPageURL();
        
        $install = "[install]\n";
        $install .= "catalogues = $catalog\n";
        $install .= "package = $package\n";
        $install .= "\n";
        $install .= "[$catalog]\n";
        $install .= "name = $catalog\n";
        $install .= "uri = $url\n";
        $install .= "components = $components\n";
        
        return $install;
    }
    
    
    function curPageURL()
    {
        $pageURL = 'http';
        
        if($_SERVER["HTTPS"] == "on")
        {
            $pageURL .= "s";
        }
        
        $pageURL .= "://";
        
        if($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        }else
        {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        
        return dirname($pageURL);
    }
}
?>
