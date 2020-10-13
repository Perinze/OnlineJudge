<?php


namespace app\panel\controller;


use app\panel\model\SubmitModel;
use think\facade\Session;

class Submit extends Base
{
    /* 接口 */
    public function getAllSubmit()
    {
        $submit_model = new SubmitModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'name');
        $resp = $submit_model->getAllSubmit($where['where'], $where['limit'], $where['offset']);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $submit_model);
    }

    public function getTheSubmit()
    {
        $submit_model = new SubmitModel();
        $req = input('post.');
        if(!isset($req['id'])){
            return apiReturn(CODE_ERROR, '请填写id', '');
        }
        $resp = $submit_model->getTheSubmit( $req['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function reJudge()
    {
        $req = input('post.');
        $submit_model = new SubmitModel();
        if(!isset($req['id'])){
            return apiReturn(CODE_ERROR, '请填写重新评测的id', '');
        }
        if(!is_array($req['id'])){
            return apiReturn(CODE_ERROR, '请按规则提交', '');
        }
        $problems = $req['id'];
        $submit_url = config('wutoj_config.submit_url');
        $length = count($submit_url);
        foreach ($problems as $item){
            $info = $submit_model->getTheSubmit($item);
            if ($info['code'] !== CODE_SUCCESS) {
                return apiReturn($info['code'], $info['msg'], $info['data']);
            }
            $info = $info['data'][0];

            // post to the random judger
            post($submit_url[mt_rand(0, $length - 1)], json_encode(array(
                'id' => (string)$info['data'],
                'pid' => (string)$req['problem_id'],
                'env' => (string)config('wutoj_config.environment'),
                'source' => [
                    'language' => $req['language'],
                    'code' => $req['source_code'],
                ]
            ), true));
        }
        return apiReturn(CODE_SUCCESS, '重新评测成功', '');
    }

    public function rejudge_group()
    {
        $req = input('post.');
        $submit_model = new SubmitModel();
        $where = array();
        if ($req['problem_id'] != '') {
            $where['problem_id'] = $req['problem_id'];
        }
        if ($req['user_id'] != '') {
            $where['user_id'] = $req['user_id'];
        }
        if ($req['language'] != 'all') {
            $where['language'] = $req['language'];
        }
        if ($req['start'] != '') {
            $where['id'] = ['>=', $req['start']];
        }
        if ($req['end'] != '') {
            $where['id'] = ['<=', $req['end']];
        }
        $info = $submit_model->getSubmitGroup($where);
        if ($info['code'] !== CODE_SUCCESS) {
            return apiReturn($info['code'], $info['msg'], $info['data']);
        }
        $submits = $info['data'];
        $submit_url = config('wutoj_config.submit_url');
        $length = count($submit_url);
        foreach ($submits as $info){

            $info = $info['data'][0];

            // post to the random judger
            post($submit_url[mt_rand(0, $length - 1)], json_encode(array(
                'id' => (string)$info['data'],
                'pid' => (string)$req['problem_id'],
                'env' => (string)config('wutoj_config.environment'),
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
        return $this->fetch();
    }

    public function info()
    {
        $req = input('get.');
        $id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('id', $id);
        return $this->fetch();
    }

    //重判
    public function pending()
    {
        return $this->fetch();
    }

}
