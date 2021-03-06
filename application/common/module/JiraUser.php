<?php
namespace app\common\model;
use think\Model;

class JiraUser extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'ao_2d3bea_user_index';
    protected $pk = 'ID';
//        //设置软删除字段
//        use SoftDelete;
//        protected $deleteTime = 'deleted';
//        protected $defaultSoftDelete = 0;

    //获取器
    public function getStatusAttr($value)
    {
        //状态：0-未激活，1-启用，2-禁用',
        $status = [0=>'未激活',1=>'启用',2=>'禁用'];
        return $status[$value];
    }
}