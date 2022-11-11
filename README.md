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


## 说明

因该项目缓存 Token 直接使用了Laravel Cache 的 Facades，建议将 CACHE_DRIVER=file 改为 CACHE_DRIVER=redis
