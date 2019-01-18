<?php
    namespace app\jira\controller;
    use app\jira\model\User as modelUser;
    use think\Request;
    class User extends Base{
        private $obj='';
        public function index(Request $request){
            $id=$request->param('id');
            if(!$this->obj){
                $this->obj=new modelUser();
            }
            $res=$this->baseFind($this->obj,$id);
            return json($res);
        }

        public function chaZhao(){
            $array=[
                'field'=>'USER_KEY',
                'value'=>'sbo'
            ];
            if(!$this->obj){
                $this->obj=new modelUser();
            }
            $res=$this->baseFindOne($this->obj,$array,$order='id',$temp='asc');
            return json($res);
        }
    }