<?php


namespace app\oj\model;


use think\facade\Session;
use think\Model;

class CommonModel extends Model
{
    public function checkIdentity()
    {
        $user_model = new UserModel();
        $session = Session::get('user_id');
        if(empty($session)){
            return ['code' => CODE_ERROR, 'msg' => '未登录', 'data' => ''];
        }
        $user = $user_model->searchUserById($session);
        isset($user['data']['identity']) ? $identity = $user['data']['identity'] : $identity = 0;
        if($identity !== ADMINISTRATOR){
            return ['code' => CODE_ERROR, 'msg' => '你没有权限', 'data' => ''];
        }
        return ['code' => CODE_SUCCESS, 'msg' => '权限正常', 'data' => ''];
    }
}