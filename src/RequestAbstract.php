<?php

namespace Sohophp\Fetcher;

abstract class RequestAbstract
{

    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $scheme;
    /**
     * @var string
     */
    protected $host;
    /**
     * @var integer
     */
    protected $port;
    /**
     * @var string
     */
    protected $user;
    /**
     * @var string
     */
    protected $pass;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $query;
    /**
     * @var string
     */
    protected $fragment;
    /**
     * @var string
     */
    protected $protocol = 'tcp';
    /**
     * @var array
     */
    protected $headers = [];
    protected $raw_headers = [];


    protected $method = 'GET';


    /**
     * @var array POST 欄位
     */
    protected $data = [];

    /**
     * @var int 超時秒數
     */
    protected $timeout = 30;
    /**
     * @var Response
     */
    protected $Response;

    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->parseUrl($url);
        return $this;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param string $fragment
     */
    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return array
     */
    public function getRawHeaders()
    {
        return $this->raw_headers;
    }

    /**
     * @param array $raw_headers
     */
    public function setRawHeaders($raw_headers)
    {
        $this->raw_headers = $raw_headers;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return RequestAbstract
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return RequestAbstract
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function parseUrl($url)
    {
        $defaults = [
            'scheme' => '',
            'host' => '',
            'port' => '',
            'user' => '',
            'pass' => '',
            'path' => '',
            'query' => '',
            'fragment' => '',
            'protocol' => 'tcp'
        ];

        $parse = parse_url($url);

        $parse = array_merge($defaults, $parse);
        if ($parse['port'] === '') {
            if ($parse['scheme'] === 'https') {
                $parse['port'] = 443;
                $parse['protocol'] = 'ssl';
            } else {
                $parse['port'] = 80;
                $parse['protocol'] = 'tcp';
            }
        }
        foreach ($parse as $k => $v) {
            $this->{$k} = $v;
        }
        $this->url = $url;
        return $this;
    }

    protected function normalizeHeader($name)
    {
        $filtered = str_replace(array('-', '_'), ' ', ( string )$name);
        $filtered = ucwords(strtolower($filtered));
        $filtered = str_replace(' ', '-', $filtered);
        return $filtered;
    }

    public function setHeader($name, $value, $replace = false)
    {
        $name = $this->normalizeHeader((string)$name);
        $value = (string)$value;
        if ($replace) {
            foreach ($this->headers as $key => $header) {
                if ($key === $name) {
                    unset($this->headers[$key]);
                }
            }
        }
        $this->headers[] = ['name' => $name, 'value' => $value, 'replace' => $replace];
        return $this;
    }

    public function setRawHeader($value)
    {
        $this->raw_headers [] = ( string )$value;
        return $this;
    }

    public function getHeaderString($ln = true)
    {
        $headers = [];
        foreach ($this->raw_headers as $header) {
            $headers[] = $header . "\r\n";
        }
        foreach ($this->headers as $header) {
            $headers[] = $header['name'] . ':' . $header['value'] . "\r\n";
        }
        if ($ln) {
            $headers[] = "\r\n";
        }
        return implode("", $headers);
    }

    /**
     * @see RequestInterface::request()
     * @return Response
     */
    public function request():Response
    {
        return new Response();
    }

    public function post($url, $data = [], $raw_headers = [])
    {
        return $this->setMethod('POST')
            ->setUrl($url)
            ->setData($data)
            ->setRawHeaders($raw_headers)
            ->request();
    }

    public function get($url, $data = [], $raw_headers = [])
    {
        return $this->setMethod('GET')
            ->setUrl($url)
            ->setData($data)
            ->setRawHeaders($raw_headers)
            ->request();
    }

    public function getDebugMessage()
    {

        $data = [];
        $data['url'] = $this->url;
        $data['scheme'] = $this->scheme;
        $data['host'] = $this->host;
        $data['port'] = $this->port;
        $data['user'] = $this->user;
        $data['pass'] = $this->pass;
        $data['path'] = $this->path;
        $data['query'] = $this->query;
        $data['fragment'] = $this->fragment;
        $data['protocol'] = $this->protocol;
        $data['method'] = $this->method;
        $data['data'] = $this->data;
        $data['header'] = $this->getHeaderString();
        $data['Response'] = $this->Response->getDebugMessage();
        return $data;
    }

    public function getDebugMessageTable()
    {
        return new Debug($this);
    }

}
