<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
<link REL="StyleSheet" TYPE="text/css" HREF="style.css"/>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://autobahn.tablesorter.com/jquery.tablesorter.js"></script>
<script type="text/javascript" src="jsscripts.js"></script>
<script>
$(document).ready(function()
{
$("#myTable").tablesorter();
$('#content h2').text("Search Result");
}
);
</script>
</head>
<body>
<form name="searchResult" >
<?php
            ini_set("display_errors", "On");
            include_once 'Recipe.php';
            include_once 'FormGenerator.php';

            $dal = new DBLayer();
            $search = new FormGenerator();
            if (strlen($_GET['name']) > 0) {
                $dal = new DBLayer();
                $array = $dal->findAnyMatch($_GET['name']);
                $search->createTable($array);
            }
            ?>
</form>
</body>
</html>

