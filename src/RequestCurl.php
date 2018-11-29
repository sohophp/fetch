<?php

namespace Sohophp\Fetcher;

class RequestCurl extends RequestAbstract implements RequestInterface
{

    public function request():Response
    {

        $url = $this->url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($this->method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->data));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $this->Response = new Response();
        if ($error != "") {
            $this->Response->setErrorString($error);
        } else {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $this->Response->setRawHeader(substr($response, 0, $header_size));
            $this->Response->setBody(substr($response, $header_size));
            $this->Response->setHttpCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));
            $this->Response->setEffectiveUrl(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
        }
        return $this->Response;
    }

}
