<?php
namespace app\admin\validate;

use think\Validate;

class Conf extends Validate
{
    protected $rule = [
        'cnname'  =>  'require|max:60|unique:conf',
        'enname'  =>  'require|max:60|unique:conf',
        'type' =>  'require',
    ];
    protected $message  =   [
        'cnname.require' => '名称必须填写',
        'cnname.unique' => '名称已存在',
        'cnname.max'     => '名称最多不能超过60个字符',
        'enname.require' => '名称必须填写',
        'enname.unique' => '名称已存在',
        'enname.max'     => '名称最多不能超过60个字符',
        'type.require'   => '类型必须填写', 
        
    ];
    
    protected $scene = [
        'edit'  =>  ['cnname'=>'require|max:60','enname'=>'require|max:60'],
    ];
}