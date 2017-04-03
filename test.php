<?php
/**
 * Created by PhpStorm.
 * User: lzh
 * Date: 4/3/17
 * Time: 8:04 PM
 */
class Test
{
    public function __construct()
    {
        $this->map = ['a' => 'funca',
                      'b' => 'funcb'];
    }
    public function call_f()
    {
        call_user_func(array($this,$this->map['a']));
    }
    public function funca()
    {
        echo 'this is funca';
    }
    public function funcb()
    {
        echo 'this is funcb';
    }
}
$test = new Test();
$test->call_f();