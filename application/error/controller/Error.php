<?php
    namespace app\error\controller;
    class Error extends Base
    {
        public function index()
        {

            return json('模块不存在',404);
        }
    }