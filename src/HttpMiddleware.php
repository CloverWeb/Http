<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 16:02
 */

namespace Joking\Http;


use Joking\Http\Middleware\SessionMiddlewareInterfaces;

class HttpMiddleware {

    /**
     * @var array(SessionMiddlewareInterfaces)
     */
    public static $sessionStartBefore = array();

    public static function registerSessionStartBefore($sessionStartBefore) {
        static::$sessionStartBefore = $sessionStartBefore;
    }
}