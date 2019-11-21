<?php
return [
    /* 排行榜 */
    'rank_cache_time' => 5, // 排行榜储存时间
    'host' => 'localhost',
    'port' => '6379',
    'user_rank_cache' => 'user_rank_cache',
    /* 提交 */
    'submit_url' => [
        'http://10.143.216.128:8819/submit'
    ],
    'interval_time' => 5,
    'language' => [
        'c.gcc',
        'cpp.g++',
    ],
    /* 每面数量 */
    'page_limit' => 20,
];