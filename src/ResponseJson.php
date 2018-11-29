<?php

namespace Sohophp\Fetcher;

class ResponseJson
{
    private $body;
    private $data = [];
    private $is_json;

    public function __construct($body)
    {
        $this->body = $body;
        $data = json_decode($body, true);
        if (is_null($data)) {
            $this->is_json = false;
            $this->data = [];
        } else {
            $this->is_json = true;
            $this->data = $data;
        }
    }

    public function __get($key)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    public function exists($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function isJson()
    {
        return $this->is_json;
    }

}
