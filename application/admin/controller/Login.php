<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use think\controller;
class Login extends controller
{
    public function index()
    {
    	if (request()->isPost()) {
    		$admin= new AdminModel();
        	$adminers = $admin->login(input('post.'));
        	if ($adminers==2) {
        		$this->success('登录成功','Index/index');
        	}elseif ($adminers==3) {
        		$this->error('密码错误');
        	}else{
        		$this->error('用户不存在');
        	}
    	}
        return view('login');
    }
}