<?php
    namespace app\admin\controller;
    use app\common\controller\Base;
    class Login extends Base
    {
        public function index(){

            return $this->fetch();
        }
    }