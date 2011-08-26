<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="CSS XHTML"/>
<meta name="author" content="Harsha"/>
<title>Assignment4 - Part2 </title>
<link REL="StyleSheet" TYPE="text/css" HREF="style.css"/>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://autobahn.tablesorter.com/jquery.tablesorter.js"></script>
<script type="text/javascript" src="jsscripts.js"></script>
</head>
<body>
<form  method="post" name="addRecipe" >
 <input type="hidden" id="recordId" name="recordId" value="<?php echo $_GET['id'] ?>"/>
<?php
            ini_set("display_errors", "On");
            include_once 'Recipe.php';
            include_once 'FormGenerator.php';


            $recipe = new Recipe();
            $testForm = new FormGenerator();
            $testForm->generate($recipe, "Add");

            if (empty($_POST["name"]) && empty($_POST["description"]) && empty($_POST["image"]) && empty($_POST["name"])) {
                echo 'Please Enter Recipe Information.';
            } else {
                $thing = new Recipe();
                echo $thing->saveRecipeWork();
                echo 'Recipe Saved Successfully.';
            }
            ?>
   
    
</form>
</body>
</html>

