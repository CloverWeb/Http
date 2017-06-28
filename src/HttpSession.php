<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 0:10
 */

namespace Joking\Http;

use Joking\Http\Functions\SessionEntity;
use Joking\Http\Middleware\SessionMiddlewareInterfaces;


/**
 * Class HttpSession
 * @package OBlood\Component\Http
 */
class HttpSession {

    private $isOpen = false;

    public function open() {
        if (!$this->isOpen) {
            $this->middleware();

            session_start();
            $this->isOpen = true;
        }
    }

    public function isOpen() {
        return $this->isOpen;
    }

    /**
     * 执行已经绑定的middleware
     * @throws \Exception
     */
    private function middleware() {

        //执行session开启之前的中间件
        foreach (HttpMiddleware::$sessionStartBefore as $sessionMiddleware) {
            if (is_object($sessionMiddleware)) {
                if ($sessionMiddleware instanceof SessionMiddlewareInterfaces) {
                    $sessionMiddleware->execute();
                } else {
                    throw new \Exception('找不到对象！！！！');
                }
            } elseif (is_string($sessionMiddleware) && class_exists($sessionMiddleware)) {
                $reflectionClass = new \ReflectionClass($sessionMiddleware);
                $class = $reflectionClass->newInstance();
                if ($class instanceof SessionMiddlewareInterfaces) {
                    $class->execute();
                } else {
                    throw new \Exception('找不到对象！！！！');
                }
            }
        }
    }

    /**
     * 添加session
     * @param $name
     * @param $value
     * @param null|int $time 过期时间
     */
    public function add($name, $value, $time = null) {
        $this->open();
        $_SESSION[$name] = (new SessionEntity())->load($name, $value, $time ? $time + time() : 0);
    }

    public function remove($name) {
        $this->open();
        if (isset($_SESSION[$name])) unset($_SESSION[$name]);
    }

    public function all() {
        $this->open();
        $session = $_SESSION;
        foreach ($session as $name => $value) {
            if ($value instanceof SessionEntity) {
                $this->checkTimeout($value) && $this->remove($name);
            }
        }

        return $_SESSION;
    }

    public function get($name) {
        $this->open();
        if ($this->has($name)) {
            return $_SESSION[$name] instanceof SessionEntity ? $_SESSION[$name]->value : $_SESSION[$name];
        }

        return null;
    }

    public function has($name) {
        if (isset($_SESSION[$name])) {
            if ($_SESSION[$name] instanceof SessionEntity) {
                $this->checkTimeout($_SESSION[$name]) && $this->remove($name);
                return isset($_SESSION[$name]) ? true : false;
            }
            return true;
        }
        return false;
    }

    /**
     * 设置session id
     * @param null $id
     */
    public function setId($id = null) {
        session_id($id);
    }

    /**
     * 获取session id
     * @return string
     */
    public function getId() {
        $this->open();
        return session_id();
    }

    /**
     * 设置session的名称
     * @param $name
     */
    public function setName($name) {
        session_name($name);
    }

    /**
     * 获取session的名称
     * @return string
     */
    public function getName() {
        return session_name();
    }

    public function destroy() {
        $this->open();
        session_destroy();
    }

    /**
     * 判断 session 是否依然坚挺
     * 当时间 $entity->time 为 0 时那么该session值坚挺到海枯石烂
     * @param SessionEntity $entity
     * @return bool
     */
    public function checkTimeout(SessionEntity $entity) {
        if ($entity->time > 0) {
            return $entity ? $entity->time > time() ? false : true : true;
        } else {
            return false;
        }
    }
}