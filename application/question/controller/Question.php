<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/9/25
 * Time: 21:45
 */
namespace app\index\controller;

use think\Session;
use app\question\model\UserModel;
class Question extends Base
{
    public function index()
    {
        $data = input("post.");
        $temp = new UserModel();
        $rel = $temp->judge($data['username'], $data['password']);
        if(!$rel['data']){
            Session::set('user', $rel['data'], 'ziqiang');
        }
        else{
            $this->fecth('question/error.html');
        }
    }
}