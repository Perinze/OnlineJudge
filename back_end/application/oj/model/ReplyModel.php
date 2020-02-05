<?php


namespace app\oj\model;


use think\Exception;
use think\Model;

class ReplyModel extends Model
{
    protected $table = 'reply';

    public function add_reply($data)
    {
        try{
            $info = $this->strict(false)->insert($data);
            if($info === false){
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function get_the_discuss($discuss_id, $page)
    {
        try{
            $page_limit = config('wutoj_config.page_limit');
            $info['data'] = $this
                ->field(['reply.id as id','reply.user_id as user_id', 'nick','discuss_id', 'content', 'time'])
                ->where('discuss_id', $discuss_id)
                ->limit($page * $page_limit, $page_limit)
                ->join('users','reply.user_id = users.user_id')
                ->select()
                ->toArray();
            $info['count'] = $this->where('discuss_id', $discuss_id)->count();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}