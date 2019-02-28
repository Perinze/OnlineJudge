<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 16:08
 */

namespace app\oj\model;


use think\Model;

class GroupModel extends Model
{
    protected $table = 'group';

    public function get_all_group()
    {
        try{
            $info = $this->select();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else{
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function get_the_group($id)
    {
        try{
            $info = $this->where('id', $id)->find();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else{
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }
}