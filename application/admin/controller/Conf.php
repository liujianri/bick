<?php
namespace app\admin\controller;
use app\admin\controller\Base;

use app\admin\model\Conf as ConfModel;
class Conf extends Base
{

    public function lst(){
        $conf = new ConfModel;
        $conflist=$conf->paginate(5);
        $this->assign('conflists',$conflist);
        return view();
    }

    public function add(){

        if (request()->isPost()) {
            $data = $this->request->post();
            $conf = new ConfModel;
            if ($conf->save($data)) {
                $this->redirect('lst');
            }else{
                $this->error('新增失败');
            }
        }
        return view();
    }
}