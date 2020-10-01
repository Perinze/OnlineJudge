<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/12/3
 * Time: 16:43
 */

namespace app\oj\controller;


use app\oj\model\FeedbackModel;
use app\oj\validate\FeedbackValidate;
use think\facade\Session;
// TODO 需要一个静态资源站
class Feedback extends Base
{
    /**
     *
     * 添加反馈信息
     */
    public function add_feedback()
    {
        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        $data = input('post.');
        $add_feedback_validate = new FeedbackValidate();
        $rel = $add_feedback_validate->scene('add_feedback')->check($data);
        if ($rel !== VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $add_feedback_validate->getError(), '');
        }
        // add
        $img = [];
        if(isset($data['img'])){
            $img = $data['img'];
            if(!is_array($img)){
                return apiReturn(CODE_ERROR, '图片url格式不正确', '');
            }
        }
        $add_data = array(
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $user_id,
            'img_url' => json_encode($img),
        );
        $add_model = new FeedbackModel();
        $resp = $add_model->add_feedback($add_data);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function get_code()
    {
        $appcode = 'fyQsFidmKNJknSzqGOoezUslGFX7HJ54q2rLytgsZkA2XPO49pAlY9B5mLdSKcDJ';
        $saltstring = 'fuckjwc_token123';
        $timestamp = (string)time();
        $nonce = $this->rand();
        $resp['access_token'] = md5(substr($appcode, 0, 32).substr($timestamp, 0, strlen($timestamp) - 4)
            .substr($appcode, 32, 32).$nonce.$saltstring);
        $resp['nonce'] = $nonce;
        return apiReturn(CODE_SUCCESS, '成功', $resp);
    }
    public function rand()
    {
        $str = '';
        for($i = 0; $i < 16; $i++){
            $str .= chr(mt_rand(97, 122));
        }
        return $str;
    }
}