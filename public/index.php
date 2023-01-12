<?php

use Config\Bootstrap;
use Neoan\Helper\Env;
use Neoan\NeoanApp;
use Neoan\Routing\AttributeRouting;

require_once '../vendor/autoload.php';

$appPath = dirname(__DIR__) . '/src';
$publicPath = __DIR__;
$cliPath = dirname(__DIR__);

$setup = new \Neoan\Helper\Setup();
$setup->setPublicPath($publicPath)->setLibraryPath($appPath);

$app = new NeoanApp($setup, $cliPath);
$app->invoke(new AttributeRouting('App'));
new Bootstrap($app);

$app->run();