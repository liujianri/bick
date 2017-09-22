<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Admin as AdminModel;
use think\Loader;
class Admin extends Base
{   


    public function logout(){
        session(null);
        $this->success('退出成功','Login/index');
    }

    public function lst()
    {   
        $admin= new AdminModel();
        $adminers = $admin->getAdmin();
        $this->assign('adminers',$adminers);
        return view();
    }
    public function add()
    {   
        if (request()->isPost()) {
            $validate = Loader::validate('Admin'); 
            if (!$validate->check(input('post.'))) {
                $this->error($validate->getError());
            }
            $admin = new  AdminModel();
            if ($admin->addadmin(input('post.'))) {
                $this->redirect('lst');
            }else{
                $this->error('添加失败');
            }
            return;
        }
        
        return view();
    }
    public function edit()
    {   
        $id=input('id');
        $re= AdminModel::get($id);
        $password= $re->password;
        if (request()->isPost()) {
            $validate = Loader::validate('Admin'); 
            if (!$validate->scene('edit')->check(input('post.'))) {
                $this->error($validate->getError());
            }

            $re->name= input('name');
            if (!input('password')=='') {
               $re->password= md5(input('password'));
            }else{
                $re->password = $password;
            }
            $re->save();
            if ($re!==false) {
                return $this->redirect('lst');
            }else{
                $this->error('修改失败');
            }
        }
        $name= $re->name;
        $this->assign('name',$name);
        return view();
    }

    public function del(){
        
        if (AdminModel::destroy(input('id'))) {
            return $this->redirect('lst');
        }else{
            return $this->error('删除失败');
        }
        
    }

}