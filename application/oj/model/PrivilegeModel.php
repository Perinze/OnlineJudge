<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午1:01
 */
namespace app\oj\model;

use think\Exception;
use think\model;

class PrivilegeModel extends Model {

    //uncheck

    protected $table = 'privilege';

    public function addPrivilege($user_id, $privilege) {
        try{
            $res = $this->insert(['user_id'=>$user_id,'privilege'=>$privilege]);
            if($res){
                return ['code'=>CODE_SUCCESS,'msg'=>'添加成功','data'=>''];
            }else{
                return ['code'=>CODE_ERROR,'msg'=>'添加失败','data'=>''];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR,'msg'=>'数据库错误','data'=>$e->getMessage()];
        }
    }

    public function delePrivilege($user_id, $privilege) {
        try{
            $res = $this->where(['user_id'=>$user_id,'privilege'=>$privilege])->delete();
            if($res){
                return ['code'=>CODE_SUCCESS,'msg'=>'删除成功','data'=>''];
            }else{
                return ['code'=>CODE_ERROR,'msg'=>'删除失败','data'=>''];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR,'msg'=>'数据库错误','data'=>$e->getMessage()];
        }
    }

    public function searchPrivilege($user_id, $privilege) {
        try{
            $res = $this->where(['user_id'=>$user_id,'privilege'=>$privilege])->find();
            if($res){
                return ['code'=>CODE_SUCCESS,'msg'=>'权限验证成功','data'=>''];
            }else{
                return ['code'=>CODE_ERROR,'msg'=>'不存在该权限','data'=>''];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR,'msg'=>'数据库错误','data'=>$e->getMessage()];
        }
    }

    public function searchOnesAllPrivilege($user_id) {
        try{
            $res = $this->where('user_id',$user_id)->select();
            if($res){
                return ['code'=>CODE_SUCCESS,'msg'=>'查找成功','data'=>$res];
            }else{
                return ['code'=>CODE_ERROR,'msg'=>'查找失败','data'=>''];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR,'msg'=>'数据库错误','data'=>$e->getMessage()];
        }
    }
}