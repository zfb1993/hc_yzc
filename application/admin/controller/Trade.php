<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Trade extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    return $this->fetch();
  }
  //建仓委托
  public function openPosition()
  {
    if(Request()->isPost()){
      $listData=Db('user_declaration')->select();
      if($listData){
          foreach ($listData as $key=>$value){
              //用户信息
              $user=Db('customer')->where('id',$listData[$key]['uid'])->find();
              if($user){
                  $listData[$key]['true_name']=$user['true_name'];
                  $listData[$key]['mobile']=$user['mobile'];
                  $listData[$key]['ins_name']=$user['ins_name'];
                  $listData[$key]['p_name']=$user['p_name'];
              }
              //多空（方向）
              if($listData[$key]['direction']==48){
                  $listData[$key]['direction']='涨';
              }else if($listData[$key]['direction']==49){
                  $listData[$key]['direction']='跌';
              }else{
                  $listData[$key]['direction']='';
              }
              //合约名称
              $contract=Db('contract_manage')->where('c_code',$listData[$key]['instrumentid'])->find();
              if($contract){
                  $listData[$key]['c_name']=$contract['c_name'];
                  $listData[$key]['ptglf']=$contract['ptglf'];
                  $listData[$key]['sxf']=$contract['sxf'];
                  $listData[$key]['jsfwf']=$contract['jsfwf'];
              }
              //止盈 stop_profit
              $listData[$key]['stop_profit']=0;
              //止损 stop_loss
              $listData[$key]['stop_loss']=0;
              //时间格式转换
              $listData[$key]['inserttime']=date('Y-m-d H:i:s',$value['inserttime']);
          }
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }
  
  //平仓委托
   public function closePosition()
  {
    if(Request()->isPost()){
      $listData=Db('user_order')->select();
      if($listData){
          foreach ($listData as $key=>$value){
              //用户信息
              $user=Db('customer')->where('id',$listData[$key]['uid'])->find();
              if($user){
                  $listData[$key]['true_name']=$user['true_name'];
                  $listData[$key]['mobile']=$user['mobile'];
                  $listData[$key]['ins_name']=$user['ins_name'];
                  $listData[$key]['p_name']=$user['p_name'];
              }
              //多空（方向）
              if($listData[$key]['direction']==48){
                  $listData[$key]['direction']='涨';
              }else if($listData[$key]['direction']==49){
                  $listData[$key]['direction']='跌';
              }else{
                  $listData[$key]['direction']='';
              }
			  //开平
              if($listData[$key]['offsetflag']==48){
                  $listData[$key]['offsetflag']='开';
              }else if($listData[$key]['offsetflag']==49){
                  $listData[$key]['offsetflag']='平';
              }else{
                  $listData[$key]['offsetflag']='';
              }
              //合约名称
              $contract=Db('contract_manage')->where('c_code',$listData[$key]['instrumentid'])->find();
              if($contract){
                  $listData[$key]['c_name']=$contract['c_name'];
                  $listData[$key]['ptglf']=$contract['ptglf'];
                  $listData[$key]['sxf']=$contract['sxf'];
                  $listData[$key]['jsfwf']=$contract['jsfwf'];
              }
              //止盈 stop_profit
              $listData[$key]['stop_profit']=0;
              //止损 stop_loss
              $listData[$key]['stop_loss']=0;
              //时间格式转换
              $listData[$key]['trade_time']=substr($listData[$key]['tradedate'],0,4).'-'.substr($listData[$key]['tradedate'],4,2).'-'.substr($listData[$key]['tradedate'],6,2).' '.$listData[$key]['tradetime'];
          }
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }
  //持仓单
  public function positionOrder()
  {
    if(Request()->isPost()){
      $listData=Db('user_position')->select();
      if($listData){
          foreach ($listData as $key=>$value){
              //用户信息
              $user=Db('customer')->where('id',$listData[$key]['uid'])->find();
              if($user){
                  $listData[$key]['true_name']=$user['true_name'];
                  $listData[$key]['mobile']=$user['mobile'];
                  $listData[$key]['ins_name']=$user['ins_name'];
                  $listData[$key]['p_name']=$user['p_name'];
              }
              //多空（方向）
              if($listData[$key]['posidirection']==49){
                  $listData[$key]['posidirection']='涨';
              }else if($listData[$key]['posidirection']==50){
                  $listData[$key]['posidirection']='跌';
              }else{
                  $listData[$key]['posidirection']='';
              }
			  
			  //持仓量
			   $listData[$key]['volume']=$listData[$key]['ydposition']+$listData[$key]['position'];
              //合约名称
              $contract=Db('contract_manage')->where('c_code',$listData[$key]['instrumentid'])->find();
              if($contract){
                  $listData[$key]['c_name']=$contract['c_name'];
                  $listData[$key]['ptglf']=$contract['ptglf'];
                  $listData[$key]['sxf']=$contract['sxf'];
                  $listData[$key]['jsfwf']=$contract['jsfwf'];
				//成交均价 
			    $listData[$key]['price']=$listData[$key]['positioncost']/($listData[$key]['ydposition']+$listData[$key]['position'])/$contract['c_multiplier'];
              }
              //止盈 stop_profit
              $listData[$key]['stop_profit']=0;
              //止损 stop_loss
              $listData[$key]['stop_loss']=0;
              //时间格式转换
              $listData[$key]['positiondate']=date('Y-m-d H:i:s',$value['positiondate']);
          }
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }
    //查看持仓汇总
   // const  NB_URL='http://47.92.55.81:8888/';
    public function getMotherAccount(){
        $apiurl = getcofig('WINDOWS_URL');
        //http://47.104.173.116:8888/?action=QueryMotherAccount
        $data['action']='QueryMotherAccount';
        $res=http($apiurl,$data,'GET');
        $res=gbkToUtf8($res);
        $res=str_replace('[','{',$res);
        $res=str_replace(']','}',$res);
        $res= '['.substr($res,1);
        $res = substr($res,0,strlen($res)-1).']';
        $resArr=json_decode($res,true);
        $motherArr=array();
        if(!empty($resArr)) foreach($resArr as $key=>$val){
                $motherArrTmp['id']=$val['id'];
            $motherArrTmp['InvestorID']=$val['InvestorID'];
            $motherArr[]=$motherArrTmp;
        }
        return json(array('code'=>1,'msg'=>'成功返回','data'=>$motherArr));
    }
    public function getChildAccount(){
        //http://47.104.173.116:8888/?action=QueryMotherAccount
//        $data['action']='QueryAccountInfo';
        $m=input('motherid');
        $page = 0;
        $arr = [];
        do{
            $page++;
            $resArr = $this->getchild($m,$page);
//            print_r($resArr['TradingAccount']);
            array_push($arr,$resArr['TradingAccount']);
        }while(count($resArr['TradingAccount'])>60);
        $childrArr=array();
        foreach($arr as $vv){
           foreach($vv as $v){
               $childrArrTmp['id']=$v['id'];
               $childrArrTmp['account']=$v['account'];
               $childrArrTmp['name'] =Db('customer')->where('user_name',$v['account'])->value('true_name');
               $childrArr[]=$childrArrTmp;
           }
        }
        return json(array('code'=>1,'msg'=>'成功返回','data'=>$childrArr));
    }

    public function getchild($m,$page=1){
        $data['action']='QueryAccountInfo';
        $data['motherid']=$m;
        $data['page']=$page;
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $res=gbkToUtf8($res);
        $resArr=json_decode($res,true);
        return $resArr;
    }

    public function getPosition1(){
        //http://47.104.173.116:8888/?action=QueryTrader&motherid=100&type=1
        $data['action']='QueryTrader';
        if(!empty(input('mother_acc'))) $data['motherid']=input('mother_acc');
        if(!empty(input('childid')))  $data['childid']=input('childid');
        if(!empty(input('keyword'))){
            $data['childid'] =Db('customer')->where('user_name',input('keyword'))->value('zid');
            unset($data['motherid']);
        }
        $data['type']=input('type',1);
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $res=gbkToUtf8($res);
        $res=str_replace(',[',',"data":[',$res);
        $resArr=json_decode($res,true);
        $arr = $resArr['TraderList'];
        $l = ceil($resArr['Count']/40);

        if($l != 1){
            for($i=2;$i<=$l;$i++){
                $data['page'] = $i;
                $res=http($apiurl,$data,'GET');
                $res=gbkToUtf8($res);
                $res=str_replace(',[',',"data":[',$res);
                $resArr=json_decode($res,true);
                foreach($resArr['TraderList'] as $vv){
                    array_push($arr,$vv);
                }
            }
        }

        $sr = [];
        if(!empty($arr)){
        foreach($arr as $v){
            if($data['type'] == 2){
                if($v['CombOffsetFlag'] != '0'){//开仓
                    if(isset($sr[$v['InstrumentID']][0])){
                        $sr[$v['InstrumentID']][0] ++;
                    }else{
                        $sr[$v['InstrumentID']][0] = 1;
                    }
                }
            }elseif($data['type'] == 1){
                if($v['Direction'] == '48') {//买
                    if(isset($sr[$v['InstrumentID']]['buy'])){
                        $sr[$v['InstrumentID']]['buy'] += $v['Volume'];
                        $sr[$v['InstrumentID']]['buyProfit'] += $v['Profit'];
                    }else{
                        $sr[$v['InstrumentID']]['buy'] = $v['Volume'];
                        $sr[$v['InstrumentID']]['buyProfit'] = $v['Profit'];
                    }
                }else{
                    if(isset($sr[$v['InstrumentID']]['sell'])){
                        $sr[$v['InstrumentID']]['sell'] += $v['Volume'];
                        $sr[$v['InstrumentID']]['sellProfit'] += $v['Profit'];
                    }else{
                        $sr[$v['InstrumentID']]['sell'] = $v['Volume'];
                        $sr[$v['InstrumentID']]['sellProfit'] = $v['Profit'];
                    }
                }
            }
            $sr[$v['InstrumentID']][1] = $v['InstrumentID'];
        }
        $sr = array_values($sr);
        if($data['type'] == 1) {
            foreach ($sr as &$v) {
                if(!isset($v['sell'])){
                    $v['sell'] = 0;
                    $v['sellProfit'] = 0;
                }
                if(!isset($v['buy'])){
                    $v['buy'] = 0;
                    $v['buyProfit'] = 0;
                }
            }
        }
        }

//        echo '<pre>';
//        print_r($sr);
//        print_r($arr);
//        die;
        return json(array('code'=>0,'msg'=>'成功返回','count'=>count($sr),'data'=>$sr));
    }

    /**
     * @return \think\response\Json
     */
    public function getPosition(){
        //http://47.104.173.116:8888/?action=QueryTrader&motherid=100&type=1
        $data['action']='QueryTrader';
        if(!empty(input('mother_acc'))) $data['motherid']=input('mother_acc');
        if(!empty(input('childid')))  $data['childid']=input('childid');
        if(!empty(input('keyword'))){
            $data['childid'] =Db('customer')->where('user_name',input('keyword'))->value('zid');
            unset($data['motherid']);
        }
        $apiurl = getcofig('WINDOWS_URL');
        $data['type']=input('type',1);
        $data['page']=input('page',1);
        if($data['type']==4){
            $data['action']='QueryAccountInfo';
            $res=http($apiurl,$data,'GET');
            $res=gbkToUtf8($res);
			oplog('admin---获取账户信息--apiurl-->'.$apiurl);
			oplog('admin---获取账户信息--data-->'.json_encode($data));
			oplog('admin---获取账户信息---->'.$res);
            $resArrTmp=json_decode($res,true);
            if(!empty($resArrTmp['TradingAccount'])) {
                $resArr= $resArrTmp['TradingAccount'];
                $count=$resArrTmp['Count'];
            }else{
                $resArr=array('msg'=>json_encode($resArrTmp));
            }
        }else{
			oplog('http地址-->'.$apiurl.'--->参数--->'.json_encode($data));
            $res=http($apiurl,$data,'GET');
//            $res=gbkToUtf8($res);
            $res=str_replace(',[',',"data":[',$res);
            $resArr=json_decode($res,true);
            $count=$resArr['Count'];
            $resArr=$resArr['TraderList'];
//            print_r($res);

//            die;
            if($data['type'] == 1){
                if(!empty($resArr)){
                foreach($resArr as &$v){
                    $v['accname'] = Db('customer')->where('user_name = '.$v['Account'])->value('true_name');
                }
                }
            }
        }

        return json(array('code'=>0,'msg'=>'成功返回','count'=>$count,'data'=>$resArr,'org'=>$res));
    }
  //历史订单
  public function historyOrder()
  {
    if(Request()->isPost()){
      $listData=Db('trade_manage')->where('type','1')->select();
      if($listData){
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }


    public function insertOrder(){
        /* http://47.104.173.116:8888/?action=OrderInsert&childid=1&instrument=rb1810&price=3555&direction=0&of=0&volume=2
         http://47.104.173.116:8888/?action=OrderInsert&childid=1&instrument=rb1810&price=3555&direction=1&of=3&volume=2
         action为操作类型 =OrderInsert为下单
       */
        $data['zid']=input('zid');
        $data['instrument']=input('instrument');
        $data['price']=input('price');
        $data['direction']=input('direction');
        $data['of']=input('of');
        $data['volume']=input('volume');
        $data['stopprofit']=input('stopprofit');
        $data['stoplost']=input('stoplost');
        $data['auth']=input('auth');
        $data['action']='OrderInsert';
        if($data['direction']==1){
            $data['direction']=0;
        }elseif($data['direction']==0){
            $data['direction']=1;
        }
        //action为操作类型 =OrderDelete为撤单
        if(!empty(input('orderref')) && !empty(input('action'))){
            $data['action']='OrderDelete';
            $data['orderref']=input('orderref');
            if(!isset($data['instrument'])||empty($data['zid'])){
                return json(array('code'=>-1,'msg'=>'参数错误'));
            }
        }else{
            if(!isset($data['instrument'])||empty($data['zid'])||!isset($data['direction'])||empty($data['volume'])||!isset($data['of'])){
                return json(array('code'=>-1,'msg'=>'参数错误'));
            }
        }


        $userInfo=Db::name('customer')->where('user_name',$data['zid'])->find();
        if(empty($userInfo)){
            return json(array('code'=>-1,'msg'=>'用户账号不存在'));
        }
        $apiurl = getcofig('WINDOWS_URL');
        $data['childid']=$userInfo['zid'];
        $res=http($apiurl,$data,'GET');
        $res=gbkToUtf8($res);
        $resArr=json_decode($res,true);
        if(!empty($resArr) && $resArr['errormsg']=='' && $resArr['error']==='0'  ){
            return json(array('code'=>1,'msg'=>'操作成功'));
        }else{
            return json(array('code'=>-1,'msg'=>'操作失败'.$res));
        }

    }









 
  //用户数据
  private function userData()
  {
    //$res=db('edit_user_info')->where('level','NEQ','Z')->select();
    //return $res;
  }
    
}
