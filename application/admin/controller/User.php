<?php
    namespace app\admin\controller;
    use think\Request;
    use app\common\controller\Base;
    use app\admin\model\User as modelUser;
    class User extends Base
    {
        private $obj='';

        public function index(Request $request)
        {
            $id = $request->param('id');
            if (!$this->obj) {
                $this->obj = new modelUser();
            }
            $res=$this->find($this->obj,$id);
            return json($res);
        }

        public function add()
        {
            $user=array('username'=>'111','real_name'=>'111','table'=>'qweqwe');
            $field=['username'];
            if(!$this->obj){
                $this->obj=new modelUser();
            }
            $id=$this->insert($this->obj ,$user,'id',$field);
            return json($id);
        }

        public function mod(){
            $user=array('id'=>'13','username'=>'11686311','table'=>'qweqwe');
            if(!$this->obj){
                $this->obj=new modelUser();
            }
            $res=$this->update($this->obj,$user);
            return json($res);
        }

        public function delete(){
            $user=[14];
            if(!$this->obj){
                $this->obj=new modelUser();
            }
            $res=$this->del($this->obj ,$user,true);
            return json($res);
        }
    }