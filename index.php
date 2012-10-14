<?php
include_once("class/construct.class.php");
$construct = new construct;
$construct->pagestart();

echo "<h2>Repository Statistics</h2>";

if( is_dir("dists")  == false )
{
    echo "No Dists folder\n";
}else
{
    echo "<h4>Distributions</h4>\n";
	include_once("class/repos.class.php");
	$repos = new dists;
	$pkgs = $repos->repo_array();
	include_once("class/readpackages.class.php");
	$readpkg = new readpkg;
	
	echo "<ul>\n";
	foreach($pkgs as $dist => $var)
	{
	    echo "<li>$dist</li>\n";
	    echo "<ul>\n";
	    foreach( $pkgs[$dist] as $component => $var)
	    {
	        echo "<li>$component</li>\n";
	        echo "<ul>\n";
	        foreach( $pkgs[$dist][$component] as $arch)
	        {
	            $num = $readpkg->ctpkgs("dists/$dist/$component/binary-$arch/Packages");
	            echo "<li><a href=\"pkgview.php?file=dists/$dist/$component/binary-$arch\" >$arch</a> $num Packages</li>\n";
	        }
	        echo "</ul>\n";
	    }
	    echo "</ul>\n";
	}
	echo "</ul>\n";
}


if( is_dir($pool) )
{
    $poolf = scandir($pool);
    $fcount = 0;
    foreach( $poolf as $file )
    {
        if( is_file($pool.$file) == true )
        {
            $fcount++;
        }
    }
    echo "<h4>Number of packages in pool: ". $fcount ."</h4>";
    echo "<a href=\"$pool\">View pool</a>";
}else
{
    echo "<h4>Pool: ". $pool ." Does not yet exist</h4>";
}

$construct->pageend();
?>
