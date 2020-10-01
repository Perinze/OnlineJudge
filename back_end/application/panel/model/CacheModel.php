<?php

namespace app\panel\model;

use think\Exception;
use think\facade\Cache;
use think\Model;

class CacheModel extends Model {
    protected $cache_time;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->cache_time = 5;
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