<?php

return $config = [
    //log目录
    'logPath'           => __DIR__ . '/../runtime/logs/swoole-jobs',
    'pidPath'           => __DIR__ . '/../runtime/logs/swoole-jobs',
    'processName'       => ':swooleTopicQueueYii2', // 设置进程名, 方便管理, 默认值 swooleTopicQueue
    //job任务相关
    'job'         => [
        'topics'  => [
            ['name'=> 'MyJob', 'workerMinNum'=>1, 'workerMaxNum'=>2],
            ['name'=> 'MyJob2', 'workerMinNum'=>1, 'workerMaxNum'=>2],
            ['name'=> 'MyJob3', 'workerMinNum'=>1, 'workerMaxNum'=>1],
        ],
        'queue'   => [
            'class'    => '\Kcloze\Jobs\Queue\RedisTopicQueue',
            'host'     => '192.168.3.9',
            'port'     => 6379,
            //'password'=> 'pwd',
        ],

   ],
   //框架类型及装载类
   'framework' => [
       'type'   => 'yii',
       'config' => require __DIR__ . '/console.php',
       //可以自定义，但是该类必须继承\Kcloze\Jobs\Action\BaseAction
       'class'=> 'Kcloze\Jobs\Action\YiiAction',

   ],

];
