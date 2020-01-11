<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 14:38
 */

namespace app\oj\controller;

use app\oj\model\CommonModel;
use app\oj\model\ContestModel;
use app\oj\model\ContestUserModel;
use app\oj\model\ProblemModel;
use app\oj\model\SampleModel;
use app\oj\validate\ProblemValidate;
use think\Controller;
use think\facade\Session;


class Problem extends Controller
{
    /**
     * 题目展示
     * 前端请求该接口以获取所有题目的详细信息
     */
    public function displayAllProblem()
    {
        $problem_model = new ProblemModel();
        // TODO 上Redis
        $req = input('post.');
        $page = isset($req['page']) ? (int)$req['page'] : 0;
        $resp = $problem_model->get_all_problem($page);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 展示具体的一个题目内容
     */
    public function displayProblem()
    {
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();
        $sample_model = new SampleModel();
        $contest_model = new ContestModel();
        $contest_user_model = new ContestUserModel();

        $req = input('post.');
        $time = time();
        $result = $problem_validate->scene('displayProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }

        $user_id = Session::get('user_id');
        $identity = Session::get('identity');

        /**
         * check problem status
         * banned: return
         * contest: check authority
         */
        $resp = $problem_model->searchProblemById($req['problem_id']);
        if (empty($resp['data']['status']) || $resp['data']['status'] !== USING) {
            if($resp['data']['status'] === CONTEST){
                if (isset($req['contest_id'])) {
                    // check contest exist or not
                    $contest_id = $req['contest_id'];
                    $contest = $contest_model->searchContest($contest_id);
                    if ($contest['code'] !== CODE_SUCCESS) {
                        return apiReturn($contest['code'], $contest['msg'], $contest['data']);
                    }
                    // check authority
                    $info = $contest_user_model->searchUser($contest_id, $user_id);
                    if ($info['code'] !== CODE_SUCCESS) {
                        return apiReturn($info['code'], $info['msg'], $info['data']);
                    }
                    if ($time < strtotime($contest['data']['begin_time']) && $identity !== ADMINISTRATOR) {
                        return apiReturn(CODE_ERROR, '比赛未开始', '');
                    }
                    if ($time > strtotime($contest['data']['end_time'])) {
                        $problem_model->editProblem($req['problem_id'], ['status' => 1]);
                    }
                } else {
                    return apiReturn(CODE_ERROR, '缺少比赛ID', '');
                }
            } else {
                return apiReturn($resp['code'], '题目不可用', '');
            }
        }

        // get the problem samples
        $sample = $sample_model->searchSampleByProblemID($req['problem_id']);
        if($sample['code'] !== CODE_SUCCESS){
            return apiReturn($sample['code'], $sample['msg'], '');
        }
        $resp['data']['sample'] = $sample['data'];

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 模糊查询题目
     */
    public function searchProblem()
    {
        // TODO 返回数据格式化，减少返回数据
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();

        $req = input('post.');
        $result = $problem_validate->scene('search')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }

        $resp1 = $problem_model->searchProblemById($req['search']);
        $resp2 = $problem_model->searchProblemByTitle($req['search']);
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

        // check authority
        $resp = $common_model->checkIdentity();
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }

        $req = input('post.');
        $result = $problem_validate->scene('newProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }

        // add
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

        // check authority
        $resp = $common_model->checkIdentity();
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }

        $req = input('post.');
        $result = $problem_validate->scene('editProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }

        // edit
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
}