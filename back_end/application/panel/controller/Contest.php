<?php


namespace app\panel\controller;


use app\oj\model\ContestModel;

class Contest extends Base
{
    /* 接口 */
    /**
     * 添加比赛
     */
    public function addContest()
    {

    }

    /**
     * 删除比赛
     */
    public function deleContest()
    {

    }

    /**
     * 修改比赛
     */
    public function editContest()
    {

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

    }

    /* 页面 */
    /**
     * 添加比赛页面
     */
    public function add()
    {

    }

    /**
     * 比赛详情页面
     */
    public function info()
    {

    }

    /**
     * 首页
     */
    public function index()
    {
        return $this->fetch('index');
    }
}