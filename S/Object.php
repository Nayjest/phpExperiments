<?php
namespace S;
class Object
{
    use \S\ScopesSupport;
    public $meta;
    public $fields;
    public function setData($data) {
        foreach($data as $key=>$value) {
            $this->fields[$key]->setData($value);
        }
    }
    public function getData() {
        $res = [];
        foreach($this->fields as $key=>$field) {
            $res[$key] = $field->getData();
        }
        return $res;
    }
}
