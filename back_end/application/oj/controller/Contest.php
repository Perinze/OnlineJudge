<?php


namespace app\oj\controller;


use app\oj\model\ContestModel;
use app\oj\model\ContestUserModel;
use app\oj\validate\ContestValidate;
use think\Controller;
use think\facade\Session;


class Contest extends Controller
{
    /**
     * 获取所有比赛
     */
    public function getAllContest()
    {
        $contest_model = new ContestModel();
        $resp = $contest_model->searchContest();
        if(is_array($resp)){
            foreach ($resp['data'] as &$item){
                $item['problems'] = json_decode($item['problems'], true);
                $item['colors'] = json_decode($item['colors'], true);
            }
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 获取比赛详情
     */
    public function getTheContest()
    {
        $contest_model = new ContestModel();
        $contest_validate = new ContestValidate();
        $req = input('post.');
        $result = $contest_validate->scene('searchContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->searchContest($req['contest_id']);
        if(isset($resp['data']['problems'])){
            $resp['data']['problems'] = json_decode($resp['data']['problems'], true);
        }
        if(isset($resp['data']['colors'])){
            $resp['data']['colors'] = json_decode($resp['data']['colors'], true);
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 搜索比赛
     */
    public function searchContest()
    {
        $contest_model = new ContestModel();
        $contest_validate = new ContestValidate();
        $req = input('post.');
        $result = $contest_validate->scene('searchContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->searchContest(0, $req['contest_name']);
        if(is_array($resp['data'])){
            foreach ($resp['data'] as &$item){
                $item['problems'] = json_decode($item['problems'], true);
                $item['colors'] = json_decode($item['colors'], true);
            }
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 增加比赛
     */
    public function addContest()
    {
        $contest_model = new ContestModel();
        $contest_validate = new ContestValidate();
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if ($session['identity'] !== ADMINISTRATOR) {
            return apiReturn(CODE_ERROR, '权限不足', '');
        }
        $req = input('post.');
        $result = $contest_validate->scene('newContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->newContest(array(
            'contest_name' => $req['contest_name'],
            'begin_time' => $req['begin_time'],
            'end_time' => $req['end_time'],
            'frozen' => $req['frozen'],
            'problems' => json_encode($req['frozen']),
        ));
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 删除比赛
     */
    public function deleteContest()
    {
        $contest_model = new ContestModel();
        $contest_validate = new ContestValidate();
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if ($session['identity'] !== ADMINISTRATOR) {
            return apiReturn(CODE_ERROR, '权限不足', '');
        }
        $req = input('post.');
        $result = $contest_validate->scene('deleteContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->deleContest($req['contest_id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 更新比赛
     */
    public function updateContest()
    {
        $contest_model = new ContestModel();
        $contest_validate = new ContestValidate();
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if ($session['identity'] !== ADMINISTRATOR) {
            return apiReturn(CODE_ERROR, '权限不足', '');
        }
        $req = input('post.');
        $result = $contest_validate->scene('updateContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->editContest($req['contest_id'], array(
            'contest_name' => $req['contest_name'],
            'begin_time' => $req['begin_time'],
            'end_time' => $req['end_time'],
            'frozen' => $req['frozen'],
            'problems' => json_encode($req['frozen']),
            'state' => $req['state']
        ));
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 加入比赛
     */
    public function joinContest()
    {
        $contest_user_model = new ContestUserModel();
        $contest_model = new ContestModel();
        $contest_validate = new ContestValidate();
        $req = input('post.');
        $result = $contest_validate->scene('searchContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $contest_id = $req['contest_id'];
        $resp = $contest_model->searchContest($contest_id);
        if($resp['code'] !== CODE_SUCCESS){
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $resp = $contest_user_model->searchUser($contest_id, $user_id);
        if($resp['code'] === CODE_ERROR){
            $resp = $contest_user_model->addInfo($contest_id, $user_id);
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}