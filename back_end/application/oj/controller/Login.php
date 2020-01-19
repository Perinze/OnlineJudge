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
    /**
     * 登录
     */
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
            $data = array(
                'userId' => $result['data']['user_id'],
                'nick' => $result['data']['nick'],
                'desc' => $result['data']['desc'],
            );
            session('user_id', $result['data']['user_id']);
            session('nick', $result['data']['nick']);
            session('identity', $result['data']['identity']);
            session('data', $data);
        }

        return apiReturn($result['code'], $result['msg'], $data);
    }

    /**
     * 注销
     */
    public function do_logout()
    {
        session(null);
        return apiReturn(CODE_SUCCESS, '注销成功', '');
    }

    /**
     * 检测是否登录
     */
    public function checkLogin() {
        $req = input('post.');
        if (Session::has('user_id')) {
            if(isset($req['user_id'])) {
                if($req['user_id']==Session::get('user_id')) {
                    return apiReturn(CODE_SUCCESS, '已经登陆，且账号相符', '');
                }else{
                    return apiReturn(CODE_SUCCESS, '已经登陆，账号不符', Session::get('user_id'));
                }
            }
            return apiReturn(CODE_SUCCESS, '已经登陆', '');
        }
        return apiReturn(CODE_ERROR, '未登陆', '');
    }

    /**
     * 忘记密码，重设密码操作
     */
    public function forgetPassword()
    {
        $user_validate = new UserValidate();
        $find_model = new FindPasswordModel();
        $user_model = new UserModel();
        $mail = new Mailer();

        $req = input('post.');
        $result = $user_validate->scene('forget')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }

        // check user email address
        $info = $user_model->searchUserByNick($req['nick']);
        if ($info['code'] !== CODE_SUCCESS) {
            return apiReturn(CODE_ERROR, $info['msg'], '');
        }
        if($info['data']['mail'] !== $req['mail']){
            return apiReturn(CODE_ERROR, '邮箱不一致', '');
        }

        // gen code
        $code = $find_model->create_token($req['nick']);
        if ($code['code'] !== CODE_SUCCESS) {
            return apiReturn(CODE_ERROR, '发送失败', $code['data']);
        }

        // send mail
        $info = $mail->sendMail($info['data']['mail'], $req['nick'], '验证码发送', '本次验证码为' . $code['data'] . '该邮件不需要回复');
        if ($info !== true) {
            return apiReturn(CODE_ERROR, '发送失败', '');
        }

        return apiReturn(CODE_SUCCESS, '发送成功', '');
    }
}