<?php


namespace app\oj\controller;


use app\oj\model\ContestModel;
use app\oj\model\GroupModel;
use app\oj\model\RankCacheModel;
use app\oj\model\SubmitModel;
use app\oj\model\UserModel;
use think\Controller;

class Rank extends Controller
{
    // TODO 更新逻辑可以有多个排序规则
    public function user_rank()
    {
        $user_model = new UserModel();
        $resp = $user_model->user_rank();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function group_rank()
    {
        $group_model = new GroupModel();
        $resp = $group_model->group_rank();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    
    public function contest_rank()
    {
        $submit_model = new SubmitModel();
        $contest_model = new ContestModel();
        $rankCache_model = new RankCacheModel();
        $req = input('post');
        if(!isset($req['contest_id'])){
            return apiReturn(CODE_ERROR, '缺少contest字段', '');
        }
        // 如果有缓存，则直接返回缓存数据，减少服务器负担
        $cache = $rankCache_model->get_rank_cache($req['contest_id']);
        if($cache['code'] === CODE_SUCCESS){
            return apiReturn($cache['code'], $cache['msg'], $cache['data']);
        }
        $info = $contest_model->searchContest($req['contest_id']);
        if($info['code'] !== CODE_SUCCESS){
            return apiReturn($info['code'], $info['msg'], $info['data']);
        }
        if(time() > $info['data']['begin_time']){
            return apiReturn(CODE_ERROR, '比赛还没开放', '');
        }
        if($info['data']['end_time'] > time()){
            $where = [];
        } else {
            $where = ['submit_time', '<= time', $info['data']['begin_time']
                + ($info['data']['end_time'] - $info['data']['begin_time']) * $info['data']['frozen']];
        }
        $resp = $submit_model->get_all_submit($where);
        // TODO 处理榜单
        $data = $this->handle_rank($resp['data'], $info['data']['begin_time'], $info['data']['problem']);
        // 缓存表单数据，失败没有影响
        $cache = $rankCache_model->set_rank_cache($data, $req['contest_id']);
        return apiReturn($resp['code'], $resp['msg'], $data);
    }

    public function handle_rank($data, $begin_time, $problem)
    {
        $rank = [];
        // 数据清理
        foreach ($data as $item){
            $user_id = $item['user_id'];
            $problem_id = $item['problem_id'];
            if(!isset($rank[$user_id])){
                $rank[$user_id] = ['nick' => $item['nick'], 'penalty' => 0, 'ac_num' => 0];
            }
            //var_dump($user_id);
            //halt($rank);
            if(!isset($rank[$user_id][$problem_id])){
                $rank[$user_id][$problem_id] = ['success_time' => '', 'times' => 0];
            }
            if(empty($rank[$user_id][$problem_id]['success_time'])) {
                if ($item['status'] !== 'AC') {
                    $rank[$user_id][$problem_id]['times']++;
                    $rank[$user_id]['penalty'] += 1200;
                } else {
                    $rank[$user_id][$problem_id]['success_time'] = $item['submit_time'] - $begin_time;
                    $rank[$user_id]['penalty'] += $item['submit_time'] - $begin_time;
                    $rank[$user_id]['ac_num']++;
                }
            }
        }
        //var_dump($rank);
        $new_rank = [];
        // 格式化数据
        foreach ($rank as $key=>$item){
            //var_dump($item);
            $problem = [];
            foreach ($item as $key1=>$value){
                //var_dump($value);
                if(is_array($value)){
                    $problem[] = [
                        'problem_id' => $key1,
                        'success_time' => $value['success_time'],
                        'times' => $value['times'],
                    ];
                }
                //var_dump($key1);
            }
            $new_rank[] = [
                'user_id' => $key,
                'nick' => $item['nick'],
                'penalty' => $item['penalty'],
                'ac_num' => $item['ac_num'],
                'problem_id' => $problem,
            ];
        }
        //var_dump($new_rank);
        // 排序
        // TODO 按照run_id排序
        usort($new_rank, [$this, 'compare_arr']);
        //var_dump($new_rank);
        $new_rank['problems'] = json_decode($problem, true);
        return $new_rank;
    }
    public function compare_arr($x,$y){
        if($x['ac_num'] > $y['ac_num']){
            return -1;
        } else if($x['ac_num'] < $y['ac_num']){
            return 1;
        } else{
            if($x['penalty'] < $y['penalty']){
                return -1;
            } else {
                return 1;
            }
        }
    }
}