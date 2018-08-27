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
//            dump($temp['data'][0]['update_time']);
            if($temp['data']){
                if(strtotime($temp['data']['update_time']) + 1000 > $created){
                    return apiReturn(-1, "不要频繁提交", '', 200);
                }
            }
            $rel = $item->addsign($data);
            return apiReturn($rel['code'], $rel['msg'], $rel['data'], 200);
        }
    }
}