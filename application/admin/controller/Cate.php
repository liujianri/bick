<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Cate as CateModel;
class Cate extends Base
{
	protected $beforeActionList = [
        'delsoncate' =>  ['only'=>'del'],
    ];


    public function lst()
    {   
    	$cate= new CateModel();
    	if (request()->isPost()) {
    		$sorts=input('post.');
    		foreach ($sorts as $key => $value) {
    			$cate->update(['id'=>$key,'sort'=>$value]);
    		}
    		$this->redirect('lst');
    		return;
    	}
        
        $cateres=$cate->catetree();
    	$this->assign('cateres',$cateres);
        return view();
    }

    public function add(){
    	$cate= new CateModel();
    	if (request()->isPost()) {
    		$cate= new CateModel();
    		$cate->data(input('post.'));
    		$add=$cate->save();
    		if ($add!==false) {
    			$this->redirect('lst');
    		}else{
    			$this->error('添加栏目失败');
    		}
    	}
    	$cateres=$cate->catetree();
    	$this->assign('cateres',$cateres);
    	return view();
    }

    public function edit(){
    	$id=input('id');
    	$cate= new CateModel();
    	if (request()->isPost()) {
    		$edit=$cate->save(input('post.'),['id'=>$id]);
    		if ($edit!==false) {
    			$this->redirect('lst');
    		}else{
    			$this->error('修改栏目失败');
    		}
    		return;
    	}
    	$cates=$cate->find($id);
        $cateres=$cate->catetree();
        $this->assign('cates',$cates);
        $this->assign('cateres',$cateres);
        return view();

    }
    public function del(){
    	if (CateModel::destroy(input('id'))) {
    		$this->success('删除成功','lst');
    	}else{
    		$this->error('删除失败');
    	}

    }
    public function delsoncate(){
    	$cate= new CateModel();
        $cateres=$cate->getchilrenid(input('id'));
        if ($cateres) {
        	CateModel::destroy($cateres);
        }
        
    }


}