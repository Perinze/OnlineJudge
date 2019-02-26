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
        '' => 'require',
    ];

    protected $message = [
        '' => '',
    ];

    protected $scene = [
        'adduser' => '',
        'edituser' => '',
        'searchuser_id' => '',
        'searchuser_nick' => '',
        'deleteuser' => '',
    ];
}