<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 15:20
 */

namespace Joking\Http\Middleware;


interface SessionMiddlewareInterfaces {

    /**
     * 禁止 echo print_r等一系列输出动作
     */
    public function execute();

}