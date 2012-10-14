<?php
class dists
{

	function repo_tree()
	{
		
		$array = array();
		$sdists = scandir("dists");
		foreach( $sdists as $dist )
		{
			if( $dist != "." and $dist != ".." )
			{
				$rcomponents = scandir("dists/$dist");
				foreach( $rcomponents as $component )
				{
					if( $component != "." and $component != ".." )
					{
						$rarch = scandir("dists/$dist/$component");
						foreach( $rarch as $arch )
						{
							if( $arch != "." and $arch != ".." )
							{
								$array[] = "dists/$dist/$component/$arch";
							}
						}
					}
				}
			}
		}
		
		return $array;
	}
	
	function repo_array( $single = "no" )
	{
	    $array = array();
	    if ( $single != "no" )
	    {
	        $repos[0] = $single;
	    }else
	    {
	        $repos = $this->repo_tree();
	    }
	    
	    foreach( $repos as $repo )
	    {
            $dist = $this->repo_explode($repo,1);
            $component = $this->repo_explode($repo,2);
            $archf = $this->repo_explode($repo,3);
            $arch = substr($archf,7);
            
            $array[$dist][$component][] = $arch;
	    }
	    
	    $repoparts = $array;
	    
	    if( $single != "no" )
	    {
	        
	        $dist = array_keys($repoparts);
            $comp = array_keys($repoparts[$dist[0]]);
            $arch = $repoparts[$dist[0]][$comp[0]];
            
            $array = array( $dist[0], $comp[0], $arch[0] );
	        return $array;
	    }else
	    {
	        return $repoparts;
	    }
	}
	
	function repo_explode($repo,$part)
	{
	    $parts = explode("/",$repo);
	    return $parts[$part];
	}
	

}
?>
