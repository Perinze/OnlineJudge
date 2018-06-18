<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/12
 * Time: 上午11:33
 */
class Consumer{
    private $url = ".";

    public function consume()
    {
        // TODO 连接数据库获取评测队列中head评测
    }

    private function judge()
    {
        // TODO code-URL
        $code = "";
        $language = $_POST['language'];
        $problem = $_POST['problem'];

        exec("python3 {$this->url}/final_judger.py --problem {$problem} --code {$code} --language {$language} --action judge",$result);

        // TODO result存到数据库

        return $result;
    }

    public function check()
    {
        $problem = $_POST['problem'];

        exec("python3 {$this->url}/final_judger.py --problem {$problem} --action check",$result);
        return $result;
    }

    public function build()
    {
        $problem = $_POST['problem'];
        $dest = $_POST['dest'];

        if($problem == $dest)
            return "problem 与 dest 不能相同";

        exec("python3 {$this->url}/final_judger.py --problem {$problem} --dest {$dest} --action build",$result);
        return $result;
    }
}