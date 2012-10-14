<?php
include_once("class/construct.class.php");
$construct = new construct;
$construct->pagestart();
@$pkg = $_GET['pkg'];
@$file = $_GET['file'];

include_once("class/repos.class.php");
include_once("class/readpackages.class.php");
$repos = new dists;
$readpkg = new readpkg;
if( empty($file) ) //see if we should display menu
{
	echo "<h3>Select a repository</h3>\n";
	$pkgs = $repos->repo_tree();
    
    echo "<ol>";
	foreach($pkgs as $value)
	{
		echo "<li><a href=\"pkgview.php?file=$value\">$value</a></li>";
    }
    echo "</ol>";
    
}elseif( empty($pkg) ) //if we have a repo to display
{
    $rfile = $file.'/Packages';
    $pkgs = $readpkg->openpkgf($rfile);
    if( empty($pkgs) )
    {
        echo "<h3>No Packages In File</h3>";
    }else
    {
        echo "<h3>Packages in <a target=\"_blank\" href=\"$rfile\">$rfile</a></h3>\n";
        $pkgnum = $readpkg->ctpkgs($rfile);
        echo "$pkgnum Packages in repo\n";
        $readpkg->lspkgs($pkgs,$file);
    }
    
}else //and a package to display
{
    $rfile = $file.'/Packages';
    $pkgplace = $repos->repo_array($rfile);
    
    $name = $readpkg->pkgname($pkg,$rfile);
    
    echo "Disttribution: $pkgplace[0] &nbsp;&nbsp; Components: $pkgplace[1] &nbsp;&nbsp; Arch: $pkgplace[2] \n";
    if( @$_SESSION['phprepoauth'] == 1 )
    {
        echo "<div style=\"float: right\"><a href=\"delete.php?action=delpkg&file=$file&pkg=$pkg\">Delete from repo</a><br><a href=\"delete.php?action=delpkg&file=$file&pkg=$pkg&delpool=yes\">Delete from repo and pool</a></div>\n";
    }
    $readpkg->lspkg($pkg,$rfile);
    echo "<a href = \"install.php?pkg=$name&comp=$pkgplace[1]\">Download $name install file</a>";
    
}

$construct->pageend();
?>
