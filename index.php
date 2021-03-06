<?php
namespace think;
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.5.0','<') || version_compare(PHP_VERSION,'7.1.0','>'))
{
    header("Content-type: text/html; charset=utf-8");  
    die('PHP 版本必须 5.5 至 7.1 !');
}
//error_reporting(E_ALL ^ E_NOTICE);//显示除去 E_NOTICE 之外的所有错误信息
error_reporting(E_ERROR | E_WARNING | E_PARSE);//报告运行时错误

//header('Location:./public/index.php');
//exit();

// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 加载框架基础引导文件
require __DIR__ . '/thinkphp/base.php';

Container::get('app')->run()->send();

