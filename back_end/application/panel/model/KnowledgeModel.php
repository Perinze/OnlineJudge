<?php

namespace app\panel\model;

use think\exception\DbException;
use think\Model;

class KnowledgeModel extends Model {
    protected $table = 'knowledge';

    /**
     * @usage 获取知识点(模糊查询)
     * @param string $name
     * @return array ['code', 'msg', 'data']
     */
    public function getKnowledge($name) {
        try {
            $result = $this->where('name', 'like', '%'.$name.'%')->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取知识点
     * @param string $name
     * @return array ['code', 'msg', 'data']
     */
    public function getSpecificKnowledge($name) {
        try {
            $result = $this->where(['name' => $name])->find();
            if ($result) {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '无此知识点', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取一对知识点
     * @param array $data ['name', 'pre_name']
     * @return array ['code', 'msg', 'data']
     */
    public function getKnowledgePairID($data) {
        try {
            $msg = $this->getSpecificKnowledge($data['name']);
            if ($msg['code'] == CODE_SUCCESS) {
                $knowledge_id = $msg['data']['id'];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '知识点不存在', []];
            }
            $msg = $this->getSpecificKnowledge($data['pre_name']);
            if ($msg['code'] == CODE_SUCCESS) {
                $pre_knowledge_id = $msg['data']['id'];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '前置知识点不存在', []];
            }
            $returnData = [
                'knowledge_id'    => $knowledge_id,
                'pre_knowledge_id'=> $pre_knowledge_id
            ];
            return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $returnData];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }


    /**
     * @usage 添加知识点
     * @param array $data ['name']
     * @return array ['code', 'msg', 'data']
     */
    public function addKnowledge($data) {
        try {
            $where = ['name' => $data['name']];
            $msg = $this->where($where)->find();
            if ($msg) {
                return ['code' => CODE_ERROR, 'msg' => '已存在此知识点', 'data' => $msg];
            } else {
                $insertData = ['name' => $data['name']];
                $info = $this->insertGetId($data);
                return ['code' => CODE_SUCCESS, 'msg' => '插入成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除知识点
     * @param array $data ['name']
     * @return array ['code', 'msg', 'data']
     */
    public function deleteKnowledge($data) {
        try {
            $where = ['name' => $data['name']];
            $msg = $this->where($where)->find();
            if ($msg) {
                $info = $this->where($where)->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此知识点', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}