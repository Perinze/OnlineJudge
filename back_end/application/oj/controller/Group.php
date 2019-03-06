<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 15:33
 */

namespace app\oj\controller;

use app\oj\model\GroupModel;
use app\oj\model\UsergroupModel;
use app\oj\validate\GroupValidate;
use think\facade\Session;

class Group extends Base
{

    // uncheck

    public function get_all_group()
    {
        $usergroup_model = new UsergroupModel();
        $session = Session::get('user_id');
        $resp = $usergroup_model->find_group($session['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function get_the_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $group_model = new GroupModel();
        $req = input('post');
        $result = $group_validate->scene('get_the_group')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $usergroup_model->find_user($req['group_id']);
        $resp1 = $group_model->get_the_group($req['group_id']);
        return apiReturn($resp['code'], $resp['msg'], array(
            'user' => $resp['data'],
            'group' => $resp1['data']
        ));
    }
}