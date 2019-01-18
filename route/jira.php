<?php
use think\facade\Route;

Route::rule('jira/Bug/:id','jira/Bug/info','GET');
Route::rule('jira/Bug','jira/Bug/index','POST');

return [

];