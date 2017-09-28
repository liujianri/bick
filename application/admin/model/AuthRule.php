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
                $v['dataid']=$this->getparenid($v['id']);
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
    public function getparenid($authRuleId){
        $authRuleres=$this->select();
        return $this->_getparenid($authRuleres,$authRuleId,True);
    }
    public function _getparenid($authRuleres,$authRuleId,$clear=False){
        static $arr=array();
        if ($clear) {
            $arr=array();
        }
        foreach ($authRuleres as $k => $v) {
            if($v['id']== $authRuleId){
                $arr[]=$v['id'];
                $this->_getparenid($authRuleres,$v['pid'],False);
            }
        }
        asort($arr);
        $arrStr=implode('-', $arr);
        return $arrStr;
    }

}
