<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 14:41
 */

namespace Joking\Http;


class HttpCookie {

    public function add($name, $value, $expire = 0) {
        setcookie($name, $this->encode($value), $expire);
    }

    public function get($name, $default = null) {
        return isset($_COOKIE[$name]) ? $this->decode($_COOKIE[$name]) : $default;
    }

    public function has($name) {
        return isset($_COOKIE[$name]);
    }

    /**
     * cookie加密
     * @param string $string
     * @param string $sKey
     * @return mixed
     */
    private function encode($string = '', $sKey = 'OBlood') {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($sKey) as $key => $value)
            $key < $strCount && $strArr[$key] .= $value;
        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
    }

    /**
     * cookie解密
     * @param string $string
     * @param string $sKey
     * @return bool|string
     */
    private function decode($string = '', $sKey = 'OBlood') {
        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($sKey) as $key => $value)
            $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        return base64_decode(join('', $strArr));
    }
}