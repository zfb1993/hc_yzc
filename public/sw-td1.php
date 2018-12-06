<?php
//--处理文本 支持中文
function MyUrlDecode($data) {
    if(!is_array($data)){
        $data = urldecode($data);
        $data = str_replace('\r',"\r",$data);
        $data = str_replace('\n',"\n",$data);
    }
    else {
        foreach($data as $key=>$value) {
            $data[MyUrlDecode($key)] = MyUrlDecode($value);
	    if((string)MyUrlDecode($key)!==(string)$key){
                unset($data[$key]);
            }
        }
    }
    return $data;
}

function MyJsonDecode($data){
    $data = urlencode($data);
    $data = str_replace("%7B",'{',$data);
    $data = str_replace("%7D",'}',$data);
    $data = str_replace("%5B",'[',$data);
    $data = str_replace("%5D",']',$data);
    $data = str_replace("%3A",':',$data);
    $data = str_replace("%2C",',',$data);
    $data = str_replace("%22",'"',$data);
    return MyUrlDecode(json_decode($data,true));
}


$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
$client->on("connect", function($cli) {
    //--注册前置机 4个参数是必须的
	$reg1['UserID'] = '058260';
    $reg1['BrokerID'] = '9999';
    $reg1['HandlerID'] = 'RegisterFront';
	//--仿真交易 前置地址
    //$reg1['FrontADD'] = 'tcp://180.168.146.187:10000';
	//$reg1['FrontADD'] = 'tcp://180.168.146.187:10001';
	//$reg1['FrontADD'] = 'tcp://218.202.237.33:10002';
	//--24小时测试环境 前置地址
	$reg1['FrontADD'] = 'tcp://180.168.146.187:10030';	

	$data = json_encode($reg1);
	$cli->send($data);
});
$client->on("receive", function($cli, $data){
    echo "\n {$data}\n";
	$obj = MyJsonDecode($data,true);
	//--收到 OnFrontConnected 信息 
	//--操作：用户登录 ReqUserLogin 4个参数是必须的
	if(strcmp($obj['HandlerID'], 'OnFrontConnected')==0){
		$reg1['UserID'] = '058260';
        $reg1['BrokerID'] = '9999';
        $reg1['Password'] = 'gh002731gh';
        $reg1['HandlerID'] = 'ReqUserLogin';

		$data1 = json_encode($reg1);
		$cli->send($data1);
	}
	//--收到 OnRspUserLogin 信息 应记录 FrontID SessionID 用于撤单
	//--操作：确认结算单 ReqSettlementInfoConfirm 4个参数是必须的
	else if(strcmp($obj['HandlerID'],'OnRspUserLogin')==0){
		$reg1['UserID'] = '058260';
		$reg1['InvestorID'] = '058260';
        $reg1['BrokerID']= '9999';		
        $reg1['HandlerID'] = 'ReqSettlementInfoConfirm';
		
		//$reg1['TradingDay'] = '20180425';
		//$reg1['HandlerID'] = 'ReqQrySettlementInfo';
		//$reg1['HandlerID'] = 'ReqQrySettlementInfoConfirm';
		
		$data1 = json_encode($reg1);
        $cli->send($data1);

	}
	//--收到 OnRspSettlementInfoConfirm 信息 登陆完成，其他功能可用
	else if(strcmp($obj['HandlerID'],'OnRspSettlementInfoConfirm')==0){		
		//--测试查询合约：InstrumentID不填，查询所有合约，填写查询单个合约
		/*/
		$reg1['UserID'] = '058260';
        //$reg1['InstrumentID']= 'ag1812'; 
		$reg1['HandlerID'] = 'ReqQryInstrument';
		/*/
		
		//--测试查询账户资金：4个参数必须
		/*/
		$reg1['UserID'] = '058260';
		$reg1['InvestorID'] = '058260';
        $reg1['BrokerID']= '9999';		
        $reg1['HandlerID'] = 'ReqQryTradingAccount';
		/*/
		
		//--测试查询账户持仓（汇总）：4个参数必须
		//--InstrumentID不填，查询全部；填写，插叙单个合约
		/*/
		$reg1['UserID'] = '058260';
		$reg1['InvestorID'] = '058260';
        $reg1['BrokerID']= '9999';
		//$reg1['InstrumentID']= 'ag1812'; 
        $reg1['HandlerID'] = 'ReqQryInvestorPosition';
		/*/
		
		//--测试报单：limit 回调信息里面记录报单引用 OrderRef，用于撤单
		
		$reg1['UserID'] = '058260';
		$reg1['HandlerID'] = 'ReqOrderInsert';
		
		$reg1['InvestorID'] = '058260';
        $reg1['BrokerID']= '9999';
		$reg1['InstrumentID']= 'ag1812'; 
        $reg1['OrderRef'] = '';
		$reg1['Direction'] = '0'; //'0'-buy,'1'-sell
		$reg1['CombOffsetFlag'] = ['0']; //'0'-开,'1'-平,'3'-平今
		$reg1['CombHedgeFlag'] = ['1']; //'1'-投机,'2'-套保,'3'-对冲
		$reg1['VolumeTotalOriginal'] = 1; //报单数量
		$reg1['ContingentCondition'] = '1'; //立即执行
		$reg1['VolumeCondition'] = '1'; //任意数量
		$reg1['MinVolume'] = 1;
		$reg1['ForceCloseReason'] = '0'; //非强平 
		$reg1['IsAutoSuspend'] = 0; //
		$reg1['UserForceClose'] = 0; //
		
		$reg1['OrderPriceType'] = '1'; 
		$reg1['LimitPrice'] = 4000; 
		$reg1['TimeCondition'] = '1'; 
		
		
		//--测试撤单
		/*/
		$reg1['UserID'] = '058260';
		$reg1['HandlerID'] = 'ReqOrderAction';
		
		$reg1['InvestorID'] = '058260';
        $reg1['BrokerID']= '9999';
		$reg1['FrontID']= ; //记录
		$reg1['SessionID']= ; //记录
		$reg1['OrderRef']= ''; //记录	
		/*/
		
		$data1 = json_encode($reg1);
		$cli->send($data1);
	}
});
$client->on("error", function($cli){
    echo "connect failed\n";
});
$client->on("close", function($cli){
    echo "connection close\n";
});
$client->connect("127.0.0.1", 12590, 0.5);






?>
