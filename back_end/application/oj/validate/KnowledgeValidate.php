<?php

namespace app\oj\validate;

use think\Validate;

class KnowledgeValidate extends Validate {
    protected $rule = [
        'knowledge' => 'require',
    ];

    protected $message = [
        'knowledge.require' => '未输入知识点',
    ];

    protected $scene = [
        'add_knowledge' => ['knowledge'],
        'delete_knowledge' => ['knowledge']
    ];
}
