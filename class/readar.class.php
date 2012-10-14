<?php
class readar
{
        function runclass($file)
        {
                include_once("class/construct.class.php");
                $construct = new construct;
                $this->contents = $file;
                if( $this->read_ar() == true )
                {                        
                        if( $this->filecontents("debian-binary") == "2.0\n")
                        {
                                $ctrltgz = $this->filecontents("control.tar.gz");
                                return($ctrltgz);
                        }
                        else
                        {
                                $construct->error("Bad deb version");
                        }
		}
                else
                {
                        $construct->error("Error bad archive");
                }
                
        }
        
        function read_ar()
        {
              $line1 = substr($this->contents, 0, 8);
              if ( $line1 == "!<arch>\n" )
              {
                  return true;
              }
              else
              {
                  return false;
              }
        }

        // find_filesize(archive,inner filename) returns the size in bytes of the inner file
        function find_filesize($file)
        {
            $filestart = strpos($this->contents, $file);
            $sizestart = $filestart + 48;
            $filesize = substr($this->contents, $sizestart, 9);
            settype($filesize,"integer");
            return($filesize);
        }

        //get the contents of a file in the archive filecontents(archive,size of inner file, innerfile)
        function filecontents($file)
        {
            $filesize = $this->find_filesize($file);
            $filestart = strpos($this->contents, $file);
            $datastart = $filestart + 60;
            $data = substr($this->contents, $datastart, $filesize);
            return($data);
        }
}
?>
