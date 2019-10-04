<?php


namespace app\oj\controller;


use app\oj\model\ContestModel;
use app\oj\validate\ContestValidate;
use think\Controller;
use think\facade\Session;
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Request-Methods:*');
class Contest extends Controller
{
    /**
     * 获取所有比赛
     */
    public function getAllContest()
    {
        $contest_model = new ContestModel();
        $resp = $contest_model->searchContest();
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
        $result = $contest_validate->scene('getTheContest')->check($req);
        if($result !== true){
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->searchContest($req['id']);
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
        if($result !== true){
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->searchContest($req['contest_name']);
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
        if(empty($session)){
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if($session['identity'] !== ADMINISTRATOR){
            return apiReturn(CODE_ERROR, '权限不足', '');
        }
        $req = input('post.');
        $result = $contest_validate->scene('newContest')->check($req);
        if($result !== true){
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
        if(empty($session)){
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if($session['identity'] !== ADMINISTRATOR){
            return apiReturn(CODE_ERROR, '权限不足', '');
        }
        $req = input('post.');
        $result = $contest_validate->scene('deleteContest')->check($req);
        if($result !== true){
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
        if(empty($session)){
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if($session['identity'] !== ADMINISTRATOR){
            return apiReturn(CODE_ERROR, '权限不足', '');
        }
        $req = input('post.');
        $result = $contest_validate->scene('updateContest')->check($req);
        if($result !== true){
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
        // TODO 逻辑
    }
}