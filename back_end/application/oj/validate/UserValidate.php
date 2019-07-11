<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午2:08
 */

namespace app\oj\validate;


use think\Validate;

class UserValidate extends Validate
{

    protected $rule = [
        'user_id' => 'require',
        'nick' => 'require|max:25',
        'password' => 'require|min:6',
        'password_check' => 'require',
        'identify' => 'in:0',
        'realname' => 'require',
        'school' => 'require',
        'major' => 'require',
        'class' => 'require',
        'contact' => 'require',
        'mail' => 'require|email',
    ];

    protected $message = [
        'user_id.require' => '缺少用户id',
        'nick.require' => '缺少用户昵称',
        'nick.max' => '昵称最长25个字符',
        'password.require' => '缺少密码',
        'password.min' => '密码长度过短',
        'password_check' => '请再次输入密码',
        'identify.in' => '请不要修改身份',
        'realname.require' => '请输入真实姓名',
        'school.require' => '请输入学校',
        'major.require' => '请输入专业',
        'class.require' => '请输入班级',
        'contact.require' => '请留下你的联系方式',
        'mail.require' => '请输入邮箱',
        'mail.email' => '邮箱格式错误',
    ];

    protected $scene = [
        'addUser' => '',
        'editUser' => '',
        'searchUser_id' => ['user_id'],
        'searchUser_nick' => ['nick'],
        'deleteUser' => ['user_id'],
        'foreAddUser'=>'',
        'login' => ['nick','password'],
        'register' => ['nick', 'password', 'password_check', 'identify', 'realname', 'school', 'major', 'class', 'contact', 'mail'],
        'forget' => ['nick'],
    ];
}