<?php
# @Author : zhoulei
# @Time   : 2022-11-11
# @File   : AuthTokenInterface.php

namespace Zuogechengxu\Zabbix\Kernel\Contracts;

interface AuthTokenInterface
{
    public function getAuthToken(): array;

    public function refresh(): self;
}
