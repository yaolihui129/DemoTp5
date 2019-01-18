<?php
    namespace app\goods\controller;
    use app\goods\model\Goods as modelGoods;
    use think\Request;

    /**
     * 商品管理
     * Class Goods
     * @package app\goods\controller
     */
    class Goods extends Base
    {
        private $obj='';
        //商品列表
        public function index(Request $request){
            $id=$request->param('id');
            return json($id);
        }

        public function info(Request $request){
            $id=$request->param('id');
            if(!$this->obj){
                $this->obj=new modelGoods();
            }
            $res=$this->baseFind($this->obj,$id);
            return json($res);
        }

        //添加商品
        public function create(Request $request){
            $data=$request->param();
            if(!$this->obj){
                $this->obj=new modelGoods();
            }
            $id=$this->baseInsert($this->obj ,$data);
            return json($id);
        }

        //修改商品
        public function update(Request $request){
            $data=$request->param();
            if(!$this->obj){
                $this->obj=new modelGoods();
            }
            $res=$this->baseUpdate($this->obj,$data);
            return json($res);
        }
        //删除商品
        public function del(Request $request){
            $id=$request->param('id');
            if(!$this->obj){
                $this->obj=new modelGoods();
            }
            $res=$this->baseDel($this->obj ,$id,true);
            return json($res);
        }
        //获取指定状态的所有商品
        public function getByStatus(Request $request){
            $array=[
                'field'=>'USER_KEY',
                'value'=>'sbo'
            ];
            if(!$this->obj){
                $this->obj=new modelGoods();
            }
            $res=$this->baseFindOne($this->obj,$array,$order='id',$temp='asc');
            return json($res);
        }
        //商品上下架
        public function modProductStatus(Request $request){

        }


    }
