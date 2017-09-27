<?php
namespace app\admin\model;
use think\Model;
class AuthRule extends Model
{
   public function authRuleTree(){
    	$authRule = $this->order('sort desc')->select();
    	return $this->sort($authRule);

    }
    public function sort($data,$pid=0){
    	static $arr=array();
    	foreach ($data as $k => $v) {
    		if ($v['pid']==$pid) {
    			$arr[]=$v;
    			$this->sort($data,$v['id']);
    		}
    	}
    	return $arr;
    }
    public function getchilrenid($authRuleId){
    	$authRuleres=$this->select();
    	return $this->_getchilrenid($authRuleres,$authRuleId);
    }
    public function _getchilrenid($authRuleres,$authRuleId){
    	static $arr=array();
    	foreach ($authRuleres as $k => $v) {
    		if($v['pid']== $authRuleId){
    			$arr[]=$v['id'];
    			$this->_getchilrenid($authRuleres,$v['id']);
    		}
    	}
    	return $arr;
    }

}
