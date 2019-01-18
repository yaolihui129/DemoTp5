<?php
namespace app\common\controller;
use think\Controller;
class Base extends Controller
{
    function _empty()
    {
//       return $this->fetch('index');
        return json(403);
    }

    /**
     * 新增一条数据并返回自增ID
     * @param $object
     * @param $data
     * $data 为一维数组
     * @param string $id
     * @param array $field
     * @param bool $temp
     * @return mixed
     */
    function baseInsert($object,$data,$id='id',$field=array(),$temp=false)
    {
        $obj = $object::create($data,$field,$temp);
        return $obj->$id;
    }

    /**
     *  批量添加或更新，并返回添加数量
     * @param $object
     * @param $list
     * @return mixed
     */
    function baseInsertAll($object,$list)
    {
        $ojb=$object->saveAll($list);
        return $ojb;
    }

    /**
     * 根据ID查找数据
     * @param $object
     * @param $id
     * @return mixed
     */
    function baseFind($object,$id){
        $obj = $object::get($id);
        return $obj;
    }

    /**
     * 根据ID查找数据某一属性
     * @param $object
     * @param $id
     * @param $column
     * @return mixed
     */
    function baseValueID($object,$id,$column){
        $res = $object::where('id',$id)->value($column);
        return $res;
    }

    /**
     * 根据单一条件查找一条数据
     * @param $object
     * @param $array
     * @param string $order
     * @param string $temp
     * @return mixed
     */
    function baseFindOne($object,$array,$order='id',$temp='asc'){
        $obj = $object::where($array['field'],$array['value'])->limit(1)->order($order, $temp)->findOrEmpty();
        return $obj;
    }

    /**
     * 根据单一条件查询某一列的值
     * @param $object
     * @param $array=[
     *              'field'=>'USER_KEY',
     *              'value'=>'sbo'
     *      ]
     * @param $column
     * @param string $order
     * @param string $temp
     * @return mixed
     */
    function baseFindColumn($object,$array,$column,$order='id',$temp='asc'){
        $res = $object::where($array['field'],$array['value'])->order($order, $temp)->column($column);
        return $res;
    }

    /**
     * 范围查询
     *
     * @param $object
     * @param $where=array(
            array('column'=>'value'),
     * )
     * @return mixed
     */
    function baseScope($object,$where){
        $res=$object::$where[0]['column']($where[0]['value'])->score(80)->select();
        return $res;
    }

    /**
     * 单条数据更新
     * @param $object
     * @param $data
     * @return mixed
     */
    function baseUpdate($object,$data){
        $obj = $object::update($data);
        return $obj;
    }

    /**
     * 数据删除
     * @param $object
     * @param $array
     * @param bool $temp
     * @return mixed
     */
    function baseDel($object,$array,$temp=false){
        if($temp){//物理删除
            $obj=$object::destroy($array,true);
        }else{//软删除
            $obj=$object::destroy($array);
        }
        return $obj;
    }

    /**
     * 文件上传
     * @param $image
     * @param int $size
     * @param string $ext
     * @param string $uploads
     * @return array|mixed|string
     */
    function baseUpload($image,$size=15678,$ext='jpg,png,gif',$uploads='../uploads'){
        $files = request()->file($image);
        $info='';
        if(is_array($files)){
            foreach($files as $file){
                $info[] = $this->move($file,$size,$ext,$uploads);
            }
        } else {
            $info = $this->move($files,$size,$ext,$uploads);
        }
        return $info;
    }

    /**
     * 文件移动
     * @param $file
     * @param int $size
     * @param string $ext
     * @param string $uploads
     * @return mixed
     */
    function baseMove($file,$size=15678,$ext='jpg,png,gif',$uploads='../uploads'){
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate(['size'=>$size,'ext'=>$ext])->move($uploads);
        if($info){
            return $info;
        }else{
            return $file;
        }
    }


}