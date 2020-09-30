<?php


namespace app\panel\controller;


use app\oj\validate\ContestValidate;
use app\panel\model\ContestModel;
use app\panel\model\ProblemModel;

class Contest extends Base
{
    /* 接口 */
    /**
     * 增加比赛
     */
    public function addContest()
    {
        $contest_model = new ContestModel();
        $problem_model = new ProblemModel();
        $contest_validate = new ContestValidate();

        // add
        $req = input('post.');
        $result = $contest_validate->scene('newContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        foreach ($req['problems'] as $item){
            $resp = $problem_model->editProblem($item, ['status' => CONTEST]);
            if($resp['code'] !== CODE_SUCCESS){
                return apiReturn($resp['code'], $resp['msg'], $resp['data']);
            }
        }
        $resp = $contest_model->newContest(array(
            'title' => $req['contest_name'],
            'begin_time' => $req['begin_time'],
            'end_time' => $req['end_time'],
            'frozen' => $req['frozen'],
            'colors' => json_encode(isset($req['colors']) ? $req['colors'] : array()),
            'problems' => json_encode($req['problems']),
        ));

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 删除比赛
     */
    public function deleContest()
    {
        $contest_model = new ContestModel();
        $contest_validate = new ContestValidate();

        // delete
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
    public function editContest()
    {
        $contest_model = new ContestModel();
        $problem_model = new ProblemModel();
        $contest_validate = new ContestValidate();

        // update
        $req = input('post.');
        $result = $contest_validate->scene('updateContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        $resp = $contest_model->searchContest($req['contest_id']);
        if($resp['code'] !== CODE_SUCCESS){
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $old_problem = json_decode($resp['data']['problems'], false);
        $status = $resp['data']['status'];
        foreach ($old_problem as $item){
            $resp = $problem_model->editProblem($item, ['status' => USING]);
            if($resp['code'] !== CODE_SUCCESS){
                return apiReturn($resp['code'], $resp['msg'], $resp['data']);
            }
        }
        foreach ($req['problems'] as $item){
            $resp = $problem_model->editProblem($item, ['status' => CONTEST]);
            if($resp['code'] !== CODE_SUCCESS){
                return apiReturn($resp['code'], $resp['msg'], $resp['data']);
            }
        }

        $resp = $contest_model->editContest($req['contest_id'], array(
            'contest_name' => $req['contest_name'],
            'begin_time' => $req['begin_time'],
            'end_time' => $req['end_time'],
            'frozen' => $req['frozen'],
            'problems' => json_encode($req['problems']),
            'status' => isset($req['status']) ? $req['status'] : $status,
        ));

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 查询所有比赛
     */
    public function getAllContest()
    {
        $contest_model = new ContestModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'contest_name');
        $resp = $contest_model->getAllContest($where['where'], $where['limit'], $where['offset']);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $contest_model);
    }

    /**
     * 查询单个比赛信息
     */
    public function getTheContest()
    {
        $contest_model = new ContestModel();

        $req = input('post.');
        if(!isset($req['contest_id'])){
            return apiReturn(CODE_ERROR, '没有填写比赛编号', '');
        }

        $resp = $contest_model->searchContest($req['contest_id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /* 页面 */
    /**
     * 添加比赛页面
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 比赛详情页面
     */
    public function info()
    {
        $req = input('get.');
        $id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('id', $id);
        return $this->fetch();
    }

    /**
     * 首页
     */
    public function index()
    {
        return $this->fetch('index');
    }
}