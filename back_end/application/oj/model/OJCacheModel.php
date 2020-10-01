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

    public function set_password_cache($data, $user_id)
    {
        try {
            $ok = Cache::store('redis')->set('find_password'.$user_id, $data, VALID_TIME);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '更新找回密码信息失败', 'data' => $data];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '更新找回密码信息成功', 'data' => $data];
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

    public function set_update_cache($data)
    {
        try {
            $ok = Cache::store('redis')->set('update'.$data, $data, VALID_TIME * 6 * 24);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '更新用户缓存失败', 'data' => $data];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '更新用户缓存成功', 'data' => $data];
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

    public function get_password_cache($user_id)
    {
        try {
            $ok = Cache::store('redis')->get('find_password'.$user_id);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '获取找回密码信息失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取找回密码信息成功', 'data' => $ok];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }

    public function get_update_cache($data)
    {
        try {
            $ok = Cache::store('redis')->get('update'.$data);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '获取用户缓存失败', 'data' => $data];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取用户缓存成功', 'data' => $data];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }


    /**
     * @param array $data
     * @param int $problem_id
     * @param boolean core_only
     * @return array ['code', 'msg', 'data']
     */
    public function setProblemKnowledgeCache($data, $problem_id, $core_only) {
        try {
            $ok = Cache::store('redis')->set("problem_knowledge".$problem_id.$core_only, $data, VALID_TIME);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '更新题目知识点信息失败', 'data' => $data];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '更新题目知识点信息成功', 'data' => $data];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @param int $problem_id
     * @param boolean $core_only
     * @return array ['code', 'msg', 'data']
     */
    public function getProblemKnowledgeCache($problem_id, $core_only) {
        try {
            $ok = Cache::store('redis')->get("problem_knowledge".$problem_id.$core_only);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '获取题目知识点信息失败', 'data' => []];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取题目知识点信息成功', 'data' => $ok];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @param int $problem_id
     * @param boolean $core_only
     * @return array ['code', 'msg', 'data']
     */
    public function unsetProblemKnowledgeCache($problem_id, $core_only) {
        try {
            $ok = Cache::store('redis')->rm("problem_knowledge".$problem_id.$core_only);
            if (!$ok) {
                return ['code' => CODE_ERROR, 'msg' => '删除题目知识点信息失败', 'data' => $ok];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '删除题目知识点信息成功', 'data' => $ok];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => 'redis异常', 'data' => $e->getMessage()];
        }
    }
}