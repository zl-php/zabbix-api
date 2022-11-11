<?php
namespace Zuogechengxu\Zabbix\RpcApi;

use Zuogechengxu\Zabbix\Kernel\BaseClient;

class Rpc extends BaseClient
{
   public function call(string $method, array $params = [], bool $returnRaw = false)
   {
        $request = $this->buildRequest($method, $params);

        $domain = $this->app['config']['zabUrl'];
        $zabUrl = substr($domain , -1) == '/' ?  $domain : $domain .= '/';
        $rawResponse = $this->request($zabUrl . 'api_jsonrpc.php', $request);

       return  $returnRaw ? $rawResponse : $this->toArray($rawResponse);
   }

   protected function buildRequest(string $method, array $params = [])
   {
       $params = [
           'auth' => $this->authToken ? $this->authToken->getAuthToken()['result'] : '',
           'method' => $method,
           'id' => 1,
           'params' => ( is_array($params) ? $params : [] ),
           'jsonrpc' => "2.0"
       ];

       if ($method == 'user.login' || $method == 'apiinfo.version') {
           unset($params['auth']);
       }

       return $params;
   }

}
