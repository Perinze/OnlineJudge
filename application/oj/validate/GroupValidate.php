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
        'desc' => 'text', // TODO check
        'group_creator' => 'require|number'
    ];

    protected $message = [
        'group_id.require' => '未获取到团队id',
        'group_id.number' => '请输入数字',
        'group_name.require' => '请输入分组名称',
        'group_name.max' => '分组名称应小于64个字符',
        'group_creator.require' => '缺少创建者ID',
        'group_creator.number' => '创建者ID格式不正确',
        'desc.text' => '团队描述格式不正确',
    ];

    protected $scene = [
        'get_the_group' => ['group'],
    ];
}