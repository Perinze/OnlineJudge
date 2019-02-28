<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/9/26
 * Time: 10:42
 */
namespace app\index\model;

use think\exception\DbException;
use think\Model;

class ProblemModel extends Model{
    protected $table = 'problem';

    public function login($username, $password)
    {
        try{
            $info = $this->where($username)->find();
            if($info){
                if($info['pwd'] != $password){
                    return ['code' => -1, 'msg' => '失败', 'data' => $info];
                }
                else{
                    return ['code' => 1, 'msg' => '成功', 'data' => $info];
                }
            }
            else{
                return ['code' => -1, 'msg' => '无此用户', 'data' => $info];
            }
        }catch (DbException $e) {
            return false;
        }
        return false;
    }

}