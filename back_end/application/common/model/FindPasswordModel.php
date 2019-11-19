<?php


namespace app\common\model;


use app\oj\model\OJCacheModel;
use think\Exception;
use think\Model;
use think\Session;

class FindPasswordModel extends Model
{
    protected $table = 'find_password';
    // TODO 验证
    public function create_token($user_name)
    {
        $oj_cache_model = new OJCacheModel();
        $codeSet  = '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
        $length = 10;
        try{
            $info = $oj_cache_model->get_password_cache($user_name);
            if($info['code'] === CODE_SUCCESS){
                return ['code' => CODE_ERROR, 'msg' => '你已有验证码', 'data' => ''];
            }
            $code = '';
            for($i = 0; $i < $length; $i++){
                $code = $code.$codeSet[mt_rand(0, strlen($codeSet) - 1)];
            }
            $resp = $oj_cache_model->set_password_cache($code, $user_name);
            if($resp['code'] !== CODE_SUCCESS){
                return ['code' => CODE_ERROR, 'msg' => '生成失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '生成成功', 'data' => $code];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function check_token($nick, $token)
    {
        try{
            $oj_cache_model = new OJCacheModel();
            $info = $oj_cache_model->get_password_cache($nick);
            if($info['code'] !== CODE_SUCCESS || $info['data'] !== $token){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '验证成功', 'data' => ''];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}