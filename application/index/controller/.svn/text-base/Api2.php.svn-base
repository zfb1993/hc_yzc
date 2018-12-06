<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/21
 * Time: 9:46
 */

namespace app\index\controller;
use think\Db;
use think\Controller;

class Api2 extends controller
{
    //宝塔自动执行的方法---------------开始
    public function zidong()
    {
        $today = date('Ymd', time());
        $list = Db::connect(config('db_trade'))->name('trader_close_log')->where('TradingDay ='.$today)->select();//数据分析原始表
        $arr = [];
        $ar = [];
        foreach ($list as $v) {
            $arr[$v['AccountID']][] = $v;
            $ar[] = $v['AccountID'];
        }
        $yesday = date('Y-m-d',strtotime('-1day'));
        $tadelist = Db::connect(config('db_trade'))->name('tadelist_all')->where('tradedate',$yesday)->select();//数据分析原始表
        foreach($tadelist as $v){
            if(in_array($v['zid'],$ar)){
                continue;
            }
            unset($v['id']);
            $v['time'] = time();
            $v['tradedate'] = $today;
            Db::connect(config('db_trade'))->name('tadelist_all')->insert($v);
        }

        $account=Db::connect(config('db_trade'))->name('account_info_log')->field('deposit,withdraw,zaccount')->where('tradedate ='.$today)->where('deposit > 0 or withdraw > 0')->select();//查询出入金的表
        if(!empty($account)){
            foreach($account as $v){
                $zid=Db('customer')->where("mobile = ".$v['zaccount'])->value('zid');
                $trad=Db::connect(config('db_trade'))->name('tadelist')->where("zid = ".$zid)->find();
                if($v['deposit'] > 0){
                    $ddd['id'] = $trad['id'];
                    $ddd['allmoney'] = $trad['allmoney']+$v['deposit'];
                }elseif($v['withdraw'] > 0){
                    $ddd['id'] = $trad['id'];
                    $ddd['allmoney'] = $trad['allmoney']-$v['withdraw'];
                }
                Db::connect(config('db_trade'))->name('tadelist')->update($ddd);
            }
        }

        foreach ($arr as $k => $vv) {
            $data = [];
            $tradecount = 0;//交易笔数
            $profitcount = 0;//盈利笔数
            $losscount = 0;//亏损笔数
            $lossmoney = 0;//亏损总额
            $profitmoney = 0;//盈利总额
            foreach ($vv as $v1) {
                $tradecount++;
                if ($v1['Profit'] < 0) {
                    $losscount++;
                    $lossmoney += $v1['Profit'];
                } else {
                    $profitcount++;
                    $profitmoney += $v1['Profit'];
                }
            }
            if ($losscount == 0) {
                $avgloss = 0;//平均亏损
                $prorate = 0;//盈亏比例
            } else {
                $avgloss = round($lossmoney / $losscount, 2);//平均亏损
                $prorate = round($profitcount / $losscount, 2);//盈亏比例
            }
            if ($profitcount == 0) {
                $avgprofit = 0;//平均盈利
            } else {
                $avgprofit = round($profitmoney / $profitcount, 2);//平均盈利
            }
            $profitrate = round($profitcount / $tradecount, 2);//胜率
            $lossrate = round($losscount / $tradecount, 2);//失败率

            $trad = Db::connect(config('db_trade'))->name('tadelist')->where('zid ='.$k)->find();
            $allprlo = $lossmoney +$profitmoney;//总盈亏
            $allmoney = $trad['allmoney'];//总份额
            $latednet = round($allprlo/$allmoney+1,2);


            $data['zid'] = $k;
            $data['tradecount'] = $tradecount;
            $data['profitcount'] = $profitcount;
            $data['profitmoney'] = $profitmoney;
            $data['losscount'] = $losscount;
            $data['lossmoney'] = $lossmoney;
            $data['avgloss'] = $avgloss;
            $data['avgprofit'] = $avgprofit;
            $data['prorate'] = $prorate;
            $data['profitrate'] = $profitrate;
            $data['lossrate'] = $lossrate;
            $data['latednet'] = $latednet;//累计净值
            $data['allmoney'] = $allmoney;//总份额
            $data['time'] = time();
            $data['tradedate'] = $today;

            Db::connect(config('db_trade'))->name('tadelist_all')->insert($data);

            $tradate['tradecount'] = $data['tradecount']+$trad['tradecount'];//交易笔数
            $tradate['profitcount'] = $data['profitcount']+$trad['profitcount'];//盈利笔数
            $tradate['losscount'] = $data['losscount']+$trad['losscount'];//亏损笔数
            $tradate['lossmoney'] = $data['lossmoney']+$trad['lossmoney'];//亏损总额
            $tradate['profitmoney'] = $data['profitmoney']+$trad['profitmoney'];//盈利总额

            if ($tradate['losscount']  == 0) {
                $tradate['avgloss'] = 0;//平均亏损
                $tradate['prorate'] = 0;//盈亏比例
            } else {
                $tradate['avgloss'] = round($tradate['lossmoney'] / $tradate['losscount'] , 2);//平均亏损
                $tradate['prorate'] = round( $tradate['profitcount'] / $tradate['losscount'] , 2);//盈亏比例
            }
            if ( $tradate['profitcount'] == 0) {
                $tradate['avgprofit'] = 0;//平均盈利
            } else {
                $tradate['avgprofit'] = round($tradate['profitmoney'] /  $tradate['profitcount'], 2);//平均盈利
            }
            $tradate['profitrate'] = round($tradate['profitcount'] / $tradate['tradecount'], 2);//胜率
            $tradate['lossrate'] = round($tradate['losscount'] / $tradate['tradecount'], 2);//失败率\
            $tradate['allmoney'] = $allmoney;
            $aaa = $tradate['profitmoney'] + $tradate['lossmoney'];
            $tradate['latednet'] = round($aaa/$allmoney+1,2);
            $tradate['time'] = time();
            $tradate['id'] = $trad['id'];
            Db::connect(config('db_trade'))->name('tadelist')->update($tradate);
        }

    }

    //宝塔自动执行的方法---------------结束

    //交易员详情接口
    public function overview(){
        $zid = input('zid');
        if($zid == ''){
            echo iconv('gbk','utf8','缺少参数');die;
        }
        $list = Db::connect(config('db_trade'))->name('tadelist')->where('zid',$zid)->find();
        $data['data'] = $list;
        $data['code'] = 0;
        return json($data);
    }

    public function over(){
        $list=Db::connect(config('db_trade'))->name('trader_close_log')->select();
        $arr=[];
        $arr1=[];
        $dewi = [];
        $today = date('Ymd',time());
        $account=Db::connect(config('db_trade'))->name('account_info_log')->field('deposit,withdraw,zaccount')->where('deposit > 0 or withdraw > 0')->select();
        foreach($list as $v){
            $arr[$v['AccountID']][] = $v;
        }
        foreach($account as $v1){
            $arr1[$v1['zaccount']][] = $v1['deposit']-$v1['withdraw'];
        }

        foreach($arr1 as $k=>$vv){
            if($k != 'aaaaaa'){
                $zid=Db('customer')->where("mobile = $k")->value('zid');
                if($zid != ''){
                    $dewi[$zid] = array_sum($vv);
                }
            }
        }
print_r($arr);die;
        foreach($arr as $k=>$vv){
            if(!array_key_exists($k,$dewi)){
                continue;
            }
            $data = [];
            $tradecount = 0;//交易笔数
            $profitcount = 0;//盈利笔数
            $losscount = 0;//亏损笔数
            $lossmoney = 0;//亏损总额
            $profitmoney = 0;//盈利总额
            foreach($vv as $v1){
                $tradecount++;
                if($v1['Profit'] < 0){
                    $losscount++;
                    $lossmoney += $v1['Profit'];
                }else{
                    $profitcount++;
                    $profitmoney += $v1['Profit'];
                }
            }
            if($losscount == 0){
                $avgloss = 0;//平均亏损
                $prorate = 0;//盈亏比例
            }else{
                $avgloss = round($lossmoney/$losscount,2);//平均亏损
                $prorate = round($profitcount/$losscount,2);//盈亏比例
            }
            if($profitcount == 0){
                $avgprofit = 0;//平均盈利
            }else{
                $avgprofit = round($profitmoney/$profitcount,2);//平均盈利
            }
            $profitrate = round($profitcount/$tradecount,2);//胜率
            $lossrate = round($losscount/$tradecount,2);//失败率

            //累计净值
            $allprlo = $lossmoney +$profitmoney;//总盈亏
            $allmoney = $dewi[$k];//总份额
            if($allmoney == 0){
                $latednet = 1;
            }else{
                $latednet = round($allprlo/$allmoney+1,2);
            }

            if($latednet < 0){
                $latednet = 0;
            }
//            echo $latednet;

            $data['zid'] = $k;
            $data['tradecount'] = $tradecount;
            $data['profitcount'] = $profitcount;
            $data['profitmoney'] = $profitmoney;
            $data['losscount'] = $losscount;
            $data['lossmoney'] = $lossmoney;
            $data['avgloss'] = $avgloss;
            $data['avgprofit'] = $avgprofit;
            $data['prorate'] = $prorate;
            $data['profitrate'] = $profitrate;
            $data['lossrate'] = $lossrate;
            $data['latednet'] = $latednet;//累计净值
            $data['allmoney'] = $allmoney;//总份额
            $data['time'] = time();
//            Db::connect(config('db_trade'))->name('tadelist')->insert($data);
            $data['tradedate'] = $today;
//            Db::connect(config('db_trade'))->name('tadelist_all')->insert($data);
        }
    }

    //跟随者接口
    public function gensui(){
        $zid = input('zid');
        $da['childid'] = $zid;
        $da['action'] = 'QueryFollowInfo';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$da,'GET');
        $res = substr($res,0,strlen($res)-1);
        $res=substr($res,1);
        $resArr=json_decode($res,true);
        foreach($resArr as $k=>&$v){
            $static=Db::connect(config('db_trade'))->name('tadelist')->where('zid',$v['Followed'])->find();
            if(empty($static)){
                unset($resArr[$k]);
                continue;
            }
            $v = array_merge($static,$v);
        }
        if(empty($resArr)){
            $data['data'] = [];
            $data['code'] = 0;
        }else{
            $data['data'] = array_values($resArr);
            $data['code'] = 1;
        }
        return json($data);
    }

    //添加跟随
    public function FollowInsert(){
        $apiurl = getcofig('WINDOWS_URL');
        $data = input('get.');
        $data['action'] = 'FollowInsert';
        $html=http($apiurl,$data);
        $arr = json_decode($html,true);
        if($arr['error'] == '0'){
            $arr['errormsg'] = iconv('gbk','utf8','跟单成功');
            $arr['code'] = 1;
            $arr = json($arr);
        }else{
            $arr = $html;
        }
        return $arr;
    }

    //取消跟随
    public function delfollow(){
        $data['childid'] = input('childid');
        $data['followed'] = input('followed');
        $data['action'] = 'FollowDelete';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $resArr=json_decode($res,true);
        $msg = iconv('gbk','utf8','跟单删除成功');
        if($resArr['error'] == 0){
            return json(array('code'=>1,'msg'=>$msg));
        }else{
            return json(array('code'=>2,'msg'=>$resArr['errormsg']));
        }
    }

    //跟单首页接口
    public function usermob(){
        $zid = input('zid');
        $type = input('type',0);
        $order = input('order',0);
        $is = input('is');
        $da['childid'] = $zid;
        $da['action'] = 'QueryFollowInfo';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$da,'GET');
        $res = substr($res,0,strlen($res)-1);
        $res=substr($res,1);
        $resArr=json_decode($res,true);//获取当前账号跟单的人
        $a = [];
        if(!empty($resArr)){
            foreach($resArr as $v){
                $a[] = $v['Followed'];
            }
        }

        $dat['action'] = 'QueryFollowUser';
        $ress=http($apiurl,$dat,'GET');
        $ress = substr($ress,0,strlen($ress)-1);
        $ress=substr($ress,1);
        $ab = [];
        $resAr=json_decode($ress,true);//获取有哪些人跟过别人
        if(!empty($resAr)){
            foreach($resAr as $v){
                $ab[] = $v['id'];
            }
        }

        if($type != 0){
            if($type ==1){//一周内有交易
                $d = date('Ymd',strtotime('-1 week'));
            }elseif($type == 2){//两周内有交易
                $d = date('Ymd',strtotime('-2 week'));
            }
            $where['TradingDay'] = ['>=',$d];
            $li=Db::connect(config('db_trade'))->name('trader_close_log')->where($where)->column('AccountID');
            $li = array_unique($li);
        }

        $list=Db('customer')->where("zid != $zid")->field('nick_name,zid')->select();
//        print_r($li);
//        print_r($ab);
//        print_r($list);
        foreach($list as $k=>&$v){
            if(in_array($v['zid'],$ab)){
                unset($list[$k]);
                continue;
            }

            $static=Db::connect(config('db_trade'))->name('tadelist')->where('zid',$v['zid'])->find();
            if($static == ''){
                unset($list[$k]);
                continue;
            }else{
                $v = array_merge($static,$v);
            }

            if($type != 0){
                if(!in_array($v['zid'],$li)){
                    unset($list[$k]);
                    continue;
                }
            }

            if(in_array($v['zid'],$a)){
                $v['status'] = 1;
            }else{
                $v['status'] = 0;
            }
            if($v['nick_name'] == ''){
                $v['nick_name'] = iconv('gbk','utf8','大赢家_');
            }
        }

//        foreach ($list as $key => $row){
//            $volume[$key]  = $row['status'];
//        }
//        array_multisort($volume, SORT_DESC, $list);

        $list = array_values($list);
//        print_r($list);die;
        $data['data'] = $list;
        $data['code'] = 0;
        return json($data);
    }


//盈亏曲线收益图
    public function index(){
        $mobile = input('zid');
        if($mobile == ''){
            echo iconv('gbk','utf8','缺少参数');die;
        }
        $infos=Db::connect(config('db_trade'))->name('tadelist_all')->where('zid',$mobile)->select();
        foreach($infos as $k=>$v){
            $date[] = $v['tradedate'];
            $loss['data']['y'][] = $v['profitmoney']+$v['lossmoney'];
        }
        $loss['data']['x'] = $date;
        $loss['code'] = 1;
         return json($loss);

    }

    //周盈亏
    public function getclose(){
        $mobile = input('zid');
        if($mobile == ''){
            echo iconv('gbk','utf8','缺少参数');die;
        }
        $infos=Db::connect(config('db_trade'))->table('yp_close_position')->where('zaccount',$mobile)->select();
        $data = [];
        foreach($infos as $v){
            $w = date('W',strtotime($v['tradedate']));//当前记录日期所属周数
            $n = date('Y',strtotime($v['tradedate']));//当前记录日期所属年份

            if($v['closeprofit']<0){
                if(isset($data[$n.'-'.$w]['y1'])){
                    $data[$n.'-'.$w]['y1'] += $v['closeprofit'];
                }else{
                    $data[$n.'-'.$w]['y1'] = $v['closeprofit'];;
                }
                $data[$n.'-'.$w]['y'] = 0;
            }else{
                $data[$n.'-'.$w]['y1'] = 0;
                if(isset($data[$n.'-'.$w]['y'])){
                    $data[$n.'-'.$w]['y'] += $v['closeprofit'];;
                }else{
                    $data[$n.'-'.$w]['y'] = $v['closeprofit'];;
                }
            }
        }
        foreach($data as $k=>$vv){
            $weeks['data']['x'][] = $k;
            $weeks['data']['y'][] ="". $vv['y']."";
            $weeks['data']['y1'][] = "".$vv['y1']."";;
        }
        $weeks['code'] = 1;
        $weeks['msg'] = iconv('gbk','utf-8','成功返回');
        return json($weeks);
    }

    //成交结构
    public function getinstrate(){
        $mobile = input('mobile');
        if($mobile == ''){
            echo iconv('gbk','utf8','缺少参数');die;
        }
        $trade = Db('batch_trade')->where('zaccount',$mobile)->field('instrumentid,tradeprice')->select();

        foreach($trade as $v){
            if(isset($arr[$v['instrumentid']])){
                $arr[$v['instrumentid']] += $v['tradeprice'];
            }else{
                $arr[$v['instrumentid']] = $v['tradeprice'];
            }
            if(isset($arr['all'])){
                $arr['all'] += $v['tradeprice'];
            }else{
                $arr['all'] = $v['tradeprice'];
            }
        }

        $retu['code'] = 1;
        $i = 0;
        foreach($arr as $k=>$v){
            if($k == 'all'){
                continue;
            }
            $retu['data']['x'][] = $k;
            $rate = $v/$arr['all']*100;
            $retu['data']['y'][$i]['name'] = $k;
            $retu['data']['y'][$i]['value'] = round($rate,2);
            $i++;
        }
        return json($retu);
    }

}