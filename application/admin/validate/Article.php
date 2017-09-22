<?php
namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title'  =>  'require|max:50|unique:article',
        'keywords'  =>  'require|max:50',
        'des'  =>  'require|max:50',
        'author'  =>  'require|max:50',
        'content'  =>  'require',
        'cateid'  =>  'require',
    ];
    protected $message  =   [
        'title.require' => '标题必须填写',
        'keywords.require' => '关键词必须填写',
        'des.require' => '描述必须填写',
        'author.require' => '作者必须填写',
        'content.require' => '内容必须填写',
        'cateid.require' => '标所属栏目必须填写',
        'title.unique' => '标题已存在',
        'title.max'     => '名称最多不能超过25个字符',
        'keywords.max'     => '名称最多不能超过25个字符',
        'des.max'     => '名称最多不能超过25个字符',
        'author.max'     => '名称最多不能超过25个字符',
        
    ];
    
    protected $scene = [
        'edit'  =>  ['title'=>'require|max:25','keywords','des','author','content','cateid'],
    ];
}