<?php

namespace app\core;

/**
 * Response
 * 
 * Response is responsible for handling the response to the client. like http status codes and redirects.
 * 
 * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
 * @package app\core
 */
class Response
{
    public function setStatusCode($code)
    {
        if (is_int($code)) {
            http_response_code($code);
        } else {
            http_response_code(500);
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}
