<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:44
 */
namespace app\oj\controller;

use think\Controller;
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Request-Methods:*');
class Base extends Controller {
    public function __construct() {
        parent::__construct();
//        if(!Session::has('user_id')){
//            $this->redirect('http://xxx.xxx.xxx/');
//        }
    }
}