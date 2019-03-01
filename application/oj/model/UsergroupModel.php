<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 18:04
 */

namespace app\oj\model;

use think\Exception;
use think\Model;

class UsergroupModel extends Model
{

    // TODO handle duplicated key such as '1 1' then insert '1 1'

    protected $table = 'user_group';

    public function find_group($user_id)
    {
        $group_model = new GroupModel();
        try{
            $info = $this->where('user_id', $user_id)->select()->toArray();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' =>''];
            } else{
                $i = 0;
                $data = array();
                foreach ($info as $key=>$value){
                    $a_group_res = $group_model->get_the_group($value['group_id']);
                    if($a_group_res['code']==CODE_SUCCESS){
                        if(!empty($a_group_res['data'])){
                            $data[$i]=$a_group_res['data'];
                        }else{
                            $data[$i]='分组不存在';
                        }
                    }else{
                        $data[$i]='查询错误';
                    }
                    $i++;
                }
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $data];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function find_user($group_id)
    {
        $user_model = new UserModel();
        try{
            $info = $this->where('group_id', $group_id)->select()->toArray();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            } else{
                $i = 0;
                $data = array();
                foreach ($info as $key=>$value){
                    $a_group_res = $user_model->searchUserById($value['user_id']);
                    if($a_group_res['code']==CODE_SUCCESS){
                        if(!empty($a_group_res['data'])){
                            $data[$i]=$a_group_res['data'];
                        }else{
                            $data[$i]='用户不存在';
                        }
                    }else{
                        $data[$i]='查询错误';
                    }
                    $i++;
                }
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $data];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    /**
     * @param $group_id
     * @param $user_id
     * @return array['int','string','object']
     */
    public function searchRelation($group_id, $user_id) {
        try{
            $content = $this->where(['group_id'=>$group_id, 'user_id'=>$user_id])->select()[0]; // return object
            if($content) {
                return ['code' => CODE_SUCCESS, 'msg' => '成功', 'data' => $content];
            }else{
                return ['code' => CODE_ERROR, 'msg' => '失败', 'data' => ''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库异常', 'data'=>$e->getMessage()];
        }
    }

    public function addRelation($group_id, $user_id) {
        try{
            $res = $this->insert(['group_id'=>$group_id, 'user_id'=>$user_id]);
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'失败', 'data'=>''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    public function deleRelation($group_id, $user_id) {
        try{
            $res = $this->where(['group_id'=>$group_id, 'user_id'=>$user_id])->delete();
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'失败', 'data'=>''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }
}