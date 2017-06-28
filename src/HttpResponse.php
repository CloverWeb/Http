<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 13:24
 */

namespace Joking\Http;

use Joking\Http\Functions\ResponseResult;

class HttpResponse {

    const USER_REDIRECT = 'redirect';       //跳转
    const USER_VIEW = 'view';               //视图，带渲染的html或者其他
    const USER_HTML = 'html';               //html模板，不带渲染
    const USER_JSON = 'json';               //json数据

    const RESPOND_HTML = 'text/html';
    const RESPOND_JSON = 'application/json';
    const RESPOND_XML = 'text/xml';

    public function view($name, array $parameters = array()) {
        return new ResponseResult(['userHandle' => self::USER_VIEW, 'file' => $name, 'data' => $parameters]);
    }

    public function html($name) {
        return new ResponseResult(['userHandle' => self::USER_HTML, 'file' => $name]);
    }

    public function json(array $data) {
        return new ResponseResult(['userHandle' => self::USER_VIEW, 'data' => $data]);
    }

    public function redirect($url = '/', $status = 302, array $options = array()) {
        return new ResponseResult(['url' => $url, 'status' => $status, 'data' => $options]);
    }

    public function setCharset($charset = 'utf-8') {
        header('Content-Type:charset=' . $charset);
    }

    /**
     * @param string $name 可选参数 ： RESPOND_HTML，RESPOND_JSON，RESPOND_XML
     */
    public function setRespondType($name) {
        header('Content-Type:' . $name);
    }

    public function setStatus($status = 200) {
        header('HTTP/1.1 ' . $status);
    }

    public function setLanguage($language = 'zh-cn') {
        header('Content-language: ' . $language);
    }
}