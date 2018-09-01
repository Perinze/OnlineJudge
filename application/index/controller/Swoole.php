<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/12
 * Time: 上午11:49
 */
namespace app\index\controller;

class Swoole extends Base{
    CONST HOST = "0.0.0.0";
    CONST PORT = 8812;

    public $ws = null;
    public function __construct()
    {
        $this->ws = new swoole_websocket_server("0.0.0.0",8812);

        $this->ws->set(
            [
                'worker_num' => 2,
                'task_worker_num' => 2,
            ]
        );

        $this->ws->on("open",[$this, 'onOpen']);
        $this->ws->on("message",[$this, 'onMessage']);
    }
}