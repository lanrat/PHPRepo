<div id="sidebar">
<ul>
<li><a href="index.php">Home</a></li>
<?php
if( @$_SESSION['phprepoauth'] !== 1 )
{
    echo "<li><a href=\"login.php\">Login</a></li>";
}else
{
	echo "<li><a href=\"login.php?action=logout\">Logout</a></li>";
	echo "<li><a href=\"addpkg.php\">Add Package</a></li>";
    echo "<li><a href=\"delete.php\">Delete</a></li>";
}
global $guest;
if( $guest == 1 or @$_SESSION['phprepoauth'] == 1 )
{
    echo "<li><a href=\"search.php\">Search</a></li>";
    echo "<li><a href=\"pkgview.php\">View Packages</a></li>";
}
?>
</ul>
</div>
