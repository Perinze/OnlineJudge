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
use app\oj\model\RankCacheModel;
use app\oj\model\SubmitModel;
use app\oj\validate\SubmitValidate;
use think\facade\Session;


class Submit extends Base
{
    public function get_submit_info()
    {
        $submit_model = new SubmitModel();
        $contest_model = new ContestModel();
        $rankCache_model = new RankCacheModel();
        $req = input('post.');
        $where = [];
        $user_id = Session::get('user_id');
        $identify = Session::get('identify');
        $time = time();
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if(!isset($req['contest_id']) && !isset($req['user_id'])){
            $resp = $submit_model->get_the_submit(array(
                'contest_id' => 0
            ));
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
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
            if (!($identify === ADMINISTRATOR || $time > strtotime($contest['data']['end_time']))) {
                //$user_id = isset($req['user_id']) ? $req['user_id'] : $user_id;
                $where[] = ['submit.user_id', '=', $user_id];
            } else {
                if(isset($req['user_id'])){
                    $where[] = ['submit.user_id', '=', $req['user_id']];
                }
            }
            $resp = $submit_model->get_the_submit($where);
            $temp = $resp['data'];
            unset($resp['data']);
            $resp['data']['submit_info'] = $temp;
            $resp['data']['penalty'] = $this->handle_data($resp['data']['submit_info'],  $contest['data']['begin_time'], json_decode($contest['data']['problems'], true));
            $cache = $rankCache_model->get_rank_cache($req['contest_id']);
            if ($cache['code'] === CODE_SUCCESS) {
                $resp['data']['rank'] = $this->getRank($cache['data'], $user_id);
            } else {
                $resp['data']['rank'] = 1;
            }
        } else {
            if(isset($req['user_id'])){
                $where[] = ['submit.user_id', '=', $req['user_id']];
            }
            $resp = $submit_model->get_the_submit($where);
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function submit()
    {
        $submit_model = new SubmitModel();
        $problem_model = new ProblemModel();
        $submit_validate = new SubmitValidate();
        $contest_model = new ContestModel();
        $contest_user_model = new ContestUserModel();
        $language = ['c.gcc', 'cpp.g++'];
        $time = time();
        $req = input('post.');
        $result = $submit_validate->scene('submit')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $submit_validate->getError(), '');
        }
        if(array_search($req['language'], $language, false) === false){
            return apiReturn(CODE_ERROR, '暂不支持该语言', '');
        }
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
        $temp = $submit_model->get_the_submit(['submit.user_id' => $user_id]);
        $interval_time = config('wutoj_config.interval_time');
        if(!empty($temp['data']) && $time - strtotime($temp['data'][count($temp['data']) - 1]['submit_time']) < $interval_time){
            return apiReturn(CODE_ERROR, '请'.$interval_time.'S后再交题');
        }
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
//        echo json_encode(array(
//            'id' => $info['data'],
//            'pid' => $req['problem_id'],
//            'source' => [
//                'language' => $req['language'],
//                'code' => $req['source_code'],
//            ]
//        ), true);
        $submit_url = config('wutoj_config.submit_url');
        $length = count($submit_url);
        post($submit_url[mt_rand(0, $length - 1)], json_encode(array(
            'id' => (string)$info['data'],
            'pid' => (string)$req['problem_id'],
            'source' => [
                'language' => $req['language'],
                'code' => $req['source_code'],
            ]
        ), true));
        return apiReturn(CODE_SUCCESS, '提交成功', $info['data']);
    }

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
    public function reJudge()
    {
        $req = input('post.');
        $submit_model = new SubmitModel();
        $user_id = Session::get('user_id');
        $identity = Session::get('identity');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if($identity !== ADMINISTRATOR){
            return apiReturn(CODE_ERROR, '权限不足', '');
        }
        if(!isset($req['id'])){
            return apiReturn(CODE_ERROR, '请填写重新评测的id', '');
        }
        $problems = json_decode($req['id'], false);
        foreach ($problems as $item){
            $info = $submit_model->get_a_submit(['submit.id' => $item]);
            if ($info['code'] !== CODE_SUCCESS) {
                return apiReturn($info['code'], $info['msg'], $info['data']);
            }
            $info = $info['data'][0];
            post('http://10.143.216.128:8819/submit', json_encode(array(
                'id' => (string)$info['runid'],
                'pid' => (string)$info['problem_id'],
                'source' => [
                    'language' => $info['language'],
                    'code' => $info['source_code'],
                ]
            ), true));
        }
        return apiReturn(CODE_SUCCESS, '重新评测成功', '');
    }
}