<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\controller\Auth;
use think\Request;
class Base extends Controller
{
     public function _initialize()
    {
        if (!Session('id')) {
             $this->error('未登录！','Login/index');
        }
        $auth = new Auth();
        $request =Request::instance();
        $con=$request->controller();
        $action=$request->action();
        $name=$con.'/'.$action;
        $notCheck=array('Index/index','Admin/logout');
        if (Session('id')!=1) {
        	if (!in_array($name, $notCheck)) {
        		if (!$auth->check($name, Session('id'))) {
        			$this->error('没有权限','index/index');
        		}
        	}
        }
        
    }
}
