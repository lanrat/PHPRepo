<?php
class readpkg
{
    function openpkgf($file)
    {
        include_once("class/construct.class.php");
        $construct = new construct;
        
        $pkgsf = file_get_contents($file) or $construct->error("File does not exist");
        $pkgs = explode("\n\n",$pkgsf);
        foreach($pkgs as $key => $value)
        {
            $pkgs[$key] = trim($value);
            if( empty($value) )
            {
                unset($pkgs[$key]);
            }
        }
        return $pkgs;
    }
    
    function readpkgd($pkgdata)
    {
        include_once("class/readcontrol.class.php");
        $readcontrol = new readcontrol;
        $info = $readcontrol->runclass($pkgdata);
        return $info;
    }
    
    function lspkgs($pkgs,$file)
    {
        
        echo "<table cellpadding=\"5\">\n<tr><th>PackageName</th><th>Version</th><th>Arch</th></tr>\n";
        foreach($pkgs as $key => $value)
        {
            if( empty($value)){
                continue;
            }
            $pkgdata = $this->readpkgd($value);
            $pkg = $key + 1;
            $link = "pkgview.php?file=$file&pkg=$pkg";
            echo "<tr><td><a href=\"$link\">".$pkgdata["Package"]."</a></td><td><a href=\"$link\">".$pkgdata["Version"]."</a></td><td><a href=\"$link\">".$pkgdata["Architecture"]."</a></td></tr>\n";
        }
    echo "</table>\n";
    }
    
    function lspkg($pkg,$file)
    {
        
        $pkg--;
        $pkgs = $this->openpkgf($file);
        $pkginfo = $this->readpkgd($pkgs[$pkg]);
        
        echo "<table>\n";
        foreach($pkginfo as $key => $value)
        {
            if( empty($value)){
                continue;
            }if( $key == "Filename" )
            {
                echo "<tr><th>$key:</th><td><a href=\"$value\">$value</a></td></tr>\n";
            }else
            {
                echo "<tr><th>$key:</th><td>$value</td></tr>\n";
            }
        }
    echo "</table>\n";
    }
    
    function ctpkgs($file)
	{
        $pkgs = $this->openpkgf($file);
        
        $num = count($pkgs);
	    
	    return $num;
	}
	
	function pkgname($pkg,$file)
	{
	    $pkg--;
        $pkgs = $this->openpkgf($file);
        $pkginfo = $this->readpkgd($pkgs[$pkg]);
	    
	    $name = $pkginfo['Package'];
	    
	    return $name;
	}
    

}
?>
