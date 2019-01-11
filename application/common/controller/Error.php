<?php
    namespace app\common\controller;
    use think\Request;
    class Error extends Base
    {
        public function index(Request $request)
        {

            return json(403);
        }
    }