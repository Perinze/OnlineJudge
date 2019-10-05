<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/27
 * Time: 下午10:12
 */

namespace app\oj\validate;

use think\Validate;

class ProblemValidate extends Validate
{

    // TODO fill in

    protected $rule = [
        'problem_id' => 'require|number',
        'search' => 'require',
        'title' => 'require',
        'background' => 'require',
        'describe' => 'require',
    ];

    protected $message = [
        'problem_id.require' => '请输入题目序号',
        'problem_id.number' => '请输入正确题号',
        'search.require' => '请输入搜索内容',
        'title.require' => '请输入标题',
        'background.require' => '请输入背景',
        'describe.require' => '请输入描述',
    ];

    protected $scene = [
        'displayProblem' => ['problem_id'],
        'search' => ['search'],
        'newProblem' => ['title', 'background', 'describe'],
        'editProblem' => ['problem_id', 'title', 'background', 'describe'],
    ];
}