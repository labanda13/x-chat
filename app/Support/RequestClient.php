<?php

namespace App\Support;

class RequestClient
{
    /**
     * Get request ip
     *
     * @return string
     */
    public static function ip(): string
    {
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        return @$_SERVER['REMOTE_ADDR'] ?: '127.0.0.1';
    }
}
