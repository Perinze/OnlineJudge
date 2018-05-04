<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午9:43
 */
namespace app\index\Controller;

class Login extends Base{
    public function login(){
        $ret = array('errCode'=>0,'errMsg'=>'OK','data'=>null);
        $account = input('post.account');
        $password = md5(base64_encode(input('post.password')));
        $user = Db('user')->where(array('account'=>$account,'password'=>$password))->find();
        if($user)
        {
            session('userId',$user['userId']);
        }else{
            $ret = array('errCode'=>102,'errMsg'=>'用户名或密码错误','data'=>null);
        }
        return json($ret);
    }
}