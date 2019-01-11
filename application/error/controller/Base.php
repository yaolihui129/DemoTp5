<?php
namespace app\error\controller;
use think\Controller;
class Base extends Controller
{
    function _empty()
    {
//       return $this->fetch('index');
        return json('方法不存在',404);
    }


}