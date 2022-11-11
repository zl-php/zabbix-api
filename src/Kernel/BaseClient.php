<?php
# @Author : zhoulei1
# @Time   : 2022-11-10
# @File   : BaseClient.php
namespace Zuogechengxu\Zabbix\Kernel;

use Zuogechengxu\Zabbix\Kernel\Traits\HasRpcRequest;
use Zuogechengxu\Zabbix\Kernel\Contracts\AuthTokenInterface;

class BaseClient
{
    use HasRpcRequest;

    protected $app;
    protected $authToken = null;

    public function __construct(ServiceContainer $app, AuthTokenInterface $authToken = null )
    {
        $this->app = $app;
        $this->authToken = $authToken ?? $this->app['auth_token'];
    }
}
