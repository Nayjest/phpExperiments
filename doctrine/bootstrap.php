<?php

require_once "../vendor/autoload.php";
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


//set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . 'runtime');

#temp
$files = glob(__DIR__ . '/runtime/*/*.php');
foreach ($files as $file) {
    include_once $file;
}


// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/src/D'), $isDevMode);

// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
$config = Setup::createYAMLMetadataConfiguration(
    [
        __DIR__ . DIRECTORY_SEPARATOR . "config",
        __DIR__ . DIRECTORY_SEPARATOR . "runtime" . DIRECTORY_SEPARATOR . "config"
    ],
    $isDevMode,
    __DIR__ . '/runtime/proxies'
);
$config->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());


//$config->setClassMetadataFactoryName('MyMetadataFactory');
// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'host' => '127.0.0.1',
    'dbname' => 'test',
    'user' => 'root',
    'password' => ''

);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
\S\Doctrine\BasicEntity::$metadataFactory = $entityManager->getMetadataFactory();

//$driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver($entityManager->getConnection()->getSchemaManager());
//$driver->setNamespace('App\\Model\\Entities\\');
//
//$entityManager->getConfiguration()->getMetadataDriverImpl()->setNamespace("\\test");