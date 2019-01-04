<?php
    namespace app\admin\controller;
    use app\admin\model\User as modelUser;
    class User extends Base
    {
        public function index(){
            $user = modelUser::where('username', 'yaolh')->find();
//            dump($user);
            return json($user);
        }
    }