<?php

namespace Service;

use GuzzleHttp\Client;

class Remote
{
    protected static $httpClient;

    public static function getHttpClient()
    {
        if (!self::$httpClient) {
            self::$httpClient = new Client();
        }

        return self::$httpClient;
    }

    public static function getIp()
    {
        return self::getHttpClient()->get('http://httpbin.org/ip')->getBody()->__toString();
    }

    public function nonStatic($path)
    {
        return self::getHttpClient()->get('http://httpbin.org/' . $path)->getBody()->__toString();
    }
}
