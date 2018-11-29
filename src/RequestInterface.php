<?php

namespace Sohophp\Fetcher;

interface RequestInterface
{
    /**
     * @return \Sohophp\Fetcher\Response
     */
    public function request();
}
