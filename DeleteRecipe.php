<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Schema Creator</title>
<link REL="StyleSheet" TYPE="text/css" HREF="style.css"/>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://autobahn.tablesorter.com/jquery.tablesorter.js"></script>
<script type="text/javascript" src="jsscripts.js"></script>
</head>
<body>
<form  method="post" name="DeleteRecipe"/>
<?php
            ini_set("display_errors", "On");
            include_once 'Recipe.php';
            include_once 'FormGenerator.php';

            $recipe = new Recipe();
            $form = new FormGenerator();
           
            $form->generate($recipe, "Delete");

            if (strlen($_GET['id']) > 0) {
                $dal = new DBLayer();
                $array = $dal->findone(array('_id' => new MongoId($_GET['id'])));

                echo "<script>
                $(document).ready(function(){
                document.getElementById('name').value = '{$array['name']}';
                document.getElementById('description').value = '{$array['description']}';
                document.getElementById('image').value = '{$array['image']}';
                document.getElementById('about').value = '{$array['about']}';
                document.getElementById('author').value = '{$array['author']}';
                document.getElementById('url').value = '{$array['url']}';
                document.getElementById('ingredients').value = '{$array['ingredients']}';
                document.getElementById('instructions').value = '{$array['instructions']}';
                });
                </script>";
            }


            if (empty($_POST["name"]) && empty($_POST["description"]) && empty($_POST["image"]) && empty($_POST["name"])) {
                echo 'Please Enter Recipe Information.';
            } else {
                $thing = new Recipe();
                echo $thing->RemoveRecipework($_GET['id']);
                echo 'Recipe Deleted Successfully.';
            }
            ?>
<input type="hidden" id="recordId" name="recordId" value="<?php echo $_GET['id'] ?>"/>
</form>
</body>
</html>

