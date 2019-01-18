<?php
namespace app\jira\model;
use think\Model;
class Issue extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'jiraissue';
    protected $pk = 'ID';


}