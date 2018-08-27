<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/8/6
 * Time: 下午10:16
 */
namespace app\index\controller;

require_once "Base.php";

class Problem extends Base{
    private $python3;

    public function __construct()
    {
        $this->python3 = '/Users/wdhhdzyhb/PycharmProjects/DoTA2Analysis/venv/bin/python3';
    }

    /**
     * 构建题目
     */
    public function build()
    {
        //构建题目
        $command = $this->python3 . "./final_judge";
        $command .= "--problem "."";
        $command .= "--dest "."";
        $command .= "--action build";
        exec($command,$str);
    }

    /**
     * 检查题目
     */
    public function check()
    {
        //检查题目
        $command = $this->python3 . "./final_judge";
        $command .= "--problem "."";
        $command .= "--action check";
        exec($command,$str);
    }
}