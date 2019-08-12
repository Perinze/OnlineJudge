<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
define("VALIDATE_PASS", true);
define("VALIDATE_ERROR", false);
define("CODE_SUCCESS", 0);
define("CODE_ERROR", -1);

define("CODE_PARAM_ERROR", -2);
define("NO_LOGIN", -3);

define("USERNAME_NOT_EXIST", 10001); // 登录用户名不存在
define("LOGIN_PASSWORD_WRONG", 10002); // 登录密码错误
define("LOGIN_STATUS_WRONG", 10003); // 登录状态异常
define("USERNAME_IS_EXIST", 10004); // 注册用户名已存在

define('ADMINISTRATOR', 3);
define('TEACHER', 2);
define('TRAINING_TEAM_MEMBER', 1);
define('ORDINARY_MEMBER', 0);

define('BANNED', 0);
define('USING', 1);
define('CONTEST', 2);
define('VALID_TIME', 600);
// 应用公共文件
function apiReturn($status, $message, $data=[], $httpCode=200)
{
    return json([
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
    ], $httpCode);
}
