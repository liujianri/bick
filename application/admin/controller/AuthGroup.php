<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\AuthGroup as AuthGroupModel;
class AuthGroup extends Base
{
    public function lst(){
        $authGroupModel= new AuthGroupModel();
        $authGroupres = $authGroupModel->paginate(10);
        $this->assign('authGroupres',$authGroupres );
        return view();
    }
    public function add(){
        if (request()->isPost()) {
            $data=input('post.');
            $authGroupModel= new AuthGroupModel();
            if (in_array('on', $data)) {
                $data['status']=1;
            }else{
                $data['status']=0;
            }
            if ($authGroupModel->save($data)!==false) {
                $this->redirect('lst');
            }else{
                $this->error('添加失败');
            }
            return;
        }
        return view();
    }
    public function edit(){
        $id=input('id');
        $authGroupModel= new AuthGroupModel();
        if (request()->isPost()) {
            $data=input('post.');
            if (in_array('on', $data)) {
                $data['status']=1;
            }else{
                $data['status']=0;
            }
            $re = $authGroupModel->save($data,['id'=>$id]);
            if ($re!==false) {
               $this->redirect('lst');
            }else{
                $this->error('修改失败');
            }
           return;
        }
        $authGroups = $authGroupModel->find($id);
        $this->assign('authGroups',$authGroups);
        return view();
    }
    public function del(){
        if (AuthGroupModel::destroy(input('id'))) {
            $this->redirect('lst');
        }else{
            $this->error('删除失败');
        }
    }

}