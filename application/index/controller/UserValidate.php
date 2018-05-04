<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 下午3:34
 */
namespace app\index\validate;

use think\Validate;

class UserValidate extends Validate{
    protected $rule = [
        'account' => 'require|max:25|unique:user',
        'mail' => 'email',
        'password' => 'require',
        'phone' => 'mobile',
        'name' => 'cls',
        'gender' => [ 'regex'=>'/^(男|女)$/'],
    ];

    protected $scene = [
        'register' => ['account','mail','password','phone','name','gender'],
        'login' => ['account','password'],
    ];
}