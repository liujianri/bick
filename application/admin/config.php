<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    
    'template'               => [
        // 模板后缀
        'view_suffix'  => 'htm',
    ],
      //输出替换
    'view_replace_str'  =>  [
    '__PUBLIC__'=>'/bick/public',
    '__ROOT__' => '/',
    '__ADMIN__' => '/bick/public/static/admin',
	]

];
