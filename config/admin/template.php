<?php
// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

return [
    // 模板引擎类型 支持 php think 支持扩展
    'type'         => 'Think',
    // 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写 3 保持操作方法
    'auto_rule'    => 1,
    // 模板路径
    'view_path'    => '',
    // 模板后缀
    'view_suffix'  => 'html',
    // 模板文件名分隔符
    'view_depr'    => DIRECTORY_SEPARATOR,
    // 模板引擎普通标签开始标记
    'tpl_begin'    => '{',
    // 模板引擎普通标签结束标记
    'tpl_end'      => '}',
    // 标签库标签开始标记
    'taglib_begin' => '{',
    // 标签库标签结束标记
    'taglib_end'   => '}',

    'layout_on'    =>  true,

    'layout_name'  =>  'layout',

    'tpl_replace_string'  =>  [
        '__PUBLIC__' => dirname($_SERVER['SCRIPT_NAME']),
        '__STATIC__' => dirname($_SERVER['SCRIPT_NAME']) . '/public/static',
        '__CSS__'    => dirname($_SERVER['SCRIPT_NAME']) . '/public/static/css',
        '__JS__'     => dirname($_SERVER['SCRIPT_NAME']) . '/public/static/js',
        '__IMG__'    => 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']) . '/public/static/images',


    ]
];
