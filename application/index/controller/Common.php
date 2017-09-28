<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Conf;
class Common extends Controller
{
    public function _initialize(){
    	$conf = new Conf;
    	$_confres = $conf ->select();
    	$confres=array();
    	foreach ($_confres as $key => $value) {
    		$confres[$value['enname']]=$value['value'];
    	}
    	$this->getNavCates();
    	$this->assign('confres',$confres);
    }

    public function getNavCates(){
    	$cateres=db('cate')->where('pid',0)->select();
    	foreach ($cateres as $k => $value) {
    		$children = db('cate')->where('pid',$value['id'])->select();
    		if ($children) {
    			$cateres[$k]['children']=$children;
    		}else{
    			$cateres[$k]['children']=0;
    		}
    	}
    	$this->assign('cateres',$cateres);
    }
}
