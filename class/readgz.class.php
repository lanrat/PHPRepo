<?php
class readgz
{
        function runclass($filename,$ctrltgz)
        {
                $this->contents_compressed = $ctrltgz;
                $filename = str_replace("debs/","",$filename);
                $filename = str_replace("/tmp/","",$filename);
                $this->tmp_file = "tmp/" . $filename . ".tar.gz";

                $this->create_tmp_file();
                $this->read_tmp_file();
                $this->del_tmp_file();
                
                return($this->contents_uncompressed);
        }
        
        function create_tmp_file()
        {
                if( is_dir("tmp") == false )
                {
                    mkdir("tmp");
                }
                $handle = fopen($this->tmp_file ,"w+");//write the tar.gz to a temp folder
                fwrite($handle,$this->contents_compressed);
                fclose($handle);
        }
        
        function read_tmp_file()
        {
                $handle = gzopen($this->tmp_file,"r");//uncompress .tar.gz
                $readgzsize = "1000000";
                $this->contents_uncompressed = gzread($handle,$readgzsize);
                gzclose($handle);
        }
        
        function del_tmp_file()
        {
                unlink($this->tmp_file);
        }
}
?>
