<?php
namespace app\goods\model;
use think\Model;
class Category extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'jiraissue';
    protected $pk = 'ID';

    // 定义全局的查询范围
    protected function base($query)
    {
        $query->where('issuetype','10008');
    }
}