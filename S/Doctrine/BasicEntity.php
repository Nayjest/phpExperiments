<?php
namespace S\Doctrine;
class BasicEntity
{
    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadataFactory
     */
    public static $metadataFactory;

    protected $data = [];
    public function __call($name, $args) {

        $method = substr($name,0,3);
        if ($method == 'get') {
            $field  = lcfirst(substr($name,3));
            return $this->get($field);

        } elseif ($method == 'set') {
            $field  = lcfirst(substr($name,3));
            return $this->set($field, $args[0]);
        }
        throw new \Exception('Calling unexistant method '.$name );
    }


    protected function get($field) {


        if (isset($this->data[$field])) {
            return $this->data[$field];
        } else {
            $md = static::$metadataFactory->getMetadataFor(get_class($this));
            $fields  = $md->getFieldNames();
            if (in_array($field, $fields)) {
                return null;
            }
            $associations = $md->getAssociationMappings();
            foreach ($associations as $assoc) {
                $className = $assoc['targetEntity'];
                $assocMd = static::$metadataFactory->getMetadataFor($className);
                $assocFields  = $assocMd->getFieldNames();
                if (in_array($field, $assocFields)) {
                    return $this->getAssoc($className)->{'get'.ucfirst($field)}();
                }
            }
            throw new \Exception('Calling unexistant method '.'get'.ucfirst($field));
        }
    }

    protected function set($field, $val) {
        $this->data[$field] = $val;
        $md = static::$metadataFactory->getMetadataFor(get_class($this));
        $fields  = $md->getFieldNames();
        if (in_array($field, $fields)) {
            $this->data[$field] = $val;
            return $this;
        }
        $associations = $md->getAssociationMappings();
        foreach ($associations as $assoc) {
            $className = $assoc['targetEntity'];
            $assocMd = static::$metadataFactory->getMetadataFor($className);
            $assocFields  = $assocMd->getFieldNames();
            if (in_array($field, $assocFields)) {
                $this->getAssoc($className)->{'set'.ucfirst($field)}($val);
                return $this;
            }
        }
        throw new \Exception('Calling unexistant method '.'set'.ucfirst($field));
    }


}
