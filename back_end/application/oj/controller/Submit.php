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
use app\oj\model\SubmitModel;
use app\oj\validate\SubmitValidate;
use think\facade\Session;


class Submit extends Base
{
    public function get_submit_info()
    {
        $submit_model = new SubmitModel();
        $contest_model = new ContestModel();
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
                $user_id = isset($req['user_id']) ? $req['user_id'] : $user_id;
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
        $language = ['c.gcc', 'cpp.g++', 'py.cpython', 'java.java'];
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
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $contest_id = 0;
        if ($problem['data']['status'] === CONTEST) {
            if (isset($req['contest_id'])) {
                $contest_id = $req['contest_id'];
                $contest = $contest_model->searchContest($contest_id);
                if ($contest['code'] !== CODE_SUCCESS) {
                    return apiReturn($contest['code'], $contest['msg'], $contest['data']);
                }
                $info = $contest_user_model->searchUser($contest_id, $user_id);
                if ($info['code'] !== CODE_SUCCESS) {
                    return apiReturn($info['code'], $info['msg'], $info['data']);
                }
                if ($time < $contest['data']['begin_time']) {
                    return apiReturn(CODE_ERROR, '比赛未开始', '');
                }
                if ($time > $contest['data']['end_time']) {
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
        post('http://10.143.216.128:8819/submit', json_encode(array(
            'id' => $info['data'],
            'pid' => $req['problem_id'],
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

        $info = $submit_model->get_the_submit(array(
            'id' => $req['status_id']
        ));
        if($info['code'] !== CODE_SUCCESS) {
            return apiReturn($info['code'], $info['msg'], $info['data']);
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
                    $re_data['problem'][$p]['times']++;
                } else {
                    $re_data['problem'][$p]['success_time'] = strtotime($item['submit_time']) - $begin_time;
                    $re_data['penalty'] += strtotime($item['submit_time']) - $begin_time + $re_data['problem'][$p]['times'] * 1200;
                    $re_data['acnum']++;
                }
            }
        }
        return $re_data;
    }
}