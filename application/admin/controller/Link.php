<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Loader;
use app\admin\model\Link as LinkModel;
class Link extends Base
{

    public function lst()
    {   
        $link =  new LinkModel;
        if (request()->isPost()) {
            $sorts=input('post.');

            foreach ($sorts as $key => $value) {
                $link->update(['id'=>$key,'sort'=>$value]);
            }
            $this->redirect('lst');
            return;
        }
        $linkres = $link->order('sort desc')->paginate(5);
        $this->assign('linkres',$linkres);
        return view();
    }
    public function del(){
        if (LinkModel::destroy(input('id'))) {
            $this->success('删除成功','lst');
        }else{
            $this->error('删除失败');
        }

    }
    public function edit(){
        $link= LinkModel::get(input('id'));
        if (request()->isPost()) {
            $data=$this->request->post();

            $validate = Loader::validate('Link'); 
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
            }
            $link->data($data);
            if ($link->save()!==false) {
                $this->redirect('lst');
            }else{
                $this->error('修改失败');
            }
        }

        $this->assign('link',$link);
        return $this->fetch();
    }
    public function add(){

        if (request()->isPost()) {
            $data=$this->request->post();

            $validate = Loader::validate('Link'); 
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            
            $linkModel = new LinkModel;
            $linkModel->data($data);
            if ($linkModel->save()) {
                $this->redirect('lst');
            }else{
                $this->error('添加失败');
            }
        }
        return $this->fetch();
    }

}