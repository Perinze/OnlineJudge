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
        'group_name' => 'require|max:64',
        'desc' => 'require',
        'group_creator' => 'require|number',
        'join_code' => 'require'
    ];

    protected $message = [
        'group_id.require' => '未获取到团队id',
        'group_id.number' => '请输入数字',
        'group_name.require' => '请输入分组名称',
        'group_name.max' => '分组名称应小于64个字符',
        'group_creator.require' => '缺少创建者ID',
        'group_creator.number' => '创建者ID格式不正确',
        'desc.require' => '缺少团队描述',
        'join_code.require' => '缺少加群码'
    ];

    protected $scene = [
        'get_the_group' => ['group'],
        'add_group' => ['group_name', 'desc', 'join_code'],
        'join_group' => ['group_id', 'join_code'],
    ];
}