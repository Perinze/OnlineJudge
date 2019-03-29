<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/27
 * Time: 下午10:12
 */
namespace app\oj\validate;

use think\Validate;

class ProblemValidate extends Validate {

    // TODO fill in

    protected $rule = [
        'problem_id' => 'require|number',

    ];

    protected $message = [
        'problem_id.require' => '请输入题目序号',
        'problem_id.number' => '请输入正确题号',
    ];

    protected $scene = [
        'displayProblem' => ['priblem_id'],
    ];
}