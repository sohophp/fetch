<?php

namespace Sohophp\Fetcher;

class Fetcher
{
    public static function get($url,$params=[],$raw_headers=[]){
        return (new Request())->get($url,$params,$raw_headers);
    }
    public static function post($url,$params=[],$raw_headers=[]){
        return (new Request())->post($url,$params,$raw_headers);
    }
}
