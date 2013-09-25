<?php

require_once "bootstrap.php";
$em = $entityManager;
$product = [
    'name' => 'Product',
    'area' => 'Test',
    'fields' => [
        'sku' => [
            'type' => 'string'
        ],
        'name' => [
            'type' => 'string',
            'scopes' => ['store', 'lang']
        ],
        'price' => [
            'type' => 'integer',
            'scopes' => ['store', 'customerGroup']
        ]

    ]

];
$dg = new \S\Doctrine\EntityConfigGenerator();
$dg->generateAndWrite($product,'runtime'.DIRECTORY_SEPARATOR.'config');


