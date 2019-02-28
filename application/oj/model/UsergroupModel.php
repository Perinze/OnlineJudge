<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 18:04
 */

namespace app\oj\model;


use think\Model;

class UsergroupModel extends Model
{
    protected $table = 'user_group';

    public function find_group($user)
    {
        $group_model = new GroupModel();
        try{
            $info = $this->where('user', $user)->select()->toArray();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else{
                $i = 0;
                $data = array();
                foreach ($info as $k){
                    $data[$i++] = $group_model->get_the_group($info['group'])['data'];
                }
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $data];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function find_user($group)
    {
        $user_model = new UserModel();
        try{
            $info = $this->where('group', $group)->select()->toArray();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else{
                $i = 0;
                $data = array();
                foreach ($info as $k){
                    $data[$i++] = $user_model->searchUserById($info['user'])['data'];
                }
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $data];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }
}