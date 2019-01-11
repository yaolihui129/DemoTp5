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
            $res=$this->find($this->obj,$id);
            return json($res);
        }
    }