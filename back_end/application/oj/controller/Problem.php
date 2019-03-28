<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 14:38
 */
namespace app\oj\controller;

use app\oj\model\ProblemModel;
use app\oj\validate\ProblemValidate;
use think\Controller;

class Problem extends Controller
{
    /**
     * 题目展示
     * 前端请求该接口以获取所有题目的详细信息
     */
    public function displayAllProblem()
    {
        $problem_model = new ProblemModel();
        $resp = $problem_model->get_all_problem();
        return apiReturn($resp['code'],$resp['msg'],$resp['data']);
    }

    public function displayProblem()
    {
        $req = input('post.');
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();
        $result = $problem_validate->scene('displayProblem')->check($req);
        if($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }
        $resp = $problem_model->searchProblem($req['problem_id']);
        if(!empty($resp['data']['status']) && $resp['data']['status'] == USING){
            return apiReturn($resp['code'], '题目不可用', '');
        }
        return apiReturn($resp['code'],$resp['msg'],$resp['data']);
    }
    public function searchProblem()
    {

    }
    /**
     * 新建题目
     */
    public function newProblem()
    {

    }

    /**
     * 编辑题目
     */
    public function editProblem()
    {

    }

    /**
     * 提交题目
     * 用户提交source_code的接口，主要功能为向GoLang服务器(FinalRank)发送http请求
     */
    public function submit()
    {

    }
}