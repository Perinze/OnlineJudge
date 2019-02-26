<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午9:45
 */
namespace app\index\controller;

require_once "UserValidate.php";

class Register extends Base{

    public function __construct()
    {
        parent::__construct();
        if($this->checkToken(input('post.token'))!==true)
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }
    }

    /**
     * 用户注册
     * TODO 重构 with UserModel
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function registe()
    {
        $rcode = input('post.rcode');
        $password = input('post.password');
        $repassword = input('post.repassword');
        if($repassword!=$password)
        {
            $ret = array('errCode'=>102,'errMsg'=>'两次密码不相同','data'=>null);
            return json($ret);
        }
        $data = array(
            'account' => input('post.account'),
            'password' => md5(base64_encode($password)),
            'mail' => input('post.mail'),
            'phone' => input('post.phone'),
            'name' => input('post.name'),
            'gender' => input('post.gender'),
            'joinTime' => date("Y-m-d h:i:s",time()),
            'type' => $this->checkRcode($rcode)?0:1,
        );
        if($this->validate($data,'app\index\validate\UserValidate.register')) {
            unset($data['token']);
            $userId = Db('user')->insertGetId($data);
            if ($userId) {
                $ret = array('errCode' => 0, 'errMsg' => 'OK', 'data' => null);
                return json($ret);
            }else{
                $ret = array('errCode' => 102, 'errMsg' => '注册失败', 'data' => null);
                return json($ret);
            }
        }else{
            $ret = array('errCode' => 102, 'errMsg' => '表单信息错误', 'data' => null);
            return json($ret);
        }
    }

    /**
     * 批量产生邀请码
     * @param $num
     * @return \think\response\Json
     * @throws \Exception
     */
    public function newRcode($num)
    {
        if($this->checkUserType(session('userId'))<=1)
        {
            $ret = array('errCode'=>403,'errMsg'=>'没有操作权限','data'=>null);
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