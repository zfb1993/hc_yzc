<?php
namespace app\qihuo\controller;
use think\Controller;
use think\Db;
use \think\Log;
// 必须 use 并继承 \think\swoole\Server 类
use think\swoole\Server;

class Testweb extends Server
{

    // 监听所有地址
    protected $host = '0.0.0.0';
    // 监听 9501 端口
    protected $port = 9509;
    // 指定运行模式为多进程
    protected $mode = SWOOLE_PROCESS;
    // 指定 socket 的类型为 ipv4 的 tcp socket
    protected $sockType = SWOOLE_SOCK_TCP;
    private $response;
    private $resp=0;
    protected $serverType='http';
    static $client=null;
    // 配置项
    protected $option = [
        /**
         *  设置启动的worker进程数
         *  业务代码是全异步非阻塞的，这里设置为CPU的1-4倍最合理
         *  业务代码为同步阻塞，需要根据请求响应时间和系统负载来调整
         */
        'worker_num' => 4,
        // 守护进程化
        'daemonize'  => true,
        // 监听队列的长度
        'backlog'    => 128
    ];

    private $server;
    public function startup(){
        $http = new \swoole_http_server("0.0.0.0", 9508);

        $http->on('request', function ($request, $response){
            $this->response=$response;
            $this->resp=0;

                self::$client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
                self::$client->on("connect", function($cli) {
                    //echo "***********connect";
                    $reg1['UserID'] = '058260';
                    $reg1['BrokerID'] = '9999';
                    $reg1['HandlerID'] = 'RegisterFront';
                    $reg1['FrontADD'] = 'tcp://180.168.146.187:10013';
                    //$reg1->FrontADD = 'tcp://180.168.146.187:10031';

                    $data = json_encode($reg1);
                    echo $data;
                    $cli->send($data);
                });


            //if(!self::$client->isConnected())   self::$client->connect("127.0.0.1", 9501, 0.5);

            self::$client->on("error", function($cli){
                echo "connect failed\n";
            });

            self::$client->on("close", function($cli){
                echo "connection close\n";
            });

            self::$client->connect("127.0.0.1", 9501, 0.5);
            self::$client->on("receive", function($cli, $data){
                echo "\nreceived: {$data}\n";
                $obj = json_decode($data,true);

                if(strcmp($obj['HandlerID'], 'onFrontConnected')==0){
                    $reg1['UserID'] = '058260';
                    $reg1['BrokerID'] = '9999';
                    $reg1['Password'] = '123456';
                    $reg1['HandlerID'] = 'ReqUserLogin';
                    $data1 = json_encode($reg1);
                    $cli->send($data1);
                    //$this->response->end("<h1>Hello Swoole. #".$data."</h1>");
                }
                else if(strcmp($obj['HandlerID'], 'onRspUserLogin')==0){
                    $reg2['UserID'] = '058260';
                    $reg2['BrokerID']= '9999';
                    $reg2['HandlerID'] = 'SubscribeMarketData';
                    $reg2['InstrumentID'] = ['ag1812','cu1806','m1809','IF1805'];
                    $data2 = json_encode($reg2);
                    $cli->send($data2);

                }else if(strcmp($obj['HandlerID'], 'onRtnDepthMarketData')==0){
                    if($this->resp==0){
                        $this->response->end("$data");
                        $this->resp=1;
                        //$cli->close(true);
                    }
                }

            });

        });

        $http->start();

    }


}
