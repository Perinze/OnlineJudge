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
            return apiReturn(CODE_ERROR, '暂无数据', '');
        }
        $page_limit = config('wutoj_config.page_limit');
        $page = isset($req['page']) ? $req['page'] : 0;
        $resp['data'] = [];
        $resp['count'] = 0;
        if ($resp1['code'] === CODE_SUCCESS) {
            $resp['data'][] = $resp1['data'];
            $resp['count'] += 1;
        }
        if ($resp2['code'] === CODE_SUCCESS) {
            $count = count($resp2['data']['data']);
            $start = $page * $page_limit - $resp['count'];
            $start = $start > 0 ? $start : 0;
            $end = $start + $page_limit;
            for ($i = $start; $i < $count && $i < $end; $i++) {
                $resp['data'][] = $resp2['data']['data'][$i];
            }
            $resp['count'] += $count;
        }

        return apiReturn(CODE_SUCCESS, '查询成功', $resp);
    }

}