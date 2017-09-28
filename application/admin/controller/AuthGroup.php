<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule as AuthRuleModel;

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
            if (isset($data['rules'])) {
                $data['rules']=implode(',', $data['rules']);
            }
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
        $authRuleModel = new AuthRuleModel;
        $authruleres=$authRuleModel->authRuleTree();
        $this->assign('authruleres',$authruleres);
        return view();
    }
    public function edit(){
        $id=input('id');
        $authGroupModel= new AuthGroupModel();
        if (request()->isPost()) {
            $data=input('post.');
            if (isset($data['rules'])) {
                $data['rules']=implode(',', $data['rules']);
            }
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
        $authRuleModel = new AuthRuleModel;
        $authruleres=$authRuleModel->authRuleTree();
        $this->assign('authruleres',$authruleres);
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