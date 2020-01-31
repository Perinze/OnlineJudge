<?php

namespace app\oj\validate;

use think\Validate;

class KnowledgeValidate extends Validate {
    protected $rule = [
        'knowledge'         => 'require',
        'pre_knowledge'     => 'require',
    ];

    protected $message = [
        'knowledge.require'         => '未输入知识点',
        'pre_knowledge.require'     => '未输入前置知识点',
    ];

    protected $scene = [
        'add_knowledge'             => ['knowledge'],
        'delete_knowledge'          => ['knowledge'],
        'add_knowledge_relation'    => ['knowledge', 'pre_knowledge'],
        'delete_knowledge_relation' => ['knowledge', 'pre_knowledge'],
        'get_pre_knowledge'         => ['knowledge'] ,
        'set_knowledge_relation'    => ['knowledge', 'pre_knowledge'],

    ];
}
