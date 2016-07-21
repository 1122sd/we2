<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

//判断是否安装
define('IA_DIR', str_replace("\\",'/', __DIR__.'/../'));
if(file_exists(IA_DIR.'install/install.lock')){
    header("location:../install/install.php");
    die;
}
//结束
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();



