<?php

namespace Test;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product_Store_CustomerGroup
 */
class Product_Store_CustomerGroup
{
    /**
     * @var string
     */
    private $store;

    /**
     * @var string
     */
    private $customerGroup;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var \Test\Product
     */
    private $product;


    /**
     * Set store
     *
     * @param string $store
     * @return Product_Store_CustomerGroup
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
     * Set customerGroup
     *
     * @param string $customerGroup
     * @return Product_Store_CustomerGroup
     */
    public function setCustomerGroup($customerGroup)
    {
        $this->customerGroup = $customerGroup;
    
        return $this;
    }

    /**
     * Get customerGroup
     *
     * @return string 
     */
    public function getCustomerGroup()
    {
        return $this->customerGroup;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Product_Store_CustomerGroup
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set product
     *
     * @param \Test\Product $product
     * @return Product_Store_CustomerGroup
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
