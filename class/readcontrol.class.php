<?php

class readcontrol
{
        function runclass($control)
        {

                $this->contents = $control;
                if( false == empty($this->contents))
                {
                        $data = $this->breakfile();
                        return $data; 
                }
                else
                {
                        include_once("class/construct.class.php");
                        $construct = new construct;
                        
                        $construct->error("No Data");
                }

        }
        
        function breakfile()
        {
                $array = explode("\n",$this->contents);
                $in_desc = "no";
                foreach($array as $key => $line )
                {

                                $temp_array = explode( ":" , $line , 2 );
								if(count($temp_array) > 1)
								{
                                
                                //if( in_array($temp_array[0],$placevars) != false )
                                //{
                                    $this->control[trim($temp_array[0])] = trim($temp_array[1]);
                                    if($temp_array[0] == "Description")
                                    {
                                        $in_desc = "yes";
                                        $this->control["Long_Description"] = "";
                                    }else
									{
										$in_desc = "no";
									}
                                //}
								}else
								{
									if( $in_desc == "yes")
									{
										$this->control["Long_Description"] .= $line . "\n";
									}
								}
                }
                if( true == empty($this->control["Long_Description"]) )
                {
                    unset($this->control["Long_Description"]);
                }
                return($this->control);
        }
}
?>
