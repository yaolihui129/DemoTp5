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
    function insert($object,$data,$id='id',$field=array(),$temp=false)
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
    function insertAll($object,$list)
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
    function find($object,$id){
        $obj = $object::get($id);
        return $obj;
    }

    /**
     * 根据单一条件查找一条数据
     * @param $object
     * @param $field
     * @param $value
     * @param string $order
     * @return mixed
     */
    function findOne($object,$field,$value,$order='id'){
        $obj = $object::where($field, $value)->limit(1)->order($order, 'asc')->findOrEmpty();
        return $obj;
    }

    /**
     * 单条数据更新
     * @param $object
     * @param $data
     * @return mixed
     */
    function update($object,$data){
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
    function del($object,$array,$temp=false){
        if($temp){
            //物理删除
            $obj=$object::destroy($array,true);
        }else{
            //软删除
            $obj=$object::destroy($array);
        }
        return $obj;
    }

}