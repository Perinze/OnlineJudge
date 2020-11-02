<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:48
 */

namespace app\oj\model;

use think\Db;
use think\Exception;
use think\Model;

class UserModel extends Model
{
    protected $table = 'users';

    public function addUser($data)
    {
        try {
            $info = $this->where('nick', $data['nick'])->find();
            if (!empty($info)) {
                return ['code' => USERNAME_IS_EXIST, 'msg' => '该昵称已被注册', 'data' => ''];
            }
            $res = $this->strict(false)->insert($data);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function editUser($user_id = 0, $data, $nick = 0)
    {
        try {
            if($user_id !== 0){
                $info = $this->where('user_id', $user_id)->update($data);
            } else {
                $info = $this->where('nick', $nick)->update($data);
            }
            if ($info !== 0) {
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            }
            return ['code' => CODE_ERROR, 'msg' => '更新失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function searchUserById($user_id)
    {
        try {
            $content = $this
                ->field(['user_id', 'nick', 'avatar', 'realname', 'school', 'major', 'class', 'contact', 'mail', 'desc'])
                ->where('user_id', $user_id)->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function searchUserByNick($nick)
    {
        try {
            $content = $this
                ->field(['user_id', 'nick', 'avatar', 'realname', 'school', 'major', 'class', 'contact', 'mail', 'desc'])
                ->where('nick', $nick)->find();
            if (empty($content)) {
                return ['code' => CODE_ERROR, 'msg' => '用户名不存在', 'data' => $content];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function loginCheck($req)
    {
        // uncheck
        try {
            $res = $this->where([['nick', '=', $req['nick']], ['password', '=', $req['password']]])
                ->find();
            if ($res) {
                $res['all_problems'] = Db::table('submit')
                    ->field(['status', 'count(*) as cnt'])
                    ->where('user_id', $res['user_id'])
                    ->group('status')
                    ->select();
                $cnt = Db::table('submit')
                    ->field(['count(distinct problem_id) as cnt'])
                    ->where('user_id', $res['user_id'])
                    ->where('status', 'AC')
                    ->select();
                foreach ($res['all_problems'] as &$item){
                    if($item['status'] === 'AC'){
                        $item['cnt'] = $cnt[0]['cnt'];
                    }
                }
                return ['code' => CODE_SUCCESS, 'msg' => '登陆成功', 'data' => $res];
            }
            return ['code' => CODE_ERROR, 'msg' => '用户名或密码错误', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function user_rank($offset)
    {
        try {
            $info = $this->field(['user_id', 'nick', 'school', 'desc', 'ac_num', 'wa_num'])
                ->where('state', 0)->order('ac_num')->limit($offset, config())->select()->toArray();
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

}