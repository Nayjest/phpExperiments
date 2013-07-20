<?php
namespace S\Meta;
class Object
{
    //use \S\ScopesSupport;
    use \S\ConfigurableObject;

    public $name;
    public $instanceClass = '\S\Object';
    public $scopes;

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
            $this->fields[$name] = new \S\Field($fieldConfig);
        }
    }

    protected function pushScopesToFields() {
        $fieldNames = array_keys($this->fields);

        foreach ($fieldNames as $field) {
            foreach($this->scopes as $scope => $fields) {
                if (in_array($field, $fieldNames)) {
                    $this->fields[$field]->scopes[] = $scope;
                }
            }
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
        $inst = new $this->instanceClass([
            'meta' => $this,
            'fields' => $fields,
            'data' => $data
        ]);
        return $inst;
    }

}

