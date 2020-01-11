<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 16:50
 */

namespace app\oj\controller;


use app\oj\model\NoticeModel;
use app\oj\model\RotationModel;
use app\oj\model\SubmitlogModel;
use app\oj\model\SubmitModel;
use think\Controller;


class Index extends Controller
{
    /**
     * 首页公告
     */
    public function notice()
    {
        $notice_model = new NoticeModel();
        $resp = $notice_model->get_all_notice();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 首页轮播图
     */
    public function rotation()
    {
        $rotation_model = new RotationModel();
        $resp = $rotation_model->get_all_rotation();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 首页数据
     */
    public function data()
    {
        $submitlog_model = new SubmitlogModel();
        $resp = $submitlog_model->get_the_log();
        $data = $submitlog_model->get_all_log();
        $resp['data'][] = $data['data'];
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 首页显示比赛
     * TODO 限制条数
     */
    public function contest()
    {
        $submit_model = new SubmitModel();
        halt($submit_model->get_all_submit([]));
    }

    public function date()
    {

    }

    public function all_num()
    {

    }
}