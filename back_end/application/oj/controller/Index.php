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
use think\Controller;


class Index extends Controller
{
    public function notice()
    {
        $notice_model = new NoticeModel();
        $resp = $notice_model->get_all_notice();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function rotation()
    {
        $rotation_model = new RotationModel();
        $resp = $rotation_model->get_all_rotation();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function data()
    {
        $submitlog_model = new SubmitlogModel();
        $resp = $submitlog_model->get_the_log();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function contest()
    {

    }

    public function date()
    {

    }

    public function all_num()
    {

    }
}