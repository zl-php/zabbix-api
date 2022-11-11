<?php
# @Author : zhoulei1
# @Time   : 2022-11-11
# @File   : AuthToken.php
namespace Zuogechengxu\Zabbix\RpcApi;

use Zuogechengxu\Zabbix\Kernel\AuthToken as BaseAuthToken;

class AuthToken extends BaseAuthToken
{
    protected function getCredentials(): array
    {
        return [
            'zabUser' => $this->app['config']['zabUser'],
            'zabPassword' => $this->app['config']['zabPassword'],
        ];
    }
}
