<?php
    namespace app\admin\controller;
    use \PHPExcel;
    class Index extends Base
    {
        public function index(){

//            $objPHPExcel= new PHPExcel();
////            dump(config());

            $user=find('user',1);
//            dump($user);
            return json($user);
        }
    }
