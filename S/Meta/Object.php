<?php
namespace S\Meta;
class Object
{
    //use \S\ScopesSupport;
    use \S\ConfigurableObject;

    public $name;
    public $instanceClass = '\S\Object';
    //public $scopes;

    private $fields = [];

    public function getFields()
    {
        return $this->fields;
    }

    protected function setFields($fields) {
        foreach($fields as $name => $fieldConfig) {
            if (empty($fieldConfig['name'])){
                $fieldConfig['name'] = $name;
            }
            $this->fields[$name] = new \S\Meta\Field($fieldConfig);
        }
    }


    /**
     * @param array $data
     * @return \S\Object
     */
    public function create($data = []) {
        $fields = [];
        foreach ($this->fields as $key => $field) {
            $fields[$key] = new \S\Field([
                'meta' => $field
            ]);
        }
        $class = $this->instanceClass;
        $inst = new $class([
            'meta' => $this,
            'fields' => $fields,
            'data' => $data
        ]);
        return $inst;
    }

}

