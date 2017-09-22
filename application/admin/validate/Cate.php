<?php
namespace app\admin\validate;

use think\Validate;

class Cate extends Validate
{
    protected $rule = [
        'catename'  =>  'require|max:25|unique:cate',
    ];
    protected $message  =   [
        'catename.require' => '栏目名称不能为空',
        'catename.unique' => '栏目已存在',
        'catename.max'     => '栏目名称最多不能超过25个字符',
        
    ];
    
    protected $scene = [
        'edit'  =>  ['catename'=>'require|max:25'],
    ];
}