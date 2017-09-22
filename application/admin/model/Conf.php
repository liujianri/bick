<?php
namespace app\admin\model;
use think\Model;
class Conf extends Model
{
   
	public function getTypeAttr($value)
    {
        $type = [0=>'无',1=>'单行文本',2=>'多行文本',3=>'单选按钮',4=>'复选框',5=>'下拉菜单'];
        return $type[$value];
    }
    

}