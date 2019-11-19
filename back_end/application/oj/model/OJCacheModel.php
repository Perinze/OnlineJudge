<?php


namespace app\oj\model;


use think\Exception;
use think\facade\Cache;
use think\Model;

class OJCacheModel extends Model
{
    protected $cache_time;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->cache_time = config('wutoj_config.rank_cache_time');
    }

    public function set_user_rank_cache($data)
    {
        try {
            $ok = Cache::store('redis')->set(config('wutoj_config.user_rank_cache'), $data, $this->cache_time * 12);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '更新用户排行榜失败', 'data' => $data];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '更新用户排行榜成功', 'data' => $data];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }
    public function set_rank_cache($data, $contest_id)
    {
        try {
            $ok = Cache::store('redis')->set('contest'.$contest_id, $data, $this->cache_time);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '更新排行榜失败', 'data' => $data];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '更新排行榜成功', 'data' => $data];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }

    public function set_submit_cache($data)
    {
        try {
            $ok = Cache::store('redis')->set('submit'.$data, $data, config('wutoj_config.interval_time'));
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '更新提交缓存失败', 'data' => $data];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '更新提交缓存成功', 'data' => $data];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }
    public function get_user_rank_cache()
    {
        try {
            $ok = Cache::store('redis')->get(config('wutoj_config.user_rank_cache'));
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '获取用户排行榜失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取用户排行榜成功', 'data' => $ok];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }

    public function get_rank_cache($contest_id)
    {
        try {
            $ok = Cache::store('redis')->get('contest'.$contest_id);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '获取排行榜失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取排行榜成功', 'data' => $ok];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }

    public function get_submit_cache($data)
    {
        try {
            $ok = Cache::store('redis')->get('submit'.$data);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '获取提交缓存失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取提交缓存成功', 'data' => $ok];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }
}