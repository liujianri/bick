<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\AuthRule as AuthRuleModel;
class AuthRule extends Base
{

    
    public function lst()
    {   
        $authRuleModel = new AuthRuleModel;
        if (request()->isPost()) {
            $sorts=input('post.');
            foreach ($sorts as $key => $value) {
                $authRuleModel->update(['id'=>$key,'sort'=>$value]);
            }
            $this->redirect('lst');
            return;
        }
        $authRuleRes=$authRuleModel->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
       return view();
    }
   
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $plevel=db('auth_rule')->where('id',$data['pid'])->field('level')->find();
            if ($plevel) {
                $data['level']=$plevel['level']+1;
            }else{
                 $data['level']=0;
            }
            $add = db('auth_rule')->insert($data);
            if ($add) {
                $this->redirect('lst');
            }else{
                $this->error('添加错误');
            }
            return;
        }
        $authRuleModel = new AuthRuleModel;
        $authruleres=$authRuleModel->authRuleTree();
        $this->assign('authruleres',$authruleres);
        return view();
    }
    public function edit()
    {   
        $id=input('id');
        $authRuleModel = new AuthRuleModel;
        if (request()->isPost()) {
            $data = input('post.');
            $plevel=db('auth_rule')->where('id',$data['pid'])->field('level')->find();
            if ($plevel) {
                $data['level']=$plevel['level']+1;
            }else{
                 $data['level']=0;
            }
            $re=$authRuleModel->save($data,['id'=>$id]);
            if ($re!==false) {
                $this->redirect('lst');
            }else{
                $this->error('修改失败');
            }
        }
        
        $authruleres=$authRuleModel->authRuleTree();
        $authrules = $authRuleModel->find($id);
        $this->assign('authruleres',$authruleres);
        $this->assign('authrules',$authrules);
        return view();
    }
    public function del()
    {
        $id = input('id');
        $authRuleModel= new AuthRuleModel();
        $authRuleid=$authRuleModel->getchilrenid($id);
        $authRuleid[]=$id;
        if ($authRuleid) {
            if (AuthRuleModel::destroy($authRuleid)) {
                $this->success('删除成功','lst',2);
            }else{
                $this->error('删除失败');
            }
        }
    }
}