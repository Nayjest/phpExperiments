<?php

namespace Test;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
{
    use \S\Doctrine\ScopedEntity;
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $scope_store_langs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $scope_store_customergroups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scope_store_langs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->scope_store_customergroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sku
     *
     * @param string $sku
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    
        return $this;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Add scope_store_langs
     *
     * @param \Test\Product_Store_Lang $scopeStoreLangs
     * @return Product
     */
    public function addScopeStoreLang(\Test\Product_Store_Lang $scopeStoreLangs)
    {
        $this->scope_store_langs[] = $scopeStoreLangs;
    
        return $this;
    }

    /**
     * Remove scope_store_langs
     *
     * @param \Test\Product_Store_Lang $scopeStoreLangs
     */
    public function removeScopeStoreLang(\Test\Product_Store_Lang $scopeStoreLangs)
    {
        $this->scope_store_langs->removeElement($scopeStoreLangs);
    }

    /**
     * Get scope_store_langs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScopeStoreLangs()
    {
        return $this->scope_store_langs;
    }

    /**
     * Add scope_store_customergroups
     *
     * @param \Test\Product_Store_CustomerGroup $scopeStoreCustomergroups
     * @return Product
     */
    public function addScopeStoreCustomergroup(\Test\Product_Store_CustomerGroup $scopeStoreCustomergroups)
    {
        $this->scope_store_customergroups[] = $scopeStoreCustomergroups;
    
        return $this;
    }

    /**
     * Remove scope_store_customergroups
     *
     * @param \Test\Product_Store_CustomerGroup $scopeStoreCustomergroups
     */
    public function removeScopeStoreCustomergroup(\Test\Product_Store_CustomerGroup $scopeStoreCustomergroups)
    {
        $this->scope_store_customergroups->removeElement($scopeStoreCustomergroups);
    }

    /**
     * Get scope_store_customergroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScopeStoreCustomergroups()
    {
        return $this->scope_store_customergroups;
    }
}
