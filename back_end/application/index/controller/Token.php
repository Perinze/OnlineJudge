<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 下午9:17
 */
namespace app\index\widget;

class Token{
    /**
     * view文件夹内可调用：生成token
     * @return string
     * @throws \Exception
     */
    public function tokenGenerate()
    {
        $hash = bin2hex(random_bytes(16));
        cache($hash,md5(time()));
        return $hash;
    }
}