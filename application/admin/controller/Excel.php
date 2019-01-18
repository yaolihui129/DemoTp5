<?php
    namespace app\admin\controller;
    use \PHPExcel;
    use app\common\controller\Base;
    class Excel extends Base
    {
        public function index(){

            return $this->fetch();
        }
    }