<?php

namespace app\common\validate;


use think\Validate;

class NotificationValidate extends Validate
{
    protected $rule = [
        'contest_id' => 'require|number',
        'id' => 'require|number',
        'title' =>  'require',
        'content'   => 'require',
        'user_id'   =>  'require'
    ];

    protected $message = [
        'contest_id.require' => '缺少比赛ID',
        'id.require' => '缺少通知ID',
        'title.require' => '缺少标题',
        'content.require' => '缺少通知内容',
        'user_id.require' => '缺少用户id',
    ];

    protected $scene = [
        'getNotificationByID' => ['id'],
        'getNotificationByUser' => ['user_id'],
    ];
}