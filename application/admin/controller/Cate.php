<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
use think\Loader;
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

            $validate = Loader::validate('Cate'); 
            if (!$validate->check(input('post.'))) {
                $this->error($validate->getError());
            }

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

            $validate = Loader::validate('Cate'); 
            if (!$validate->scene('edit')->check(input('post.'))) {
                $this->error($validate->getError());
            }

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
        $id = input('id');
    	$cate= new CateModel();
        $cateresid=$cate->getchilrenid($id);
        $allcateid = $cateresid;
        $allcateid[]=$id;
        foreach ($allcateid  as $k => $v) {
            $thumb = ArticleModel::where('cateid',$v)->value('thumb');
            $thumbpath = $_SERVER['DOCUMENT_ROOT']."/bick/public/".$thumb;
            if (file_exists($thumbpath)) {
                @unlink($thumbpath);
            }
           ArticleModel::destroy(['cateid'=>$v]);
        }
        if ($cateresid) {
        	CateModel::destroy($cateresid);
        }
    }

}