<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 0:25
 */

namespace Joking\Http\Functions;

/**
 * Class SessionEntity
 * @package OBlood\Component\Http\Entity
 *
 * @property int $time              过期时间
 * @property string $name
 * @property string $value
 */
class SessionEntity extends Parameters {

    public function load($name, $value, $time) {
        $this->name = $name;
        $this->value = $value;
        $this->time = $time;
        return $this;
    }
}