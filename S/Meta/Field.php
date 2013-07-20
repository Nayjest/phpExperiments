<?php
namespace S\Meta;

class Field  {
    use \S\ConfigurableObject;
    public $name;
    public $type;
    public $scopes;

//    public $validators = [];
//    public $dataSource;
//    public $views = [];
//    protected $validatorInstances;
//
//    public function getValidatorInstances() {
//        if (!$this->validatorInstances) {
//            $this->validatorInstances = array();
//            foreach ($this->validators as $key => $value) {
//                $validator = \S\Meta\Validator::fromConfig($key, $value);
//                $this->validatorInstances[] = $validator;
//            }
//        }
//        return $this->$this->validatorInstances;
//    }
//
//    public function create() {
//        $instance = new \S\Field();
//        return $instance;
//    }
}