<?php
namespace app\admin\controller;
use \think\controller;

class Base extends controller
{
     public function _initialize()
    {
        if (!Session('id')) {
             $this->error('未登录！','Login/index');
        }
    }

}
