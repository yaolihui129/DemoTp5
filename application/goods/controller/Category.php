<?php
    namespace app\goods\controller;
    use think\Request;
    use app\goods\model\Category as modelCategory;
    /**
     * 分类管理
     * Class Goods
     * @package app\goods\controller
     */
    class Category extends Base
    {

        private $obj='';
        //商品列表
        public function index(Request $request){
            $data=$request->param();
            return 'this is goods Index index';
        }

        public function info(Request $request){
            $id=$request->param('id');
            if(!$this->obj){
                $this->obj=new modelCategory();
            }
            $res=$this->baseFind($this->obj,$id);
            return json($res);
        }

        //添加分类
        public function create(Request $request){
            $data=$request->param();
            if(!$this->obj){
                $this->obj=new modelCategory();
            }
            $id=$this->baseInsert($this->obj ,$data);
            return json($id);
        }

        //修改分类
        public function update(Request $request){
            $data=$request->param();
            if(!$this->obj){
                $this->obj=new modelCategory();
            }
            $res=$this->baseUpdate($this->obj,$data);
            return json($res);
        }
        //删除分类
        public function del(Request $request){
            $id=$request->param('id');
            if(!$this->obj){
                $this->obj=new modelCategory();
            }
            $res=$this->baseDel($this->obj ,$id,true);
            return json($res);
        }


        
    }
