<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 19:41
 */

namespace app\oj\controller;


use app\oj\model\SubmitModel;
use think\facade\Session;

class Submit extends Base
{
    public function get_submit_info()
    {
        $submit_model = new SubmitModel();
        $req = input('post');
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
}