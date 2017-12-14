<?php
/**
 * @see http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

/*
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since 2.0
 */

use Kcloze\Jobs\JobObject;
use Kcloze\Jobs\Queue\Queue;
use yii\console\Controller;
use yii\console\ExitCode;

class JobsController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     *
     * @param string $message the message to be echoed
     * @param mixed  $a
     * @param mixed  $b
     * @param mixed  $c
     */
    public function actionIndex($message, $a, $b, $c)
    {
        echo $message . $a . $b . $c . "\n";

        return ExitCode::OK;
    }

    public function actionAdd()
    {
        $config =[
            'type'       => 'redis',
            'host'       => '127.0.0.1',
            'port'       => 6379,
        ];
        $queue=Queue::getQueue($config);
        if (!$queue) {
            die('queue object is null' . PHP_EOL);
        }
        //往topic为MyJob的任务增加执行job
        for ($i = 0; $i < 100; $i++) {
            $job = new JobObject('MyJob', 'Kcloze\Jobs\Jobs\MyJob', 'test1', ['kcloze', time()]);

            $result=$queue->push('MyJob', $job);
            var_dump($result, $queue->len('MyJob'));
        }
        for ($i = 0; $i < 100; $i++) {
            // 根据自定义的 $jobs->load() 方法, 自定义数据格式
            $job   = new JobObject('MyJob', 'Kcloze\Jobs\Jobs\MyJob', 'test1', ['kcloze', time()]);
            $result=$queue->push('MyJob2', $job);
            var_dump($result, $queue->len('MyJob'));
        }
    }
}
