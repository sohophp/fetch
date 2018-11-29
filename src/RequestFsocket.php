<?php

namespace Sohophp\Fetcher;

class RequestFsocket extends RequestAbstract implements RequestInterface
{

    public function request():Response
    {
        $fp = fsockopen($this->protocol . '://' . $this->host, $this->port, $errno, $errstr, $this->timeout);
        $this->Response = new Response();
        if (!$fp) {
            $this->Response->setErrorString($errstr)->setErrorNo($errno);
            return $this->Response;
        }

        stream_set_blocking($fp, 1);
        stream_set_timeout($fp, $this->timeout);
        $body = http_build_query($this->data);

        $url = $this->path;
        if (!empty($this->query)) {
            $url .= '?' . $this->query;
        }

        if ($this->method === 'GET' && !empty($this->data)) {
            if ($this->query) {
                $url .= '&' . http_build_query($this->data);
            } else {
                $url .= '?' . http_build_query($this->data);
            }
        }

        $this->setRawHeader("{$this->method} {$url} HTTP/1.1");
        $this->setHeader('Host', $this->host);
        $this->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        $this->setHeader('Content-Length', strlen($body));
        $this->setHeader('Connection', 'close');
        $header = $this->getHeaderString();
        $header .= $body;
        fwrite($fp, $header);
        usleep(1000); // nginx
        $inheader = true;
        while (!feof($fp)) {
            $line = fgets($fp, 1024);
            if ($inheader) {
                if ($line == "\n" || $line == "\r\n") {
                    $inheader = false;
                } else {
                    $this->Response->setRawHeader($line);
                }
            } else {
                $this->Response->appendBody($line);
            }
        }
        fclose($fp);
        return $this->Response;
    }

}
