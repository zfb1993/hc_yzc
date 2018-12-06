<?php
/**
 * Created by PhpStorm.
 * User: willion
 * Date: 2018/4/24
 * Time: 21:46
 */
/*$http_server = new \swoole_http_server('0.0.0.0',9508);

$http_server->set(array('daemonize'=> true));
$http_server->on('request',function ($serv, $fd, $threadId, $data) {
    echo '9501:'.$data.".\n";
});*/

$http = new \swoole_http_server("0.0.0.0", 9508);
$http->on('request', function ($request, $response) {
    $client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
    $client->on("connect", function($cli) {
        //echo "***********connect";
        $reg1->UserID = '058260';
        $reg1->BrokerID = '9999';
        $reg1->HandlerID = 'RegisterFront';
        $reg1->FrontADD = 'tcp://180.168.146.187:10031';
        //$reg1->FrontADD = 'tcp://180.168.146.187:10031';

        $data = json_encode($reg1);
        echo $data;
        $cli->send($data);
    });

    $client->on("error", function($cli){
        echo "connect failed\n";
    });
    $client->on("close", function($cli){
        echo "connection close\n";
    });
    $client->connect("127.0.0.1", 9501, 0.5);
    $client->on("receive", function($cli, $data){
        echo "\nreceived: {$data}\n";
        $obj = json_decode($data,true);

        if(strcmp($obj['HandlerID'], 'onFrontConnected')==0){
            $reg1->UserID = '058260';
            $reg1->BrokerID = '9999';
            $reg1->Password = '123456';
            $reg1->HandlerID = 'ReqUserLogin';
            $data1 = json_encode($reg1);
            echo $data1;
            $cli->send($data1);
            $response->end("<h1>Hello Swoole. #".$data1."</h1>");
        }
        else if(strcmp($obj['HandlerID'], 'onRspUserLogin')==0){
            $reg2->UserID = '058260';
            $reg2->BrokerID = '9999';
            $reg2->HandlerID = 'SubscribeMarketData';
            $reg2->InstrumentID = ['ag1812','cu1806','m1809','IF1805'];
            $data2 = json_encode($reg2);
            echo $data2;
            $cli->send($data2);
            $response->end("<h1>Hello Swoole. #".$data2."</h1>");
        }
    });

    //$response->end("<h1>Hello Swoole. #555"."</h1>");
});
$http->start();
/*//......设置各个回调......
//多监听一个tcp端口，对外开启tcp服务，并设置tcp服务器的回调
$tcp_server = $http_server->addListener('0.0.0.0', 9505, SWOOLE_SOCK_TCP);
//默认新监听的端口 9999 会继承主服务器的设置，也是 Http 协议
//需要调用 set 方法覆盖主服务器的设置
$tcp_server->set(array('daemonize'=> true));
$tcp_server->on("receive", function ($serv, $fd, $threadId, $data) {
    echo '9501:'.$data.".\n";
});*/

