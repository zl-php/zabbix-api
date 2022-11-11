<?php
# @Author : zhoulei1
# @Time   : 2022-11-10
# @File   : ServiceContainer.php
namespace Zuogechengxu\Zabbix\Kernel;

use Pimple\Container;
use Zuogechengxu\Zabbix\Kernel\Providers\ConfigServiceProvider;

class ServiceContainer extends Container
{
    protected $providers  = [];
    protected $userConfig = [];
    protected $defaultConfig = [];

    public function __construct(array $config = [])
    {
        parent::__construct();

        $this->userConfig = $config;
        $this->registerProviders($this->getProviders());
    }

    // 获取配置参数
    public function getConfig()
    {
        return array_replace_recursive($this->userConfig, $this->defaultConfig);
    }

    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class
        ], $this->providers);
    }

    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}
