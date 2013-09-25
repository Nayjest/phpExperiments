<?php

require_once "bootstrap.php";
$em = $entityManager;
$prod = new \Test\Product();
$prod->setSku("Skuuuu".rand(0,100));
$s = new \Test\Product_Store_Lang();
$s->setName("Test Name");
$s->setStore('some_store');
$s->setLang('ru');
$prod->addScopeStoreLang($s);
$em->persist($s);
$em->persist($prod);
$em->flush();

