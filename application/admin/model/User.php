<?php
    namespace app\admin\model;
    use think\Model;
    use think\model\concern\SoftDelete;

    class User extends Model
    {
        // 设置当前模型对应的完整数据表名称
        protected $table = 'tp_admin_user';
        protected $pk = 'id';
//        //设置软删除字段
        use SoftDelete;
        protected $deleteTime = 'deleted';
        protected $defaultSoftDelete = 0;
        // 定义只读字段
        protected $readonly = ['username', 'ctime'];
        protected $autoWriteTimestamp = 'int';
        // 定义时间戳字段名
        protected $createTime = 'ctime';
        protected $updateTime = 'utime';
        // 定义全局的查询范围
        protected function base($query)
        {
            $query->where('deleted',0);
        }
        //获取器
        public function getStatusAttr($value)
        {
            //状态：0-未激活，1-启用，2-禁用',
            $status = [0=>'未激活',1=>'启用',2=>'禁用'];
            return $status[$value];
        }



    }
