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
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Request-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class Submit extends Base
{
    public function get_submit_info()
    {
        $submit_model = new SubmitModel();
        $req = input('post.');
        if(!isset($req['contest_id']) && !isset($req['user_id'])){
            return apiReturn(CODE_ERROR, '缺少查询数据', '');
        }
        $where = [];
        $user_id = Session::get('user_id');
        // TODO 检查是否在比赛期间
        // TODO 检查权限
        if(isset($req['contest_id'])){
            $where[] = ['contest_id', '=', $req['contest_id']];
        }
        if(isset($req['user_id'])){
            $where[] = ['user_id', '=', $req['user_id']];
        }
        $resp = $submit_model->get_the_submit($where);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function submit()
    {
        $submit_model = new SubmitModel();
        $problem_model = new ProblemModel();
        $submit_validate = new SubmitValidate();
        $contest_model = new ContestModel();
        $contest_user_model = new ContestUserModel();
        $time = time();
        $req = input('post.');
        $result = $submit_validate->scene('submit')->check($req);
        if($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $submit_validate->getError(), '');
        }
        $problem = $problem_model->searchProblemById($req['problem_id']);
        if($problem['code'] !== CODE_SUCCESS){
            return apiReturn($problem['code'], $problem['msg'], $problem['data']);
        }
        if($problem['data']['status'] === BANNED){
            return apiReturn(CODE_ERROR, '题目暂不可用', '');
        }
        $user_id = Session::get('user_id');
        $contest_id = 0;
        if($problem['data']['status'] === CONTEST){
            if(isset($req['contest_id'])){
                $contest_id = $req['contest_id'];
                $info = $contest_user_model->searchUser($contest_id, $user_id);
                if($info['code'] !== CODE_SUCCESS){
                    return apiReturn($info['code'], $info['msg'], $info['data']);
                }
                $contest = $contest_model->searchContest($contest_id);
                if($contest['code'] !== CODE_SUCCESS){
                    return apiReturn($contest['code'], $contest['msg'], $contest['data']);
                }
                if($time < $contest['data']['begin_time']){
                    return apiReturn(CODE_ERROR, '比赛未开始', '');
                }
                if($time > $contest['data']['end_time']){
                    $problem_model->editProblem($req['problem_id'], ['status' => 1]);
                    $contest_id = 0;
                }
            } else {
                return apiReturn(CODE_ERROR, '缺少比赛ID', '');
            }
        }
        $info = $submit_model->add_submit(array(
            'user_id' => $user_id,
            'user_nick' => Session::get('nick'),
            'problem_id' => $req['problem_id'],
            'contest_id' => $contest_id,
            'source_code' => $req['source_code'],
            'language' => $req['language'],
            'status' => Judging,
            'time' => 0,
            'memory' => 0,
            'submit_time' => $time,
        ));
        if($info['code'] !== CODE_SUCCESS){
            return apiReturn($info['code'], $info['msg'], $info['data']);
        }
        post('', json_encode(array(
            'id' => $info['data'],
            'pid' => $req['problem_id'],
            'source' => [
                'language' => $req['language'],
                'code' => $req['source_code'],
            ]
        ), true));
        return apiReturn(CODE_SUCCESS, '提交成功', '');
    }
}