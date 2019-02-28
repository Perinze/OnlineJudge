<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 16:08
 */
namespace app\oj\model;
use think\Exception;
use think\Model;

class GroupModel extends Model
{

    // uncheck

    protected $table = 'group';

    public function get_all_group() {
        try{
            $info = $this->select();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else{
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function get_the_group($group_id) {
        try{
            $info = $this->where('group_id', $group_id)->find();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else{
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function newGroup($data) {
        try{
            $res = $this->insert($data);
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'创建分组成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'创建分组失败', 'data'=>$this->getError()];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    public function editGroup($group_id, $data) {
        try{
            $res = $this->where('group_id',$group_id)->update($data);
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'修改分组成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'修改分组失败', 'data'=>$this->getError()];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    public function deleGroup($group_id) {
        try{
            $res = $this->where('group_id',$group_id)->delete();
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'删除分组成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'删除分组失败', 'data'=>$this->getError()];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }
}