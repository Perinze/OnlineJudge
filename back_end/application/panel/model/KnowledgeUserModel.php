<?php

namespace app\panel\model;

use think\exception\DbException;
use think\Model;

class KnowledgeUserModel extends Model
{
    protected $table = 'knowledge__user';

    /**
     * @usage 获取所有正在进行的知识点
     * @param int $user_id
     * @return array ['code', 'msg', 'data']
     */
    public function getAllDoingKnowledge($user_id) {
        try {
            $result = $this->where(['user_id' => $user_id])->find();
            $returnData = json_decode($result['knowledge_doing']);
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $returnData];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => $e->getMessage(), 'data' => []];
        }
    }

    /**
     * @usage 获取所有已完成的知识点
     * @param $user_id
     * @return array ['code', 'msg', 'data']
     */
    public function getAllDoneKnowledge($user_id) {
        try {
            $result = $this->where(['user_id' => $user_id])->find();
            $returnData = json_decode($result['knowledge_done']);
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $returnData];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => $e->getMessage(), 'data' => []];
        }
    }

    /**
     * @usage 判断知识点状态
     * @param int $user_id
     * @param string $knowledge
     * @return array ['code', 'msg', 'data']
     */
    public function getKnowledgeStatus($user_id, $knowledge) {
        try {
            $result = $this->where(['user_id' => $user_id])->find();
            $knowledge_doing = json_decode($result['knowledge_doing']);
            $knowledge_done = json_decode($result['knowledge_done']);
            if ($this->checkDoingKnowledge($knowledge_doing, $knowledge)) {
                return ['code' => CODE_SUCCESS, 'msg' => '知识点进行中', 'data' => 0];
            } else if ($this->checkDoneKnowledge($knowledge_done, $knowledge)) {
                return ['code' => CODE_SUCCESS, 'msg' => '知识点已完成', 'data' => 1];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '知识点未开始', 'data' => -1];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => $e->getMessage(), 'data' => []];
        }
    }

    /**
     * @usage 添加进行的知识点
     * @param int $user_id
     * @param string $knowledge
     * @return array ['code', 'msg', 'data']
     */
    public function addDoingKnowledge($user_id, $knowledge) {
        try {
            $knowledgeRelationModel = new KnowledgeRelationModel();
            $result = $this->processData($user_id, $knowledge);
            if ($result['code'] != CODE_SUCCESS) {
                return $result;
            } else {
                $knowledge_doing = $result['data']['knowledge_doing'];
                $knowledge_done = $result['data']['knowledge_done'];
            }
            if ($this->checkDoneKnowledge($knowledge_done, $knowledge) == true) {
                return ['code' => CODE_ERROR, 'msg' => '知识点已完成', 'data' => []];
            }
            if ($this->checkDoingKnowledge($knowledge_doing, $knowledge) == true) {
                return ['code' => CODE_ERROR, 'msg' => '知识点进行中', 'data' => []];
            }
            $pre_knowledge = $knowledgeRelationModel->getPreKnowledge($knowledge, true)['data'];
            foreach ($pre_knowledge as $item) {
                if ($this->checkDoneKnowledge($knowledge_done, $item['name']) == false) {
                    return ['code' => CODE_ERROR, 'msg' => '存在前置知识点未完成', 'data' => $item];
                }
            }
            array_push($knowledge_doing, $knowledge);
            $result = $this->where(['user_id' => $user_id])->update(['knowledge_doing' => (array)$knowledge_doing]);
            return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => $result];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => $e->getMessage(), 'data' => []];
        }
    }


    /**
     * @usage 添加完成知识点
     * @param int $user_id
     * @param string $knowledge
     * @return array ['code', 'msg', 'data']
     */
    public function addDoneKnowledge($user_id, $knowledge) {
        try {
            $submitModel = new SubmitModel();
            $problemKnowledgeModel = new KnowledgeProblemModel();
            $result = $this->processData($user_id, $knowledge);
            if ($result['code'] != CODE_SUCCESS) {
                return $result;
            } else {
                $knowledge_doing = $result['data']['knowledge_doing'];
                $knowledge_done = $result['data']['knowledge_done'];
            }
            if ($this->checkDoneKnowledge($knowledge_done, $knowledge) == true) {
                return ['code' => CODE_ERROR, 'msg' => '知识点已完成', 'data' => []];
            }
            if ($this->checkDoingKnowledge($knowledge_doing, $knowledge) == false) {
                return ['code' => CODE_ERROR, 'msg' => '知识点未进行', 'data' => []];
            }
            $problems = $problemKnowledgeModel->getProblemByKnowledge($knowledge, true)['data'];
            foreach ($problems as $problem) {
                $problem_id = $problem['problem_id'];
                $where = [
                    'user_id' => $user_id,
                    'problem_id' => $problem_id,
                    'status' => 'AC'
                ];
                $result = $submitModel->where($where)->find();
                if (!$result) {
                    return ['code' => CODE_ERROR, 'msg' => '有题目未完成', 'data' => $problem];
                }
            }
            $knowledge_doing = array_diff($knowledge_doing, [$knowledge]);
            array_push($knowledge_done, ['name' => $knowledge, 'score' => 100]);
            $insertData = [
                'knowledge_doing' => $knowledge_doing,
                'knowledge_done' => $knowledge_done
            ];
            $result = $this->where(['user_id' => $user_id])->update($insertData);
            return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $result];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => $e->getMessage(), 'data' => []];
        }
    }

    /**
     * @usage 删除知识点
     * @param string $knowledge
     * @return boolean
     */
    public function deleteKnowledge($knowledge) {
        try {
            $data = $this->select();
            foreach ($data as $item) {
                $id = $item['id'];
                $knowledge_doing = json_decode($item['knowledge_doing']);
                $knowledge_done = json_decode($item['knowledge_done']);
                $new_knowledge_doing = array();
                $new_knowledge_done = array();
                foreach ($knowledge_doing as $doing) {
                    if ($doing == $knowledge) continue;
                    array_push($new_knowledge_doing, $doing);
                }
                foreach ($knowledge_done as $done) {
                    if ($done->name == $knowledge) continue;
                    array_push($new_knowledge_done, $done);
                }
                $insertData = [
                    'knowledge_doing' => $new_knowledge_doing,
                    'knowledge_done' => $new_knowledge_done
                ];
                $this->where(['id' => $id])->update($insertData);
                return true;
            }
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @usage 处理数据
     * @param int $user_id
     * @param string $knowledge
     * @return array ['code', 'msg', 'data']
     */
    public function processData($user_id, $knowledge) {
        try {
            $userModel = new UserModel();
            $knowledgeModel = new KnowledgeModel();
            $knowledgeRelationModel = new KnowledgeRelationModel();
            $result = $userModel->searchUserById($user_id);
            if ($result['code'] != CODE_SUCCESS) {
                return ['code' => CODE_ERROR, 'msg' => '用户不存在', 'data' => []];
            }
            $result = $knowledgeModel->getSpecificKnowledge($knowledge);
            if ($result['code'] != CODE_SUCCESS) {
                return ['code' => CODE_ERROR, 'msg' => '知识点不存在', 'data' => []];
            }
            $result = $this->where(['user_id' => $user_id])->find();
            if (!$result) {
                $insertData = [
                    'user_id' => $user_id,
                    'knowledge_doing' => array(),
                    'knowledge_done' => array()
                ];
                $this->insertGetId($insertData);
                $knowledge_doing = $knowledge_done = array();
            } else {
                $knowledge_doing = json_decode($result['knowledge_doing']);
                $knowledge_done = json_decode($result['knowledge_done']);
            }
            $data = [
                'knowledge_doing' => $knowledge_doing,
                'knowledge_done' => $knowledge_done
            ];
            return ['code' => CODE_SUCCESS, 'msg' => '处理成功', 'data' => $data];
        }catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => $e->getMessage(), 'data' => []];
        }
    }

    /**
     * @usage 查找正在进行中是否包含某知识点
     * @param array $doing
     * @param string $knowledge
     * @return boolean
     */
    public function checkDoingKnowledge($doing, $knowledge) {
        foreach ($doing as $item) {
            if ($item == $knowledge) {
                return true;
            }
        }
        return false;
    }

    /**
     * @usage 查找已完成中是否包含某知识点
     * @param array $done
     * @param string $knowledge
     * @return boolean
     */
    public function checkDoneKnowledge($done, $knowledge) {
        foreach ($done as $item) {
            if ($item->name == $knowledge) {
                return true;
            }
        }
        return false;
    }
}