<?php
namespace app\admin\controller;
use app\common\controller\Base as commonBase;
class Base extends commonBase
{
    function _empty()
    {
       return $this->fetch('index');
    }


}