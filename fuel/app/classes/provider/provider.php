<?php

namespace Provider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use GuzzleHttp\Client;

class Provider extends AbstractServiceProvider
{
    protected $provides = ['httpclient'];

    public function register()
    {
        $this->getContainer()->add('httpclient', new Client());
    }
}
