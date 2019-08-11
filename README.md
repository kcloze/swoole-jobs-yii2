## swoole-jobs-yii2

* 基于swoole-jobs的yii2 demo项目
* 教大家如何整合yii2和swoole-jobs

## 文档

* git clone https://github.com/kcloze/swoole-jobs-yii2.git
* composer install -vvv --profile
* 修改config/swoole-jobs.php配置

## 管理服务

* php ./swoole-jobs.php start|stop|exit

## 增加测试任务到队列

* php yii jobs/add

## 自己的yii2项目怎么改？
* 修改自己项目composer.json，增加swoole-jobs包，并执行composer update
```
    "require": {
        "php": ">=7.0",
        "kcloze/swoole-jobs": "*"
    }
```
* 复制该项目swoole-jobs文件到自己项目根目录
* 复制该项目config/swoole-jobs.php到自己项目配置目录
* 插入队列：参考commands/JobsController.php代码
* 参考上面文档启动服务


## 更多信息
* [swoole-jobs](https://github.com/kcloze/swoole-jobs)



## 联系

qq群：141059677

