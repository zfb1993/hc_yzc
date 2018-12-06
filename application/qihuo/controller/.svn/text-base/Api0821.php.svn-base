<?php

namespace app\qihuo\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\admin\model;

class Api extends Controller
{
    /**
     * 测试地址:
    http://106.14.81.139:800/testbase.html
    账户用: 1101
    交易相关: http://106.14.81.139:800/testbase.html
    管理相关: http://106.14.81.139:800/managertestbase.html
    行情相关: http://106.14.81.139:800/markettestbase.html
    账户 adminwebtest
    密码 888888
     */


    const API_URL='http://106.14.81.139:800';

    /**
     *1. 查询资金.
     * @url:/qihuo/api/queryFundDetail
     * @API_URL: /futuresapi/queryFundDetail
     * 第一项	为0，表示正确。值无意义。非0，表示错误。错误时后边的值为错误信息。其后所有项与顺序无关。按Key值决定意义;
     * {"code":1,"msg":"\u8bf7\u6c42\u6210\u529f","data":{"account":"1101","lz_money":1024843.39,"rj_money":0,"cj_money":0,"dj_money":20,"dj_sxf":44.28,"sxf":132.71,"pc_yk":-100,"cc_yk":-700,"money":1001726.4,"jt_qy":1024843.39,"dt_qy":1023910.68}}
     * data: 1: Account;2: 上次结算准备金;3: 入金金额 4: 出金金额,5: 冻结保证金,6: 冻结手续费,7: 手续费,8: 平仓盈亏,9: 持仓盈亏,10: 可用资金,11: 静态权益,12: 动态权益
     * {"0":"","1":"1101","2":1024843.390000,"3":0.000000,"4":0.000000,"5":0.000000,"6":0.000000,"7":0.000000,"8":0.000000,"9":33300.000000,"10":994333.390000,"11":1024843.390000,"12":1058143.390000}
     */
    public function queryFundDetail()
    {
        $account=input('account');
        $data['account']=$account;
        $res=queryFundDetail($data);
        echo json_encode($res);
    }

    /**
     * 2. 出入金
     * @url:/qihuo/api/actFundTransfer
     * @API_URL:/futuresapi/actFundTransfer
     * params:	account,direction (0: 入金，1：出金),amount,transfertype(0:劣后，1：优先)
     * 第一项	为0，表示正确。值无意义。非0，表示错误。错误时后边的值为错误信息。
     */
    public function actFundTransfer()
    {
        $account=input('account');
        $direction=input('direction');
        $amount=input('amount');
        $transfertype=input('transfertype');
        $data['account']=$account;
        $data['direction']=$direction;
        $data['amount']=$amount;
        $data['transfertype']=$transfertype;
        $res=actFundTransfer($data);
        echo json_encode($res);
    }

    /**
     * 3. 自适应开平市价单
     * @url:/qihuo/api/actMarketOrderNoOffset
     * @API_URL:/futuresapi/actMarketOrderNoOffset
     * params:	account,instrument, (合约)direction (0: 买，1：卖),volume
    返回：   第一项	为0，表示正确。值无意义。非0，表示错误。错误时后边的值为错误信息。
     */
    public function actMarketOrderNoOffset(){

        $account=input('account');
        $direction=input('direction');
        $volume=input('volume');
        $instrument=input('instrument');

        $data['account']=$account;
        $data['direction']=$direction;
        $data['volume']=$volume;
        $data['instrument']=$instrument;
        $res=actMarketOrderNoOffset($data);
        echo json_encode($res);
    }

    /**
     * 4. 市价单
     * @url:/qihuo/api/actMarketOrder?account=777&direction=0&volume=1&instrument=R1080&offset=0&auth=xxx
     * @API_URL:/futuresapi/actMarketOrder
     * params:account,instrument(合约)，direction (0: 买 涨，1：卖 跌),offset (0: 开仓，1：平仓, 3: 平今),volume（手数）,auth 签名验证
    返回：   第一项	为0，表示正确。值无意义。非0，表示错误。错误时后边的值为错误信息。
     */
    public function actMarketOrder(){
        $account=input('account');
        $direction=input('direction');
        $volume=input('volume');
        $instrument=input('instrument');
        $offset=input('offset');
        $auth=input('auth');
        if(!isset($account)||!isset($direction)||!isset($volume)||!isset($instrument)||!isset($offset)||!isset($auth)){
            return json(array('code'=>-1,'msg'=>'参数错误'));
        }
        $data['account']=$account;
        $data['direction']=$direction;
        $data['volume']=$volume;
        $data['offset']=$offset;
        $data['instrument']=$instrument;

        $insertData['account']=$data['account'];
        $insertData['heyue']=$data['instrument'];
        $insertData['direction']=$data['direction'];
        $insertData['offset']=$data['offset'];
        $insertData['volume']=$data['volume'];
        $insertData['kc_price']=0;
        $insertData['bz_money']=0;
        $insertData['kc_date']=0;
        $insertData['ip']=get_client_ip();
        $insertData['create_time']=time();
        $insertData['status']=0;
       // $res=actMarketOrder($data);
        if(!empty($res)&&$res['code']==1){
            $insertData['kc_price']=0;
            $insertData['bz_money']=0;
            $insertData['kc_date']=0;
            $insertData['status']=1;
        }
        db::name('hy_order')->insert($insertData);
        return json(array('code'=>1,'msg'=>'下单成功','data'=>$data));
        //echo json_encode($res);
    }

    /**
     * 5. 持仓查询
     * @url:/qihuo/api/queryPositionDetail
     * @API_URL:/futuresapi/actMarketOrder
     * params:{"data":[{"1":"aa","2":"bb"......},{......}]}
     *  第一项	为0，表示正确。值为持仓信息数组。非0，表示错误。错误时后边的值为错误信息。持仓信息数组中每项值的顺序不固定。按Key值决定意义;
        1: Account;2: 合约,3: 方向;4: 开仓日期5: 手数,6: 开仓价格,7: 占用保证金
     */
    public function queryPositionDetail(){
        $account=input('account');
        $data['account']=$account;
        $res=queryPositionDetail($data);
        echo json_encode($res);
    }


    /**
    4. 优先资金查询
    call: url/futuresapi/queryFundPrior
    method: post
    params:	account,
    back:
    Correct: {0:"", 1:data,2:data,3:data.......}
    key-Explain:
    第一项	为0，表示正确。值为持仓信息数组。
    非0，表示错误。错误时后边的值为错误信息。
    持仓信息数组中每项值的顺序不固定。按Key值决定意义;
    1: Account;
    2: 昨优先资金
    3: 当前优先资金
    5. 持仓汇总查询
    call: url/futuresapi/queryPositionSummary
    method: post
    params:	account,
    back:
    {"data":[{"1":"aa","2":"bb"......},{......}]}
    key-Explain:
    第一项	为0，表示正确。值为持仓信息数组。
    非0，表示错误。错误时后边的值为错误信息。
    持仓信息数组中每项值的顺序不固定。按Key值决定意义;
    1: Account;
    2: 合约
    3: 方向;
    4: 手数
    5: 开仓均价
    6: 占用保证金
    7: 持仓盈亏
     */


    /**
     * 账户密码重置
     * @url:/qihuo/api/queryFundDetail
     * @API_URL: /managerapi/reqAccountResetPassword
     * back:{"id":"message"}id = 0： 正确。其它： 错误;
     */
    public function reqAccountResetPassword()
    {
        $url=self::API_URL.'/managerapi/reqAccountResetPassword';
        $account=input('account');
        $password=input('password');
        $data['account']=$account;
        $data['password']=$password;
        $res=http($url,$data,'POST');
        echo $res;
    }

    /**
     * 测试webservice接口
     * @url:/qihuo/api/testwsdl
     * @API_URL: /managerapi/reqAccountResetPassword
     * back:{"id":"message"}id = 0： 正确。其它： 错误;
     */
    public function testwsdl()
    {

        $content='55551'."|".'nb123456';
        $res=aliSmsNotice(13975196821,$content,$skin='33657');
        var_dump($res);
       /* echo ord('1');exit;
        $url='http://118.89.194.86:9118/webser/WebTN.dll/wsdl/IwebV';
        $soap = new \SoapClient($url);
        $ret_object =  $soap->__soapCall('heartbeat',array());
        echo $ret_object;*/
    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取股票K数据格式
     * @url:/qihuo/Api/getQihuoKlineData?stockid=RB0Y00.XSGE&candle_period=6
     * @params_remark:stockid:股票代码
     * candle_period:必选K线周期	取值可以是数字1-9，表示含义如下： 1：1分钟K线 2：5分钟K线 3：15分钟K线 4：30分钟K线 5：60分钟K线 6：日K线 7：周K线 8：月K线 9：年K线
      @returnRes:[["2017/10/31",28.8,28.96,28.28,29.28],["2017/11/01",28.96,29.15,28.73,30.54]]
     */
    public function getQihuoKlineData(){
        $prodCode=input('stockid');
        $type=input('candle_period');
        $dayKlineUrl='http://107.1caopan.com/index/selfstock/kline?get_type=offset&prod_code=';
        $dayKlineUrl.=$prodCode.'&candle_period='.$type.'&candle_mode=1&fields=open_px,high_px,low_px,close_px,business_amount&data_count=200';
        $content=http($dayKlineUrl);
        $contentArr=json_decode($content,true);
        if(is_array($contentArr)&&isset($contentArr['data']['candle'][$prodCode])){
            $qihuoKArr=$contentArr['data']['candle'][$prodCode];
            $dataArr= $tmpArr=array();
            foreach($qihuoKArr as $key=>$val){
                //循环读取配置数据，从第二行开始
                $tmpArr=array($val[0],$val[1],$val[4],$val[3],$val[2],$val[5]);
                if(!empty($tmpArr)) $dataArr[]=$tmpArr;
                $tmpArr=array();
            }
        }else{
            return '-';
        }
        echo json_encode($dataArr,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取分时数据
     * @url:/qihuo/Api/getQihuoMinuteData?stockid=RB1805.XSGE
     * @params_remark:stockid:股票代码
     * @returnRes:[["93:0","93:1","93:2","93:3","93:4],["10.85","10.89","10.88","10.86","10.86"]]
     */
    public  function getQihuoMinuteData(){
        $prodCode=strtoupper(input('stockid'));
        $Url='http://107.1caopan.com/index/selfstock/trend/?prod_code=';
        $Url.=$prodCode.'&fields=last_px';
        $content=http($Url);
        $contentArr=json_decode($content,true);
        if(is_array($contentArr)&&isset($contentArr['data']['trend'][$prodCode])){
            $qihuoKArr=$contentArr['data']['trend'][$prodCode];
            $dataArr= $tmpArr=array();
            foreach($qihuoKArr as $key=>$val){
                $h=substr($val[0],8,2);
                $m=substr($val[0],10,2);
                $timeTmpArr[]=$h.':'.$m;
                $stockTmpArr[]=$val[1];
            }
            $dataArr[0]=$timeTmpArr;
            $dataArr[1]=$stockTmpArr;
        }else{
            return '-';
        }
        echo json_encode($dataArr,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    /************************************* 获取诺贝对接接口************************************************* */
    const  NB_URL='http://47.92.55.81:8888/';

    /**
     * @date: 2017/07/01
     * @author: willion
     * @brief:获取持仓
     * @url:http://cqh.1caopan.com/qihuo/api/getUserRecord?userid=14&type=2&auth=xxx
     * userid 用户ID;type类型：0为未成交  =1为持仓 =2 平仓记录 3 全部；auth:登陆时候返回，存在本地localstorage 中（用户ID也是）
     * @return_param:
     * {"code":1,"msg":"返回成功","data":[
     * {"Direction":"买","InsertDate":"20180604","InsertTime":"13:42:02","InstrumentID":"rb1810","OrderRef":"1342020352","OrderStatus":"3","Price":"0.000000","Volume":"0","InstrumentName":"螺纹钢RB1810"},{"Direction":"买","InsertDate":"20180604","InsertTime":"13:42:07","InstrumentID":"rb1810","OrderRef":"1342080353","OrderStatus":"3","Price":"0.000000","Volume":"0","InstrumentName":"螺纹钢RB1810"},{"Direction":"买","InsertDate":"20180604","InsertTime":"13:46:06","InstrumentID":"rb1810","OrderRef":"1346060354","OrderStatus":"3","Price":"0.000000","Volume":"0","InstrumentName":"螺纹钢RB1810"},{"Direction":"买","InsertDate":"20180604","InsertTime":"13:46:11","InstrumentID":"rb1810","OrderRef":"1346120355","OrderStatus":"3","Price":"0.000000","Volume":"0","InstrumentName":"螺纹钢RB1810"}
     * ]}
     */
    public function getUserRecord(){
       // http://47.104.173.116:8888/?action=QueryTrader&userid=14&type=1
        $data['type']=input('type');
        $data['userid']=input('userid');
        $data['action']='QueryTrader';
        if(!isset($data['type'])||empty($data['userid'])){
            return json(array('code'=>-1,'msg'=>'参数错误'));
        }
        $userInfo=Db::name('customer')->where('id',$data['userid'])->find();
        if(empty($userInfo)){
            return json(array('code'=>-1,'msg'=>'userid不存在'));
        }

        $data['childid']=$userInfo['zid'];
        $res=http(self::NB_URL,$data,'GET');
        $res=gbkToUtf8($res);
        $res= substr($res,1);
        $resArrTmp=explode(',[',$res);
        if(isset($resArrTmp[1])){
            $res ='['.$resArrTmp[1];
            $res = substr($res,0,strlen($res)-1);
        }
        $resArr=json_decode($res,true);
        $instrumentIDArr=array();

        if(!empty($resArr)){
          /*      $heyueRes=Db::name('contract_manage')->select();
                if(!empty($heyueRes)){
                    $hyArr=array();
                    foreach ($heyueRes as $key=>$val){
                        $hyArr[$val['c_code']]=$val['c_name'];
                        $hyArr[$val['c_code'].'c_multiplier']=$val['c_multiplier'];

                    }
                    $instrumentIDArr = $hyArr;
                }*/

            //获取对应合约信息
            $nb= new model\NbeApi();
            $dataInstrument['instrument']='';
            $heyueResArr= $nb->getContact($dataInstrument);
            if($heyueResArr['code']==1){
                $heyueRes=$heyueResArr['data'];
                $hyArr=array();
                foreach ($heyueRes as $key=>$val){
                    $hyArr[$val['Instrument']]=$val['Instrument'];
                    $hyArr[$val['Instrument'].'c_multiplier']=$val['PipValue'];
                }
                $instrumentIDArr = $hyArr;
            }

            foreach ($resArr as $key=>&$val){
                if(input('type')==0 && $val['OrderStatus']!=3){
                    unset($resArr[$key]);
                    continue;
                }

                if(input('type')==2 && $val['ClosePrice']=='0.000000'){
                    unset($resArr[$key]);
                    continue;
                }

                if(isset($instrumentIDArr[$val['InstrumentID']])){
                    $val['InstrumentName']=$instrumentIDArr[$val['InstrumentID']];
                    $val['c_multiplier']=$instrumentIDArr[$val['InstrumentID'].'c_multiplier'];
                }

                if(input('type')==2){
                    if($val['Direction']==49){
                        $val['Direction']='买';
                    }else if($val['Direction']==48){
                        $val['Direction']='卖';
                    }
                }else{
                    if($val['Direction']==48){
                        $val['Direction']='买';
                    }else if($val['Direction']==49){
                        $val['Direction']='卖';
                    }
                }
                unset($val['BuyOrderRef']);
                unset($val['BrokerID']);
                unset($val['InvestorID']);
                //unset($val['LimitPrice']);
            }
        }
        $returnArr['code']=1;
        $returnArr['msg']='返回成功';
        $returnArr['data']=$resArr;
        return json($returnArr);
    }

    /**
     * @date: 2017/07/01
     * @author: willion
     * @brief:下单接口
     * @url:http://cqh.1caopan.com/qihuo/api/insertOrder?userid=14&instrument=rb1810&price=3555&direction=0&of=0&volume=2&auth=xxx
     *   userid用户ID，instruent为合约，price 为价格 （如果of为平仓不用填价格 ，如果of为开仓price传0为加市价单）
         direction为买卖方向（同ctp参数）=0为买 =1为卖，of 为开平仓 =0为开哟  仓 =1为平仓，volume为数量
     * @return {"code":1,"msg":"报单成功"}
     * @return_param:
     */
    public function insertOrder(){
       /* http://47.104.173.116:8888/?action=OrderInsert&childid=1&instrument=rb1810&price=3555&direction=0&of=0&volume=2
        http://47.104.173.116:8888/?action=OrderInsert&childid=1&instrument=rb1810&price=3555&direction=1&of=3&volume=2
        action为操作类型 =OrderInsert为下单
      */
        $data['userid']=input('userid');
        $data['instrument']=input('instrument');
        $data['price']=input('price');
        $data['direction']=input('direction');
        $data['of']=input('of');
        $data['volume']=input('volume');
        $data['stopprofit']=input('stopprofit');
        $data['stoplost']=input('stoplost');
        $data['auth']=input('auth');
        $data['action']='OrderInsert';
        //action为操作类型 =OrderDelete为撤单
        if(!empty(input('orderref')) && !empty(input('action'))){
            $data['action']='OrderDelete';
            $data['orderref']=input('orderref');
            if(!isset($data['instrument'])||empty($data['userid'])){
                return json(array('code'=>-1,'msg'=>'参数错误'));
            }
        }else{
            if(!isset($data['instrument'])||empty($data['userid'])||!isset($data['direction'])||empty($data['volume'])||!isset($data['of'])){
                return json(array('code'=>-1,'msg'=>'参数错误'));
            }
        }


        $instrumentIDArr=array();
        $heyueRes=Db::name('contract_manage')->select();
        if(!empty($heyueRes)){
            $hyArr=array();
            foreach ($heyueRes as $key=>$val){
                $data['instrument']=strtoupper($data['instrument']);
                if($val['c_code']==strtoupper($data['instrument'])){
                    $data['instrument']=strtoupper($data['instrument']);
                     break;
                }else if($val['c_code']==strtolower($data['instrument'])){
                    $data['instrument']=strtolower($data['instrument']);
                    break;
                }else{
                    continue;
                }  

            }
        }
        if(!empty($resArr)){
          
            foreach ($resArr as $key=>&$val){
                if(isset($instrumentIDArr[$val['InstrumentID']])){
                    $val['InstrumentName']=$instrumentIDArr[$val['InstrumentID']];
                    $val['c_multiplier']=$instrumentIDArr[$val['InstrumentID'].'c_multiplier'];
                }
                if($val['Direction']==48){
                    $val['Direction']='买';
                }else if($val['Direction']==49){
                    $val['Direction']='卖';
                }
                unset($val['BuyOrderRef']);
                unset($val['BrokerID']);
                unset($val['InvestorID']);
                unset($val['LimitPrice']);
            }
        }

        $userInfo=Db::name('customer')->where('id',$data['userid'])->find();
        if(empty($userInfo)){
            return json(array('code'=>-1,'msg'=>'userid不存在'));
        }
        $data['childid']=$userInfo['zid'];
        $res=http(self::NB_URL,$data,'GET');
        $res=gbkToUtf8($res);
        $resArr=json_decode($res,true);
        if(!empty($resArr) && $resArr['errormsg']=='' && $resArr['error']==='0'  ){
            return json(array('code'=>1,'msg'=>'报单成功'));
        }else{
            return json(array('code'=>-1,'msg'=>'报单失败'.$res));
        }

    }


    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取资金接口
     * @url:http://cqh.1caopan.com/qihuo/api/getAccountInfo?userid=14&auth=xxx
     * @params_remark:
     * @return \think\response\Json
    @returnRes:{"code":1,"msg":"成功返回","data":{"id":"14","account":"15974171311","password":"123123","motherid":"100","cash":"5300000000000.000000","control":"100.000000","FrozenMargin":"5000.000000","FrozenCommission":"50.000000","CurrMargin":"6000.000000","Commission":"0.000000","CloseProfit":"0.000000","PositionProfit":"320.000000","Available":"5299999989270.000000",
     * "DynamicCash":"5300000000320.000000","InCash":"200000000000.000000","OutCash":"0.000000","InitCash":"5100000000000.000000"}}
     */
  public function getAccountInfo(){
          // http://47.104.173.116:8888/?action=QueryAccountInfo&childid=1
          $data['userid']=input('userid');
          $data['auth']=input('auth');
          $data['action']='QueryAccountInfo';
          if(!isset($data['userid'])||empty($data['auth'])){
              return json(array('code'=>-1,'msg'=>'参数错误'));
          }
          $userInfo=Db::name('customer')->where('id',$data['userid'])->find();
          if(empty($userInfo)){
              return json(array('code'=>-1,'msg'=>'userid不存在'));
          }

          $data['childid']=$userInfo['zid'];
          $res=http(self::NB_URL,$data,'GET');
          $res=gbkToUtf8($res);
          $resArr=json_decode($res,true);
          return json(array('code'=>1,'msg'=>'成功返回','data'=>$resArr));
  }


    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取合约品种参数
     * @url:http://cqh.1caopan.com/qihuo/api/getInstrument?instrument=rb1810&userid=14&auth=xxx
     * @params_remark:
     * @return： instrument 为空则返回全部合约，不为空，则返回具体合约的 开仓保证金 OpenBond，手续费Charge，每点价值PipValue
      @returnRes:{"code":1,"msg":"成功返回","data":{"Instrument":"rb1810","Name":"luowengang","OpenBond":"1000.00","Charge":"10.00","PipValue":"10.00"}}
     */
    public function getInstrument(){
        //http:// 47.104.173.116:8888/?action=QueryInstrument&instrument=rb1810
        $data['userid']=input('userid');
        $data['auth']=input('auth');
        $data['instrument']=input('instrument');
        $data['action']='QueryInstrument';
        if(!isset($data['userid'])||empty($data['auth'])){
            return json(array('code'=>-1,'msg'=>'参数错误'));
        }
        $userInfo=Db::name('customer')->where('id',$data['userid'])->find();
        if(empty($userInfo)){
            return json(array('code'=>-1,'msg'=>'userid不存在'));
        }

        $data['childid']=$userInfo['zid'];
        $res=http(self::NB_URL,$data,'GET');
        $res=gbkToUtf8($res);
        $res=str_replace('[','{',$res);
        $res=str_replace(']','}',$res);
        $res= '['.substr($res,1);
        $res = substr($res,0,strlen($res)-1).']';
        $resArr=json_decode($res,true);
        if(!empty($data['instrument'])){
            $resArr=$resArr[0];
        }
        return json(array('code'=>1,'msg'=>'成功返回','data'=>$resArr));
    }


    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:每日结算报表
     * @url:/qihuo/api/dayStatements?day=20180814&zid=20&auth=xxx
     * @params_remark:accountInfo:资金信息，closePosition平仓明细，tradePosition持仓汇总，tradePositionDetail持仓明细，batchTrade成交明细，
     * @returnRes:
     * {"code":1,"day":"20180814","account":"20","accountInfo":
     * {"id":154,"zaccount":"13987654321","accountname":"0","prebalance":"1270.5","balance":"1270.5","available":"1270.5","commission":"0","positionprofit":"0","closeprofit":"0","currmargin":"0","frozenmargin":"0","deposit":"0","withdraw":"0","lowprebalance":"0","lowbalance":"0","lowdeposit":"0","lowwithdraw":"0","lowavailable":"0","highbalance":"0","highdeposit":"0","highwithdraw":"0","tradedate":"20180814","create_time":"2018-08-11 16:00:55","update_time":"2018-08-16 14:45:39"},
     * "closePosition":[{"id":1,"zaccount":"20","direction":"1","offset":"平","commission":"50","instrumentid":"i1901","closeprofit":"-150","tradedate":"20180814","tradeid":"081410081550","tradeprice":"514","openprice":"0","tradetime":"10:08:14","ip":null,"tradevolume":0,"create_time":"2018-08-14 15:20:48"},{"id":2,"zaccount":"20","direction":"1","offset":"平","commission":"100","instrumentid":"cu1810","closeprofit":"-50","tradedate":"20180814","tradeid":"081410111652","tradeprice":"49500","openprice":"0","tradetime":"10:11:15","ip":null,"tradevolume":0,"create_time":"2018-08-14 15:20:48"},
     *                 {"id":3,"zaccount":"20","direction":"1","offset":"平","commission":"100","instrumentid":"cu1810","closeprofit":"0","tradedate":"20180814","tradeid":"081410354655","tradeprice":"49540","openprice":"0","tradetime":"10:35:45","ip":null,"tradevolume":0,"create_time":"2018-08-14 15:20:48"},{"id":4,"zaccount":"20","direction":"1","offset":"平","commission":"100","instrumentid":"cu1810","closeprofit":"-100","tradedate":"20180814","tradeid":"081410354656","tradeprice":"49540","openprice":"0","tradetime":"10:35:45","ip":null,"tradevolume":0,"create_time":"2018-08-14 15:20:48"},
     *                 {"id":5,"zaccount":"20","direction":"0","offset":"平","commission":"50","instrumentid":"rb1901","closeprofit":"-20","tradedate":"20180814","tradeid":"081410461358","tradeprice":"4163","openprice":"0","tradetime":"10:46:13","ip":null,"tradevolume":0,"create_time":"2018-08-14 15:20:48"},{"id":6,"zaccount":"20","direction":"1","offset":"平","commission":"50","instrumentid":"rb1901","closeprofit":"-10","tradedate":"20180814","tradeid":"081410494560","tradeprice":"4160","openprice":"0","tradetime":"10:49:44","ip":null,"tradevolume":0,"create_time":"2018-08-14 15:20:48"}],
     * "tradePositionDetail":[{"id":1,"zaccount":"20","direction":"1","offset":"0","bourse":"0","bzj":"100","instrumentid":"rb1901","profit":"0","tradeprice":"4159","price":"0","tradevolume":2,"tradedate":"20180814","create_time":"2018-08-14 17:53:25"}],
     * "tradePosition":[{"id":4,"zaccount":"20","direction":"1","offset":"0","bzj":"100","instrumentid":"rb1901","profit":"0","tradeprice":"4159","price":"0","tradedate":"20180814","tradevolume":2,"create_time":"2018-08-14 17:55:49"}],
     * "batchTrade":[{"id":1,"zaccount":"20","direction":"0","offset":"开","commission":"50","instrumentid":"i1901","bourse":"0","tradedate":"20180814","tradeid":"081410080249","tradeprice":"515","tradetime":"10:08:01","ip":null,"tradevolume":1,"create_time":"2018-08-14 17:47:32"},{"id":2,"zaccount":"20","direction":"0","offset":"开","commission":"100","instrumentid":"cu1810","bourse":"0","tradedate":"20180814","tradeid":"081410110351","tradeprice":"49510","tradetime":"10:11:03","ip":null,"tradevolume":1,"create_time":"2018-08-14 17:47:32"},
     *             {"id":3,"zaccount":"20","direction":"0","offset":"开","commission":"100","instrumentid":"cu1810","bourse":"0","tradedate":"20180814","tradeid":"081410144053","tradeprice":"49540","tradetime":"10:14:40","ip":null,"tradevolume":1,"create_time":"2018-08-14 17:47:32"},{"id":4,"zaccount":"20","direction":"0","offset":"开","commission":"100","instrumentid":"cu1810","bourse":"0","tradedate":"20180814","tradeid":"081410345254","tradeprice":"49560","tradetime":"10:34:51","ip":null,"tradevolume":1,"create_time":"2018-08-14 17:47:32"},
     *             {"id":5,"zaccount":"20","direction":"1","offset":"开","commission":"50","instrumentid":"rb1901","bourse":"0","tradedate":"20180814","tradeid":"081410450257","tradeprice":"4161","tradetime":"10:45:02","ip":null,"tradevolume":1,"create_time":"2018-08-14 17:47:32"},{"id":6,"zaccount":"20","direction":"0","offset":"开","commission":"50","instrumentid":"rb1901","bourse":"0","tradedate":"20180814","tradeid":"081410492559","tradeprice":"4161","tradetime":"10:49:24","ip":null,"tradevolume":1,"create_time":"2018-08-14 17:47:32"},
     *              {"id":7,"zaccount":"20","direction":"1","offset":"开","commission":"100","instrumentid":"rb1901","bourse":"0","tradedate":"20180814","tradeid":"081410500261","tradeprice":"4159","tradetime":"10:50:01","ip":null,"tradevolume":2,"create_time":"2018-08-14 17:47:32"}]}
     */
    public function dayStatements(){
        $day=input('day');
        $account=input('zid');
        $returnArr=array('code'=>1,'day'=>$day,'account'=>$account);
        $userName='';
        //判断请求账号是否存在
        $userInfo=Db::name('customer')->where('zid',$account)->find();
        if(!empty($userInfo)){
            $userName=$userInfo['user_name'];
        }
        //判断是否有缓存
        $Cachekey=$day.$account;
        $response=\think\Cache::get($Cachekey);
        if(!empty($response)){
            $returnArr=json_decode($response,true);
            return json($returnArr);
        }
        //资金明细
        $accountInfoLog=Db::connect(config('db_trade'))->table('yp_account_info_log')->where('zaccount',$userName)->where('tradedate',$day)->find();
        $returnArr['accountInfo']=$accountInfoLog;

        //平仓明细
        $closePosition=Db::connect(config('db_trade'))->table('yp_close_position')->where('zaccount',$account)->where('tradedate',$day)->select();
        $returnArr['closePosition']=$closePosition;

        //持仓明细yp_trade_position_detail
        $tradePositionDetail=Db::connect(config('db_trade'))->table('yp_trade_position_detail')->where('zaccount',$account)->where('tradedate',$day)->select();
        $returnArr['tradePositionDetail']=$tradePositionDetail;

        //持仓汇总 yp_trade_position
        $tradePosition=Db::connect(config('db_trade'))->table('yp_trade_position')->where('zaccount',$account)->where('tradedate',$day)->select();
        $returnArr['tradePosition']=$tradePosition;
        //var_dump($tradePositionDetail);exit;
        //成交明细
        $batchTrade=Db::connect(config('db_trade'))->table('yp_batch_trade')->where('zaccount',$account)->where('tradedate',$day)->select();
        $returnArr['batchTrade']=$batchTrade;
        \think\Cache::set($Cachekey,json_encode($returnArr),'3600');
        return json($returnArr);

    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:每日结算报表
     * @url:http://cqh.1caopan.com/qihuo/api/dayStatementsLog?day=20180801&account=14&auth=xxx
     * @params_remark:accountInfo:资金详细数组，closePosition：平仓明细，tradePositionDetail：持仓明细，tradePosition：持仓汇总，batchTrade成交明细
     * @returnRes:
     */
    public function dayStatementsLog(){
        $day=input('day');
        $account=input('account');
        $returnArr=array('code'=>1,'day'=>$day,'account'=>$account);

        //查找资管ID，判断是否正常请求
        $accountInfo=Db::name('customer')->where('user_name',$account)->find();
        if(empty($accountInfo)){
           return json(array('code'=>-1,'day'=>$day,'account'=>$account,'msg'=>'参数错误！'));
        }
        //判断是否有缓存
        $Cachekey=$day.$account;
        $response=\think\Cache::get($Cachekey);
        if(!empty($response)){
            $returnArr=json_decode($response,true);
            return json($returnArr);
        }
        //资金明细
        $accountInfoLog=Db::connect(config('db_trade'))->name('account_info_log')->where('zaccount',$account)->where('tradedate',$day)->find();
        $returnArr['accountInfo']=$accountInfoLog;

        //平仓明细
        $closePosition=Db::connect(config('db_trade'))->name('close_position')->where('zaccount',$account)->where('create_time',$day)->find();
        $returnArr['closePosition']=$closePosition;

        //持仓明细yp_trade_position_detail
        $tradePositionDetail=Db::connect(config('db_trade'))->name('trade_position_detail')->where('zaccount',$account)->where('create_time',$day)->find();
        $returnArr['tradePositionDetail']=$tradePositionDetail;

        //持仓汇总 yp_trade_position
        $tradePosition=Db::connect(config('db_trade'))->name('trade_position')->where('zaccount',$account)->where('create_time',$day)->find();
        $returnArr['tradePosition']=$tradePosition;

        //成交明细
        $batchTrade=Db::connect(config('db_trade'))->name('batch_trade')->where('zaccount',$account)->where('create_time',$day)->find();
        $returnArr['batchTrade']=$batchTrade;
        \think\Cache::set($Cachekey,json_encode($returnArr),'3600');
        return json($returnArr);

    }


    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:
     * @url:
     * @params_remark:
     * @returnRes:
     */



    //修改环境配置
    //  @url:/qihuo/Api/config?account=354535295&SttDate=20180501&EndDate=20180504
    function config(){
        //写入配置
        $config = array(
            "theme"=>'default',
            "url"=>'http://pay.sxbcx88.com/',
            "title"=>'WeiPay直达支付官网',
            "keywords"=>'支付宝免签直达支付接口，微信免签支付接口',
            "description"=>'',
            "site"=>'WeiPay直达支付官网',
            "accessKeyId"=>'LTAIhTZWyWEE4X02',
            "accessKeySecret"=>'caoKvHnVJF3sQhJH0c8uM5fqmGfRS8',
            "SignName"=>'WeiPay',
            "TemplateCode"=>'SMS_135033001',
            "Abnormal"=>'SMS_135044683',
            "Poundage"=>str_replace(PHP_EOL, ',', trim('default=>0.008',PHP_EOL))
        );
        file_put_contents(  'dynamic_config.php', self::encode(json_encode($config), 'f5624bac9df1db7b9d6c8fabdb77706d'));
        echo self::encode(json_encode($config), 'f5624bac9df1db7b9d6c8fabdb77706d');
    }
    // RC4加密和解密  action 1加密 2解密
    static function encode($data,$pwd,$action=1){
        if ($action == 1){
            return base64_encode(self::RC4($pwd, $data));
        }
        if ($action == 2){
            return iconv("UTF-8", "GB2312//IGNORE", self::RC4($pwd, base64_decode($data)));
        }
    }

    //RC4加密
    private static function RC4 ($pwd, $data)
    {
        $key[] ="";
        $box[] ="";

        $pwd_length = strlen($pwd);
        $data_length = strlen($data);

        for ($i = 0; $i < 256; $i++)
        {
            $key[$i] = ord($pwd[$i % $pwd_length]);
            $box[$i] = $i;
        }

        for ($j = $i = 0; $i < 256; $i++)
        {
            $j = ($j + $box[$i] + $key[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        $cipher='';
        for ($a = $j = $i = 0; $i < $data_length; $i++)
        {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;

            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;

            $k = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher .= chr(ord($data[$i]) ^ $k);
        }

        return $cipher;
    }

}
