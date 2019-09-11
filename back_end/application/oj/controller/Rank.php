<?php


namespace app\oj\controller;


use app\oj\model\GroupModel;
use app\oj\model\UserModel;
use think\Controller;

class Rank extends Controller
{
    // TODO 更新逻辑可以有多个排序规则
    public function user_rank()
    {
        $user_model = new UserModel();
        $resp = $user_model->user_rank();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function group_rank()
    {
        $group_model = new GroupModel();
        $resp = $group_model->group_rank();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}