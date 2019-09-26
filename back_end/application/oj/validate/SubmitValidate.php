<?php


namespace app\oj\validate;


use think\Validate;

class SubmitValidate extends Validate
{
    protected $rule = [
        'language' => 'require',
        'problem_id' => 'require|number',
        'source_code' => 'require',
    ];

    protected $message = [
        'language.require' => '请选择语言',
        'problem_id.require' => '请选择题目',
        'problem_id.number' => '请使用数字',
        'source_code.require' => '请填写代码',
    ];

    protected $scene = [
        'submit' => ['language', 'problem_id', 'source_code'],
    ];
}