<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 18:14
 */

namespace app\oj\validate;


use think\Validate;

class GroupValidate extends Validate
{
    protected $rule = [
        'group_id' => 'require|number',
    ];

    protected $message = [
        'group_id.require' => '未获取到团队id',
        'group_id.number' => '请输入数字',
    ];

    protected $scene = [
        'get_the_group' => ['group'],
    ];
}