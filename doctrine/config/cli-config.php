<?php

require_once "bootstrap.php";

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Version;


use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;

$commands[] = new \S\Doctrine\Tools\Console\Command\GenerateEntitiesCommand();

return new HelperSet(array(
    'db' => new ConnectionHelper($entityManager->getConnection()),
    'em' => new EntityManagerHelper($entityManager)
));
