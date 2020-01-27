<?php


namespace app\panel\controller;


use app\oj\model\SubmitModel;
use think\facade\Session;

class Submit extends Base
{
    /* 接口 */
    public function getAllSubmit()
    {

    }

    public function getTheSubmit()
    {

    }

    public function reJudge()
    {
        $req = input('post.');
        $submit_model = new SubmitModel();
        if(!isset($req['id'])){
            return apiReturn(CODE_ERROR, '请填写重新评测的id', '');
        }
        $problems = json_decode($req['id'], false);
        $submit_url = config('wutoj_config.submit_url');
        $length = count($submit_url);
        foreach ($problems as $item){
            $info = $submit_model->get_a_submit(['submit.id' => $item]);
            if ($info['code'] !== CODE_SUCCESS) {
                return apiReturn($info['code'], $info['msg'], $info['data']);
            }
            $info = $info['data'][0];

            // post to the random judger
            post($submit_url[mt_rand(0, $length - 1)], json_encode(array(
                'id' => (string)$info['data'],
                'pid' => (string)$req['problem_id'],
                'source' => [
                    'language' => $req['language'],
                    'code' => $req['source_code'],
                ]
            ), true));
        }
        return apiReturn(CODE_SUCCESS, '重新评测成功', '');
    }
    /* 页面 */
    public function index()
    {

    }

    public function info()
    {

    }
}