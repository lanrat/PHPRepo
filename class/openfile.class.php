<?php

class openfile
{
	function runclass($file,$size)
	{
		$this->file = $file;
		$this->fsize = $size;
		return($this->read_file());
	}
	
        //return the contents of the file in a string
	function read_file()
        {
                global $maxsize;
                ini_set('memory_limit',$maxsize . "M");
                include_once("class/construct.class.php");
                $construct = new construct;
                if( $this->fsize <= ($maxsize *  1048576))
                {
                        
                        include_once("class/construct.class.php");
                        $construct = new construct;
                        $fh = file_get_contents($this->file) or $construct->error("No File!");
                        return($fh);
                }else
                {
                        $construct->error("File larger than " . $maxsize . "MB");
                }

	}

	
}

?>
