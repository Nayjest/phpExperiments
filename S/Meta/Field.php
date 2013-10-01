<?php
namespace S\Meta;

class Field  {
    use \S\ConfigurableObject;

    public static function getNativeTypes()
    {
        return [
            'int',
            'string'
        ];
    }

    public function isNativeType() {
        return in_array($this->type, static::getNativeTypes());
    }

    public $name;
    public $type;
    public $scopes;
    public $validators = [];

    /**
     * @var \S\Meta\Entity;
     */
    public $entity;


    /**
     * Real class of entity that stores field value
     * @var string
     */
    private $storingClassName;

    public function isNativeEntityField()
    {
        return empty($this->scopes) and $this->isNativeType();
    }


    public function getStoringClassName() {
        if (!$this->storingClassName) {
            $mainClass  = $this->entity->getClassName();
            if ($this->isNativeEntityField()) {
                $this->storingClassName =  $mainClass;
            } else {
                $this->storingClassName = $mainClass . '_' . join('_', array_map('ucfirst', $this->scopes));
            }
        }
        return $this->storingClassName;
    }



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