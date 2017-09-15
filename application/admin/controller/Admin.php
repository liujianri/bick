<?php
namespace app\admin\controller;
use think\controller;
use app\admin\model\Admin as AdminModel;
class Admin extends controller
{
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
        if (request()->isPost()) {
            $re->name= input('name');
            if (!input('password')=='') {
               $re->password= md5(input('password'));
            }
            $re->save();
            if ($re) {
                return $this->redirect('lst');
            }else{
                $this->error('修改失败');
            }
            
        }

        $name= $re->name;
        $this->assign('name',$name);
        return view();
    }
}