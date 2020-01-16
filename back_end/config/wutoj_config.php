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
    /* 交题时间间隔 */
    'interval_time' => 5,
    /* 支持语言 */
    'language' => [
        'c.gcc',
        'cpp.g++',
    ],
    /* 每面数量 */
    'page_limit' => 20,
    /* oj 链接 */
    'oj_url' => 'https://acmwhut.com',
];