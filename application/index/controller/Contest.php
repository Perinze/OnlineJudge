<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/6/17
 * Time: 下午5:27
 */
namespace app\index\controller;

class Contest extends Base{
    public function signUp($contestId)
    {
        if($this->checkToken(input('post.token'))!==true)
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }

        if(session('userId')==null)
        {
            $ret = array('errCode'=>405,'errMsg'=>'用户未登录','data'=>null);
            return json($ret);
        }

        $userInfo = Db('user')->where('userId',session('userId'))->find();
        $contestInfo = Db('contest')->where('contestId',$contestId)->find();

        $teamInfo = array(
            'contestId'=>$contestId,
            'account'=>,//账号
            'password'=>,//密码
            );

        if($contestInfo['type']=="新生赛")
        {
            $teamInfo['CNname']=$userInfo['name'];

        }else{

        }
    }
}