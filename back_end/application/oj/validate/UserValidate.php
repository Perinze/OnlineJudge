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
        'password' => 'require',
    ];

    protected $message = [
        'user_id.require' => '缺少用户id',
        'nick.require' => '缺少用户昵称',
        'nick.max' => '昵称最长25个字符',
        'password.require' => '缺少密码',
    ];

    protected $scene = [
        'addUser' => '',
        'editUser' => '',
        'searchUser_id' => ['user_id'],
        'searchUser_nick' => ['nick'],
        'deleteUser' => ['user_id'],
        'foreAddUser'=>'',
        'login'=>['nick','password'],
    ];
}