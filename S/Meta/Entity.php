<?php
namespace S\Meta;
use S\Doctrine\NamingConvention;

class Entity
{
    //use \S\ScopesSupport;
    use \S\ConfigurableObject;

    public $name;

    public $area;

    private $table;

    /**
     * @return mixed
     */
    public function getTable()
    {
        if (!$this->table) {
            $this->table = NamingConvention::getTableNameByClass($this->getClassName());
        }
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    private $className;

    private $alias;

    private $fields = [];

    private $scopes;

    private $storingClasses;


    public function getAlias()
    {
        if (!$this->alias) {
            $this->alias = $this->area . '.' . $this->name;
        }
        return $this->alias;
    }

    public function getClassName()
    {
        if (!$this->className) {
            $this->className = NamingConvention::getClassByAlias($this->getAlias());
        }
        return $this->className;
    }

    public function getScopes()
    {
        if (!$this->scopes) {
            $this->scopes = [];
            foreach ($this->fields as $field) {
                if (!empty($field->scopes)) {
                    foreach ($field->scopes as $scope) {
                        if (!in_array($scope, $this->scopes)) {
                            $this->scopes[] = $scope;
                        }
                    }
                }
            }
        }
        return $this->scopes;
    }

    public function getStoringClasses()
    {
        if (!$this->storingClasses) {
            $this->storingClasses = [];
            /** @var $field \S\Meta\Field */
            foreach ($this->fields as $field) {
                if (!empty($field->scopes)) {
                    $class = $field->getStoringClassName();
                    if (!in_array($this->storingClasses, $class)) {
                        $this->storingClasses[] = $class;
                    }
                }
            }

        }
        return $this->storingClasses;
    }


    public function getFields()
    {
        return $this->fields;
    }

    private $nativeFields;

    public function getNativeFields()
    {
        if ($this->nativeFields === null) {
            $this->nativeFields = [];
            /** @var $field \S\Meta\Field */
            foreach ($this->fields as $field) {
                if ($field->isNativeEntityField()) {
                    $this->nativeFields[] = $field;
                }
            }
        }
        return $this->nativeFields;
    }

    /**
     * @param $name
     * @return \S\Meta\Field
     * @throws \Exception
     */
    public function getField($name)
    {
        if (!isset($this->fields[$name])) {
            throw new \Exception("Configuration of '{$this->getAlias()}' entity has no '{$name}' field");
        }
        return $this->fields[$name];
    }

    protected function setFields($fields)
    {
        foreach ($fields as $name => $fieldConfig) {
            if (empty($fieldConfig['name'])) {
                $fieldConfig['name'] = $name;
            }
            $this->fields[$name] = new \S\Meta\Field($fieldConfig);
            $this->fields[$name]->entity = $this;
        }
    }


}

