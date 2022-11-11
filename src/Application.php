<?php

namespace Zuogechengxu\Zabbix;

use Zuogechengxu\Zabbix\Kernel\ServiceContainer;

class Application extends ServiceContainer
{
    protected $providers = [
        RpcApi\ServiceProvider::class,
    ];

    // 使用该参数可替换用户配置
    protected $defaultConfig = [];
}
