<?php
    namespace app\admin\controller;
    use \PHPExcel;
    use app\common\controller\Base;
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