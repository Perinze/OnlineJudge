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
        'password' => 'require|length:6,16',
        'old_password' => 'require|length:6,16',
        'password_check' => 'require|length:6,16',
        'identify' => 'in:-1,0,1,2,3',
        'realname' => 'require',
        'school' => 'require',
        'major' => 'require',
        'class' => 'require',
        'contact' => 'require',
        'mail' => 'require|email',
        'check' => 'require',
        'status' => 'require|in:-1,0'
    ];

    protected $message = [
        'user_id.require' => '缺少用户id',
        'nick.require' => '缺少用户昵称',
        'nick.max' => '昵称最长25个字符',
        'password.require' => '缺少密码',
        'password.length' => '密码长度不正确',
        'old_password.require' => '缺少旧密码',
        'old_password.length' => '旧密码长度不正确',
        'password_check.length' => '密码长度不正确',
        'password_check.require' => '请再次输入密码',
        'identify.in' => '用户身份异常',
        'realname.require' => '请输入真实姓名',
        'school.require' => '请输入学校',
        'major.require' => '请输入专业',
        'class.require' => '请输入班级',
        'contact.require' => '请留下你的联系方式',
        'mail.require' => '请输入邮箱',
        'mail.email' => '邮箱格式错误',
        'check.require' => '请填写验证码',
        'status.require' => '请填写用户身份',
        'status.in' => '用户状态异常'
    ];

    protected $scene = [
        'addUser' => ['nick', 'password', 'realname', 'school', 'major', 'class', 'contact', 'mail', 'status'],
        'editUser' => ['realname', 'school', 'major', 'class', 'contact', 'mail', 'status'],
        'searchUser_id' => ['user_id'],
        'searchUser_nick' => ['nick'],
        'deleteUser' => ['user_id'],
        'foreAddUser' => [],
        'login' => ['nick', 'password'],
        'register' => ['nick', 'password', 'password_check', 'realname', 'school', 'major', 'class', 'contact', 'mail'],
        'forget' => ['nick', 'mail'],
        'forget_password' => ['nick', 'password', 'password_check', 'check'],
        'change_password' => ['nick', 'old_password', 'password', 'password_check'],
    ];
}