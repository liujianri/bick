<?php
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'name'  =>  'require|max:25|unique:admin',
        'password' =>  'require',
    ];
    protected $message  =   [
        'name.require' => '管理员名称不能为空',
        'name.unique' => '管理员已存在',
        'name.max'     => '管理员名称最多不能超过25个字符',
        'password.require'   => '密码不能为空', 
        
    ];
    
    protected $scene = [
        'edit'  =>  ['name'=>'require|max:25'],
    ];
}