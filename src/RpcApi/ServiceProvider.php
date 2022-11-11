<?php
namespace Zuogechengxu\Zabbix\RpcApi;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        isset($app['auth_token']) || $app['auth_token'] = function ($app) {
            return new AuthToken($app);
        };

        isset($app['rpc']) || $app['rpc'] = function ($app) {
            return new Rpc($app);
        };
    }
}
