<h1 align="center">Laravel Zabbix SDK</h1>

一个基于 Laravel 开发的 Zabbix SDK

## 环境要求
- PHP >= 7.1
- pimple/pimple >= 3.5

## 安装
使用 [composer](http://getcomposer.org/):

目前阿里云Composer镜像同步问题尚未解决，建议使用官方镜像或者腾讯等镜像

```shell
# 取消当前镜像配置
composer config -g --unset repos.packagist

# 使用腾讯镜像
composer config -g repos.packagist composer https://mirrors.tencent.com/composer/

# 安装
composer require zuogechengxu/zabbix
```

## 使用

### 初始化
``` php
use Zuogechengxu\Zabbix\Application;

$zbx_config = [
    'zabUrl' => 'http://xxx.xx.xx.xx',
    'zabUser' => 'Admin',
    'zabPassword' => 'zabbix'
];

$app = new Application($zbx_config);
```

### 获取用户令牌（user.login）
``` php
use Zuogechengxu\Zabbix\Application;

# 获取用户令牌，返回数组，设置了缓存2小时
$token = $app->auth_token->getAuthToken();

# 刷新令牌
$app->auth_token->refresh()

# 获取zabbix api版本，返回字符串
$version = $app->auth_token->getApiVersion();
```

### 调用其他api，示例
``` php
use Zuogechengxu\Zabbix\Application;

# 使用以下方法可以直接调用 Zabbix 任意 API，该方法默认自动处理了用户令牌逻辑，以获取主机为例。
$params = [
    "filter" => ["host" => ['Zabbix server']]
];

# 返回数据
$host = $app->rpc->call('host.get', $params)

# 返回原始 response 对象
$host = $app->rpc->call('host.get', $params, true)
```

## 说明

因该项目缓存 Token 直接使用了Laravel Cache 的 Facades，建议将 CACHE_DRIVER=file 改为 CACHE_DRIVER=redis
