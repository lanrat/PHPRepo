<?php
$pkg = trim($_GET['pkg']);
$comp = trim($_GET['comp']);
if( empty($pkg) or empty($comp) )
{
    die("Missing data!");
}

header("Content-Type: application/octet-stream");
include("class/install.class.php");
$install = new install;

$install_file = $install->geninstall($pkg,$comp);

header("Content-Disposition: attachment; filename=" . urlencode($pkg.".install"));   
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");            
header("Content-Length: " . strlen($install_file));
flush(); // this doesn't really matter.

echo $install_file;
flush(); // this is essential for large downloads

?>
