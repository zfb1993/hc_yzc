<?php
namespace app\qihuo\controller;
use think\Controller;
use think\Db;
use \think\Log;
// 必须 use 并继承 \think\swoole\Server 类
use think\swoole\Server;

class Hqingsocket1 extends Server
{

    // 监听所有地址
    protected $host = '0.0.0.0';
    // 监听 9501 端口
    protected $port = 9509;
    // 指定运行模式为多进程
    protected $mode = SWOOLE_PROCESS;
    // 指定 socket 的类型为 ipv4 的 tcp socket
    protected $sockType = SWOOLE_SOCK_TCP;
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
    /**
     * @var swoole_websocket_server
     */
    private $server;
    private $client;
    /**
     * @var swoole_process
     */
    private $process;

    /**
     * @var Cache_Redis
     */
    private $redis;

    /**
     * @var swoole_atomic
     */
    private $app_status;
    /**
     * @var swoole_atomic
     */
    private $sub_status;

    /**
     * @var swoole_table
     */
    public $player_table;
    private $app_config= array(
        'reactor_num' => 1,     //reactor thread num
        'worker_num'  => 1,     //worker process num
        'task_worker_num' => 1, //worker process num
        'backlog'     => 128,   //listen backlog
        'daemonize'=>1,         //是否作为守护进程,此配置一般配合log_file使用
        //'log_file'=>'./swoole.log',
        'max_request' => 1000,
        'dispatch_mode' => 1,
        'heartbeat_check_interval'=>600, //每隔多少秒检测一次，单位秒，Swoole会轮询所有TCP连接，将超过心跳时间的连接关闭掉
        'heartbeat_idle_time' => 720,    //TCP连接的最大闲置时间，单位s , 如果某fd最后一次发包距离现在的时间超过
    );

    /**
     * @name 系统接口
     */
    public function index()
    {
        //检查是否登陆
        // $this->redirect('mobile/user/login');
    }
    function startup(){
        $port=9509;
        $memory_limit = ini_get('memory_limit');
        echo "memory_limit:$memory_limit \n";
        $this->_initServer($port);
        $this->_initGlobal();
        echo "server start at ".date("Y-m-d H:i:s");//$request->fd 是客户端id
        echo "\n";
        $this->server->start();
    }

    protected function _initServer($port){
        $port = !empty($port)?intval($port):9509;
        $this->server = new \swoole_websocket_server("0.0.0.0", $port);
        $this->server->set($this->app_config);
        $this->server->on('open', array($this, 'onOpen'));
        $this->server->on('task', array($this, 'onTask'));
        $this->server->on('finish', array($this, 'onFinish'));
        $this->server->on('message', array($this, 'onMessage'));
        $this->server->on('close', array($this, 'onClose'));
        $this->server->on('start', array($this, 'onStart'));
        $this->server->on('WorkerStart', array($this, 'onWorkerStart') );

    }

    protected function _initGlobal(){
        $this->app_status = new \swoole_atomic(0);
        $this->sub_status = new \swoole_atomic(0);

        $this->player_table = new \swoole_table(65536);
        $this->player_table->column('socket_id', \swoole_table::TYPE_INT, 8);       //1,2,4,8
        $this->player_table->column('status', \swoole_table::TYPE_INT, 4);
        $this->player_table->column('game_id', \swoole_table::TYPE_INT, 4);
        $this->player_table->column('login', \swoole_table::TYPE_INT, 8);
        $this->player_table->column('logout', \swoole_table::TYPE_INT, 8);
        $this->player_table->create();
        // CharStatusModel::status_init($this->player_table);
    }

    function onOpen(\swoole_websocket_server $server,\swoole_http_request $request) {
        $msg = 'onOpen request: '.json_encode($request)."\n";
        Log::log($msg);
    }

    function onWorkerError(\swoole_websocket_server $server , $work_id, $worker_pid, $exit_code, $signo) {
        $msg = 'onWorkerError work_id: '.$work_id."\n";
        Log::log($msg);
    }

    function onWorkerStart(\swoole_websocket_server $server, $work_id) {
        $msg = 'onWorkerStart work_id: '.$work_id."\n";
        Log::log($msg);
//        //只需要启动一次的task
        if($work_id==0){
            $server->tick(30000, function($tick_id) use ($work_id,$server) {
                //CharStatusModel::sync($server);
            });

         $this->client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
         $this->client->on("connect", function($cli) {
            //echo "***********connect";
            $reg1['UserID'] = '058260';
            $reg1['BrokerID'] = '9999';
            $reg1['HandlerID'] = 'registerFront';
            $reg1['FrontADD'] = 'tcp://180.168.146.187:10031';
            //$reg1->FrontADD = 'tcp://180.168.146.187:10031';

            $data = json_encode($reg1);
            echo $data;
            $cli->send($data);
         });


        $this->client->on("error", function($cli){
            echo "connect failed\n";
        });

        $this->client->on("close", function($cli){
            echo "connection close\n";
        });

        $this->client->connect("127.0.0.1", 12589, 0.5);
        $this->client->on("receive", function($cli, $data){
            echo "\nreceived: {$data}\n";
            $obj = json_decode_gbk($data);

            if(strcmp($obj['HandlerID'], 'onFrontConnected')==0){
                $reg1['UserID'] = '058260';
                $reg1['BrokerID'] = '9999';
                $reg1['Password'] = '123456';
                $reg1['HandlerID'] = 'reqUserLogin';
                $data1 = json_encode_gbk($reg1);
                $cli->send($data1);
                  echo "\nreceived: {$data}\n";
            }
            else if(strcmp($obj['HandlerID'], 'onRspUserLogin')==0){
                $reg2['UserID'] = '058260';
                $reg2['BrokerID']= '9999';
                $reg2['HandlerID'] = 'subscribeMarketData';
                $reg2['InstrumentID'] = ['ag1812','cu1806','m1809','IF1805','rb1810','ni1807','au1806','ru1809'];

                $data2 = json_encode_gbk($reg2);
                $cli->send($data2);
                  echo "\nreceived: {$data}\n";

            }else if(strcmp($obj['HandlerID'], 'onRtnDepthMarketData')==0){

                   $player_info =  $this->player_table->get('test1');
                        if (!empty($player_info)) {
                            $sockets = $player_info['socket_id'];
                        }
                    if(empty($sockets)) return;
                  echo "\n onRtnDepthMarketData: {111111}\n";
                    echo "\n socketID: {$sockets}\n";
                    self::broadcast($data,$this->server,array($sockets));
              
            }else if(strcmp($obj['HandlerID'], 'OnRspQryProduct')==0){

                    $player_info =  $this->player_table->get('test1');
                        if (!empty($player_info)) {
                            $sockets = $player_info['socket_id'];
                        }
                         if(empty($sockets)) return;
                    echo "\n socketID: {$sockets}\n";
                     $data1 = json_encode($data);
                    self::broadcast($data1,$this->server,array($sockets));
        
            }else{
                 echo "\nreceived: {$data}\n";
            }

        });
        }


    }

    function onStart(\swoole_websocket_server $server) {

    }

    function onTask(\swoole_websocket_server $server,   $task_id,  $from_id,  $task_data) {
        switch ($task_data['action']) {
            case 'redis':
                # code...
                break;
            case 'sql':
                $game_id = isset($task_data['game_id']) ? $task_data['game_id'] : '';
                $sql     = $task_data['sql'];
                $params  = $task_data['params'];

                $db_name = 'hcgame';
                if(!empty($game_id) && isset(Game_Config::$plat_club_db[$game_id])){
                    $db_name = Game_Config::$plat_club_db[$game_id];
                }
                // $pdo_hcgame = new Db_Pdo($db_name);
                try{
                    //$pdo_hcgame->prepareQuery($sql, $params);
                }catch (\Exception $e){
                    $msg = 'sql_error task_data:'.json_encode($task_data).$e->getMessage();
                    log::log($msg);
                }
                break;
            case 'sql_transaction': //事物处理的sql
                $game_id    = isset($task_data['game_id']) ? $task_data['game_id'] : '';
                $sql_arr    = $task_data['sqls'];
                $params_arr = $task_data['params'];
                $count = count($sql_arr);

                $db_name = 'hcgame';

                /*   $pdo_hcgame = new Db_Pdo($db_name);
                   try{
                       $pdo_hcgame->beginTransaction();
                       for($i = 0; $i < $count; $i++){
                           $pdo_hcgame->prepareQuery($sql_arr[$i], $params_arr[$i]);
                       }
                       $pdo_hcgame->commit();
                   }catch (\Exception $e){
                       $msg = 'task_data:'.json_encode($task_data).$e->getMessage();
                       Common::log($msg, 'sql_transaction_error');
                       $pdo_hcgame->rollBack();
                   }*/
                break;
            default:
                # code...
                break;
        }

        return $task_id;
    }

    function onFinish(\swoole_websocket_server $server, $task_id, $return) {
        $msg = 'onFinish task_id: '.$task_id."\n";
        Log::log($msg);
        return array('finish');
    }

    /**
     * @param  $controller
     * @param  $action
     * @param array $parameters
     * @param  $module
     */
    function _dispatcher($controller = 'Index', $action = 'Index', array $parameters = array(), $module = 'Index') {
        // $request = new Yaf_Request_Simple("CLI", $module, $controller, $action, $parameters);
        //  Yaf_Application::app()->getDispatcher()->dispatch($request);
    }

    function onMessage(\swoole_websocket_server $server,\swoole_websocket_frame $frame) {
        $msg = 'onMessage frame: '.json_encode($frame)."\n";
        Log::log($msg);

        $data_string = $frame->data;
        $socket_id   = $frame->fd;
         $a=$this->client->send($data_string);
        $server->push($socket_id, $data_string);
        $this->player_table->set('test1',['socket_id' => $socket_id, 'status' => 0]);

       
        //{UserID=’’,HandleID=’ReqQryInstrument’,InstrumentID=’’}
       /* $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
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
            }
            else if(strcmp($obj['HandlerID'], 'onRspUserLogin')==0){
                $reg2->UserID = '058260';
                $reg2->BrokerID = '9999';
                $reg2->HandlerID = 'SubscribeMarketData';
                $reg2->InstrumentID = ['ag1812','cu1806','m1809','IF1805'];

                $data2 = json_encode($reg2);
                echo $data2;
                $cli->send($data2);

            }
        });
        $client->on("error", function($cli){
            echo "connect failed\n";
        });
        $client->on("close", function($cli){
            echo "connection close\n";
        });
        $client->connect("127.0.0.1", 9501, 0.5);*/


     /*   $data_string = $frame->data;
        $socket_id   = $frame->fd;
        $data  = json_decode($data_string, true);
        if(!is_array($data)) {
            $msg = "onMessage bad protocol".$data_string. "\n";
            Log::log($msg);
            $server->push($frame->fd,json_encode(array('error'=>'bad protocol')));
            return false;
        }*/
        /*  $controller_name = isset($data['c']) ? $data['c'] : 'Index';
          $action_name     = isset($data['a']) ? $data['a'] : 'index';
          $module_name     = isset($data['m']) ? $data['m'] : 'Index';
          $data['player_table'] = &$this->player_table;

          //$player_info     = $this->player_table->get($char_id);
          //$data['game_id'] = $player_info['game_id'];
          $parameters = array('server'=> &$server,'frame'=> $frame,'socket_id'=> $socket_id,'data'=> &$data);
          $this->_dispatcher($controller_name, $action_name, $parameters, $module_name);*/

    }

    function onClose(\swoole_websocket_server $server, $fd) {
        $msg = 'fd: '.$fd."\n";
        Log::log($msg, 'onClose');
        //CharStatusModel::logout( $fd, $server);
    }

        /**
     * @param $data
     * @param $server swoole_websocket_server
     * @param $sockets
     */
    public static function broadcast($data,$server,$sockets) {
        if(is_array($data) || is_object($data)) {
            $data = json_encode($data);
        }

        if(!empty($sockets)){
            foreach($sockets as $socket_id) {
                if ($server->exist($socket_id)) {
                    $server->push($socket_id, $data);
                }
            }
        }

    }

       /**
     * @param $char_ids
     * @return array
     */
    public static function getSocketIdsByCharIds($char_ids) {
        if(empty($char_ids)){
            return array();
        }
        if(!is_array($char_ids)) {
            $char_ids = array($char_ids);
        }
        $socket_ids = array();
        foreach($char_ids as $char_id) {
            $table = self::$table;
            $player_info = $table->get($char_id);
            if (!empty($player_info)) {
                $socket_ids[] = $player_info['socket_id'];
            }
        }
        $socket_ids = array_unique($socket_ids);
        return $socket_ids;
    }
}
