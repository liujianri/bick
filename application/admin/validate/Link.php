<?php
namespace app\admin\validate;

use think\Validate;

class Link extends Validate
{
    protected $rule = [
        'title'  =>  'require|max:25|unique:link',
        'url' =>  'require|url|unique:link',
    ];
    protected $message  =   [
        'title.require' => '标题必须填写',
        'title.unique' => '标题已存在',
        'title.max'     => '名称最多不能超过25个字符',
        'url.require'   => '链接必须填写', 
        'url.unique' => '链接已存在', 
    ];
    
    protected $scene = [
        'edit'  =>  ['title'=>'require|max:25','url'=>'require|url'],
    ];
}