<?php

namespace Sohophp\Fetcher;

class RequestFile extends RequestAbstract implements RequestInterface
{

    public function request():Response
    {
        $body = http_build_query($this->data);
        $this->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        $this->setHeader('Content-Length', strlen($body));
        $context_options = array(
            'https' => array(
                'method' => $this->method,
                'header' => $this->getHeaderString(false),
                'content' => $body,
                'timeout' => $this->timeout
            )
        );
        $context = stream_context_create($context_options);
        $content = file_get_contents($this->url, false, $context);
        $this->Response = new Response();
        $this->Response->setRawHeader($http_response_header)->appendBody($content);
        return $this->Response;
    }

}
