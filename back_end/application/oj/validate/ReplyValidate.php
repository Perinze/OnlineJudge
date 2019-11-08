<?php


namespace app\oj\validate;


use think\Validate;

class ReplyValidate extends Validate
{
    protected $rule = [
        'id' => 'require',
        'content' => 'require|max:200',
    ];

    protected $message = [
        'id.require' => '未选中回复',
        'content.require' => '未填写内容',
        'contest.max' => '内容长度超限',
    ];

    protected $scene = [
        'add_reply' => ['id', 'content'],
    ];
}