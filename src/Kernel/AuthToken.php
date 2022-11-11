<?php
# @Author : zhoulei1
# @Time   : 2022-11-11
# @File   : AuthToken.php
namespace Zuogechengxu\Zabbix\Kernel;

use Illuminate\Support\Facades\Cache;
use Zuogechengxu\Zabbix\Kernel\Traits\HasRpcRequest;
use Zuogechengxu\Zabbix\Kernel\Contracts\AuthTokenInterface;
use Zuogechengxu\Zabbix\Kernel\Exceptions\AuthTokenException;

abstract class AuthToken implements AuthTokenInterface
{
    use HasRpcRequest;

    protected $app;
    protected $tokenKey = 'result';
    protected $authToken = null;
    protected $requestMethod = 'POST';
    protected $zabApiVersion = '';
    protected $cachePrefix = 'zuogechengxu.zabbix.auth_token.';

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    public function getAuthToken(bool $refresh = false): array
    {
        $cacheKey = $this->getCacheKey();
        if (!$refresh && Cache::has($cacheKey) && $result = Cache::get($cacheKey)) {
            return $result;
        }

        // 获取token
        $authToken = $this->requestToken($this->getCredentials());

        $this->setAuthToken($authToken[$this->tokenKey]);

        $this->authToken = $authToken;

        return $authToken;
    }

    public function refresh(): AuthTokenInterface
    {
        $this->getAuthToken(true);

        return $this;
    }

    public function getApiVersion()
    {
        $credentials = [
            'method' => 'apiinfo.version',
            'id' => 1,
            'params' => [],
            'jsonrpc' => "2.0"
        ];

        $response = $this->sendRequest($credentials);

        if (isset($response['id']) && $response['id'] == 1 && isset($response['result'])) {
            $this->zabApiVersion = $response['result'];
        }

        return $this->zabApiVersion;
    }

    protected function getCacheKey()
    {
        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
    }

    protected function requestToken(array $credentials)
    {
        if (!$this->zabApiVersion) {
            $this->getApiVersion();
        }

        if (version_compare($this->zabApiVersion, '5.4.0') < 0) {
            $userKey = 'user';
        } else {
            $userKey = 'username';
        }

        $credentials = [
            'method' => 'user.login',
            'id' => 1,
            'params' => ['password' => $credentials['zabPassword'], $userKey => $credentials['zabUser']],
            'jsonrpc' => "2.0"
        ];

        $response = $this->sendRequest($credentials);

        if (isset($response['id']) && $response['id'] == 1 && isset($response['result'])) {
            $this->zabApiVersion = $response['result'];
        }

        return $response;
    }

    protected function setAuthToken($authToken, $lifetime = 7200)
    {
        Cache::put($this->getCacheKey(), [
            $this->tokenKey => $authToken
        ], $lifetime);

        if (!Cache::has($this->getCacheKey())) {
            throw new AuthTokenException('Failed to cache access token.');
        }

        return $this;
    }

    protected function sendRequest(array $credentials)
    {
        $domain = $this->app['config']['zabUrl'];
        $zabUrl = substr($domain , -1) == '/' ?  $domain : $domain .= '/';

        try {
            $rawResponse = $this->request($zabUrl . 'api_jsonrpc.php', $credentials);

            $response = json_decode($rawResponse, true);

            return $response;

        }catch (\Exception $e){
            throw new AuthTokenException($e->getMessage());
        }
    }

}
