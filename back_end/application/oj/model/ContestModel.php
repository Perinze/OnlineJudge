<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:47
 */

namespace app\oj\model;

use think\Exception;
use think\Model;

class ContestModel extends Model
{

    // uncheck

    protected $table = 'contest';

    public function searchContest($contest_id = 0, $contest_name = '')
    {
        try {
            if ($contest_id === 0 && $contest_name === '') {
                $content = $this->where('status', '<>', 0)->select()->toArray();
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            } else if ($contest_id !== 0) {
                $content = $this->where('contest_id', $contest_id)->find();
                if (empty($content)) {
                    return ['code' => CODE_ERROR, 'msg' => '未找到数据', 'data' => ''];
                }
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            } else {
                $content = $this->where('contest_name', 'like', '%' . $contest_name . '%')->select()->toArray();
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

}