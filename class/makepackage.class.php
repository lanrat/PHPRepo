<?php

class makepackage
{
        function runclass($fileloc,$pkginfo)
        {
			if( $pkginfo["Architecture"] == "all" )
            {
                echo "Package is for all arch, putting it in previously created archs\n<br>\n";
                $this->allarch($fileloc,$pkginfo);
            }else
            {
                $fileloc = $fileloc . "binary-". $pkginfo["Architecture"] ;
                $this->makepkg($fileloc,$pkginfo);
            }
        }
        
        function makepkg($fileloc,$pkginfo)
        {

			$pkgd = $this->genpkginfo($pkginfo);
			
			$this->createpkgs($fileloc,$pkgd);
        }
        
        function createpkgs($fileloc,$pkgd)
        {
            include_once("class/construct.class.php");
            $construct = new construct;

            
            if (!$handle = fopen($fileloc."/Packages", 'a'))
			{
				$construct->error("Error, cannot make Packages file");
			}else
			{
				
				if (fwrite($handle, $pkgd ) === FALSE)
				{
					$construct->error("Cannot write to file");
				}
				fclose($handle);
			}
			
			$this->makegz($fileloc);
        }
        
        function remakepkg($fileloc,$pkgsd)
        {
            unlink($fileloc."/Packages");
            foreach( $pkgsd as $pkgd )
            {
                $pkgd .= "\n\n";
                $this->createpkgs($fileloc,$pkgd);
            }
        }
		
		function genpkginfo($pkginfo)
		{
			global $pool;
			
			$file = $pool . $_FILES["file"]["name"];
			
			@$package = array(
				"Package" => $pkginfo["Package"],
				"Priority" => $pkginfo["Priority"],
                "Section" => $pkginfo["Section"],
				"Installed-Size" => $pkginfo["Installed-Size"],
				"Maintainer" => $pkginfo["Maintainer"],
				"Architecture" => $pkginfo["Architecture"],
                "Source" => $pkginfo["Source"],
				"Version" => $pkginfo["Version"],
                "Depends" => $pkginfo["Depends"],
				"Replaces" => $pkginfo["Replaces"],
				"Suggests" => $pkginfo["Suggests"],
				"Provides" => $pkginfo["Provides"],
				"Conflicts" => $pkginfo["Conflicts"],
				"Filename" => $file,
				"Size" => filesize($file),
				"MD5sum" => md5_file($file),
				"SHA1" => sha1_file($file),
                "SHA256" => hash_file("sha256",$file),
				"Description" => $pkginfo["Description"],
	    		"Long-Description" => $pkginfo["Long_Description"]);
			
            $something ="";
			foreach($package as $title => $value)
			{
				if( empty($value) )
				{
					continue;
				}
				if($title == "Long-Description")
				{
					$something .= $value."\n";
				}else
				{
					$something.=$title.": ".$value."\n";
				}
			}
			$final = trim($something) . "\n\n";
			
			return $final;
		}
		
		function makegz($fileloc)
		{
            include_once("class/construct.class.php");
            $construct = new construct;
            
            $pdata = implode("", file($fileloc."/Packages")); 
            $gzdata = gzencode($pdata, 9); 
            $fp = fopen($fileloc."/Packages.gz","w");
            fwrite($fp, $gzdata) or $construct->error("Could not create Packages.gz"); 
            fclose($fp); 
		}
        
        function allarch($fileloc,$pkginfo)
        {
            $allarch = scandir($fileloc);
            if ( count($allarch) <= 2 )
            {
                echo "<strong>Warning: No other archs created yet, please upload a file for that arch first, or manually create the arch folder!</strong>\n<br>\n";
            }else
            {
                foreach( $allarch as $archm )
                {
                    if( $archm != "." and $archm != ".." )
                    {
                        $archloc = $fileloc . $archm;
                        $this->makepkg($archloc,$pkginfo);
                    }
                }
            }
        }

}

?>
