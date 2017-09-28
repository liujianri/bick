<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Admin as AdminModel;
use app\admin\model\AuthGroup as AuthGroupModel;
use think\Loader;
use app\admin\controller\Auth;
class Admin extends Base
{   


    public function logout(){
        session(null);
        $this->success('退出成功','Login/index');
    }

    public function lst()
    {   
        $auth =new Auth();
        $admin= new AdminModel();
        $adminers = $admin->getAdmin();
        foreach ($adminers as $key => $value) {
            $_title=$auth->getGroups($value['id']);
            $title = $_title[0]['title'];
            $value['groupTitile']=$title;
        }
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
        $authGroupModel= new AuthGroupModel();
        $authGroupres = $authGroupModel->select();
        $this->assign('authGroupres',$authGroupres );
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
            $re->allowField(true)->save();
            if ($re!==false) {
                $uid=$re->id;
                $groupAccess['group_id'] =input('group_id');
                db('auth_group_access')->where('uid',$uid)->update($groupAccess);
                return $this->redirect('lst');
            }else{
                $this->error('修改失败');
            }
        }
        $authGroupModel= new AuthGroupModel();
        $authGroupres = $authGroupModel->select();
        $this->assign('authGroupres',$authGroupres );
        $name= $re->name;
        $authGroupAccess=db('auth_group_access')->where('uid',$id)->find();
        $this->assign('groupId',$authGroupAccess['group_id']);
        $this->assign('name',$name);
        return view();
    }

    public function del(){
        if (AdminModel::destroy(input('id'))) {
            db('auth_group_access')->where('uid',input('id'))->delete();
            return $this->redirect('lst');
        }else{
            return $this->error('删除失败');
        }
        
    }

}