<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$entidades = array("");
$isDevMode = true;

$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'webx',
);

$config = Setup::createAnnotationMetadataConfiguration($entidades, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
