<?php


namespace app\oj\validate;


use think\Validate;

class DiscussValidate extends Validate
{
    protected $rule = [
        'contest_id' => 'require',
        'problem_id' => 'require',
        'title' => 'require|max:30',
        'content' => 'require|max:10000',
    ];

    protected $message = [
        'contest_id.require' => '未选中比赛',
        'problem_id.require' => '未选中题目',
        'title.require' => '未填写标题',
        'title.max' => '标题长度超限',
        'content.require' => '未填写内容',
        'content.max' => '内容长度超限',
    ];

    protected $scene = [
        'add_discuss' => ['problem_id', 'title', 'content'],
    ];
}