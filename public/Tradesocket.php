<?php
namespace app\qihuo\controller;
use think\Controller;
use think\Db;
use \think\Log;
// 必须 use 并继承 \think\swoole\Server 类
use think\swoole\Server;

class Tradesocket extends Server
{

    // 监听所有地址
    protected $host = '0.0.0.0';
    // 监听 9501 端口
    protected $port;
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
        'worker_num' => 1,
        //是否作为守护进程,此配置一般配合log_file使用,'log_file'=>'./swoole.log',
        'daemonize'  => 1,
        // 监听队列的长度
        'backlog'    => 128,
        //reactor thread num
        'reactor_num' => 1,
        //worker process num
        'task_worker_num' => 1,
        'max_request' => 1000,
        'dispatch_mode' => 1,
        //每隔多少秒检测一次，单位秒，Swoole会轮询所有TCP连接，将超过心跳时间的连接关闭掉
        'heartbeat_check_interval'=>120,
        //TCP连接的最大闲置时间，单位s , 如果某fd最后一次发包距离现在的时间超过
        'heartbeat_idle_time' => 240,
    ];
    /**
     * @var swoole_websocket_server
     */
    private $client;
    /**
     * @var swoole_process
     */
    private $process;

    /**
     * @var Cache_Redis
     */
    private $redis;

    //是否记录访问日志
    private $isLog=true;
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
    private $user_table;


    public function __construct()
    {
        $this->serverType='socket';
        $this->port=9507;
        parent::__construct();
    }
    /**
     * @name 系统接口
     */
    public function index()
    {
        //检查是否登陆
        // $this->redirect('mobile/user/login');
    }

    /**
     * @name 项目启动入口
     * @start  php index.php qihuo/Tradesocket/startup
     */

    function startup(){

        $memory_limit = ini_get('memory_limit');
        echo "memory_limit:$memory_limit \n";
        $this->_initGlobal();
        echo "server start at ".date("Y-m-d H:i:s");//$request->fd 是客户端id
        $this->start();

    }


    //初始化全局内存
    protected function _initGlobal(){
        $this->app_status = new \swoole_atomic(0);
        $this->sub_status = new \swoole_atomic(0);
        $this->user_table = new \swoole_table(65536);
        $this->user_table->column('socket_id', \swoole_table::TYPE_INT, 8);       //1,2,4,8
        //$this->user_table->column('type', \swoole_table::TYPE_INT, 4);
        $this->user_table->column('uid', \swoole_table::TYPE_INT, 4);
        $this->user_table->column('zid', \swoole_table::TYPE_STRING, 14);//ctp 用户id
        //$this->user_table->column('bid', \swoole_table::TYPE_INT, 8);//ctp BrokerID
        $this->user_table->create();
    }


    //开启行情
    function StartTrade(){
        echo 'onStart: '."\n";
        $this->initTradeCtp();
    }


    function onOpen(\swoole_websocket_server $server,\swoole_http_request $request) {
        $msg = 'onOpen request: '.json_encode($request)."\n";
        if($this->isLog) {
            Log::log($msg);
            echo "\n {$msg}\n";
        }
    }

    function onWorkerStart(\swoole_websocket_server $server, $work_id) {
        $msg = 'onWorkerStart work_id: '.$work_id."\n";
        //只需要启动一次的task
        if($work_id==0){
            $server->tick(30000, function($tick_id) use ($work_id,$server) {
                //CharStatusModel::sync($server);
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

    function onMessage(\swoole_websocket_server $server,\swoole_websocket_frame $frame) {
        $msg = 'onMessage frame: '.json_encode($frame)."\n";
        if($this->isLog) {
            Log::log($msg);
            echo "\n {$msg}\n";
        }
        $data_string = $frame->data;
        $socket_id   = $frame->fd;

        $data  = json_decode($data_string, true);
        if(!is_array($data) || !isset($data['HandlerID']) || !isset($data['UserID'])) {
            $server->push($socket_id,json_encode(array('error'=>'bad protocol')));
            return false;
        }
        $params['socket_id'] = $socket_id;
        $user_info =  $this->user_table->get($data['UserID']);
        if($data['HandlerID']!='ReqUserLogin'&& $data['HandlerID']!='StartTrade'){
            //重复登陆，删掉不必要的连接
            if(empty($user_info)||$data['UserID']!=$user_info['uid'] ||$params['socket_id']!=$user_info['socket_id'] ){
                if ($user_info['socket_id'] > 0 && $this->swoole->exist($user_info['socket_id'])){
                    $this->swoole->close($user_info['socket_id']);
                }
                $this->user_table->del($data['UserID']);
                $server->push($socket_id,json_encode(array('error'=>'please login first')));
                return false;
            }
            if(empty($user_info['zid'])||$user_info['zid']==0){
                $server->push($socket_id,json_encode(array('error'=>'zid nil')));
                return false;
            }
            $data['UserID']=$user_info['zid'];
        }

        if (method_exists($this, $data['HandlerID'])) {
            $this->$data['HandlerID']($data,$params);
            return false;
        }else{
            $server->push($socket_id,json_encode(array('error'=>'not function protocol')));
            return false;
        }

    }

    function onClose(\swoole_websocket_server $server, \swoole_websocket_frame $fd) {
        $msg = 'onClose fd: '.$fd."\n";
        if($this->isLog) {
            Log::log($msg);
            echo "\n {$msg}\n";
        }
        //销毁状态
        //CharStatusModel::logout( $fd, $server);
    }
    function onFinish(\swoole_websocket_server $server, \swoole_websocket_frame $fd) {
        $msg = 'onFinish fd: '.$fd."\n";
        if($this->isLog) {
            Log::log($msg);
            echo "\n {$msg}\n";
        }
        //销毁状态
        //CharStatusModel::logout( $fd, $server);
    }

    //发送信息
    public function sendMsgClient($data,$server,$userTable=array()) {
        if(!is_array($data) || !is_object($data)) {
            $data = json_decode($data,true);
        }
        if(!empty($userTable['socket_id']) && $server->exist($userTable['socket_id'])){
            $server->push($userTable['socket_id'], json_encode($data));
            return false;
        }else{
            //删除不存在的链接内存数据
            $this->user_table->del($userTable['zid']);
            return false;
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



    /**
     * @param $socket_id int
     * @param $server swoole_websocket_server
     * @throws Exception
     */
    public static function logout($socket_id, &$server)
    {
        $player_table = self::$table;
        if (empty($player_table)) {
            throw new \Exception('player_table is not init');
        }
    }

    //处理接受信息处理
    function initTradeCtp(){
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->on("connect", function($cli) {
            //echo "***********connect";
            $reg1['UserID'] = '058260';
            $reg1['BrokerID'] = '9999';
            $reg1['HandlerID'] = 'RegisterFront';
            $reg1['FrontADD'] = 'tcp://180.168.146.187:10030';
            //$reg1->FrontADD = 'tcp://180.168.146.187:10031';
            $data = json_encode_gbk($reg1);
            $cli->send($data);
        });
        $this->client->on("error", function($cli){
            echo "connect failed\n";
        });
        $this->client->on("close", function($cli){
            echo "connection close\n";
        });
        $this->client->connect("127.0.0.1", 12590, 0.5);
        $this->client->on("receive", function($cli, $data){
            //echo "\nreceived: {$data}\n";
            $obj = json_decode_gbk($data);
            $this->doReceive($obj,$data,$cli);
        });
    }

    //处理接受信息处理
    public function doReceive($obj,$data,$cli){
        switch($obj['HandlerID']){
            //--操作：用户登录 ReqUserLogin 4个参数是必须的
            case 'OnFrontConnected':
                $reg1['UserID'] = '058260';
                $reg1['BrokerID'] = '9999';
                $reg1['Password'] = 'gh002731gh';
                $reg1['HandlerID'] = 'ReqUserLogin';
                $data1 = json_encode_gbk($reg1);
                $cli->send($data1);
                echo "OnFrontConnected: { send ReqUserLogin}\n";
                break;

            //--操作：确认结算单 ReqSettlementInfoConfirm 4个参数是必须的
            case 'OnRspUserLogin':
                $reg2['UserID'] = '058260';
                $reg2['InvestorID'] = '058260';
                $reg2['BrokerID'] = '9999';
                $reg2['HandlerID'] = 'ReqSettlementInfoConfirm';
                $data2 = json_encode_gbk($reg2);
                $cli->send($data2);
                echo "OnRspUserLogin: { send ReqSettlementInfoConfirm}\n";
                break;

            //--收到 OnRspSettlementInfoConfirm 信息 登陆完成，其他功能可用
            case 'OnRspSettlementInfoConfirm':
                echo "OnRspSettlementInfoConfirm!\n";
                break;

            default:
                if (method_exists($this, $obj['HandlerID'])) {
                    $userTableArr=array();
                    if (!empty($this->user_table)) {
                        foreach($this->user_table as $uid=>$_data)
                        {
                            if($_data['zid']==$obj['UserID']){
                                $userTableArr = $_data;
                                break;
                            }
                        }
                    }
                    $this->$data['HandlerID']($obj,$userTableArr);
                    return false;
                }else{
                    return false;
                }
                break;
        }
        return false;
    }

    function ReqUserLogin($data,$params){
        //判断auth 并登陆账号（后续执行登陆CTP链接）
        $uid= $data['UserID'];

        if(empty($data['UseType'])){
            $this->swoole->push($params['socket_id'],json_encode(array('error'=>'use type nil')));
            return false;
        }

        if($data['UseType']==1){
            $authInfo=Db('customer')->where('id','=',$uid)->field(['auth','zid','zpwd','bid'])->find();
        }elseif($data['UseType']==2){
            $authInfo=Db('agentor')->where('id','=',$uid)->field(['auth','zid','zpwd','bid'])->find();
        }else{
            $this->swoole->push($params['socket_id'],json_encode(array('error'=>'UseType unAccept!')));
            return false;
        }
        if(empty($authInfo) || $authInfo['auth']!=$data['AuthCode']){
            $this->swoole->push($params['socket_id'],json_encode(array('error'=>'auth fail')));
            return false;
        }


        if(empty($this->user_table)) {
            throw new \Exception('user_table is not init');
            return false;
        }
        $this->swoole->push($params['socket_id'], json_encode($data));
        $update_info = array(
            'socket_id' => $params['socket_id'],
            'uid'   => $data['UserID'],
            'zid'   => $authInfo['zid'],
        );
        $this->user_table->set($data['UserID'], $update_info );
    }

    //--测试查询合约：InstrumentID不填，查询所有合约，填写查询单个合约
    function ReqQryInstrument($data,$params){

        //找到这个用户ID，对应的socket 如果与当前不一致，则需要重新登陆
        $data1 = json_encode_gbk($data);
        $this->client->send($data1);
        $this->swoole->push($params['socket_id'], json_encode($data));
    }

    //--测试查询账户资金：4个参数必须
    function ReqQryTradingAccount($data,$params){

        //找到这个用户ID，对应的socket 如果与当前不一致，则需要重新登陆
        $data1 = json_encode_gbk($data);
        $this->client->send($data1);
        $this->swoole->push($params['socket_id'], json_encode($data));
    }


    //--测试查询账户持仓（汇总）：4个参数必须
    //--InstrumentID不填，查询全部；
    function ReqQryInvestorPosition($data,$params){

        //找到这个用户ID，对应的socket 如果与当前不一致，则需要重新登陆
        $data1 = json_encode_gbk($data);
        $this->client->send($data1);
        $this->swoole->push($params['socket_id'], json_encode($data));
    }


    //--测试报单：limit 回调信息里面记录报单引用 OrderRef，用于撤
    function ReqOrderInsert($data,$params){

        //找到这个用户ID，对应的socket 如果与当前不一致，则需要重新登陆
        $data1 = json_encode_gbk($data);
        $this->client->send($data1);
        $this->swoole->push($params['socket_id'], json_encode($data));
    }

    //--测试撤单
    function ReqOrderAction($data,$params){

        //找到这个用户ID，对应的socket 如果与当前不一致，则需要重新登陆
        $data1 = json_encode_gbk($data);
        $this->client->send($data1);
        $this->swoole->push($params['socket_id'], json_encode($data));
    }


    //--处理获取资金回调
    function OnRspQryTradingAccount($data,$userTableArr){

        if(empty($userTableArr) || isset($userTableArr['zid'])|| isset($userTableArr['uid'])){
            return false;
        }

        //更新数据库中对应账号的资金金额
        $updateArr['total_money']=$data['TradingAccount']['Available'];
        Db('customer')->where('id','=',$userTableArr['uid'])->update($updateArr);

        //发送结果给前端
        $sendData=$data['TradingAccount'];
        self::sendMsgClient($sendData,$this->swoole,$userTableArr);

    }

    //--处理获取持仓回调
    function OnRspQryInvestorPosition($data,$userTableArr){
        //更新数据库中对应账号的获取持仓

        //发送结果给前端
        $sendData=$data['InvestorPosition'];
        self::sendMsgClient($sendData,$this->swoole,$userTableArr);
    }

    //--处理报单回调
    function OnRtnOrder($data,$userTableArr){
        //更新数据库中对应账号的报单回调

        //发送结果给前端
        $sendData=$data['Order'];
        self::sendMsgClient($sendData,$this->swoole,$userTableArr);
    }

    //--处理成交回报
    function OnRtnTrade($data,$userTableArr){

        if(empty($userTableArr)|| empty($data['Trade']) || empty($data) || !isset($userTableArr['zid'])|| !isset($userTableArr['uid'])){
            return false;
        }
        $sendData=$data['Trade'];
        //发送结果给前端
        self::sendMsgClient($sendData,$this->swoole,$userTableArr);

        //更新数据库中对应账号的成交回报,账单
        $insertDataArr['uid']=$userTableArr['uid'];
        $insertDataArr['zid']=$userTableArr['zid'];
        $insertDataArr['instrumentid']=$sendData['InstrumentID'];
        $insertDataArr['exchangeid']=$sendData['ExchangeID'];
        $insertDataArr['tradeid']=$sendData['TradeID'];
        $insertDataArr['direction']=$sendData['Direction'];
        $insertDataArr['ordersysid']=$sendData['OrderSysID'];
        $insertDataArr['clientid']=$sendData['ClientID'];
        $insertDataArr['tradeid']=$sendData['TradeID'];
        $insertDataArr['exchangeinstid']=$sendData['ExchangeInstID'];
        $insertDataArr['offsetflag']=$sendData['OffsetFlag'];
        $insertDataArr['price']=$sendData['Price'];
        $insertDataArr['volume']=$sendData['Volume'];
        $insertDataArr['tradedate']=$sendData['TradeDate'];
        $insertDataArr['tradetime']=$sendData['TradeTime'];
        $insertDataArr['tradetype']=$sendData['TradeType'];
        $insertDataArr['orderlocalid']=$sendData['OrderLocalID'];
        $insertDataArr['businessunit']=$sendData['BusinessUnit'];
        $insertDataArr['sequenceno']=$sendData['SequenceNo'];
        $insertDataArr['tradingday']=$sendData['TradingDay'];
        $insertDataArr['brokerorderseq']=$sendData['BrokerOrderSeq'];
        Db('user_order')->insert($insertDataArr);

    }
}
