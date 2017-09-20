<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{
	public function getTypeAttr($value)
    {
        $type = [1=>'列表',2=>'单页'];
        return $type[$value];
    }
    public function catetree(){
    	$cateres = $this->order('sort desc')->select();
    	return $this->sort($cateres);

    }
    public function sort($data,$pid=0,$level=0){
    	static $arr=array();
    	foreach ($data as $k => $v) {
    		if ($v['pid']==$pid) {
    			$v['level']=$level;
    			$arr[]=$v;
    			$this->sort($data,$v['id'],$level+1);
    		}
    	}
    	return $arr;
    }
    public function getchilrenid($cateid){
    	$cateres=$this->select();
    	return $this->_getchilrenid($cateres,$cateid);
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