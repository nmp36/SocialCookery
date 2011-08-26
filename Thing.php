<?php

ini_set('display_errors', 'On');
include_once 'Tag.php';

class Thing extends Tag {

    private $itemscope = 'http://www.schema.org/Thing';
    private $id; //mongo object id
    private $name;
    private $url;
    private $image;
    private $description;
    private $itemtype = '"http://www.schema.org/Thing"';
    private $result;
    protected $test1;
    protected $sortedThing = array("a" => "name_txt", "b" => "description_txt", "c" => "image_txt", "d" => "url_txt");
    public $objID;
    Public $Colname = "FinalThing";
    Public $recordID;
    
    //saves thing
    function save_object($collection) {
        $obj = $this->prepare_array();
        $collection->insert($obj);
    }

//gets a thing array to pass to mongo, it will error if you just pass in a $this because it can't access the private variables;
    Public function prepare_array() {
        /* Hardcoded Temp */
        
       
        if (strlen($_POST['recordId']) > 0) {
            echo $_POST['recordId'];
            $obj['_id'] = new MongoId($_POST['recordId']);
        }
        
        $obj['name'] = $_POST["name"];
        $obj['url'] = $_POST["url"];
        $obj['image'] = $_POST["image"];
        $obj['description'] = $_POST["description"];
        $obj['itemscope'] = 'itemtype=http://schema.org/Thing';
        return $obj;
    }

    function getItemTypeValue() {

        return $this->itemtype;
    }

    function getItemTypeAttributes() {


        $this->itemtype->attributes['itemprop'] = 'itemtype';
    }

    function setItemTypeValue($var) {
        $this->itemtype = $var;
    }

    function getItemScope() {

        return $this->itemscope;
    }

    function setNameValue($var) {

        $this->name->value = $var;
    }

    function getNameValue() {

        return $this->name->value;
    }

    function setNameTag($var) {

        $this->name->tag->tagtype = $var;
    }

    function getNameTag() {
        if (strlen($this->name->tag->tagtype) != 0) {
            return $this->name->tag->tagtype;
        } else {
            return 'span';
        }
    }

    function setNameAttributes($var) {

        $class = get_class($this) . ' name ' . $var;
        $this->name->tag->attributes['class'] = $class;
        $this->name->tag->attributes['itemprop'] = 'name';
    }

    function getNameAttributes() {

        return $this->name->tag->attributes;
    }

    function setUrlValue($var) {

        $this->url->value = $var;
    }

    function getUrlValue() {

        return $this->url->value;
    }

    function setUrlTag($var) {

        $this->url->tag->tagtype = $var;
    }

    function getUrlTag() {

        if (strlen($this->url->tag->tagtype) != 0) {
            return $this->url->tag->tagtype;
        } else {
            return 'a';
        }
    }

    function setUrlAttributes($var) {

        $class = get_class($this) . ' url ' . $var;
        $this->url->tag->attributes['class'] = $class;
        $this->url->tag->attributes['itemprop'] = 'url';
    }

    function getUrlAttributes() {

        return $this->url->tag->attributes;
    }

    function setImageValue($var) {

        $this->image->value = $var;
    }

    function getImageValue() {

        return $this->image->value;
    }

    function setImageTag($var) {

        $this->image->tag->tagtype = $var;
    }

    function getImageTag() {

        if (strlen($this->image->tag->tagtype) != 0) {
            return $this->image->tag->tagtype;
        } else {
            return 'img';
        }
    }

    function setImageAttributes($var) {

        $class = get_class($this) . ' image ' . $var;
        $this->image->tag->attributes['class'] = $class;
        $this->image->tag->attributes['itemprop'] = 'image';
    }

    function getImageAttributes() {

        return $this->image->tag->attributes;
    }

    function setDescriptionValue($var) {

        $this->description->value = $var;
    }

    function getDescriptionValue() {

        return $this->description->value;
    }

    function getDescriptionTag() {

        if (strlen($this->description->tag->tagtype) != 0) {
            return $this->description->tag->tagtype;
        } else {
            return 'span';
        }
    }

    function getDescriptionFormFieldType() {

        return $this->description->form->fieldtype;
    }

    function setDescriptionFormFieldType($var) {

        $this->description->form->fieldtype = $var;
    }

    function getImageFormFieldType() {

        return $this->image->form->fieldtype;
    }

    function setImageFormFieldType($var) {

        $this->image->form->fieldtype = $var;
    }

    function getUrlFormFieldType() {

        return $this->url->form->fieldtype;
    }

    function setUrlFormFieldType($var) {

        $this->url->form->fieldtype = $var;
    }

    function getNameFormFieldType() {

        return $this->name->form->fieldtype;
    }

    function setNameFormFieldType($var) {

        $this->name->form->fieldtype = $var;
    }

    function setDescriptionTag($var) {

        $this->description->tag->tagtype = $var;
    }

    function setDescriptionAttributes($var) {

        $class = get_class($this) . ' description ' . $var;
        $this->description->tag->attributes['class'] = $class;
        $this->description->tag->attributes['itemprop'] = 'description';
    }

    function getDescriptionAttributes() {

        return $this->description->tag->attributes;
    }

    function __construct($id = null, $collection = null) {
//allows the loading of object at instantiation;
        if (!is_null($id)) {

            $this->get_object($collection, $id);
        }

        $this->description->tag->tagtype = 'span';
        $this->image->tag->tagtype = 'img';
        $this->url->tag->tagtype = 'a';
        $this->name->tag->tagtype = 'span';
        $this->description->form->fieldtype = 'text';
        $this->image->form->fieldtype = 'text';
        $this->url->form->fieldtype = 'text';
        $this->name->form->fieldtype = 'text';
        $this->name->tag->attributes['class'] = get_class($this) . ' tag ';
        $this->name->tag->attributes['itemprop'] = 'tag';
        $this->url->tag->attributes['class'] = get_class($this) . ' url ';
        $this->url->tag->attributes['itemprop'] = 'url';
        $this->url->tag->attributes['href'] = 'myownrecipe.com';

        $this->image->tag->attributes['class'] = get_class($this) . ' image ';
        $this->image->tag->attributes['itemprop'] = 'image';
        $this->description->tag->attributes['class'] = get_class($this) . ' description ';
        $this->description->tag->attributes['itemprop'] = 'description';

//print_r($this);
    }

    public function PrintThing() {
        // $this->get_object();
        $dbl = new DBLayer();
        $dbl->setCollectionObj($this->Colname);
        $obj = $this->prepare_array();
        $this->objID = $dbl->InsertCollection($obj);
        $cursor = $dbl->get_CollectionObjectbyid($this->Colname, $this->objID);
        foreach ($cursor as $arr) {
            $this->name->value = $arr["name"];
            $this->url->value = $arr["url"];
            $this->image->value = $arr["image"];
            $this->description->value = $arr["description"];
        }
//echo 'Printing';
        /*
echo '<b>Name<b></b> :'. $this->printNameHtmlTag().'<br>';
echo '<b>Description</b> :'. $this->printDescriptionHtmlTag().'<br>';
echo '<b>URL </b> :'. $this->printUrlHtmlTag().'<br>';
echo '<b>Image </b> :'. $this->printImageHtmlTag().'<br>';
*/
//$this->printNameHtmlTag();
    }

    public function saveThing() {
// $this->get_object();
        $dbl = new DBLayer();
        $dbl->setCollectionObj($this->Colname);
        $obj = $this->prepare_array();
        $this->objID = $dbl->SaveCollection($obj, NULL);
        $cursor = $dbl->get_CollectionObjectbyid($this->Colname, $this->objID);
        foreach ($cursor as $arr) {
            $this->name->value = $arr["name"];
            $this->url->value = $arr["url"];
            $this->image->value = $arr["image"];
            $this->description->value = $arr["description"];
        }
    }

    public function UpdateThing($paramName, $paramValue) {
        $dbl = new DBLayer();
        $dbl->setCollectionObj($this->Colname);
        $cursor = $dbl->get_CollectionObjectbysearchParameter($this->Colname, $paramName, $paramValue);
        foreach ($cursor as $arr) {
            $this->objID = $arr["_id"];
            $this->name->value = $arr["name"];
            $this->url->value = $arr["url"];
            $this->image->value = $arr["image"];
            $this->description->value = $arr["description"];
        }
        $obj = $this->prepare_array();
        $dbl->SaveCollection($obj, $this->objID);

        $cursor = $dbl->get_CollectionObjectbyid($this->Colname, $this->objID);
        foreach ($cursor as $arr) {
            $this->name->value = $arr["name"];
            $this->url->value = $arr["url"];
            $this->image->value = $arr["image"];
            $this->description->value = $arr["description"];
        }
    }

    public function RemoveThing($paramName, $paramValue) {
        $dbl = new DBLayer();
        $dbl->setCollectionObj($this->Colname);
        $cursor = $dbl->get_CollectionObjectbysearchParameter($this->Colname, $paramName, $paramValue);
        foreach ($cursor as $arr) {
            $this->objID = $arr["_id"];
            $this->name->value = $arr["name"];
            $this->url->value = $arr["url"];
            $this->image->value = $arr["image"];
            $this->description->value = $arr["description"];
        }
        $obj = $this->prepare_array();
        $criteria = array("_id" => $this->objID);
        $this->objID = $dbl->RemoveCollection($this->Colname, $criteria);
    }

    private function printNameHtmlTag() {
        $tag = new Tag($this->getNameTag(), $this->getNameAttributes(), $this->getNameValue());
        return $tag->get_tag();
    }

    private function printUrlHtmlTag() {
        $tag = new Tag($this->getUrlTag(), $this->getUrlAttributes(), $this->getUrlValue());
        return $tag->get_tag();
    }

    private function printDescriptionHtmlTag() {
        $tag = new Tag($this->getDescriptionTag(), $this->getDescriptionAttributes(), $this->getDescriptionValue());
        return $tag->get_tag();
    }

    private function printImageHtmlTag() {
        $tag = new Tag($this->getImageTag(), $this->getImageAttributes(), $this->getImageValue());
        return $tag->get_tag();
    }

    public function SearchThing($arr) {
        $this->objID = $arr["_id"];
        $this->name->value = $arr["name"];
        $this->url->value = $arr["url"];
        $this->image->value = $arr["image"];
        $this->description->value = $arr["description"];

        //echo $this->printHtml();
        $this->result = 1;
    }

    /* * * print html tag functions * */

    private function printItemScopeHtmlOpen() {
        $tag = "<" . 'div' . ' itemscope itemtype=' . $this->getItemTypeValue();
        return $tag;
    }

    private function printItemScopeHtmlClose() {
        $tag = ">";
        return $tag;
    }

    function printHtml() {
        echo '<b>Name<b></b> : ' . $this->printNameHtmlTag() . '<br>';
        echo'<b>Description</b> : ' . $this->printDescriptionHtmlTag() . '<br>';
        echo'<b>URL </b> : ' . $this->printUrlHtmlTag() . '<br>';
        echo'<b>Image </b> : ' . $this->printImageHtmlTag() . '<br>';
    }

}

?>