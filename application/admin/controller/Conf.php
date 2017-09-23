<?php
namespace app\admin\controller;
use app\admin\controller\Base;

use app\admin\model\Conf as ConfModel;
class Conf extends Base
{

    public function lst(){
        $conf = new ConfModel;

        if (request()->isPost()) {
            $sorts=input('post.');
            foreach ($sorts as $key => $value) {
                $conf->update(['id'=>$key,'sort'=>$value]);
            }
            $this->redirect('lst');
            return;
        }
        $conflist=$conf->order('sort desc')->paginate(5);
        $this->assign('conflists',$conflist);
        return view();
    }

    public function confs(){
        $conf = new ConfModel;
        $conflist=$conf->order('sort desc')->paginate(5);
        $this->assign('conflist',$conflist);
        return view('conf');
    }

    public function add(){

        if (request()->isPost()) {
            $data = $this->request->post();
            if ($data['valueres']) {
                $data['valueres']=str_replace('，', ',', $data['valueres']);
            }
            $conf = new ConfModel;
            if ($conf->save($data)) {
                $this->redirect('lst');
            }else{
                $this->error('新增失败');
            }
        }
        return view();
    }
    public function edit(){
        $confModel = ConfModel::get(input('id'));
        if (request()->isPost()) {
            $data = $this->request->post();
            if ($data['valueres']) {
                $data['valueres']=str_replace('，', ',', $data['valueres']);
            }
            if (!$confModel->save($data)==false) {
                $this->redirect('lst');
            }else{
                return $this->error('修改失败');
            }
            return;
        }
        $this->assign('confs',$confModel);
        return view();
    }
    public function del(){
        if (ConfModel::destroy(input('id'))) {
            return $this->redirect('lst');
        }else{
            return $this->error('删除失败');
        }
    }
}