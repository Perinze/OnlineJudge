<?php

namespace app\oj\controller;

use app\index\widget\Token;
use app\oj\model\KnowledgeModel;
use app\oj\model\KnowledgeRelationModel;
use app\oj\model\KnowledgeProblemModel;
use app\oj\model\KnowledgeTagModel;
use app\oj\model\KnowledgeUserModel;
use app\oj\validate\KnowledgeValidate;
use think\composer\ThinkExtend;
use think\response\Json;

class Knowledge extends Base {

    /**
     * @usage 获取所有知识点
     * @method get
     * @param void
     * @return json
     */
    public function getAllKnowledge() {
        $knowledgeModel = new KnowledgeModel();
        $resp = $knowledgeModel->getKnowledge("");
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 模糊查询知识点
     * @method get
     * @param string knowledge
     * @return json
     */
    public function getKnowledgeByKey() {
        $req = input('get.');
        $knowledgeModel = new KnowledgeModel();
        $knowledge = isset($req['knowledge'])?$req['knowledge']:'';
        $resp = $knowledgeModel->getKnowledge($knowledge);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 精确查询知识点
     * @method get
     * @param string knowledge
     * @return json
     */
    public function getSpecificKnowledge() {
        $req = input('get.');
        $knowledgeModel = new KnowledgeModel();
        $knowledge = isset($req['knowledge'])?$req['knowledge']:'';
        $resp = $knowledgeModel->getSpecificKnowledge($knowledge);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 添加知识点
     * @method post
     * @param string knowledge
     * @return json
     */
    public function addKnowledge() {
        $req = input('post.');
        $knowledgeModel = new KnowledgeModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('add_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge']
        ];
        $resp = $knowledgeModel->addKnowledge($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 删除知识点
     * @method post
     * @param string knowledge
     * @return json
     */
    public function deleteKnowledge() {
        $req = input('post.');
        $knowledgeModel = new KnowledgeModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('delete_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge']
        ];
        $resp = $knowledgeModel->deleteKnowledge($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 添加知识点关系
     * @method post
     * @param string knowledge
     * @param string pre_knowledge
     * @param boolean is_core
     * @return json
     */
    public function addKnowledgeRelation() {
        $req = input('post.');
        $knowledgeRelationModel = new KnowledgeRelationModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('add_knowledge_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge'],
            'pre_name' => $req['pre_knowledge'],
            'is_core' => isset($req['is_core'])?$req['is_core']:0
        ];
        $resp = $knowledgeRelationModel->addRelation($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 删除知识点关系
     * @method post
     * @param string knowledge
     * @param string pre_knowledge
     * @return json
     */
    public function deleteKnowledgeRelation() {
        $req = input('post.');
        $knowledgeRelationModel = new KnowledgeRelationModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('delete_knowledge_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge'],
            'pre_name' => $req['pre_knowledge'],
        ];
        $resp = $knowledgeRelationModel->deleteRelation($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 获取前置知识点
     * @method get
     * @param string knowledge
     * @param boolean core_only
     * @return json
     */
    public function getPreKnowledge() {
        $req = input('get.');
        $knowledgeRelationModel = new KnowledgeRelationModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('get_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $knowledge = $req['knowledge'];
        $core_only = isset($req['core_only'])?$req['core_only']:0;
        $resp = $knowledgeRelationModel->getPreKnowledge($knowledge, $core_only);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 获取后置知识点
     * @method get
     * @param string knowledge
     * @param boolean core_only
     * @return json
     */
    public function getAfterKnowledge() {
        $req = input('get.');
        $knowledgeRelationModel = new KnowledgeRelationModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('get_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $knowledge = $req['knowledge'];
        $core_only = isset($req['core_only'])?$req['core_only']:0;
        $resp = $knowledgeRelationModel->getAfterKnowledge($knowledge, $core_only);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 切换知识点对为必须
     * @method post
     * @param string knowledge
     * @param string pre_knowledge
     * @return json
     */
    public function setKnowledgeRelationCore() {
        $req = input('post.');
        $knowledgeRelationModel = new KnowledgeRelationModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('set_knowledge_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge'],
            'pre_name' => $req['pre_knowledge']
        ];
        $resp = $knowledgeRelationModel->setCore($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 切换知识点对为必须
     * @method post
     * @param string knowledge
     * @param string pre_knowledge
     * @return json
     */
    public function unsetKnowledgeRelationCore() {
        $req = input('post.');
        $knowledgeRelationModel = new KnowledgeRelationModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('set_knowledge_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge'],
            'pre_name' => $req['pre_knowledge']
        ];
        $resp = $knowledgeRelationModel->unsetCore($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 获取知识点的问题列表
     * @method get
     * @param string knowledge
     * @param boolean core_only
     * @return json
     */
    public function getProblemByKnowledge() {
        $req = input('get.');
        $problemKnowledgeModel = new KnowledgeProblemModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('get_problem_by_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $knowledge = $req['knowledge'];
        $core_only = isset($req['core_only'])?$req['core_only']:0;
        $resp = $problemKnowledgeModel->getProblemByKnowledge($knowledge, $core_only);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 获取问题的知识点列表
     * @method get
     * @param string problem
     * @param boolean core_only
     * @return json
     */
    public function getKnowledgeByProblem() {
        $req = input('get.');
        $problemKnowledgeModel = new KnowledgeProblemModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('get_knowledge_by_problem')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $problem = $req['problem'];
        $core_only = isset($req['core_only'])?$req['core_only']:0;
        $resp = $problemKnowledgeModel->getKnowledgeByProblem($problem, $core_only);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 添加问题知识点关系
     * @method post
     * @param string problem
     * @param string knowledge
     * @param boolean is_core
     * @return json
     */
    public function addProblemKnowledgeRelation() {
        $req = input('post.');
        $problemKnowledgeModel = new KnowledgeProblemModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('handle_knowledge_problem_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'problem_id' => $req['problem'],
            'knowledge' => $req['knowledge'],
            'is_core' => isset($req['is_core'])?$req['is_core']:0
        ];
        $resp = $problemKnowledgeModel->addRelation($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 删除问题知识点关系
     * @method post
     * @param string problem
     * @param string knowledge
     * @return json
     */
    public function deleteProblemKnowledgeRelation() {
        $req = input('post.');
        $problemKnowledgeModel = new KnowledgeProblemModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('handle_knowledge_problem_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'problem_id' => $req['problem'],
            'knowledge' => $req['knowledge'],
        ];
        $resp = $problemKnowledgeModel->deleteRelation($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 设置问题知识点关系为必要
     * @method post
     * @param string problem
     * @param string knowledge
     * @return json
     */
    public function setProblemKnowledgeRelationCore() {
        $req = input('post.');
        $problemKnowledgeModel = new KnowledgeProblemModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('handle_knowledge_problem_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'problem_id' => $req['problem'],
            'knowledge' => $req['knowledge'],
        ];
        $resp = $problemKnowledgeModel->setCore($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 设置问题知识点关系为不必要
     * @method post
     * @param string problem
     * @param string knowledge
     * @return json
     */
    public function unsetProblemKnowledgeRelationCore() {
        $req = input('post.');
        $problemKnowledgeModel = new KnowledgeProblemModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('handle_knowledge_problem_relation')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'problem_id' => $req['problem'],
            'knowledge' => $req['knowledge'],
        ];
        $resp = $problemKnowledgeModel->unsetCore($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 获取用户所有进行中的知识点
     * @method get
     * @param int user_id
     * @return json
     */
    public function getUserAllDoingKnowledge() {
        $req = input('get.');
        $userKnowledgeModel = new KnowledgeUserModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('user_all_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $resp = $userKnowledgeModel->getAllDoingKnowledge($req['user_id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 获取用户所有完成的知识点
     * @method get
     * @param int user_id
     * @return json
     */
    public function getUserAllDoneKnowledge() {
        $req = input('get.');
        $userKnowledgeModel = new KnowledgeUserModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('user_all_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $resp = $userKnowledgeModel->getAllDoneKnowledge($req['user_id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 获取用户某知识点的状态
     * @method get
     * @param int user_id
     * @param string knowledge
     * @return Json
     */
    public function getUserKnowledgeStatus() {
        $req = input('get.');
        $userKnowledgeModel = new KnowledgeUserModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('user_specific_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $resp = $userKnowledgeModel->getKnowledgeStatus($req['user_id'], $req['knowledge']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 添加正在进行的知识点
     * @method post
     * @param int user_id
     * @param string knowledge
     * @return Json
     */
    public function addUserDoingKnowledge() {
        $req = input('post.');
        $userKnowledgeModel = new KnowledgeUserModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('user_specific_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $resp = $userKnowledgeModel->addDoingKnowledge($req['user_id'], $req['knowledge']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 添加完成的知识点
     * @method post
     * @param int user_id
     * @param string knowledge
     * @return Json
     */
    public function addUserDoneKnowledge() {
        $req = input('post.');
        $userKnowledgeModel = new KnowledgeUserModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('user_specific_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $resp = $userKnowledgeModel->addDoneKnowledge($req['user_id'], $req['knowledge']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 获取成就点
     * @method get
     * @param int user_id
     * @return Json
     */
    public function getUserKnowledgePoint() {
        $req = input('get.');
        $userKnowledgeModel = new KnowledgeUserModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('user_all_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $resp = $userKnowledgeModel->getAllDoneKnowledge($req['user_id']);
        $score = 0;
        foreach ($resp['data'] as $item) {
            $score += $item->score;
        }
        return apiReturn($resp['code'], $resp['msg'], ['score' => $score]);
    }

    /**
     * @usage 获取标签
     * @method get
     * @param int knowledge_id
     * @return Json
     */
    public function getAllTag() {
        $req = input('get.');
        $knowledgeTagModel = new KnowledgeTagModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('knowledge_id')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $resp = $knowledgeTagModel->getKnowledgeTag($req['knowledge_id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }
}