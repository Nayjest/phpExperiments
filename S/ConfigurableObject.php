<?php
namespace S;

trait ConfigurableObject
{

    public function __construct($config = null) {
        $this->initialize($config);
    }

    protected function initialize($config)
    {
        return $this->initializeFields(
            array_replace_recursive($this->getDefaults(), $config)
        );
    }

    protected function initializeFields($config)
    {
        $ignoredFields = [];
        foreach ($config as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } else {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                } else {
                    $ignoredFields[$key] = $value;
                }
            }
        }
        return $ignoredFields;
    }

    protected function getDefaults()
    {
        return [];
    }

    public static final function build($config)
    {
        //@todo use get_called_class if no class property in config
        $class = $config['class'];
        return new $class($config);
    }


}
