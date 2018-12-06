<?php
namespace app\admin\model;
use think\Model;
class GbbApi extends Model
{
    /**
    系统允许交易的合约通过这个获取。
    http://106.14.81.139:800/testbase.html
    http://106.14.81.139:800/testbase.htm
    交易相关: http://106.14.81.139:800/testbase.html
    管理相关: http://106.14.81.139:800/managertestbase.html
    行情相关: http://106.14.81.139:800/markettestbase.html
    http://106.14.81.139:800/testbase.html
    http://106.14.81.139:800/testbase.html
    http://193.112.182.237:800/testbase.html
    http://193.112.182.237:800/managertestbase.html
    1101，1102，1103
    http://193.112.182.237:800
    主力合约查询： URL/managerapi/queryDominantContract
    111.231.73.247:806/managertestbase.html
    伪24小时。
    111.231.73.247:807/testbase.html
    http://111.231.73.247:808/testbase.html
    实际环境会随期货公司系统关闭，启动
    测试账号 1201 1101,1102....1105,密码: 888888
     */
    protected $type       = [
        // 设置addtime为时间戳类型（整型）
        'create_time' => 'timestamp:Y-m-d H:i:s',
    ];
    const TRADE_API='http://111.231.73.247:808';
    const MANAGE_API='111.231.73.247:806';
    const CREATE_ACCOUT='http://111.231.73.247:808';
    const FOLLOW_API='http://118.25.6.41:23004';
    //获取主力合约接口 /managerapi/queryDominantContract
    public function queryDominantContract($data=array()){
        $path= '/managerapi/queryDominantContract';
        $res=http(self::MANAGE_API.$path,$data,'POST');
        $resArr=json_decode($res,true);
        if(isset($resArr['data']) && !empty($resArr['data'])){
            foreach($resArr['data'] as $key=>&$val){
                $val['contractid']=strtoupper($val['contractid']);
            }
            return $resArr['data'];
        }else{
            return array();
        }
    }
    //股宝宝期货接口创建账号
    public function createAccount($data)
    {
        $dataInfo['newaccount']= $data['account'];
        $dataInfo['password']= $data['password'];
        $dataInfo['accountname']=$data['accountName'];
        $dataInfo['agentCode']= $data['agentCode'];
        try{
            $path= '/futuresapi/reqAccountCreate';
            $res=http(self::CREATE_ACCOUT.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && $resArr['id']==0){
                return array('code'=>1,'childid'=>$resArr['id'],'msg'=>'开户成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'开户失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'开户失败，资管系统未开启！');
        }
    }


    //股宝宝期货接口出入金
    public function inOutCash($data)
    {
        $dataInfo['account']= $data['account'];
        $dataInfo['direction']= $data['direction'];//(0: 入金，1：出金),
        $dataInfo['amount']= $data['amount'];
        $dataInfo['transfertype']= $data['transfertype'];//(0:劣后，1：优先)
        try{
            $path= '/futuresapi/actFundTransfer';
            $res=http(self::TRADE_API.$path,$data,'POST');
            $resArr=json_decode($res,true);

            if(!empty($resArr)&& $resArr['id']===0){
                return array('code'=>1,'msg'=>'操作成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$res);
        }
    }

    //股宝宝期货查询持仓接口
    public function queryTrader($data)
    {
        $dataInfo['account']= $data['account'];
        try{
            $path= '/futuresapi/queryPositionDetail';
            $res=http(self::TRADE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && !empty($resArr['data'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnData=array();
                $instrumentArr=$this->queryDominantContract();
                foreach($resArr['data'] as $key=>$val){
                    $returnDataArrTmp['account']=$val['1'];
                    $returnDataArrTmp['instrument']=$val['2'];
                    $returnDataArrTmp['direction']=$val['3'];
                    $returnDataArrTmp['trade_date']=$val['4'];
                    $returnDataArrTmp['volume']=$val['5'];
                    $returnDataArrTmp['open_price']=$val['6'];
                    $returnDataArrTmp['bzj']=$val['7'];
                    foreach($instrumentArr as $k=>$v){
                        if($v['contractid']==strtoupper($returnDataArrTmp['instrument'])){
                            $returnDataArrTmp['contractname']= $v['contractname'];
                            break;
                        }else{
                            $returnDataArrTmp['contractname']= $v['contractid'];
                        }
                    }
                    $returnData[]=$returnDataArrTmp;
                }
                return array('code'=>1,'msg'=>'操作成功！','data'=>$returnData);
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$e->getMessage());
        }
    }


    //股宝宝期货查询持仓汇总接口
    public function queryPositionSummary($data)
    {
        $dataInfo['account']= $data['account'];
        try{
            $path= '/futuresapi/queryPositionSummary';
            $res=http(self::TRADE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && !empty($resArr['data'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnData=array();
                $instrumentArr=$this->queryDominantContract();
                foreach($resArr['data'] as $key=>$val){
                    $returnDataArrTmp['account']=$val['1'];
                    $returnDataArrTmp['instrument']=$val['2'];
                    $returnDataArrTmp['direction']=$val['3'];
                    $returnDataArrTmp['volume']=$val['4'];
                    $returnDataArrTmp['open_price']=$val['5'];
                    $returnDataArrTmp['bzj']=$val['6'];
                    $returnDataArrTmp['profit']=$val['7'];
                    foreach($instrumentArr as $k=>$v){
                        if($v['contractid']==$returnDataArrTmp['instrument']){
                            $returnDataArrTmp['contractname']= $v['contractname'];
                            break;
                        }else{
                            $returnDataArrTmp['contractname']= $returnDataArrTmp['instrument'];
                        }
                    }
                    $returnData[]=$returnDataArrTmp;
                }
                return array('code'=>1,'msg'=>'操作成功！','data'=>$returnData);
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$e->getMessage());
        }
    }
    //股宝宝期货查询持仓接口
    public function queryHangOrderToday($data)
    {
        $dataInfo['account']= $data['account'];
        try{
            $path= '/managerapi/queryHangOrderToday';
            $res=http(self::MANAGE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && isset($resArr['data'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnData=array();
                $instrumentArr=$this->queryDominantContract();
                foreach($resArr['data'] as $key=>$val){
                    $returnDataArrTmp['account']=$val['1'];
                    $returnDataArrTmp['instrument']=$val['2'];
                    $returnDataArrTmp['direction']=$val['3'];
                    $returnDataArrTmp['offset']=$val['4'];
                    $returnDataArrTmp['price']=$val['5'];
                    $returnDataArrTmp['volume']=$val['6'];
                    $returnDataArrTmp['trade_time']=$val['7'];
                    $returnDataArrTmp['trade_date']=$val['8'];
                    $returnDataArrTmp['trade_id']=$val['9'];
                    $returnDataArrTmp['status']=$val['10'];
                    foreach($instrumentArr as $k=>$v){
                        if($v['contractid']==$returnDataArrTmp['instrument']){
                            $returnDataArrTmp['contractname']= $v['contractname'];
                            $returnDataArrTmp['point_price']= 10;
                            break;
                        }else{
                            $returnDataArrTmp['contractname']= '-'.$v['contractid'];
                        }
                    }
                    $returnData[]=$returnDataArrTmp;
                }
                return array('code'=>1,'msg'=>'操作成功！','data'=>$returnData);
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$e->getMessage());
        }
    }

    //股宝宝期货查询历史成交记录
    public function queryTradeHistory($data)
    {
        $dataInfo['account']= $data['account'];
        try{
            $path= '/managerapi/queryTradeHistory';
            $res=http(self::MANAGE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && isset($resArr['data'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnData=array();
                $instrumentArr=$this->queryDominantContract();
                foreach($resArr['data'] as $key=>$val){
                    $returnDataArrTmp['account']=$val['1'];
                    $returnDataArrTmp['instrument']=$val['2'];
                    $returnDataArrTmp['direction']=$val['3'];
                    $returnDataArrTmp['offset']=$val['4'];
                    $returnDataArrTmp['price']=$val['5'];
                    $returnDataArrTmp['volume']=$val['6'];
                    $returnDataArrTmp['trade_time']=$val['7'];
                    $returnDataArrTmp['trade_date']=$val['8'];
                    $returnDataArrTmp['trade_id']=$val['9'];
                    $returnDataArrTmp['status']=$val['10'];
                    foreach($instrumentArr as $k=>$v){
                        if($v['contractid']==$returnDataArrTmp['instrument']){
                            $returnDataArrTmp['contractname']= $v['contractname'];
                            $returnDataArrTmp['point_price']= 10;
                            break;
                        }else{
                            $returnDataArrTmp['contractname']= '-'.$v['contractid'];
                        }
                    }
                    $returnData[]=$returnDataArrTmp;
                }
                return array('code'=>1,'msg'=>'操作成功！','data'=>$returnData);
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$e->getMessage());
        }
    }


    //股宝宝期货查询当天成交记录
    public function queryTradeToday($data)
    {
        $dataInfo['account']= $data['account'];
        try{
            $path= '/managerapi/queryBatchTradeToday';
            $res=http(self::MANAGE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && isset($resArr['data'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnData=array();
                $instrumentArr=$this->queryDominantContract();
                foreach($resArr['data'] as $key=>$val){
                    $returnDataArrTmp['account']=$val['1'];
                    $returnDataArrTmp['instrument']=$val['2'];
                    $returnDataArrTmp['direction']=$val['3'];
                    $returnDataArrTmp['offset']=$val['4'];
                    $returnDataArrTmp['price']=$val['5'];
                    $returnDataArrTmp['volume']=$val['6'];
                    $returnDataArrTmp['trade_time']=$val['7'];
                    $returnDataArrTmp['trade_date']=$val['8'];
                    foreach($instrumentArr as $k=>$v){
                        if($v['contractid']==$returnDataArrTmp['instrument']){
                            $returnDataArrTmp['contractname']= $v['contractname'];
                            break;
                        }else{
                            $returnDataArrTmp['contractname']= '-'.$v['contractid'];
                        }
                    }

                    $returnData[]=$returnDataArrTmp;
                }
                return array('code'=>1,'msg'=>'操作成功！','data'=>$returnData);
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$e->getMessage());
        }
    }


    //股宝宝期货批量查询历史成交记录
    public function queryBatchTradeHistory($data)
    {
        try{
            $path= '/managerapi/queryBatchTradeHistory';
            $res=http(self::MANAGE_API.$path,$data,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && isset($resArr['data'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnData=array();
                $instrumentArr=$this->queryDominantContract();
                foreach($resArr['data'] as $key=>$val){
                    $returnDataArrTmp['account']=$val['1'];
                    $returnDataArrTmp['instrument']=$val['2'];
                    $returnDataArrTmp['direction']=$val['3'];
                    $returnDataArrTmp['offset']=$val['4'];
                    $returnDataArrTmp['close_price']=$val['5'];
                    $returnDataArrTmp['volume']=$val['6'];
                    $returnDataArrTmp['trade_time']=$val['7'];
                    $returnDataArrTmp['trade_date']=$val['8'];
                    foreach($instrumentArr as $k=>$v){
                        if($v['contractid']==$returnDataArrTmp['instrument']){
                            $returnDataArrTmp['contractname']= $v['contractname'];
                            break;
                        }else{
                            $returnDataArrTmp['contractname']= '-'.$v['contractid'];
                        }
                    }
                    $returnData[]=$returnDataArrTmp;
                }
                return array('code'=>1,'msg'=>'操作成功！','data'=>$returnData);
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$e->getMessage());
        }
    }

    //股宝宝期货批量查询历史平仓记录
    public function queryBatchClosePositionHistory($data)
    {
        try{
            $path= '/managerapi/queryBatchClosePositionHistory';
            $res=http(self::MANAGE_API.$path,$data,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && isset($resArr['data'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnData=array();
                foreach($resArr['data'] as $key=>$val){
                    $returnDataArrTmp['account']=$val['1'];
                    $returnDataArrTmp['instrument']=$val['2'];
                    $returnDataArrTmp['direction']=$val['3'];
                    $returnDataArrTmp['offset']=$val['4'];
                    $returnDataArrTmp['close_price']=$val['5'];
                    $returnDataArrTmp['volume']=$val['6'];
                    $returnDataArrTmp['trade_time']=$val['7'];
                    $returnDataArrTmp['trade_date']=$val['8'];
                    $returnDataArrTmp['profit']=$val['9'];
                    $returnDataArrTmp['open_price']=$val['10'];
                    $returnData[]=$returnDataArrTmp;
                }
                return array('code'=>1,'msg'=>'操作成功！','data'=>$returnData);
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！'.$e->getMessage());
        }
    }

    //股宝宝期货下单接口
    public function orderInsert($data)
    {
        $dataInfo['account']=$data['account'];
        $dataInfo['instrument']= $data['instrument'];
        $dataInfo['offset']= $data['offset'];// (0: 开仓，1：平仓, 3: 平今),
        $dataInfo['direction']= $data['direction'];//方向(0: 买，1：卖),
        $dataInfo['volume']= $data['volume'];//手数
        if($dataInfo['offset']==1) {
            if($dataInfo['direction']== 1){
                $dataInfo['direction']= 0;
            }else{
                $dataInfo['direction']= 1;
            }
        }
        try{
            $path= '/futuresapi/actMarketOrder';
            $res=http(self::TRADE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && $resArr['id']==0){
                return array('code'=>1,'data'=>$resArr,'msg'=>'报单成功！');
            }else{
                if($dataInfo['offset']==1){
                    //返回错误，操作失败再去平今
                    $path= '/futuresapi/actMarketOrder';
                    $dataInfo['offset']= 3;// (0: 开仓，1：平仓, 3: 平今),
                    $res=http(self::TRADE_API.$path,$dataInfo,'POST');
                    $resArr=json_decode($res,true);
                    if(!empty($resArr) && $resArr['id']==0){
                        return array('code'=>1,'data'=>$resArr,'msg'=>'报单成功！');
                    }else{
                        return array('code'=>-1,'msg'=>'操作失败1！'.$res.json_encode($dataInfo));
                    }
                }else{
                    return array('code'=>-1,'msg'=>'操作失败！'.$res.json_encode($dataInfo));
                }


            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！');
        }
    }

    //股宝宝期货 撤单接口 /futuresapi/actOrderAction
    public function orderDelete($data)
    {
        $dataInfo['account']=$data['account'];
        $dataInfo['orderid']= $data['orderid'];// 订单号
        $dataInfo['exchangeid']= $data['exchangeid'];//交易所编号
        try{
            $path= '/futuresapi/actOrderAction';
            $res=http(self::TRADE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && $resArr['id']==0){
                return array('code'=>1,'msg'=>'撤单成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！'.$res.json_encode($dataInfo));
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！');
        }
    }

    //股宝宝查询资金接口
    public function queryFundDetail($data)
    {
        $dataInfo['account']=$data['account'];
        try{
            $path= '/futuresapi/queryFundDetail';
            $res=http(self::TRADE_API.$path,$dataInfo,'POST');
            $resArr=json_decode($res,true);
            if(!empty($resArr) && isset($resArr['0'])){
                $returnArr['code']=1;
                $returnArr['msg']='请求成功';
                $returnDataArr['account']=$resArr['1'];
                $returnDataArr['lz_money']=$resArr['2'];
                $returnDataArr['rj_money']=$resArr['3'];
                $returnDataArr['cj_money']=$resArr['4'];
                $returnDataArr['dj_money']=$resArr['5'];
                $returnDataArr['dj_sxf']=$resArr['6'];
                $returnDataArr['sxf']=$resArr['7'];
                $returnDataArr['pc_yk']=$resArr['8'];
                $returnDataArr['cc_yk']=$resArr['9'];
                $returnDataArr['money']=$resArr['10'];
                $returnDataArr['jt_qy']=$resArr['11'];
                $returnDataArr['dt_qy']=$resArr['12'];
                $returnArr['data']=$returnDataArr;
            }else{
                $returnArr['code']=-1;
                $returnArr['msg']='请求错误';
                $returnArr['data']=array();
            }
            return $returnArr;
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！');
        }
    }

    //跟单接口账户查询
    public  function getFollowAccount($data){
       // {"data":[{"1":"1201","2":1,"3":0}{"1":"1202","2":0,"3":0}{"1":"1203","2":0,"3":0}]}
       ///followapi/queryAccount
        $path= '/followapi/queryAccount';
        $res=http(self::FOLLOW_API.$path,$data,'POST');
        $res=str_replace('}{','},{',$res);
        $resArr=json_decode($res,true);
        if(isset($resArr['data']) && !empty($resArr['data'])){
            $returnArr=array();
            if(empty($data['type'])){
                foreach($resArr['data'] as $key=>$val){
                    //$val['2'] : 0:主账户.1:从账户; $val['3']:0:启用; 1:禁用;
                  if($val['2']===0 && $val['3']===0) {
                      $returnArr[] = $val['1'];
                  }
                }
            }else{
                foreach($resArr['data'] as $key=>$val){

                    //$val['2'] : 0:主账户.1:从账户; $val['3']:0:启用; 1:禁用;
                    if($val['2']===1 && $val['3']===0) {
                        $returnArr[] = $val['1'];
                    }
                }
            }
            return $returnArr;
        }else{
            return $res;
        }
    }

    //跟单关系查询所跟单的母账户
    public  function queryFollowRelation($data){
        // {"data":[{"1":"1201","2":1,"3":0}{"1":"1202","2":0,"3":0}{"1":"1203","2":0,"3":0}]}
        $path= '/followapi/queryFollowRelation';
        $res=http(self::FOLLOW_API.$path,$data,'POST');
        $res=str_replace('}{','},{',$res);

        $resArr=json_decode($res,true);
        if(isset($resArr['data']) && !empty($resArr['data'])){
            $returnArr=array();
            foreach($resArr['data'] as $key=>$val){
                //$val['1'] : 0:主账户; $val['2']:1:从账户, $val['4']:0:启用; 1:禁用;
                if( $data['account']==$val['2'] && $val['4']===0) {
                    $returnArr[] = $val['1'];

                }

            }
            return $returnArr;
        }else{
            echo $res;
            exit();
            return $res;
        }
    }

    //设置跟单接口
    public  function setFollowRelation($data){
        $path= '/followapi/setFollowRelation';
        $res=http(self::FOLLOW_API.$path,$data,'POST');
        $res=str_replace('}{','},{',$res);
        $resArr=json_decode($res,true);
        if(isset($resArr['id']) && $resArr['id']==0){
            $returnArr=array('code'=>1,'msg'=>'设置成功');
            return $returnArr;
        }else{
            $returnArr=array('code'=>-1,'msg'=>'设置失败'.$res);
            return $returnArr;
        }
    }
}