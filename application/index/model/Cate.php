<?php
namespace app\index\model;
use think\Model;
class Cate extends Model
{
	public function getchilrenid($cateid){
    	$cateres=$this->select();
    	$arr=$this->_getchilrenid($cateres,$cateid);
    	$arr[]=$cateid;
    	$strId=implode(',',$arr);
    	return $strId;
    }
    public function _getchilrenid($cateres,$cateid){
    	static $arr=array();
    	foreach ($cateres as $k => $v) {
    		if($v['pid']== $cateid){
    			$arr[]=$v['id'];
    			$this->_getchilrenid($cateres,$v['id']);
    		}
    	}
    	return $arr;
    }
}