<?php


namespace app\oj\model;


use think\Exception;
use think\facade\Cache;
use think\Model;

class RankCacheModel extends Model
{
    protected $cache_time;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->cache_time = Cache::get('wutoj_cache.rank_cache_time');
    }

    public function set_rank_cache($data, $contest_id)
    {
        try {
            $ok = Cache::store('redis')->set($contest_id, $data, $this->cache_time);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '更新排行榜失败', 'data' => $data];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '更新排行榜成功', 'data' => $data];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }

    public function get_rank_cache($contest_id)
    {
        try {
            $ok = Cache::store('redis')->get($contest_id);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '获取排行榜失败', 'data' => ''];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '获取排行榜成功', 'data' => $ok];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }
}