<?php
$ds = DIRECTORY_SEPARATOR;
$yiit = '../vendor/yiisoft/yii/framework/yiit.php';
$config = './config_test.php';

require_once($yiit);

// we must match YiiTactician\ namespace to some directory
$loader = require('../vendor/autoload.php');
$loader->addPsr4('YiiTactician\\', '../src/', true);

require_once(dirname(__FILE__) . '/TestApplication.php');
require_once(dirname(__FILE__) . '/CustomTestCase.php');

new TestApplication($config);