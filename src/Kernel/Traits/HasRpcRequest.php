<?php
namespace Zuogechengxu\Zabbix\Kernel\Traits;

use Illuminate\Support\Facades\Http;

trait HasRpcRequest
{
    public function request($url, array $data = [])
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json-rpc',
        ])->post($url, $data);

        return $response;
    }

    public function toArray($rawResponse)
    {
        return json_decode($rawResponse, true);
    }
}
