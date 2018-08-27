<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/7/29
 * Time: 下午5:23
 */
namespace app\index\controller;

require_once "Base.php";

class Judger extends Base
{
    private $python3;

    public function __construct()
    {
        $this->python3 = '/Users/wdhhdzyhb/PycharmProjects/DoTA2Analysis/venv/bin/python3';
    }

    public function judge()
    {
        #sudo ./final_judger.py
        # --problem /home/darkkris/下载/pcijudger/problem/A.GSS_and_CQ
        # --code /home/darkkris/下载/A.cpp
        # --language go.go
        # --action judge

        /*
        {
          "used_time": 0.0032994747161865234,
          "detail": [],
          "exe_time": 0.0,
          "exit_code": 0,
          "verdict": "SE",
          "exe_memory": 0,
          "success": true
        }
        */
        $command = $this->python3." ./final_judger.py";
        $command .= " --problem " . "";
        $command .= " --code" . "";
        $command .= " --language " . "";
        $command .= " --action judge";
        exec($command,$rtn);
//        $json = explode(" ",$rtn);
        $json = json_decode($rtn);
        $json['verdict'];//AC WA SE CE
    }
}