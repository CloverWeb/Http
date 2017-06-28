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
}