<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/31
 * Time: 15:01
 */

namespace app\oj\controller;


use app\oj\model\CommonModel;
use app\oj\model\UserModel;

class Upload extends Base
{
    private $validate = [
        'size' => 500000,
        'ext' => 'jpg,png,gif,jpeg',
    ];
    private $path = '../uploads/image/';
    private $data_path = '../uploads/data';

    public function upload_image()
    {
        $user_id = session('user_id');
        if(empty($user_id)){
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $file = request()->file('image');
        if(empty($file)){
            return apiReturn(CODE_ERROR, '请上传图片', '');
        }
        $info = $file->validate($this->validate)->move($this->path);
        if ($info) {
            $url = $this->path.$info->getSaveName();
            return apiReturn(CODE_SUCCESS, '上传成功', $url);
        }
        return apiReturn(CODE_ERROR, $file->getError(), '');
    }
    public function upload_avatar()
    {
        $user_id = session('user_id');
        if(empty($user_id)){
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $req = input('post.');
        if(!isset($req['url'])){
            return apiReturn(CODE_ERROR, '未填写头像url', '');
        }
        $user_model = new UserModel();
        $resp = $user_model->editUser($user_id, ['avatar' => $req['url']]);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * 上传题目数据接口, 支持多组数据
     */
    public function upload_data_file()
    {
        $common_model = new CommonModel();

        $resp = $common_model->checkIdentity();
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }

        $files = request()->file('');
        $req = input('post.');
        $data = [];
        foreach($files['file'] as $file) {
            //halt($file);
            $info = $file->move($this->path);
            if ($info != VALIDATE_PASS) {
                return apiReturn(CODE_ERROR, $file->getError(), '');
            } else {
                $file_path = $this->data_path . $info->getSaveName();
                $str = file_get_contents($file_path);
                //$str = str_replace("\r\n", '\n', $str);
                $filename = substr($file->getInfo()['name'], 0, strpos($file->getInfo()['name'], '.'));
                if (!isset($data[$filename])) {
                    if ($info->getExtension() === 'in') {
                        $data[$filename] = array(
                            'in' => $str,
                            'out' => ''
                        );
                    } else {
                        $data[$filename] = array(
                            'in' => '',
                            'out' => $str
                        );
                    }
                } else {
                    if ($info->getExtension() === 'in') {
                        $data[$filename]['in'] = $str;
                    } else {
                        $data[$filename]['out'] = $str;
                    }
                }
            }
        }

        if(!isset($req['sqj'])){
            $re_data = array(
                'type' => 'Normal',
                'time_limit' => isset($req['time']) ? $req['time'] : 1000000000,
                'memory_limit' => isset($req['memory']) ? $req['memory'] : 33554432,
                'test_cases' => array()
            );
        } else {
            $re_data = array(
                'type' => 'Special',
                'time_limit' => isset($req['time']) ? $req['time'] : 1000000000,
                'memory_limit' => isset($req['memory']) ? $req['memory'] : 33554432,
                'spj' => array(
                    'language' => $req['language'],
                    'code' => $req['code']
                ),
                'test_cases' => array()
            );
        }
        foreach ($data as $item){
            $re_data['test_cases'][] = array(
                'input' => $item['in'],
                'answer' => $item['out'],
            );
        }

        // 数据文件输出
        $json_data = json_encode($re_data);
        $json_data = str_replace('\r\n', '\n', $json_data);
        file_put_contents($this->data_path . $req['problem_id'] . '.json', $json_data);
    }
}