<?php


namespace app\panel\controller;


use app\panel\model\CacheModel;
use app\panel\model\KnowledgeModel;
use app\panel\model\KnowledgeRelationModel;
use app\panel\model\ProblemKnowledgeModel;

class Knowledge extends Base
{
    public function getAllKnowledge() {
        $knowledge_model = new KnowledgeModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'group_name');
        $resp = $knowledge_model->getKnowledge("");
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $knowledge_model);
    }

    public function searchKnowledge() {
        $knowledge_model = new KnowledgeModel();
        $name = input('get.name');
        $msg = $knowledge_model->getKnowledge($name);
        return apiReturn($msg['code'], $msg['msg'], $msg['data'], 200);
    }

    public function deleteKnowledge() {
        $knowledge_model = new KnowledgeModel();
        $name = input('get.name');
        $knowledge_model->deleteKnowledge(['name' => $name]);
        $this->redirect('panel/knowledge/index');
    }

    public function addKnowledge() {
        $knowledge_model = new KnowledgeModel();
        $name = input('get.name');
        $msg = $knowledge_model->addKnowledge(['name' => $name]);
        return apiReturn($msg['code'], $msg['msg'], $msg['data'], 200);
    }

    public function getPreKnowledge() {
        $knowledge_relation_model = new KnowledgeRelationModel();
        $req = input('post.aoData');
        $name = input('post.knowledge_name');
        $where = aoDataFormat($req, 'group_name');
        $resp = $knowledge_relation_model->getPreKnowledge($name);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $knowledge_relation_model);
    }

    public function deleteKnowledgeRelation() {
        $knowledge_relation_model = new KnowledgeRelationModel();
        $name = input('get.name');
        $pre_name = input('get.pre');
        $knowledge_relation_model->deleteRelation(['name' => $name, 'pre_name' => $pre_name]);
        $this->redirect('panel/knowledge/relation', ['name' => $name]);
    }

    public function switchKnowledgeRelation() {
        $knowledge_relation_model = new KnowledgeRelationModel();
        $name = input('get.name');
        $pre_name = input('get.pre');
        $knowledge_relation_model->switchCore(['name' => $name, 'pre_name' => $pre_name]);
        $this->redirect('panel/knowledge/relation', ['name' => $name]);
    }

    public function addKnowledgeRelation() {
        $knowledge_relation_model = new KnowledgeRelationModel();
        $name = input('post.name');
        $knowledge = input('post.knowledge');
        if (isset($knowledge['is_core'])) {
            $is_core = true;
        } else {
            $is_core = false;
        }
        foreach ($knowledge as $item) {
            if ($item == "is_core") continue;
            $data = [
                'name' => $name,
                'pre_name' => $item,
                'is_core' => $is_core
            ];
            $knowledge_relation_model->addRelation($data);
        }
        return apiReturn(CODE_SUCCESS, 'ok', [], 200);
    }

    public function addProblemKnowledgeRelation() {
        $problem_knowledge_model = new ProblemKnowledgeModel();
        $problem_id = input('post.problem_id');
        $knowledge = input('post.knowledge');
        if (isset($knowledge['is_core'])) {
            $is_core = true;
        } else {
            $is_core = false;
        }
        foreach ($knowledge as $item) {
            if ($item == "is_core") continue;
            $data = [
                'problem_id' => $problem_id,
                'knowledge' => $item,
                'is_core' => $is_core
            ];
            $problem_knowledge_model->addRelation($data);
        }
        return apiReturn(CODE_SUCCESS, 'ok', [], 200);
    }

    public function switchProblemKnowledgeRelation() {
        $problem_knowledge_model = new ProblemKnowledgeModel();
        $knowledge = input('get.knowledge');
        $problem_id = input('get.problem_id');
        $data = [
            'problem_id' => $problem_id,
            'knowledge' => $knowledge
        ];
        $problem_knowledge_model->switchCore($data);
        $this->redirect('panel/knowledge/problem', ['problem_id' => $problem_id]);
    }

    public function deleteProblemKnowledgeRelation() {
        $problem_knowledge_model = new ProblemKnowledgeModel();
        $knowledge = input('get.knowledge');
        $problem_id = input('get.problem_id');
        $data = [
            'problem_id' => $problem_id,
            'knowledge' => $knowledge
        ];
        $problem_knowledge_model->deleteRelation($data);
        $this->redirect('panel/knowledge/problem', ['problem_id' => $problem_id]);
    }

    public function getProblemKnowledge() {
        $problem_knowledge_model = new ProblemKnowledgeModel();
        $req = input('post.aoData');
        $problem_id = input('post.problem_id');
        $where = aoDataFormat($req, 'group_name');
        $resp = $problem_knowledge_model->getKnowledgeByProblem($problem_id);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $problem_knowledge_model);

    }

    public function relation()
    {
        return $this->fetch('relation', ['name' => input('get.name')]);
    }

    public function index()
    {
        return $this->fetch('index');
    }

    public function problem()
    {
        return $this->fetch('problem', ['problem_id' => input('get.problem_id')]);
    }
}