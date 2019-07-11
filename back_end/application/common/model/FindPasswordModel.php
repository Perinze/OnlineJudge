<?php


namespace app\common\model;


use think\Exception;
use think\Model;

class FindPasswordModel extends Model
{
    protected $table = 'find_password';
    // TODO 验证
    public function create_token($user_name)
    {
        $codeSet  = '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
        $length = 10;
        try{
            $info = $this->where([['nick' , '=', $user_name], ['state' , '=', 0]])->select()->toArray();
            if(!empty($info)){
                foreach ($info as &$k){
                    $k['state'] = 1;
                }
                $resp = $this->saveAll($info);
                if(empty($resp)){
                    return ['code' => CODE_ERROR, 'msg' => '生成失败', 'data' => ''];
                }
            }
            $code = '';
            for($i = 0; $i < $length; $i++){
                $code = $code.$codeSet[mt_rand(0, strlen($codeSet) - 1)];
            }
            $resp = $this->strict(false)->insert(array(
               'nick' => $user_name,
               'token' => $code,
            ));
            if($resp !== 1){
                return ['code' => CODE_ERROR, 'msg' => '生成失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '生成成功', 'data' => $code];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function check_token($user_id, $token)
    {

    }
}