<?php
namespace Test;

require_once "bootstrap.php";

$em = $entityManager;
$prod = new \Test\Product();
$scope = [
    'lang' => 'ru',
    'store'=>'first'
];
$prod->setScope($scope);
$prod->setSku("Skuuuu".rand(0,100));
$prod->setName("Name");
$em->persist($prod);
$em->flush();
//$em->persist($p);
//$em->flush();
echo "\nok";
