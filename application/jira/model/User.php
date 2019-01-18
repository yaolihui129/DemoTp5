<?php
    namespace app\jira\model;
    use think\Model;
    use think\model\concern\SoftDelete;

    class User extends Model
    {
        // 设置当前模型对应的完整数据表名称
        protected $table = 'AO_2D3BEA_USER_INDEX';
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
