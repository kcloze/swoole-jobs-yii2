#!/usr/bin/env php
<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
define('APP_PATH', __DIR__);
define('SWOOLE_JOBS_ROOT_PATH', __DIR__);



use Kcloze\Jobs\Command\AppCommand;
use Kcloze\Jobs\Command\HttpCommand;
use Symfony\Component\Console\Application;

require SWOOLE_JOBS_ROOT_PATH . '/vendor/autoload.php';
require APP_PATH . '/vendor/yiisoft/yii2/Yii.php';

$config = require_once APP_PATH . '/config/swoole-jobs.php';

$application    = new Application();
$appCommand     = new AppCommand($config);
$application->add($appCommand);

//check if it has http command
$option=$argv[1] ?? '';
if (isset($config['httpServer']) && $option==='http') {
    $httpCommand    = new HttpCommand($config);
    $application->add($httpCommand);
    $application->setDefaultCommand($appCommand->getName());
} else {
    $application->setDefaultCommand($appCommand->getName(), true);
}

$application->run();




