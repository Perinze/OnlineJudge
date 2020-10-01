<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/11/6
 * Time: 14:22
 */
namespace app\admin\validate;

use think\Validate;

class FeedbackValidate extends Validate
{
    // 提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        //'token' => 'require',
        'id' => 'require',
        'content' => 'require',
        'realname' => 'require',
        'cardno' => 'require',
        'type' => 'require',
    ];

    // 不符规则的错误提示
    protected $message = [
        //'token.require' => '未获取到token令牌',
        'id.require' => '未获取到反馈序号',
        'content.require' => '未获取到反馈内容',
        'realname.require' => '未获取到真实姓名',
        'cardno.require' => '未获取到学号',
        'type.require' => '未获取到问题种类',
    ];

    // 场景验证
    protected $scene = [
        'look_feedback' =>  ['id'],
        'add_reply' => ['id', 'content'],
        'delete_reply' => ['id'],
        'recover_reply' => ['id'],
        'get_the_problem' => ['id'],
    ];
}