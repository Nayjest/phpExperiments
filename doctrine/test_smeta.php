<?php
namespace Test;

require_once "bootstrap.php";

$em = $entityManager;
$prodCfg  = $cfg['areas']['Test']['entities']['Product'];

$m = new \S\Meta\Entity($prodCfg);
var_dump($m);