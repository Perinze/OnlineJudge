<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:44
 */
namespace app\oj\controller;

use think\Controller;
use think\facade\Session;

class Base extends Controller {
    public function __construct() {
        parent::__construct();
//        if(!Session::has('user_id')){
//            $this->redirect('http://xxx.xxx.xxx/');
//        }
    }
}