<?php

namespace Sohophp\Fetcher;

class Request
{

    /**
     * @var RequestFsocket
     */
    private $Request;

    public function __construct($Request = RequestFsocket::class)
    {
        $this->Request = new $Request();
    }

    public function post($url, $data = [], $raw_headers = [])
    {
        return $this->Request->post($url, $data, $raw_headers);
    }

    public function get($url, $data = [], $raw_headers = [])
    {
        return $this->Request->get($url, $data, $raw_headers);
    }

    public function getRequest()
    {
        return $this->Request;
    }

    public function getDebugMessageTable()
    {
        return $this->Request->getDebugMessageTable();
    }
}
