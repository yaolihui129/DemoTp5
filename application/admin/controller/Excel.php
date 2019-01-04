<?php
    namespace app\admin\controller;
    use \PHPExcel;
    class Excel extends Base
    {
        public function index(){
            $where=array(
               'username'=>'yaolh'
            );

            $user=getList('user',$where);
dump($user);
        }
    }