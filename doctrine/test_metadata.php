<?php

require_once "bootstrap.php";
$em = $entityManager;
$md  = $em->getClassMetadata('Test\Product');
$data  = $md->getAssociationMappings();
var_dump($data);

