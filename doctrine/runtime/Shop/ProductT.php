<?php

namespace Shop;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductT
 */
class ProductT
{
    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $descr;

    /**
     * @var \Shop\Product
     */
    private $product;


    /**
     * Set lang
     *
     * @param string $lang
     * @return ProductT
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
     * Set descr
     *
     * @param string $descr
     * @return ProductT
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
    
        return $this;
    }

    /**
     * Get descr
     *
     * @return string 
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Set product
     *
     * @param \Shop\Product $product
     * @return ProductT
     */
    public function setProduct(\Shop\Product $product)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Shop\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
