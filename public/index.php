<?php

use Config\Bootstrap;
use Neoan\Helper\Env;
use Neoan\NeoanApp;
use Neoan\Routing\AttributeRouting;

require_once '../vendor/autoload.php';

$appPath = dirname(__DIR__) . '/src';
$publicPath = __DIR__;
$cliPath = dirname(__DIR__);

$app = new NeoanApp($appPath, $publicPath, $cliPath);
$app->invoke(new AttributeRouting('App'));
new Bootstrap($app);

$app->run();