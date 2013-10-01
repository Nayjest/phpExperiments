<?php

namespace Test;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product_Store_Lang
 */
class Product_Store_Lang
{
    /**
     * @var string
     */
    private $store;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Test\Product
     */
    private $product;


    /**
     * Set store
     *
     * @param string $store
     * @return Product_Store_Lang
     */
    public function setStore($store)
    {
        $this->store = $store;
    
        return $this;
    }

    /**
     * Get store
     *
     * @return string 
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return Product_Store_Lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    
        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product_Store_Lang
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set product
     *
     * @param \Test\Product $product
     * @return Product_Store_Lang
     */
    public function setProduct(\Test\Product $product)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Test\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
