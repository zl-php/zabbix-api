<?php
# @Author : zhoulei1
# @Time   : 2022-11-10
# @File   : ConfigServiceProvider.php
namespace Zuogechengxu\Zabbix\Kernel\Providers;

use Zuogechengxu\Zabbix\Kernel\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        !isset($pimple['config']) && $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}
