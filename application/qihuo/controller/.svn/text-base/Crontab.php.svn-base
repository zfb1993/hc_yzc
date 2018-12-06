<?php
namespace app\qihuo\controller;
use think\Controller;
use think\Db;
use \think\Log;

class Crontab extends Controller
{
    /**
     * @auth:willion
     * @brief:吉投资管软件拉取查询交易记录
     * @url:/qihuo/Crontab/doSyncTradRecords
     * @params_remark:
     * @throws \Exception
    @returnRes:
     */
    public  function doSyncTradRecords(){
        //从数据库中查询已经开户的用，进行同步处理
        $res=Db::name('customer')->alias('a')->join('zg_sys b','a.zg_id = b.id','INNER')
            ->where('is_open',1)
            ->field(['a.zid','a.id','a.total_money','b.server_ip','b.account'])->select();
        $Date=date('Ymd');
        Db::name('user_trade')->where('tradedate',$Date)->delete();
        if(!empty($res)) foreach($res as $key=>$val){
            $data['UserID']=$val['account'];
            $data['Action']='ReqQryTradeRecords';
            $data['ChdAccountID']=$val['zid'];
            $data['SttDate']=$Date;
            $data['EndDate']=$Date;
            $tradeInfo=$this->_reqQryTradeRecords($data,$val['server_ip']);
            $insertData=array();
            $commission=0;
           if($tradeInfo['code']==1 && !empty($tradeInfo['data'])) foreach($tradeInfo['data'] as $_k=>$_v){
               if(!empty($_v['AccountID'])) {
                   $insertData[] = array(
                       'uid' => $val['id'],
                       'zid' => $val['zid'],
                       'direction' => $_v['Direction'],
                       'offset' => $_v['Offset'],
                       'commission' => $_v['Commission'],
                       'instrumentid' => $_v['Instrumentid'],
                       'closeprofit' => $_v['CloseProfit'],
                       'tradedate' => $_v['Tradedate'],
                       'tradeid' => $_v['Tradeid'],
                       'tradeprice' => $_v['Tradeprice'],
                       'tradetime' => $_v['Tradetime'],
                       'ip' => $_v['IP'],
                       'tradevolume' => $_v['Tradevolume']
                   );
                   $commission+=$_v['Commission'];
               }
            }
            if(!empty($insertData)) {
              Db::name('user_trade')->insertAll($insertData);
              Db('account_info')->where('uid',$val['id'])->update(array('commission'=>$commission));
            }
            echo $val['zid'].'交易处理完毕，共'.count($insertData).'笔'."\n";
            unset($insertData);
        }
    }

    /**
     * @auth:willion
     * @brief:吉投资管软件请求查询账户余额校对
     * @url:/qihuo/Crontab/doSyncAccountMoney
     * @params_remark:
     * @throws \Exception
       @returnRes:
     */
    public function doSyncAccountMoney(){
        //从数据库中查询已经开户的用，进行同步处理
        $res=Db::name('customer')->alias('a')->join('zg_sys b','a.zg_id = b.id','INNER')
            ->where('is_open',1)
            ->field(['a.zid','a.id','a.total_money','b.server_ip','b.account'])->select();
        if(!empty($res)) foreach($res as $key=>$val){
            $data['UserID']=$val['account'];
            $data['Action']='ReqQryAccountInfo';
            $data['ChdAccountID']=$val['zid'];
            $accountInfo=$this->_reqQryAccountInfo($data,$val['server_ip']);
            if($accountInfo['code']==1 && !empty($accountInfo['Available'])) {
                   Db::name('customer')->where('id',$val['id'])->update(array('available_money'=>$accountInfo['Balance']/100,'total_money'=>$accountInfo['Balance']/100));
                   $insertData= array(
                       'uid' => $val['id'],
                       'zid' => $val['zid'],
                       'accountname' => $accountInfo['AccountName'],
                       'prebalance' => $accountInfo['PreBalance'],
                       'balance' => $accountInfo['Balance'],
                       'available' => $accountInfo['Available'],
                       'positionprofit' =>$accountInfo['PositionProfit'],
                       'closeprofit' => $accountInfo['CloseProfit'],
                       'currmargin' =>$accountInfo['CurrMargin'],
                       'frozenmargin' => $accountInfo['FrozenMargin'],
                       'deposit' =>$accountInfo['Deposit'],
                       'withdraw' => $accountInfo['Withdraw'],
                       'lowprebalance' =>$accountInfo['LowPreBalance'],
                       'lowbalance' => $accountInfo['LowBalance'],
                       'lowdeposit' => $accountInfo['LowDeposit'],
                       'lowwithdraw' =>$accountInfo['LowWithdraw'],
                       'lowavailable' => $accountInfo['LowAvailable'],
                       'highbalance' => $accountInfo['HighBalance'],
                       'highdeposit' => $accountInfo['HighDeposit'],
                       'highwithdraw' => $accountInfo['HighWithdraw']
                   );
                Db('account_info')->insert($insertData,true);
                echo $val['zid'].'资金更新完毕，更新资金为'.($accountInfo['Balance']/100)."\n";
            }else{
                echo $val['zid'].'资金，处理失败'."\n";
            }


        }
    }


    //结算
    public function jieSuan()
    {
        //返佣明细表
        $list=Db('account_info')->select();
        $res=Db('user_settlement')->find();
        if($res){
            Db('user_settlement')->delete(true);
        }
        foreach($list as $key=>$value)
        {
            $user=Db('customer')->where('id',$list[$key]['uid'])->find();
            $agent=Db('agentor')->where('id',$user['aid'])->find();
            switch($agent['aid']){
                case 1:
                    $sxf=intval($list[$key]['commission']);
                    $z_name=Db('zg_sys')->where('id',$agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$agent['mzh_id'])->value('account');
                    $money=$sxf*($agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    break;
                case 2:
                    //上级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $z_name=Db('zg_sys')->where('id',$agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$agent['mzh_id'])->value('account');
                    $money=$sxf*($agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    //一级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $one_agent=Db('agentor')->where('id',$agent['pid'])->find();
                    $z_name=Db('zg_sys')->where('id',$one_agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$one_agent['mzh_id'])->value('account');
                    $money=$sxf*($one_agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$one_agent['id'],
                        'p_name'=>$one_agent['true_name'],
                        'jszq'=>$one_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$one_agent['id'],
                        'p_name'=>$one_agent['true_name'],
                        'jszq'=>$one_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    break;
                case 3:
                    //上级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $z_name=Db('zg_sys')->where('id',$agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$agent['mzh_id'])->value('account');
                    $money=$sxf*($agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    //二级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $two_agent=Db('agentor')->where('id',$agent['pid'])->find();
                    $z_name=Db('zg_sys')->where('id',$two_agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$two_agent['mzh_id'])->value('account');
                    $money=$sxf*($two_agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$two_agent['id'],
                        'p_name'=>$two_agent['true_name'],
                        'jszq'=>$two_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$two_agent['id'],
                        'p_name'=>$two_agent['true_name'],
                        'jszq'=>$two_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    //一级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $one_agent=Db('agentor')->where('id',$two_agent['pid'])->find();
                    $z_name=Db('zg_sys')->where('id',$one_agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$one_agent['mzh_id'])->value('account');
                    $money=$sxf*($one_agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$one_agent['id'],
                        'p_name'=>$one_agent['true_name'],
                        'jszq'=>$one_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$one_agent['id'],
                        'p_name'=>$one_agent['true_name'],
                        'jszq'=>$one_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    break;
                case 4:
                    //上级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $z_name=Db('zg_sys')->where('id',$agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$agent['mzh_id'])->value('account');
                    $money=$sxf*($agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$agent['id'],
                        'p_name'=>$agent['true_name'],
                        'jszq'=>$agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    //三级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $three_agent=Db('agentor')->where('id',$agent['pid'])->find();
                    $z_name=Db('zg_sys')->where('id',$three_agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$three_agent['mzh_id'])->value('account');
                    $money=$sxf*($three_agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$three_agent['id'],
                        'p_name'=>$three_agent['true_name'],
                        'jszq'=>$three_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$three_agent['id'],
                        'p_name'=>$three_agent['true_name'],
                        'jszq'=>$three_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    //二级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $two_agent=Db('agentor')->where('id',$three_agent['pid'])->find();
                    $z_name=Db('zg_sys')->where('id',$two_agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$two_agent['mzh_id'])->value('account');
                    $money=$sxf*($two_agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$two_agent['id'],
                        'p_name'=>$two_agent['true_name'],
                        'jszq'=>$two_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$two_agent['id'],
                        'p_name'=>$two_agent['true_name'],
                        'jszq'=>$two_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    //一级代理明细
                    $sxf=intval($list[$key]['commission']);
                    $one_agent=Db('agentor')->where('id',$two_agent['pid'])->find();
                    $z_name=Db('zg_sys')->where('id',$one_agent['zg_id'])->value('name');
                    $mzh=Db('mzh_config')->where('id',$one_agent['mzh_id'])->value('account');
                    $money=$sxf*($one_agent['sxf']/100);
                    Db('user_settlement_log')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$one_agent['id'],
                        'p_name'=>$one_agent['true_name'],
                        'jszq'=>$one_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    Db('user_settlement')->insert([
                        'uid'=>$user['id'],
                        'aid'=>$one_agent['id'],
                        'p_name'=>$one_agent['true_name'],
                        'jszq'=>$one_agent['jszq'],
                        'true_name'=>$list[$key]['accountname'],
                        'account'=>$list[$key]['zid'],
                        'z_name'=>$z_name,
                        'sum_money'=>$sxf,
                        'money'=>$money,
                        'mzh'=>$mzh,
                        'date'=>time()
                    ],true);
                    break;
            }
        }
        //汇总每个代理返佣
        $agent=Db('agentor')->select();
        foreach($agent as $i=>$value){
            $log=Db('user_settlement')->where('aid',$agent[$i]['id'])->where('status',0)->select();
            if($log){
                $money=0;
                $sum_money=0;
                $z_name=Db('zg_sys')->where('id',$agent[$i]['zg_id'])->value('name');
                $mzh=Db('mzh_config')->where('id',$agent[$i]['mzh_id'])->value('account');
                $fkbh=Db('fk_config')->where('id',$agent[$i]['fk_id'])->value('account');
                foreach($log as $j=>$value){
                    $money+=$log[$j]['money'];
                    $sum_money+=$log[$j]['sum_money'];
                }
                //每天的日志
                Db('agent_settlement_log')->insert([
                    'aid'=>$agent[$i]['id'],
                    'true_name'=>$agent[$i]['true_name'],
                    'p_name'=>$agent[$i]['p_name'],
                    'jszq'=>$agent[$i]['jszq'],
                    'z_name'=>$z_name,
                    'sum_money'=>$sum_money,
                    'money'=>$money,
                    'total_money'=>$agent[$i]['total_money'],
                    'fkbh'=>$fkbh,
                    'mzh'=>$mzh,
                    'date'=>time()
                ]);
            }
        }

        return json(['code'=>1,'msg'=>'结算成功']);
    }


    /**
     * @brief:期货代理按着具体合约ID手数返佣结算列表
     * @url:/qihuo/Crontab/doJieSuan
     * @return bool
     */
    public function doJieSuan(){
		oplog('定时任务------doJieSuan');
		if(empty(input('day'))){
			$day=date('Ymd',time());
		}else{
			$day=input('day');
		}
        
        //查询当天结算数据
        $batchTrade=Db::connect(config('db_trade'))->table('yp_trade_static')->where('tradedate',$day)->select();
        try{

            if(empty($batchTrade)){
                 echo $day.'当天无交易数据！';
                 exit;
            }

            //获取当前代理的返佣比例(id,合约id,返佣比例)
            $agentInfoArr=Db::name('agentor')->distinct(true)->alias('a')
                          ->join( 'fanyong_setting b ','b.user_name= a.user_name' ,'LEFT')->field(['a.id','b.cid','b.rate','a.aid','a.pid'])->select();

            //循环当天结算数据，根据具体客户找到和计算代理1和代理2的返佣，写入表单，每10笔延迟1秒
            foreach($batchTrade as $key=>$val){
                    //根据用户zid 查找对应的账号的直接代理
                    $aid=Db::name('customer')->where('zid',$val['zaccount'])->value('aid');
                    if(empty($aid)){
                        echo $val['zaccount'].'账号未查询到对应代理，'.$val['tradevolume'].' 手 '.$val['instrumentid'].'未返佣！';
                        continue;
                    }
                   $updateDataArr= $this->_doAgentP($agentInfoArr,$aid,$val);
                   if(!empty($updateDataArr)){
                       $updateDataArr['status']=1;
                       Db::connect(config('db_trade'))->table('yp_trade_static')->where('tradedate',$day)->where('zaccount',$val['zaccount'])
                           ->where('instrumentid',$val['instrumentid'])->update($updateDataArr);
                   }
            }
            echo $day.'返佣结算处理完成！';
        }catch (\Exception $e){
            //丢入补算队列，第二次计算
            echo $day.'处理发生错误：'.$e->getMessage();
        }

    }

    private function _doAgentP($agentInfoArr,$aid,$val){

        $updateDataInfo=$updateDataInfo1=array();
        foreach($agentInfoArr as $ag=>$ak){

            if($ak['id']==$aid && strtoupper($ak['cid']) == strtoupper($val['instrumentid'])){
                switch($ak['aid']){
                    case 1:
                        //第一级代理无需执行递归
                        $updateDataInfo=array_merge($updateDataInfo,array('p1'=>intval($ak['rate'])*$val['commission']*0.01,'p1_zid'=>$aid,'p1_rate'=>intval($ak['rate'])));
                        break;
                    case 2:
                        //执行修改p2代理字段
                        $updateDataInfo=array_merge($updateDataInfo,array('p2'=>intval($ak['rate'])*$val['commission']*0.01,'p2_zid'=>$aid,'p2_rate'=>intval($ak['rate'])));
                        $tmpArrP2=  $this->_doAgentP($agentInfoArr,$ak['pid'],$val);
                        $updateDataInfo=array_merge($updateDataInfo,$tmpArrP2);
                        break;
                    case 3:
                        //执行修改p3代理字段
                        $updateDataInfo=array_merge($updateDataInfo,array('p3'=>intval($ak['rate'])*$val['commission']*0.01,'p3_zid'=>$aid,'p3_rate'=>intval($ak['rate'])));
                        $tmpArrP3=  $this->_doAgentP($agentInfoArr,$ak['pid'],$val);
                        $updateDataInfo=array_merge($updateDataInfo,$tmpArrP3);
                        break;
                    case 4:
                        //执行修改p3代理字段
                        $updateDataInfo=array_merge($updateDataInfo,array('p4'=>intval($ak['rate'])*$val['commission']*0.01,'p4_zid'=>$aid,'p4_rate'=>intval($ak['rate'])));
                        $tmpArrP4=$this->_doAgentP($agentInfoArr,$ak['pid'],$val);
                        $updateDataInfo=array_merge($updateDataInfo,$tmpArrP4);
                        break;
                    default:
                        break;
                }
                break;
            }else if ($ak['id']==$aid){
                switch($ak['aid']){
                    case 1:
                        //第一级代理无需执行递归
                        $updateDataInfo=array('p1'=>0,'p1_zid'=>$aid,'p1_rate'=>0);
                        break;
                    case 2:
                        //执行修改p2代理字段
                        $updateDataInfo=array_merge($updateDataInfo,array('p2'=>0,'p2_zid'=>$aid,'p2_rate'=>0));
                        $tmpArrP2=  $this->_doAgentP($agentInfoArr,$ak['pid'],$val);
                        $updateDataInfo=array_merge($updateDataInfo,$tmpArrP2);
                        break;
                    case 3:
                        //执行修改p3代理字段
                        $updateDataInfo=array_merge($updateDataInfo,array('p3'=>0,'p3_zid'=>$aid,'p3_rate'=>0));
                        $tmpArrP3=  $this->_doAgentP($agentInfoArr,$ak['pid'],$val);
                        $updateDataInfo=array_merge($updateDataInfo,$tmpArrP3);
                        break;
                    case 4:
                        //执行修改p3代理字段
                        $updateDataInfo=array_merge($updateDataInfo,array('p4'=>0,'p4_zid'=>$aid,'p4_rate'=>0));
                        $tmpArrP4=$this->_doAgentP($agentInfoArr,$ak['pid'],$val);
                        $updateDataInfo=array_merge($updateDataInfo,$tmpArrP4);
                        break;
                    default:
                        break;
                }
            }
        }

        return $updateDataInfo;
    }



    //执行查询校对账号数据
    private function _reqQryAccountInfo($data,$url){
        if(empty($url)) $url='http://39.104.88.33:8082/AccMgrt.aspx';
        $res= ReqQryAccountInfo($data,$url);
        return $res;
    }


    //执行查询当天历史交易数据
    private function _reqQryTradeRecords($data,$url){
        if(empty($url)) $url='http://39.104.88.33:8082/AccMgrt.aspx';
        $res= ReqQryTradeRecords($data,$url);
        return $res;
    }

	public function test_cron(){
		
		oplog('test_cron');
		var_dump(4);die;
	}



}
