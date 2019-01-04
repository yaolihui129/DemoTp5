<?php
namespace app\admin\controller;
use think\Controller;
class Base extends Controller
{
    function _empty()
    {

        $this->fetch('index');
    }
}