<?php


namespace app\oj\validate;


use think\Validate;

class SubmitValidate extends Validate
{
    protected $rule = [
        'language' => 'require',
        'problem_id' => 'require|number',
        'source_code' => 'require',
        'status_id' => 'require|number',
    ];

    protected $message = [
        'language.require' => '请选择语言',
        'problem_id.require' => '请选择题目',
        'problem_id.number' => '请使用数字',
        'source_code.require' => '请填写代码',
        'status_id.require' => '缺少status_id参数',
        'status_id.number' => 'status_id参数格式不正确',
    ];

    protected $scene = [
        'submit' => ['language', 'problem_id', 'source_code'],
        'getSubmitStatus' => ['status_id'],
    ];
}