<?php

namespace Sohophp\Fetcher;

class Debug
{
    /**
     * @var RequestAbstract
     */
    private $Request;

    public function __construct(RequestAbstract $Request)
    {
        $this->Request = $Request;
    }

    public function arrayToTable(Array $array = [])
    {
        $html = [];

        $html[] = '<table align="center" border="1" style="border-collapse: collapse;	border: solid 1px #E7E7E7;margin:50px;">';
        foreach ($array as $k => $v) {
            $html[] = sprintf('<tr><th style="border: solid 1px #E7E7E7;">%s</th><td style="border: solid 1px #E7E7E7;">%s</td></tr>',
                nl2br(htmlspecialchars($k)), is_array($v) ? $this->arrayToTable($v) : nl2br(htmlspecialchars($v)));
        }
        $html[] = '</table>';
        return implode(PHP_EOL, $html);
    }

    public function __toString()
    {
        $data = $this->Request->getDebugMessage();
        return $this->arrayToTable($data);
    }
}
