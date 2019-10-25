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

define('Report_Accepted',0);
define('Report_WrongAnswer ', 1);
define('Report_TimeLimitExceeded', 2);
define('Report_MemoryLimitExceeded', 3);
define('Report_RuntimeError', 4);
define('Report_CompileError', 5);
define('Report_SystemError', 6);
define('Judging', 9);

// 应用公共文件
function apiReturn($status, $message, $data=[], $httpCode=200)
{
    return json([
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
    ], $httpCode);
}

function post($url, $data = array(), $type = 'text') {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    if (!empty($data)) curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    if ($type == 'json') curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $content = curl_exec($curl);
    curl_close($curl);
    return $content;
}

function handle_problem($problem, $problem_array)
{
    $new_array = array();
    foreach ($problem as $item){
        $new_array[] = chr(array_search($item, $problem_array, false) + 65);
    }
    return $new_array;
}