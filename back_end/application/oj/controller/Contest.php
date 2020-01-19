<?php


namespace app\oj\controller;


use app\oj\model\ContestModel;
use app\oj\model\ContestUserModel;
use app\oj\model\SubmitModel;
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
        // if array then decode columns problems and colors;
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
        $result = $contest_validate->scene('searchContest1')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->searchContest($req['contest_id']);
        // format columns
        if(isset($resp['data']['problems'])){
            $resp['data']['problems'] = json_decode($resp['data']['problems'], true);
        }
        if(isset($resp['data']['colors'])){
            $resp['data']['colors'] = json_decode($resp['data']['colors'], true);
        }
        if(isset($resp['data']['prize'])){
            $resp['data']['prize'] = json_decode($resp['data']['prize'], true);
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
        // if array then decode columns problems and colors;
        if(is_array($resp['data'])){
            foreach ($resp['data'] as &$item){
                $item['problems'] = json_decode($item['problems'], true);
                $item['colors'] = json_decode($item['colors'], true);
            }
        }

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
        // join
        $req = input('post.');
        $result = $contest_validate->scene('searchContest1')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        //judge contest exists or not
        $contest_id = $req['contest_id'];
        $resp = $contest_model->searchContest($contest_id);
        if($resp['code'] !== CODE_SUCCESS){
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }

        // judge join info
        $resp = $contest_user_model->searchUser($contest_id, $user_id);
        if($resp['code'] === CODE_ERROR){
            $resp = $contest_user_model->addInfo($contest_id, $user_id);
        }

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 检查参加比赛状态
     */
    public function checkContest()
    {
        $contest_user_model = new ContestUserModel();
        $contest_validate = new ContestValidate();
        $req = input('post.');
        $result = $contest_validate->scene('searchContest1')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        //judge join info
        $contest_id = $req['contest_id'];
        $resp = $contest_user_model->searchUser($contest_id, $user_id);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function getUserContest()
    {
        $contest_user_model = new ContestUserModel();
        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        // get the user all contests info
        $resp = $contest_user_model->searchUserContest($user_id);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}