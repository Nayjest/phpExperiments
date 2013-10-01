<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 25.09.13
 * Time: 17:12
 * To change this template use File | Settings | File Templates.
 */

namespace S\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use \S\Meta;

trait ScopedEntity
{

    /**
     * @return \S\Meta\Entity
     */
    public function getMeta()
    {
        return Meta::getEntityByClassName(get_class($this));
    }

    protected $scope;

    private $storingObjects = [];

    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    protected function detachStoringObjects() {
        $this->storingObjects = [];
//        /** @var ScopedEntityPart $partial */
//        foreach ($this->storingObjects as $partial) {
//
//        }
    }


    public function getScope()
    {
        return $this->scope;
    }

    protected function getScopeVal($key)
    {
        return $this->scope[$key];
    }

    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        if ($method == 'get') {
            $field = lcfirst(substr($name, 3));
            return $this->get($field);

        } elseif ($method == 'set') {
            $field = lcfirst(substr($name, 3));
            return $this->set($field, $args[0]);
        }
        throw new \Exception('Calling unexistant method ' . $name);
    }


    protected function get($field)
    {
        $storingObject = $this->getStoringObject($field);
        if ($storingObject === $this) {
            throw new \Exception('Calling unexistant method ' . 'set' . ucfirst($field));
        }
        return $storingObject->{'get'.ucfirst($field)}();
    }

    protected function set($field, $val)
    {
        $storingObject = $this->getStoringObject($field);
        if ($storingObject === $this) {
            throw new \Exception('Calling unexistant method ' . 'set' . ucfirst($field));
        }
        $storingObject->{'set'.ucfirst($field)}($val);
        return $this;
    }


    public function getStoringObject($field)
    {
        $md = $this->getMeta();
        $fieldMd = $md->getField($field);
        $class = $fieldMd->getStoringClassName();
        if ($class==get_class($this)) {
            return $this;
        }
        if (!isset($this->storingObjects[$class])) {
            $obj = new $class();
            $obj->{'set'.ucfirst($md->name)}($this);
            foreach($fieldMd->scopes as $scope) {
                echo "\n[$scope] = " . $this->getScopeVal($scope);
                $obj->{'set'.ucfirst($scope)}($this->getScopeVal($scope));
            }
            $this->storingObjects[$class] = $obj;
        }
        return $this->storingObjects[$class];
    }

    public function postPersist(LifecycleEventArgs $args) {
        /** @var ScopedEntityPart $partial */
        foreach ($this->storingObjects as $partial) {
            $args->getEntityManager()->persist($partial);
            $args->getEntityManager()->flush();
           // $partial->persistLater = true;
        }
    }

    public function prePersist(LifecycleEventArgs $args) {
//        /** @var ScopedEntityPart $partial */
//        foreach ($this->storingObjects as $partial) {
//            $partial->persistLater = true;
//        }
    }


}