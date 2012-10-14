<?php

class readtar
{
        function runclass($tar)
        {
                include_once("class/construct.class.php");
                $construct = new construct;

                $this->tar = $tar;
                if(false != empty($this->tar))
                {
                        $construct->error("No Tar data");
                }
                //echo $tar;
                $data = $this->filecontents("./control");
                if ( $data == false )
                {
                    $data = $this->filecontents("control");
                    if( $data == false  )
                    {
                        $construct->error("Cant fine control file inside tar");
                    }
                }
                $cleandata = $this->cleandata($data);
                
                return $cleandata;
        }
        
        function find_filesize($filename)
        {
            $namestart = strpos($this->tar, $filename);
            if( $namestart === false)
            {
                return false;
            }
            $sizestart = $namestart + 124;
            $filesize = substr($this->tar, $sizestart, 12);
            settype($filesize,"integer");
            return($filesize);
        }
        
        function filecontents($filename)
        {
                $filesize = $this->find_filesize($filename);
                
                if( $filesize > 0)
                {
                        $filestart = strpos($this->tar, $filename);
                        $datastart = $filestart + 345 +55;
                        $data = substr($this->tar, $datastart, $filesize);
                        //$nullst = strpos( $data, /0
                        return($data); 
                }
                else
                {
                        return false;
                        //die("Could not tetermine control filesize inside tar");
                }
                

        }
        
        function cleandata($data)
        {
                $ncdata = trim($data);
                $nullst = strpos($ncdata, "\0");
                
                if( empty($nullst) == false )
                {
                        $ncdata = substr($ncdata, 0, $nullst);
                }

                return $ncdata;
        }
}

?>
