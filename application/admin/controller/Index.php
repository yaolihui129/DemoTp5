<?php
    namespace app\admin\controller;
    use think\Request;
    use app\common\controller\Base;
    class Index extends Base
    {
        public function index(Request $request){

            return $this->fetch();
        }
    }
