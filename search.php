<?php
include_once("class/construct.class.php");
require_once("class/search.class.php");
$construct = new construct;
$construct->pagestart();
@$q = $_GET['q'];
$query = trim($q);

echo "<h2>Search</h2>";
if( empty($query) ) //no query, display search box
{
?>
<h4>Search for packages:</h4>
<form method="get">
<input type="text" name="q" size="31" maxlength="255" />
<input type="submit" value="Search" />
</form>
<?php
}else //we have something to search
{
    echo "<h4>Search for: $query</h4>\n";
    $search = new search;
    $search->runclass($query);
}
$construct->pageend();
?>
