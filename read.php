<?php
ini_set('display_errors', 1);
include_once("class/openfile.class.php");
include_once("class/readar.class.php");
include_once("class/readgz.class.php");
include_once("class/readtar.class.php");
include_once("class/readcontrol.class.php");
include_once("class/ckfolder.class.php");
include_once("class/makepackage.class.php");include_once("class/construct.class.php");
$require_login = "yes";
$construct = new construct;
$construct->pagestart();

//See if file is local or uploaded
$file = $_FILES["file"]["tmp_name"] or $construct->error("No data submitted");
$size = $_FILES["file"]["size"] or $construct->error("No data submitted");
$dist = $_POST['dist'] or $construct->error("No data submitted");
$component = $_POST['component'] or $construct->error("No data submitted");
@$newd = $_POST['newdist'];
@$newc = $_POST['newcomponent'];

if( $dist == "new" )
{
    if( empty($newd) )
    {
        $construct->error("You must enter a Dist");
    }else
    {
        $dist = $newd;
    }
}
if( $component == "new" )
{
    if( empty($newc) )
    {
        $construct->error("You must enter a Component");
    }else
    {
        $component = $newc;
    }
}

//put the file contents into a variable
$openfile = new openfile;
$filedata = $openfile->runclass($file,$size);

//test at file, returns contents of control.tar.gz
$readar = new readar;
$data = $readar->runclass($filedata);

//writes compressed gc file to disk, reads it, uncompresses it, delets it, and returns the uncompressed contents
$readgz = new readgz;
$tar = $readgz->runclass($file,$data);

//echo($tar);
//return the control file from the passed tar
$readtar = new readtar;
$control = $readtar->runclass($tar);

//put the contents of the control file in an array, returns array.
$readcontrol = new readcontrol;
$info = $readcontrol->runclass($control);

echo "Package name: " . $info["Package"] . "<br>\n";
echo "Package version: " . $info["Version"] . "<br>\n";
echo "Package arch: " . $info["Architecture"] . "<br>\n";
echo "Filename: " . $_FILES["file"]["name"] . "<br>\n";
echo "Dist: $dist <br>\n";
echo "Component: $component <br>\n";

if( empty($info["Architecture"]) == true )
{
    $construct->error("Could not determine arch from control file");
}

echo "<br>Creating Folders<br>\n";
$ckfolder = new ckfolder;
$ckfolder->runclass($pool,$dist,$component,$info["Architecture"]);

echo "<br>Copying to pool<br>\n";
copy($_FILES["file"]["tmp_name"], $pool . $_FILES["file"]["name"]);

$makepackage = new makepackage;
$makepackage->runclass("dists/" . $dist ."/". $component ."/",$info);

include_once("class/readpackages.class.php");
$rdpkgs = new readpkg;
$pkg = $rdpkgs->ctpkgs("dists/$dist/$component/binary-".$info['Architecture']."/Packages");

echo "<br>Done <a href=\"index.php\">Home</a> <a href=\"addpkg.php\">Add another package</a> <a href=\"pkgview.php?file=dists/$dist/$component/binary-".$info['Architecture']."&pkg=$pkg\">View Package</a><br>";

$construct->pageend();
?>
