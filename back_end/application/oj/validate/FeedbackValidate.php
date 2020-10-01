<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/12/3
 * Time: 19:16
 */
namespace app\oj\validate;

use think\Validate;
class FeedbackValidate extends Validate
{
    // 提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'id' => 'require',
        'title' => 'require',
        'content' => 'require',
//        'realname' => 'require',
//        'cardno' =>
        'type' => 'require',
        'phone' => 'require',
        'problem_id' => 'require',
        'problem_type' => 'require',
    ];

    // 不符规则的错误提示
    protected $message = [
        //'token.require' => '未获取到token令牌',
        'id.require' => '未获取到反馈id',
        'title.require' => '未获取到标题',
        'content.require' => '未获取到问题内容',
        'type.require' => '未获取到手机类别',
        'phone.require' => '未获取到手机号',
        'problem_id.require' => '未获取到问题id',
        'problem_type.require' => '未获取到问题类别',
    ];

    // 场景验证
    protected $scene = [
        'add_feedback' =>  ['content'],
        'delete_feedback' =>  ['id'],
        'look_feedback' => ['id'],
        'look_problem' => ['problem_id'],
        'look_type' => ['problem_type'],
    ];
}