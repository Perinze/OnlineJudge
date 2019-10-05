<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 14:38
 */

namespace app\oj\controller;

use app\oj\model\CommonModel;
use app\oj\model\ProblemModel;
use app\oj\validate\ProblemValidate;
use think\Controller;

// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Request-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

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
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function displayProblem()
    {
        $req = input('post.');
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();
        $result = $problem_validate->scene('displayProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }
        $resp = $problem_model->searchProblemById($req['problem_id']);
        if (!empty($resp['data']['status']) && $resp['data']['status'] === USING) {
            return apiReturn($resp['code'], '题目不可用', '');
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function searchProblem()
    {
        // TODO 返回数据格式化，减少返回数据
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();
        $req = input('post.');
        $result = $problem_validate->scene('searchProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }
        $resp1 = $problem_model->searchProblemById($req['search']);
        $resp2 = $problem_model->searchProblemByTitle($req['search']);
        $i = 0;
        if ($resp1['code'] !== CODE_SUCCESS && $resp2['code'] !== CODE_SUCCESS) {
            return apiReturn(CODE_ERROR, '查询失败', '');
        }
        $resp = [];
        if ($resp1['code'] === CODE_SUCCESS) {
            $resp[] = $resp1['data'];
        }
        if ($resp2['code'] === CODE_SUCCESS) {
            foreach ($resp2['data'] as $k) {
                $resp[] = $k;
            }
        }
        return apiReturn(CODE_SUCCESS, '查询成功', $resp);
    }

    /**
     * 新建题目
     */
    public function newProblem()
    {
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();
        $common_model = new CommonModel();
        $resp = $common_model->checkIdentity();
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $req = input('post.');
        $result = $problem_validate->scene('newProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }
        $resp = $problem_model->addProblem(array(
            'title' => $req['title'],
            'background' => $req['background'],
            'describe' => $req['describe'],
            'input_format' => isset($req['input_format']) ? $req['input_format'] : '',
            'output_format' => isset($req['output_format']) ? $req['output_format'] : '',
            'hint' => isset($req['hint']) ? $req['hint'] : '',
            'public' => isset($req['public']) ? $req['public'] : 1,
            'source' => isset($req['source']) ? $req['source'] : '',
            'tag' => isset($req['tag']) ? $req['tag'] : '',
        ));
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 编辑题目
     */
    public function editProblem()
    {
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();
        $common_model = new CommonModel();
        $resp = $common_model->checkIdentity();
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $req = input('post.');
        $result = $problem_validate->scene('editProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }
        $resp = $problem_model->editProblem($req['problem_id'], array(
            'title' => $req['title'],
            'background' => $req['background'],
            'describe' => $req['describe'],
            'input_format' => isset($req['input_format']) ? $req['input_format'] : '',
            'output_format' => isset($req['output_format']) ? $req['output_format'] : '',
            'hint' => isset($req['hint']) ? $req['hint'] : '',
            'public' => isset($req['public']) ? $req['public'] : 1,
            'source' => isset($req['source']) ? $req['source'] : '',
            'tag' => isset($req['tag']) ? $req['tag'] : '',
        ));
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 提交题目
     * 用户提交source_code的接口，主要功能为向GoLang服务器(FinalRank)发送http请求
     */
    public function submit()
    {

    }
}