<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午9:45
 */
namespace app\index\Controller;

class Register extends Base{
    public function registe()
    {
        if(!$this->checkToken(input('post.token')))
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }
        $rcode = input('rcode');
        $data = array(
            'account' => input('post.account'),
            'password' => input('post.password'),
            'mail' => input('post.mail'),
            'phone' => input('post.phone'),
            'name' => input('post.name'),
            'gender' => input('gender'),
            'joinTime' => time(),
            'type' => $this->checkRcode($rcode)?0:1,
        );
        $userId = Db('user')->insertGetId($data);
        if($userId)
        {
            $ret = array('errCode'=>0,'errMsg'=>'OK','data'=>null);
            return json($ret);
        }
    }

    public function newRcode($num)
    {
        if(!$this->checkToken(input('post.token')))
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }

        $i=1;
        while($i<=$num)
        {
            $rcode = bin2hex(random_bytes(8));
            $result = Db('rcode')->insert([
                'code'=>$rcode,
                'isUsed'=>false
            ]);
            if($result)$i++;
        }

        $ret = array('errCode'=>0,'errMsg'=>'OK','data'=>null);
        return json($ret);
    }
}