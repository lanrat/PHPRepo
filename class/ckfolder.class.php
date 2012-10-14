<?php
class ckfolder
{
	function runclass($pool,$dist,$component,$arch)
	{
        $folders = array(
		$pool,
		"dists/",
		"dists/" . $dist,
		"dists/" . $dist ."/". $component,
		"dists/" . $dist ."/". $component ."/binary-".$arch);
		
		if( $arch == "all" )
        {
            unset($folders[4]);

        }
        
        foreach($folders as $key => $file)
		{
			$this->ckarray($file);
		}
	}
	
	function ckarray($folder)
	{
		if( $this->isfolder($folder) == true )
		{
			return true;
		}else
		{
			echo "Folder: $folder does not exist, creating it<br>\n";
			mkdir($folder);
			return false;
		}
	}
	
	function isfolder($folder)
    {
        $isdir = is_dir($folder);
        if( $isdir == true )
        {
            return true;
        }else
        {
            return false;
        }
    }

}

?>