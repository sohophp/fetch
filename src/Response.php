<?php

namespace Sohophp\Fetcher;

class Response
{

    /**
     * @var string 錯誤消息
     */
    private $error_string = '';
    /**
     * @var integer 錯誤消息代碼
     */
    private $error_no = 0;
    private $body = [];
    private $headers = [];
    private $raw_headers = [];
    /**
     * @var integer HTTP 狀態碼
     */
    private $http_code;
    /**
     * @var string 實際網址
     */
    private $effective_url;


    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getErrorString()
    {
        return $this->error_string;
    }

    /**
     * @param string $error_string
     * @return Response
     */
    public function setErrorString($error_string)
    {
        $this->error_string = $error_string;
        return $this;
    }

    /**
     * @return int
     */
    public function getErrorNo()
    {
        return $this->error_no;
    }

    /**
     * @param int $error_no
     * @return Response
     */
    public function setErrorNo($error_no)
    {
        $this->error_no = $error_no;
        return $this;
    }

    /**
     * @param $body
     * @param null $name
     * @return $this
     */
    public function appendBody($body, $name = null)
    {
        $body = (string)$body;
        if (!is_null($name)) {
            $this->body[$name] = $body;
        } else {
            $this->body[] = $body;
        }
        return $this;
    }

    /**
     * @param $header
     * @return $this
     */
    public function setRawHeader($header)
    {
        $this->raw_headers[] = $header;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        foreach ($this->raw_headers as $header) {
            $headers[] = $header;
        }
        foreach ($this->headers as $header) {
            $headers[] = $header['name'] . ':' . $header['value'];
        }
        return $headers;
    }

    /**
     * @return string
     */
    public function getHeaderString()
    {
        return implode("\n", $this->getHeaders());
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->getHeaderString();
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return implode("\n", $this->body);
    }

    /**
     * 清空body並插入一個body
     * @param $body
     */

    public function setBody($body)
    {
        $this->body = [$body];
    }

    /**
     * @param int $http_code
     */
    public function setHttpCode(int $http_code)
    {
        $this->http_code = $http_code;
    }

    /**
     * @param string $effective_url
     */
    public function setEffectiveUrl(string $effective_url)
    {
        $this->effective_url = $effective_url;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getBody();
    }

    /**
     * @return ResponseJson
     */
    public function toJson()
    {
        return new ResponseJson($this->getBody());
    }
    public function json(){
        return new ResponseJson($this->getBody());
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (new ResponseJson($this->getBody()))->toArray();
    }

    public function getDebugMessage()
    {
        $data = [];
        $data['header'] = $this->getHeaderString();
        $data['body'] = $this->getBody();
        $data['json'] = $this->toArray();
        return $data;
    }

    /**
     * @todo 应该加判断状态码,未完
     * @param callable $callback
     * @return $this
     */
    public function then(callable $callback){
         $callback($this);
         return $this;
    }

    /**
     * @todo 应该加判断状态码,未完
     * @param callable $callback
     * @return $this
     */
    public function fail(callable $callback){
        $callback($this);
        return $this;
    }
}
