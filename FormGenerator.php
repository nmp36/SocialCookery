<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of FormGenerator
*
* @author Harsha
*/
class FormGenerator {

    public function generate($schemaObject, $action) {
        $element = "";
        $subTitle = "";
        $array = array();

        $object = (array) $schemaObject;
        reset($object);

        switch ($action) {
            case "Add":
                $subTitle = "<h2>Enter new Recipe</h2>";
                break;
            case "Update":
                $subTitle = "<h2>Update existing Recipe</h2>";
                break;
            case "Delete":
                $subTitle = "<h2>Delete the Recipe</h2>";
                break;

            default:
                break;
        }
        foreach ($object as $key => $value) {
            if (stristr($key, "sorted")) {
                $array = array_merge($array, $value);
            }
        }

        ksort($array);

        foreach ($array as $value) {
            switch ($value) {
                case strcasecmp(stristr($value, "_txt"), "_txt"):
                    $ctrlNm = trim(stristr("$value", "_txt", true));
                    $element = $element . "<label>" . ucwords($ctrlNm) . "</label>";
                    $element = $element . '<input type = "text" id = "' . $ctrlNm . '" name = "' . $ctrlNm . '">';
                    $element = $element . "<br>";
                    break;
            }
        }

        if (strlen($element) > 0) {
            if (strlen($action) > 0) {
                $element = $element . '<input class="submit" type="submit" value="' . $action . '">';
            }
            $element = $subTitle . "<p>" . $element . "</p>";
            $this->template($element);
        }
    }

    private function template($content) {
        echo '<div id="page-container">
<div id="main-nav">
<dl>
<dt id="about"><a href="#">About</a></dt>
<dt id="services"><a href="#">Services</a></dt>
<dt id="recipes"><a href="#">Recipes</a></dt>
<dt id="contact"><a href="#">Contact Us</a></dt>
</dl>
<div id="search">
<input type="text" id="txt_search"/>
<img src="search.gif" id="btn_search"/>
</div>
</div>
<div id="header">
<h1> TheRecipes.com</h1>
</div>
<div id="sec-nav">
<dl >
<dt id="home"><a href="./index.php">Home</a></dt>
<dt id="appetizers"><a href="./TestAdd.php">New</a></dt>
<dt id="breakfast"><a href="./UpdateRecipe.php">Update</a></dt>
<dt id="dessert"><a href="./DeleteRecipe.php">Remove</a></dt>
</dl>
</div>
<div id="sidebar-a">
<dl >
<dt id="appetizers"><a href="#">Appetizers</a></dt>
<dt id="breakfast"><a href="#">Breakfast</a></dt>
<dt id="dessert"><a href="#">Dessert</a></dt>
<dt id="drinks"><a href="#">Drinks</a></dt>
</dl>
</div>
<div id="sidebar-b">
<dl >
<dt id="appetizers"><a href="#">Appetizers</a></dt>
<dt id="breakfast"><a href="#">Breakfast</a></dt>
<dt id="dessert"><a href="#">Dessert</a></dt>
<dt id="drinks"><a href="#">Drinks</a></dt>
</dl>
</div>
<div id="content">
<div class="padding">' . $content . '
</div>
</div>
<div id="footer">
<div id="alt-nav">
<a href="#">About</a>&nbsp;|&nbsp;
<a href="#">Services</a>&nbsp;|&nbsp;
<a href="#">Contact Us</a>&nbsp;|&nbsp;
<a href="#">Terms & conditions</a>
</div>
</div>
</div>';
    }

    public function createTable($array) {
        $i = 0;
        $table = "<h2>List of Recipes</h1><br>";
        if (count($array) == 0) {
            $table = $table . "<h3>No record</h3>";
        }

        $table = $table . "<table id='myTable' class='tablesorter'> ";
        foreach ($array as $child) {
            if ($i == 0) {
                $table = $table . "<thead><tr>";
                $temp = $child;
                reset($child);
                foreach ($child as $key => $value) {
                    $scope = "";
                    if ($key == "_id") {
                        
                    } elseif ($key == "itemscope") {
                        $scope = $value;
                    } else {
                        $table = $table . "<th><span itemscope {$child['itemscope']} itemprop='{$key}'>" . ucwords($key) . "</span></th>";
                    }
                }
                $table = $table . "<th>Action</th></tr></thead><tbody>";
                $i++;
            }

            $table = $table . "<tr>";
            foreach ($child as $key => $value) {
                $scope = "";
                if ($key == "_id") {
                    
                } elseif ($key == "itemscope") {
                    $scope = $value;
                } else {
                    $table = $table . "<td><span itemscope {$scope} itemprop='{$key}'>" . $value . "</span></td>";
                }
            }
            $table = $table . '<td><a href ="#" onClick="javascript:myfunc(' . "'" . $child["_id"] . "'" . ');">edit</a>    <a href ="#" onClick="javascript:myfunc1(' . "'" . $child["_id"] . "'" . ');">Delete</a></td></tr>';
        }
        $table = $table . "</tbody></table>";
        $this->template($table);
    }

}

?>