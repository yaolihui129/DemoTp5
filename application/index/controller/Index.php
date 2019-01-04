<?php
    namespace app\index\controller;
    class Index extends Base
    {
        public function index()
        {

//            dump(config());
            dump(test());
            dump(test2());
        }

        public function hello($name = 'ThinkPHP5')
        {
            return 'hello,' . $name;
        }
    }
