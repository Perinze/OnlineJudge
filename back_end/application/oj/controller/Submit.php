<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 19:41
 */

namespace app\oj\controller;


use app\oj\model\ContestModel;
use app\oj\model\ContestUserModel;
use app\oj\model\ProblemModel;
use app\oj\model\OJCacheModel;
use app\oj\model\SubmitModel;
use app\oj\validate\SubmitValidate;
use think\facade\Session;


class Submit extends Base
{
    private function get_where_info($req)
    {
        $where = [];
        if(isset($req['user_id'])){
            $where[] = ['submit.user_id', '=', $req['user_id']];
        }
        if(isset($req['nick'])){
            $where[] = ['users.nick', '=', $req['nick']];
        }
        if(isset($req['status'])){
            $where[] = ['submit.status', '=', $req['status']];
        }
        if(isset($req['problem_id'])){
            $where[] = ['problem_id', '=', $req['problem_id']];
        }
        if(isset($req['duration'])){
            $where[] = ['submit_time', 'between time', explode(',', $req)];
        }
        return $where;
    }

    /**
     * 获取提交详情
     */
    public function get_submit_info()
    {
        $submit_model = new SubmitModel();
        $contest_model = new ContestModel();
        $rankCache_model = new OJCacheModel();

        $req = input('post.');
        $where = [];
        $user_id = Session::get('user_id');
        $identify = Session::get('identify');
        $time = time();
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $page = isset($req['page']) ? (int)$req['page'] : 0; // 分页
        if(!isset($req['contest_id']) && !isset($req['user_id'])){
            $resp = $submit_model->get_the_submit(array(
                'contest_id' => 0,
            ),$page);
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }

        /**
         * in contest
         * users can only get themselves submit info
         */
        if (isset($req['contest_id'])) {
            $contest_id = $req['contest_id'];
            $contest = $contest_model->searchContest($contest_id);
            if ($contest['code'] !== CODE_SUCCESS) {
                return apiReturn($contest['code'], $contest['msg'], $contest['data']);
            }
            if ($time < $contest['data']['begin_time']) {
                return apiReturn(CODE_ERROR, '比赛未开始', '');
            }
            $where[] = ['contest_id', '=', $req['contest_id']];
            // administrator can get all
            if ($identify === ADMINISTRATOR || $time > strtotime($contest['data']['end_time'])) {
                $where[] = $this->get_where_info($req);
            } else {
                $req['user_id'] = $user_id;
                $where[] = $this->get_where_info($req);;
            }
            $resp = $submit_model->get_the_submit($where, $page);

            // format
            $resp['data']['penalty'] = $this->handle_data($resp['data']['submit_info'],  $contest['data']['begin_time'], json_decode($contest['data']['problems'], true));
            $cache = $rankCache_model->get_rank_cache($req['contest_id']);
            if ($cache['code'] === CODE_SUCCESS) {
                $resp['data']['rank'] = $this->getRank($cache['data'], $user_id);
            } else {
                $resp['data']['rank'] = 1;
            }
        } else {
            $where[] = $this->get_where_info($req);
            $resp = $submit_model->get_the_submit($where, $page);
        }

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 交题
     */
    public function submit()
    {
        $submit_model = new SubmitModel();
        $problem_model = new ProblemModel();
        $submit_validate = new SubmitValidate();
        $contest_model = new ContestModel();
        $contest_user_model = new ContestUserModel();
        $oj_cache_model = new OJCacheModel();

        $language = config('wutoj_config.language');
        $time = time();
        $req = input('post.');
        $result = $submit_validate->scene('submit')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $submit_validate->getError(), '');
        }

        if(array_search($req['language'], $language, false) === false){
            return apiReturn(CODE_ERROR, '暂不支持该语言', '');
        }

        /**
         * check problem
         * banned: return
         * contest: check authority
         */
        $problem = $problem_model->searchProblemById($req['problem_id']);
        if ($problem['code'] !== CODE_SUCCESS) {
            return apiReturn($problem['code'], $problem['msg'], $problem['data']);
        }
        if ($problem['data']['status'] === BANNED) {
            return apiReturn(CODE_ERROR, '题目暂不可用', '');
        }

        $user_id = Session::get('user_id');
        $identity = Session::get('identity');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $contest_id = 0;
/*        $interval_time = config('wutoj_config.interval_time');// 交题时间限制
        $ok = $oj_cache_model->get_submit_cache($user_id);
        if($ok['code'] === CODE_SUCCESS){
            return apiReturn(CODE_ERROR, '请'.$interval_time.'S后再交题');
        }*/

        // check user authority
        if ($problem['data']['status'] === CONTEST) {
            if (isset($req['contest_id'])) {
                $contest_id = $req['contest_id'];
                $contest = $contest_model->searchContest($contest_id);
                if ($contest['code'] !== CODE_SUCCESS) {
                    return apiReturn($contest['code'], $contest['msg'], $contest['data']);
                }
                $problems = json_decode($contest['data']['problems'], false);
                if(!in_array($req['problem_id'], $problems,false)){
                    return apiReturn(CODE_ERROR,'该题不是比赛试题', '');
                }
                $info = $contest_user_model->searchUser($contest_id, $user_id);
                if ($info['code'] !== CODE_SUCCESS) {
                    return apiReturn($info['code'], $info['msg'], $info['data']);
                }
                if ($time < strtotime($contest['data']['begin_time']) && $identity !== ADMINISTRATOR) {
                    return apiReturn(CODE_ERROR, '比赛未开始', '');
                }
                if ($time > strtotime($contest['data']['end_time'])) {
                    $problem_model->editProblem($req['problem_id'], ['status' => 1]);
                    $contest_id = 0;
                }
            } else {
                return apiReturn(CODE_ERROR, '缺少比赛ID', '');
            }
        }
        $info = $submit_model->add_submit(array(
            'user_id' => $user_id,
            'nick' => Session::get('nick'),
            'problem_id' => $req['problem_id'],
            'contest_id' => $contest_id,
            'source_code' => $req['source_code'],
            'language' => array_search($req['language'], $language, false),
            'status' => 'Judging',
            'time' => 0,
            'memory' => 0,
        ));
        if ($info['code'] !== CODE_SUCCESS) {
            return apiReturn($info['code'], $info['msg'], $info['data']);
        }
        $submit_url = config('wutoj_config.submit_url');
        $length = count($submit_url);
        $oj_cache_model->set_submit_cache($user_id);

        // post to the random judger
        post($submit_url[mt_rand(0, $length - 1)], json_encode(array(
            'id' => (string)$info['data'],
            'pid' => (string)$req['problem_id'],
            'env' => (string)config('wutoj_config.environment'),
            'source' => [
                'language' => $req['language'],
                'code' => $req['source_code'],
            ]
        ), true));

        return apiReturn(CODE_SUCCESS, '提交成功', $info['data']);
    }

    /**
     * 获取某次提交的状态
     * TODO 判断一个人是否已经通过一个题，若通过则可查看其他人代码
     */
    public function getSubmitStatus() {
        $submit_model = new SubmitModel();
        $submit_validate = new SubmitValidate();

        $req = input('post.');
        $chk=$submit_validate->scene('getSubmitStatus')->check($req);
        if($chk !== VALIDATE_PASS){
            return apiReturn(CODE_ERROR, $submit_validate->getError(), '');
        }

        $info = $submit_model->get_a_submit(array(
            'id' => $req['status_id']
        ));
        if($info['code'] !== CODE_SUCCESS) {
            return apiReturn($info['code'], $info['msg'], $info['data']);
        }
        $info['data'] = $info['data'][0];
        $user_id = Session::get('user_id');
        $identity = Session::get('identity');
        if($user_id !== $info['data']['user_id'] && $identity !== ADMINISTRATOR){
            return apiReturn(CODE_ERROR, '不要查看其他人代码', '');
        }

        return apiReturn(CODE_SUCCESS, '请求成功', $info['data']);
    }

    /**
     * 格式化数据
     */
    private function handle_data($data, $begin_time, $problem)
    {
        $begin_time = strtotime($begin_time);
        $re_data = array(
            'nick' => isset($data[0]['nick']) ? $data[0]['nick'] : '',
            'penalty' => 0,
            'acnum' => 0,
            'problem' => array(),
        );
        foreach ($data as $item){
            $p = array_search($item['problem_id'], $problem, false);
            if($p === false){
                continue;
            }
            $p = chr($p + 65);
            if(!isset($re_data['problem'][$p])){
                $re_data['problem'][$p] = ['success_time' => '', 'times' => 0];
            }
            if(empty($re_data['problem'][$p]['success_time'])){
                if($item['status'] !== 'AC'){
                    if($item['status'] !== 'CE'){
                        $re_data['problem'][$p]['times']++;
                    }
                } else {
                    $re_data['problem'][$p]['success_time'] = strtotime($item['submit_time']) - $begin_time;
                    $re_data['penalty'] += strtotime($item['submit_time']) - $begin_time + $re_data['problem'][$p]['times'] * 1200;
                    $re_data['acnum']++;
                }
            }
        }
        return $re_data;
    }

    private function getRank($data, $user_id)
    {
        $i = 1;
        foreach ($data as $item){
            if($item['user_id'] === $user_id){
                return $i;
            }
            $i++;
        }
    }
}
