<?php
    namespace app\jira\controller;
    use app\jira\model\Bug as modelBug;
    use think\Request;
    class Bug extends Base{
        private $obj='';
        public function index(Request $request){
            $id=$request->param('id');
            $array=[
                'field'=>'issuenum',
                'value'=>$id
            ];
            if(!$this->obj){
                $this->obj=new modelBug();
            }
            $res=$this->baseFindOne($this->obj,$array,$order='id',$temp='asc');
            return json($res);
        }


        public function info(Request $request){
            $id=$request->param('id');
            if(!$this->obj){
                $this->obj=new modelBug();
            }
            $res=$this->baseFind($this->obj,$id);
            return json($res);
        }
    }