<?php
namespace D;

/**
 * @Entity @Table(name="products")
 **/
class Product
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    public $name;

//    public function setName($name) {
//        $this->name = $name;
//    }

    public function getId()
    {
        return $this->id;
    }


    // .. (other code)
}