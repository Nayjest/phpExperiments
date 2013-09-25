<?php

require_once "bootstrap.php";
$em = $entityManager;

$newProductName = "test";


$cat = new \Category();
$cat->setName("category".rand(0,9999));
$cat->setDescription("Ololo");


$product = new \Product();
$product->setName($newProductName);
$product->addCategory($cat);
$cat->addProduct($product);


$entityManager->persist($cat);
$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getId() . "\n";

$p =  $entityManager->find('Product', 3);
//var_dump($product->getCategories());die();
$c = $p->getCategories()->first();
$c = $p->getCategories()->first();
echo "\nproduct name: {$p->getName()}\n";
echo "\ncat name: {$c->getName()}\n";
//echo get_class($p), '|';
//echo get_class($c), '|';
//var_dump(get_class($firstProduct));
//
//echo "|",get_class($em->getMetadataFactory());
//echo "|",get_class($em->getMetadataFactory()->getReflectionService());
die();


var_dump('______________________________________________'
    ,
    $entityManager->getClassMetadata('Product')
);

