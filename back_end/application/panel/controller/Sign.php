<?php
namespace app\panel\controller;
use think\Controller;
use think\Request;
use app\panel\model\SignModel;

class Sign extends Controller
{
//    public function contract()
//    {
//        return $this->fetch();
//    }

    public function addsign()
    {
        $begin = strtotime(config('begin'));
        $finish = strtotime(config('finish'));
        $now = time();
        if($now<$begin || $now>$finish){
            return apiReturn(-1, "现在不是报名时间", '', 200);
        }
        else{
            $info = $_GET;
            $created = time();
            $data = array(
                'name' => $info['name'],
                'sex' => $info['sex'],
                'class' => $info['class'],
                'cardNo' => $info['cardNo'],
                'date' => $info['date'],
                'qq' => $info['qq'],
                'tel' => $info['tel'],
                'dorm' => $info['dorm'],
                'content' => $info['content'],
                'status' => 0,
                'create_time' => $created,
                'update_time' => $created
            );

            $item = new SignModel();
            $where = ['cardNo' => $data['cardNo']];
            $temp = $item->getsign($where);
            if($temp['data']){
                if(strtotime($temp['data']['update_time']) + 60 > $created){
                    return apiReturn(-1, "不要频繁提交", '', 200);
                }
            }
            $rel = $item->addsign($data);
            return apiReturn($rel['code'], $rel['msg'], $rel['data'], 200);
        }
    }

    public function downloadCSV()
    {
        $userId = input('post.userId');
        $passwd = md5(base64_encode(input('post.passwd')));
        $user = new \app\index\model\UserModel();
        $result = $user->checkAdmin($userId, $passwd);
        if(!$result) {
            return apiReturn(-1, 'You don\'t have authority', null, 200);
        }

        $now = date("Y-m-d",time());
        $nowtoken = md5(base64_encode('panel' . 'Sign' . 'downloadCSV' . $now . 'fight in acm@wut'));
        $token = input('post.token');

        if($nowtoken != $token)
        {
            return apiReturn(-1, 'token is wrong', null, 200);
        }else{
            $item = new SignModel();
            $data = $item->getsign()['data'];
            $info = "";
            foreach ($data as $v) {
                foreach ($v as $vv) {
                    $info .= "\"";
                    $info .= $vv;
                    $info .= "\",";
                }
                $info .= "\n";
            }
            return json(array('status'=>0, 'message'=>'OK', 'data'=>$info));
        }
    }
}