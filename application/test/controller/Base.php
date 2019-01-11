<?php
    namespace app\test\controller;
    use think\Controller;
    use think\Request;
    class Base extends Controller
    {
        function _empty(){

            $this->fetch('index');
        }


    }
