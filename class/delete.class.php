<?php
class delete
{
        function deldir($dirname)
        { 
                // Sanity check
                if (!file_exists($dirname)) {
                echo "<br>$dirname does not exist";
                    return false;
                }

                // Simple delete for a file
                if (is_file($dirname) || is_link($dirname)) {
                    return unlink($dirname);
                }

                // Loop through the folder
                $dir = dir($dirname);
                while (false !== $entry = $dir->read()) {
                // Skip pointers
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
        
                // Recurse
                $this->deldir($dirname . DIRECTORY_SEPARATOR . $entry);
            }

            // Clean up
            $dir->close();
            return rmdir($dirname);
        }
        
        function delpool($pool)
        {
            if( $this->deldir($pool) == true )
            {
                echo "<br>Pool: $pool deleted";
            }else
            {
                echo "<br>Could not delete pool: $pool";
            }
        }

        function delrepo()
        {
            if( $this->deldir("dists") == true )
            {
                echo "<br>Entire repository deleted";
            }else
            {
                echo "<br>Could not delete repo";
            }
        }
        
        function delall($pool)
        {
            $this->delpool($pool);
            $this->delrepo();
        }
        
        function delpkg($file,$pkg,$delpool = "no")
        {
            
            $pkg--;

            if( $delpool = "yes" )
            {
                $this->delfrompool($file,$pkg);
            }
            include_once("class/readpackages.class.php");
            $package = new readpkg;

            $fullpkgf = $package->openpkgf($file."/Packages");

            unset($fullpkgf[$pkg]);
            
            include_once("class/makepackage.class.php");
            $mkpkg = new makepackage;
            
            $mkpkg->remakepkg($file,$fullpkgf);
        }
        
        function delsrepo($file,$delpool = "no")
        {
            if( $delpool == "yes" )
            {
                include_once("class/readpackages.class.php");
                $package = new readpkg;
                $fullpkgf = $package->openpkgf($file."/Packages");
                include_once("class/readcontrol.class.php");
                $control = new readcontrol;
                
                foreach( $fullpkgf as $pkg )
                {
                    $pkgi = $control->runclass($pkg);
                    unlink($pkgi['Filename']);
                }
            }
            
            $this->deldir($file);
        }
        
        function delfrompool($file,$pkg = null)
        {
            include_once("class/readpackages.class.php");
            $package = new readpkg;
            $fullpkgf = $package->openpkgf($file."/Packages");
            $var = $pkg;
            if( $pkg = null )
            {
                foreach( $fullpkgf as $pkg )
                {
                    $this->delf($pkg);
                }
            }else
            {
                $this->delf($fullpkgf[$var]);
            }
            
        }
        
        function delf($pkg)
        {
            include_once("class/readcontrol.class.php");
            $control = new readcontrol;
            
            $pkgi = $control->runclass($pkg);
            unlink($pkgi['Filename']);
        }
}
?>
