<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/31
 * Time: 15:01
 */

namespace app\oj\controller;


class Upload extends Base
{
    private $validate =[
        'size' => 500000,
        'ext'  => 'jpg,png,gif,jpeg',
    ];
    private $path = '/uploads/image/';
    public function upload()
    {
        $file = request()->file('image');
        $info = $file->validate($this->validate)->move($this->path);
        if($info != VALIDATE_PASS){
            return apiReturn(CODE_ERROR, $file->getError(), '');
        } else {
            return apiReturn(CODE_SUCCESS, '上传成功', $info->getSaveName());
        }
    }

}