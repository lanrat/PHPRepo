<?php
include_once("class/construct.class.php");
include_once("class/delete.class.php");
$require_login = "yes";
$construct = new construct;
$construct->pagestart();
@$action = $_GET['action'];
@$sure = $_GET['sure'];
@$file = $_GET['file'];
@$pkg = $_GET['pkg'];
@$delpool = $_GET['delpool'];

$delete = new delete;

echo "<h2>Delete</h2>";

if( empty($action) == false and empty($sure) == true ) //confirmation code
{
    echo "Are you sure you want to delete this?\n<br>\n";
    if ( $action == "delpkg" )
    {
        $url = "delete.php?action=$action&sure=yes&file=$file&pkg=$pkg&delpool=$delpool";
    }elseif( $action == "delsrepo" )
    {
        $url = "delete.php?action=$action&sure=yes&file=$file&delpool=$delpool";
    }else
    {
        $url = "delete.php?action=$action&sure=yes";
    }
    echo "<a href=\"$url\">Yes</a>  <a href=\"delete.php\">No</a>\n<br><br>\n";
}

echo "<table cellpadding=\"8\" ><tr><td>\n";

echo "<a href=\"delete.php?action=delpool\">Delete Pool</a>\n"; //del pool
if( $action == "delpool" and $sure == "yes" )
{
    $delete->delpool($pool);
}

echo "<br><a href=\"delete.php?action=delrepo\">Delete Entire repo</a>\n"; //del repo
if( $action == "delrepo" and $sure == "yes" )
{
    $delete->delrepo();
}

echo "<br><a href=\"delete.php?action=delall\">Delete Repo and pool</a>\n"; //del all
if( $action == "delall" and $sure == "yes" )
{
    $delete->delall($pool);
}

echo "</td>\n<td>";

if( is_dir("dists")  == false )
{
    echo "No Dists folder\n";
}else
{
    echo '<br><form action="delete.php" method="GET"><input type="hidden" name="action" value="delsrepo">'; //del single repo
    include_once("class/repos.class.php");
    $repos = new dists;
    echo 'Delete Single repo: <select name="file">';
    $pkgs = $repos->repo_tree();
    foreach($pkgs as $key  => $value)
    {
    	echo '<option value="'.$value.'">'.$value.'</option><br>';
    }
    echo '</select><br>';
    echo 'Delete all files in pool from repo also <input type="checkbox" name="delpool" value="yes">';
    echo '<input type="submit" value="Delete"/></form>';
    if( $action == "delsrepo" and $sure == "yes" )
    {
        $delete->delsrepo($file,$delpool);
    }
}
echo "</td></tr></table>";

if( $action == "delpkg" and $sure == "yes" ) //del single pkg
{
    $delete->delpkg($file,$pkg,$delpool);
}

$construct->pageend();
?>
