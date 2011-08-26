<?php

/**
* Description of DBLayer
* This class is responsible for making DB Connection , create ,update ,delete or insert operations.
* This is being used through out application.
* @author Dishna
*/
class DBLayer {

    //Create method to make database connection
    private $i = 0;
    private $colName;
    private $conn;
    private $Collect;
    private $dbObj;
    private $Id;
    private $abc;
    Protected $RecipeArray;
    private $arr;

    function __construct() {
        $username = 'kwilliams';
        $password = 'mongo1234';
        $conn = singleton::singleton($username, $password);
        $this->dbObj = $conn->recipe;
    }

    Function setCollectionObj($colName) {
        $this->Collect = $this->dbObj->selectCollection("$colName");
    }

    //Retrieve Collection Method
    public function get_CollectionObject($colName) {
        $this->Collect = $this->dbObj->selectCollection("$colName");
        $cursor = $this->Collect->find();
        return $cursor;
    }

    public function get_CollectionObjectbyId($colName, $Id) {

        $this->Collect = $this->dbObj->selectCollection("$colName");
        $cursor = $this->Collect->find();
        return $cursor;
    }
 
    public function InsertCollection($obj) {
        
        $Recipe = $obj["Recipe"];
        $RecipeCollection = $this->dbObj->selectCollection("RecipeTest");
        $RecipeCollection->Insert($Recipe);
        //$RecipeRef = MongoDBRef::create($RecipeCollection->getName(),$Recipe['_id']);

        $CreativeWork = $obj["CreativeWork"];
        //$CreativeWork["RecipeReference"]=$RecipeRef;
        $CreativeWork['_id'] = $Recipe['_id'];
        $CreativeWorkCollection = $this->dbObj->selectCollection("CreativeWorkTest");
        $CreativeWorkCollection->Insert($CreativeWork);
        //$CreativeWrokRef = MongoDBRef::create($CreativeWorkCollection->getName(), $CreativeWork['_id']);

        $thing = $obj["Thing"];
        $thingCollection = $this->dbObj->selectCollection("Thingtest");
        $thing['_id'] = $CreativeWork['_id'];
        $thingCollection->Insert($thing);

        $recipeback = $this->dbObj->RecipeTest;
        $RecipeResult = $recipeback->findOne(array("ingredients" => "Chicken"));
        //echo 'Result'.$RecipeResult['_id'];
        //print_r($RecipeResult);
        $CWback = $this->dbObj->CreativeWorkTest;
        $CWbackResult = $CWback->findOne(array("_id" => $RecipeResult['_id']));
        //print_r($CWbackResult);

        $Thback = $this->dbObj->Thingtest;
        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
        $ThbackResult = $Thback->findOne(array("_id" => $CreativeWork['_id']));
        //print_r($ThbackResult);
    }

    //Update collection based on Criteria and New data.
    public function SaveCollection($obj, $id) {
        //save obj values into Collection
        // save will insert if obj doesn't exists in database or updates obj if exists.
        if (!is_null($obj) || !is_null($this->Collect))
            if (!is_null($id)) {
                $obj['_id'] = $id;
            }
        $this->Collect->save($obj);
        return $obj['_id'];
    }

//Update collection based on Criteria and New data.
    public function UpdateCollection($colName, $criteria, $newData) {
        //Insert obj values into Collection
        if (!is_null($colName) || !is_null($this->Collect))
            $this->Collect = $this->dbObj->selectCollection("$colName");
        $this->Collect->update($criteria, $newData);
    }

//    //Remove collection Record
//    public function RemoveCollection($colName, $criteria) {
//        //Insert obj values into Collection
//        if (!is_null($colName) || !is_null($this->Collect))
//            $this->Collect = $this->dbObj->selectCollection("$colName");
//        $this->Collect->remove($criteria, true);
//    }

    public function findAnyMatch($param) {
        $array = array();
        $regEx = new MongoRegex("/{$param}/i");
        try {
            $db = $this->dbObj;
            $list = $db->listCollections();
            $thingCollection = $db->selectCollection('Thingtest');
            $creativeCollection = $db->selectCollection('CreativeWorkTest');
            $recipeCollection = $db->selectCollection('RecipeTest');

            $thingCursor = $thingCollection->find();
            /*Since OR operator does not work with exisiing Mongo Version , i have commeneted this part*/
                    //(array('$or' => array(array("name" => $regEx), array("url" => $regEx),
                    //array("description" => $regEx))));

            if ($thingCursor->count() > 0) {
                $temp = array();
                foreach ($thingCursor as $tcur) {
                    $temp = array_merge($temp, $tcur);

                    $creativeCursor = $creativeCollection->find(array("_id" => $tcur['_id']));

                    foreach ($creativeCursor as $ccur) {
                        $temp = array_merge($temp, $ccur);
                    }

                    $recipeCursor = $recipeCollection->find(array("_id" => $tcur['_id']));

                    foreach ($recipeCursor as $rcur) {
                        $temp = array_merge($temp, $rcur);
                    }

                    $array = array_merge($array, array($temp));
                }
                return $array;
            }

            $creativeCursor = $creativeCollection->find(array('$or' => array(array("about" => $regEx), array("author" => $regEx))));

            if ($creativeCursor->count() > 0) {
                $array = array();
                $temp = array();
                foreach ($creativeCursor as $ccur) {
                    $temp = array_merge($temp, $ccur);

                    $recipeCursor = $recipeCollection->find(array("_id" => $ccur['_id']));

                    foreach ($recipeCursor as $rcur) {
                        $temp = array_merge($temp, $rcur);
                    }

                    $thingCursor = $thingCollection->find(array("_id" => $ccur['_id']));

                    foreach ($thingCursor as $tcur) {
                        $temp = array_merge($temp, $tcur);
                    }

                    $array = array_merge($array, array($temp));
                }
                return $array;
            }

            $recipeCursor = $recipeCollection->find(array('$or' => array(array("instructions" => $regEx), array("ingredients" => $regEx))));

            if ($recipeCursor->count() > 0) {
                $array = array();
                $temp = array();
                foreach ($recipeCursor as $rcur) {
                    $temp = array_merge($temp, $rcur);

                    $thingCursor = $thingCollection->find(array("_id" => $rcur['_id']));

                    foreach ($thingCursor as $tcur) {
                        $temp = array_merge($temp, $tcur);
                    }

                    $creativeCursor = $creativeCollection->find(array("_id" => $rcur['_id']));

                    foreach ($creativeCursor as $ccur) {
                        $temp = array_merge($temp, $ccur);
                    }

                    $array = array_merge($array, array($temp));
                }
              // print_r($array);
                return $array;
            }
        } catch (MongoCursorException $exc) {
            echo $exc->getTraceAsString();
        }
        return $array;
    }
 /*get object collection by Search Paramter,Retrive all child documents and then create nested array 
    and sent back to Caller.*/
    public function get_CollectionObjectbysearchParameter($srchCriteria)
    {
        //print_r($srchCriteria);
        $this->Collect=$this->dbObj->selectCollection("Thingtest");
        if (is_null($srchCriteria))
        {
//           $criteria_delete = array('_id' => new MongoId('4e4b52e41ce31eff2c000001'));
//$this->Collect->remove($criteria_delete, true );
         $cursor = $this->Collect->find();   
            //$cursor=$this->Collect->find(array("_id" =>'4e4acfca1ce31ecb17000000'));
        }
        else
        {
         $cursor = $this->Collect->find($srchCriteria);  
        }
        
        $this->i=0;
        /*Loop through all parent records and retrive child based on _ID attribute*/
        while ($document = $cursor->getNext())
        {
            
        $CWback=$this->dbObj->CreativeWorkTest;
        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
        $CWbackResult = $CWback->findone(array("_id" => $document['_id']));
        $recipeback=$this->dbObj->RecipeTest;
        $RecipeResult = $recipeback->findOne(array("_id" => $CWbackResult['_id']));
        /*Creating array of one recipe document*/
        $this->RecipeArray=array(
             "Thing"=>$document,
             "CreativeWork"=>$CWbackResult,
             "Recipe"=>$RecipeResult
             );
        $this->arr[$this->i]=$this->RecipeArray;
        $this->i=$this->i+1;

        }    

        return $this->arr;

    }
    public function findone($s_array) {
        $db = $this->dbObj;
        
        $thingCollection = $db->selectCollection('Thingtest');
        $creativeCollection = $db->selectCollection('CreativeWorkTest');
        $recipeCollection = $db->selectCollection('RecipeTest');

        $array = array_merge($thingCollection->findOne($s_array), $creativeCollection->findOne($s_array));
                $final=array_merge($array, $recipeCollection->findOne($s_array));
        
        return $final;
    }
public function RemoveCollection($obj,$ID) {
        $db = $this->dbObj;
        try {
            /*get the collection*/
        
        $this->Collect=$this->dbObj->selectCollection("Thingtest");
        $ThingObj = $this->Collect->findone(array("_id" => new MongoId($ID)));
            
              
        /*Creative work update*/
        $CWback=$this->dbObj->CreativeWorkTest;
        $CWbackResult = $CWback->findone(array("_id" => $ThingObj['_id']));
        $Criteria_Update=array("_id" => new MongoId($CWbackResult['_id']));
        $CreativeWork=$obj["CreativeWork"];
        $CWback->remove($Criteria_Update,$CreativeWork);
        
        /*Recipe Update*/
        $Criteria_Update = array("_id" => new MongoId($CWbackResult['_id']));
        $Recipe=$obj["Recipe"];
        $RecipeCollection=$this->dbObj->selectCollection("RecipeTest");
        $RecipeCollection->remove($Criteria_Update,$Recipe);
        
        /*Thing Update*/
        $Criteria_Update=array("_id" => new MongoId($ID));
        $thing=$obj["Thing"];
        $thingCollection=$this->dbObj->selectCollection("Thingtest");
        $thingCollection->remove($Criteria_Update,$thing);
            //$recipeCollection->save($object['Recipe']);
        } catch (MongoCursorException $mce) {
            echo $mce . getTraceAsString() . "<br>";
        } catch (MongoCursorTimeoutException $mcte) {
            echo $mcte . getTraceAsString() . "<br>";
        }
    }
    public function updateRecord($object) {
        $db = $this->dbObj;
        try {
            $thingCollection = $db->selectCollection('Thingtest');
            $thingCollection->save($object['Thing']);
            $creativeCollection = $db->selectCollection('CreativeWorkTest');
            $creativeCollection->save($object['CreativeWork']);
            $recipeCollection = $db->selectCollection('RecipeTest');
            $recipeCollection->save($object['Recipe']);
        } catch (MongoCursorException $mce) {
            echo $mce . getTraceAsString() . "<br>";
        } catch (MongoCursorTimeoutException $mcte) {
            echo $mcte . getTraceAsString() . "<br>";
        }
    }

}

/* SingleTon design Pattern Implementation */

class singleton {

    private static $instance;
    private $count = 0;

    private function __construct() {
        
    }

    public static function singleton($username, $password) {
        if (!(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new Mongo("mongodb://${username}:${password}@localhost/test", array("persist" => "x"));
            ;
        }
        return self::$instance;
    }

    public function increment() {
        return $this->count++;
    }

    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }

}
?>



