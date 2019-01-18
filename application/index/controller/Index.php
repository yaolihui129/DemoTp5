<?php
    namespace app\index\controller;
    class Index extends Base
    {
        public function index()
        {

//            dump(config());

        }

        public function hello($name = 'ThinkPHP5')
        {
            return 'hello,' . $name;
        }
    }
