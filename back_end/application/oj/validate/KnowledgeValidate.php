<?php

namespace app\oj\validate;

use think\Validate;

class KnowledgeValidate extends Validate {
    protected $rule = [
        'knowledge'         => 'require',
        'pre_knowledge'     => 'require',
        'problem'           => 'require',
        'user_id'           => 'require',
    ];

    protected $message = [
        'knowledge.require'         => '未输入知识点',
        'pre_knowledge.require'     => '未输入前置知识点',
        'problem.require'           => '未输入问题',
        'user_id'                   => '未输入用户id'
    ];

    protected $scene = [
        'add_knowledge'             => ['knowledge'],
        'delete_knowledge'          => ['knowledge'],
        'add_knowledge_relation'    => ['knowledge', 'pre_knowledge'],
        'delete_knowledge_relation' => ['knowledge', 'pre_knowledge'],
        'get_knowledge'         => ['knowledge'] ,
        'set_knowledge_relation'    => ['knowledge', 'pre_knowledge'],
        'get_problem_by_knowledge'  => ['knowledge'],
        'get_knowledge_by_problem'  => ['problem'],
        'handle_knowledge_problem_relation' => ['knowledge', 'problem'],
        'user_all_knowledge'        => ['user_id'],
        'user_specific_knowledge'   => ['user_id', 'knowledge']
    ];
}
