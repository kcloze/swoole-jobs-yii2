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
use Kcloze\Jobs\Logs;
use Kcloze\Jobs\Queue\BaseTopicQueue;
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
        sleep(5);

        return ExitCode::OK;
    }

    public function actionAdd()
    {
        //往topic为MyJob的任务增加执行job
        for ($i = 0; $i < 100; $i++) {
            $result=$this->addOneJob('MyJob', 'hello', 'index', [time()]);
            var_dump($result);
        }

        echo 'done' . PHP_EOL;
    }

    //可以把这个方法移到service或者通用类库里面
    public function addOneJob($jobName, $jobClass, $jobMethod = '', $jobParams = [], $jobExt = [])
    {
        $config   = require APP_PATH . '/config/swoole-jobs.php';
        $logger   = Logs::getLogger($config['logPath'] ?? '', $config['logSaveFileApp'] ?? '');
        //exit;
        $queue    = Queue::getQueue($config['job']['queue'], $logger);
        //设置工作进程参数
        $queue->setTopics($config['job']['topics']);

        $jobExtras['delay']    = isset($jobExt['delay']) ? $jobExt['delay'] : 0;
        $jobExtras['priority'] = isset($jobExt['priority']) ? $jobExt['priority'] : BaseTopicQueue::HIGH_LEVEL_1;

        $job      = new JobObject($jobName, $jobClass, $jobMethod, $jobParams, $jobExtras);
        $result   = $queue->push($jobName, $job);

        return $result;
    }
}
