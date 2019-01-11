<?php
    namespace app\admin\controller;
    use app\admin\model\User;
    use app\common\controller\Base;
    class App extends Base
    {
        private $table = 'app';
        private $where = array();
        private $order ='id';


        public function index(){
            $user = User::get(1);
            echo $user->username;
//            $user=find('user',1);
////            dump($user);
//            return json($user);
        }

    }