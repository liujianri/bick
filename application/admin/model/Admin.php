<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
    public function addadmin($data)
    {
    	if (empty($data) || !is_array($data)) {
    		return false ;
    	}
    	if ($data['password']) {
    		$data['password']=md5($data['password']);
    	}
    	$this->data($data);
    	if ($this->save()) {
    		return true;
    	}
    	return false ;
    }
    public function getAdmin(){
    	return $this->paginate(2);
    }

}