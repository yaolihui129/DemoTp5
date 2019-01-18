<?php
    namespace app\jira\controller;
    use app\jira\model\User as modelUser;
    use think\Request;

    class Index extends Base
    {
        public function index(Request $request){
            $id=$request->param('id');
            $obj=new modelUser();
            $res=$this->baseFind($obj,$id);
            return json($res);
        }

        public function session(){
            setSession('username','yaolh');
            $name=getSession('username');
            dump($_SESSION);
            return json($name);
        }

        public function cookie(){
            setCookieKey('username','yaolh');
            $name=getCookieKey('username');
//            clearCookie();
            dump($name);
//            return json($name);
        }
    }
