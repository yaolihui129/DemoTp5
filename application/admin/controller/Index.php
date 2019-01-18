<?php
    namespace app\admin\controller;
    use think\Request;
    class Index extends Base
    {
        public function index(Request $request){

            return $this->fetch();
        }
    }
