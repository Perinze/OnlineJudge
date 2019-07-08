<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/27
 * Time: 下午10:07
 */
namespace app\oj\validate;

use think\Validate;

class ContestValidate extends Validate {
    // TODO 添加
    protected $rule = [
        'contest_id' => 'require',
    ];

    protected $message = [
        'contest_id.require' => '缺少比赛ID',
    ];

    protected $scene = [
        'searchContest' => ['contest_id'],
        'deleContest' => ['contest_id'],
        'newContest' => [],
        'editContest' => [],
    ];
}