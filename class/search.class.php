<?php
class search
{
        function runclass($query)
        {
            $answer = $this->search_tree($query);
            
            if( empty($answer) )
            {
                echo"<h3>No results found</h3>";
            }else
            {
                $this->list_results($answer);
            }
        }
        
        function search_tree($query)
        {
			include_once("class/repos.class.php");
			include_once("class/readpackages.class.php");
			$repos = new dists;
			$readpkg = new readpkg;
			
			$pkgs = $repos->repo_tree();
			
			
			/* a no longer needed test
			foreach( $pkgs as $key => $value )
			{
				echo "<small>Searching: $value/Packages</small><br />\n";
			}*/
			
			$answer = array();
			
			foreach( $pkgs as $key => $value )
			{
				$file_array = $this->search_file($value."/Packages",$query);
				if( !empty($file_array) )
				{
				    $answer[$value] = $file_array;
				}
			}
			
			return $answer;
				
		}
        
		
        function search_file($file,$query)
        {
            include_once("class/readpackages.class.php");
            $readpkg = new readpkg;
            
            $repo = $readpkg->openpkgf($file);
            
            $pkg_array = array();
            
            foreach( $repo as $key => $value )
            {
                if ($this->search_pkg($value,$query) )
                {
                    $pkg_array[] = $key;
                }
            }
            
            return $pkg_array;
        }
        
        function search_pkg($pkginfo,$query)
        {
            include_once("class/readcontrol.class.php");
            $rdcontrol = new readcontrol;
            
            $pkgdata = $rdcontrol->runclass($pkginfo);
        
            if( strpos($pkgdata['Package'],$query) !== false )
            {
                return true;
			}elseif( strpos($pkgdata['Description'],$query) !== false )
			{
			    return true;
			}elseif( @strpos($pkgdata['Long_Description'],$query) !== false )
			{
			    return true;
			}else
			{
			    return false;
			}
        }
        
        function list_results($answer)
        {
            include_once("class/readcontrol.class.php");
            include_once("class/readpackages.class.php");
            include_once("class/repos.class.php");
            $rdcontrol = new readcontrol;
            $rdpkgs = new readpkg;
            $repos = new dists;
            
            echo "<table cellpadding=\"5\">\n<tr><th>PackageName</th><th>Version</th><th>Arch</th><th>Distribution</th><th>Component</th></tr>\n";
            
            foreach( $answer as $key => $value )
            {
                $pkg_array = $rdpkgs->openpkgf($key."/Packages");
                
                $pkgplace = $repos->repo_array($key."/Packages");
                
                foreach( $value as $pkg )
                {
                    $pkgi = $rdcontrol->runclass($pkg_array[$pkg]);
                    
                    $pkgnum = $pkg + 1;
                    $link = "pkgview.php?file=$key&pkg=$pkgnum";
                    echo "<tr><td><a href=\"$link\">".$pkgi["Package"]."</a></td><td><a href=\"$link\">".$pkgi["Version"]."</a></td><td><a href=\"$link\">".$pkgi["Architecture"]."</a></td><td><a href=\"$link\">".$pkgplace[0]."</a></td><td><a href=\"$link\">".$pkgplace[1]."</a></td></tr>\n";
                }
            }
            
            echo "</table>\n";
            
            /* for debug
            echo "<pre>";
            print_r($answer);
            echo "</pre>";*/
        }
}
?>
