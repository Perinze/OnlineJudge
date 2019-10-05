<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/27
 * Time: 下午10:07
 */

namespace app\oj\validate;

use think\Validate;

class ContestValidate extends Validate
{
    // TODO 添加
    protected $rule = [
        'contest_id' => 'require|number',
        'contest_name' => 'require',
        'begin_time' => 'require|date',
        'end_time' => 'require|date',
        'frozen' => 'require|float|<:1',
        'problems' => 'require|array',
    ];

    protected $message = [
        'contest_id.require' => '缺少比赛ID',
        'contest_name.require' => '缺少比赛名称',
        'begin_time.require' => '缺少开始时间',
        'end_time.require' => '缺少结束时间',
        'frozen.require' => '缺少封榜时间比',
        'problems.require' => '缺少比赛题目',
        'contest_id.number' => '比赛ID为数字',
        'begin_time.date' => '时间格式错误',
        'end_time.date' => '时间格式错误',
        'frozen.float' => '封榜时间比错误',
        'frozen.<:1' => '封榜时间比错误',
        'problem.array' => '题目传值错误',
    ];

    protected $scene = [
        'searchContest' => ['contest_id'],
        'deleContest' => ['contest_id'],
        'newContest' => ['contest_name', 'begin_time', 'end_time', 'frozen', 'problems'],
        'editContest' => ['contest_id', 'contest_name', 'begin_time', 'end_time', 'frozen', 'problems'],
    ];
}