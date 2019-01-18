<?php
namespace app\jira\model;
use think\Model;
class TestCase extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'jiraissue';
    protected $pk = 'ID';

    // 定义全局的查询范围
    protected function base($query)
    {
        $query->where('issuetype','10101');
    }
}