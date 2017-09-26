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
    	$this->assign('confres',$confres);
    }
}
