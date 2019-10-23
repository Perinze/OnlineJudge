<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午2:33
 */

namespace app\oj\controller;

use app\common\model\FindPasswordModel;
use app\oj\model\UserModel;
use app\oj\validate\UserValidate;
use custom\Mailer;
use think\Controller;
use think\facade\Session;


class Login extends Controller
{
    public function do_login()
    {
        // 检测重复登录
        if (Session::has('user_id')) {
            return apiReturn(CODE_ERROR, '已有账号登录', Session::get('data'));
        }
        // 正常登陆逻辑
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        // 检测前端传送的用户登陆数据
        $result = $user_validate->scene('login')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        // 密码加密
        $req['password'] = md5(base64_encode($req['password']));
        // 身份验证
        $result = $user_model->loginCheck($req);
        $data = array();
        if ($result['code'] === CODE_SUCCESS) {
            // 验证成功，session分配
            session('user_id', $result['data']['user_id']);
            session('nick', $result['data']['nick']);
            session('identity', $result['data']['identity']);
            $data = array(
                'userId' => $result['data']['user_id'],
                'nick' => $result['data']['nick'],
                'desc' => $result['data']['desc'],
                'acCnt' => count(json_decode($result['data']['ac_problem'], true)),
                'waCnt' => count(json_decode($result['data']['wa_problem'], true)),
            );
            session('data', $data);

        }
        return apiReturn($result['code'], $result['msg'], $data);
    }

    public function do_logout()
    {
        session(null);
        return apiReturn(CODE_SUCCESS, '注销成功', '');
    }

    public function forgetPassword()
    {
        //TODO 验证邮箱
        $user_validate = new UserValidate();
        $find_model = new FindPasswordModel();
        $user_model = new UserModel();
        $mail = new Mailer();
        $req = input('post.');
        $result = $user_validate->scene('forget')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $code = $find_model->create_token($req['nick']);
        if ($code['code'] !== CODE_SUCCESS) {
            return apiReturn(CODE_ERROR, '发送失败', $code['data']);
        }
        $info = $user_model->searchUserByNick($req['nick']);
        if ($info['code'] !== CODE_SUCCESS) {
            return apiReturn(CODE_ERROR, $info['msg'], '');
        }
        $info = $mail->sendMail($info['data']['mail'], $req['nick'], '验证码发送', '本次验证码为' . $code['data'] . '该邮件不需要回复');
        if ($info !== true) {
            return apiReturn(CODE_ERROR, '发送失败', '');
        }
        return apiReturn(CODE_SUCCESS, '发送成功', '');
    }
}