<?php
/**
 * Created by PhpStorm.
 * User: willion
 * Date: 2018/4/24
 * Time: 20:13
 */
namespace app\qihuo\controller;
use think\swoole\Server;

class Swoole extends Server
{
    protected $host = '127.0.0.1';
    protected $port = 9505;
    protected $option = [
        'worker_num'	=> 4,
        'daemonize'	=> true,
        'backlog'	=> 128
    ];

    public function onReceive($server, $fd, $from_id, $data)
    {
        $server->send($fd, 'Swoole: '.$data);
    }
    
}