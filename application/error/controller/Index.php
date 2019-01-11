<?php
    namespace app\error\controller;
    class Index extends Base
    {
        public function index(){

            return json('控制器不存在',404);
        }
    }
