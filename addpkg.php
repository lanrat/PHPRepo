<?php
include_once("class/construct.class.php");
$require_login = "yes";
$construct = new construct;
$construct->pagestart();
?>
<h2>Upload a deb to read data from</h2>

<form name="file" enctype="multipart/form-data" action="read.php" method="POST">
File to upload: <INPUT TYPE=FILE NAME="file">
<br>
Select Distribution: <select name="dist">
<?php
include_once("class/repos.class.php");
$repos = new dists;
$pkgs = $repos->repo_array();
foreach($pkgs as $dist => $var)
{
    echo '<option value="'.$dist.'">'.$dist.'</option>';
}
echo '<option value ="new">New --></option>';
echo '</select> New: <input type="text" size="10" name="newdist" /><br />';

echo 'Select Component: <select name="component">';
$master_array = array();
foreach( $pkgs as $dist => $var )
{
    $master_array  = array_merge( $master_array, $pkgs[$dist] );
}
foreach( $master_array as $component => $var)
{
    echo '<option value="'.$component.'">'.$component.'</option>';
}
echo '<option value ="new">New --></option>';
echo '</select> New: <input type="text" size="10" name="newcomponent" /><br />';
?>
<input type="submit" value="Read!"/>
</form>

<?php
$construct->pageend();
?>
