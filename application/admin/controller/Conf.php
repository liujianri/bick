<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Loader;
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

    public function conf(){
        $conf = new ConfModel;
        if (request()->isPost()) {
            $data=input('post.');
            $_confarr=db('conf')->field('enname')->select();
            $formarr = array();
            foreach ($data as $ke => $va) {
                $formarr[]=$ke;
            }
            foreach ($_confarr as $k => $v) {
                if (!in_array($v['enname'],$formarr)) {
                   $data[$v['enname']] = '';
                }
            }
            if ($data) {
                foreach ($data as $key => $value) {
                    $conf->where('enname',$key)->update(['value'=>$value]);
                }
                $this->success('保存成功','conf');
            }
            return;
        }
        $conflist=$conf->order('sort desc')->paginate(10);
        $this->assign('conflist',$conflist);
        return view();
    }

    public function add(){

        if (request()->isPost()) {
            $data = $this->request->post();
            if ($data['valueres']) {
                $data['valueres']=str_replace('，', ',', $data['valueres']);
            }
            $validate = Loader::validate('Conf'); 
            if (!$validate->check($data)) {
                $this->error($validate->getError());
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

            $validate = Loader::validate('Conf'); 
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
            }
            $re=$confModel->save($data);
            
            if (!$re=false) {
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