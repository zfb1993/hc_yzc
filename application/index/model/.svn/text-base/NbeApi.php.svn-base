<?php
namespace app\Index\model;
use think\Model;
class NbeApi extends Model
{
    protected $type       = [
        // 设置addtime为时间戳类型（整型）
        'create_time' => 'timestamp:Y-m-d H:i:s',
    ];

    //诺贝期货接口创建账号
    public function createAccount($data)
    {
        //action=CreateAccount&account=11113&password=1111&motheraccount=000397
        $dataInfo['action']='CreateAccount';
        $dataInfo['account']= $data['account'];
        $dataInfo['password']= $data['password'];
        $dataInfo['motheraccount']= $data['motheraccount'];
        $apiurl = getcofig('WINDOWS_URL');
        try{
            $res=http($apiurl,$dataInfo);
            $resArr=json_decode($res,true);
            if(!empty($resArr) && intval($resArr['id'])>=1){
                return array('code'=>1,'childid'=>$resArr['id'],'msg'=>'开户成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'开户失败！'.$res);
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'开户失败，资管系统未开启！'.$e->getMessage());
        }
    }

    //诺贝期货接口出入金
    public function inOutCash($data)
    {
        //action=InOutCash&childid=1&cash=100&from=addcash
        $dataInfo['action']='InOutCash';
        $dataInfo['childid']= $data['childid'];
        $dataInfo['cash']= $data['cash'];
        $dataInfo['from']= $data['from'];
        $apiurl = getcofig('WINDOWS_URL');
		oplog('WINDOWS_URL-->'.$apiurl);
		oplog('inOutCash--dataInfo-->'.json_encode($dataInfo));
        try{
            $res=gbkToUtf8(http($apiurl,$dataInfo));
			oplog('操作结果--res-->'.$res);
            $resArr=json_decode($res,true);
            if(!empty($resArr)&& $resArr['errormsg']===''){
                return array('code'=>1,'msg'=>'操作成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！');
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！');
        }
    }

    //诺贝期货查询持仓接口
    public function queryTrader($data)
    {
        //action=QueryTrader&childid=1
        $dataInfo['action']='QueryTrader';
        $dataInfo['childid']= $data['childid'];
        $apiurl = getcofig('WINDOWS_URL');
        try{
            $res=http($apiurl,$dataInfo);
            $resArr=json_decode($res,true);
            if(!empty($resArr) && count($resArr)>0){
                return array('code'=>1,'data'=>$resArr,'msg'=>'操作成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！');
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！');
        }
    }

    //诺贝期货下单接口
    public function orderInsert($data)
    {
        //http://47.104.173.116:8888/?action=OrderInsert&childid=1&instrument=rb1810&price=3555&direction=0&of=0
        //http://47.104.173.116:8888/?action=OrderInsert&childid=1&instrument=rb1810&price=3555&direction=1&of=3&orderref=1637030004
        //action为操作类型 =OrderInsert为下单childid为子账号id,instruent为合约,price 为价格,direction为买卖方向（同ctp参数）=0为买 =1为卖,of 为开平仓（同ctp参数）=0为开仓 =3为平今 =4为平昨,orderref为开仓订单号 如果of为开仓这个字段可以不填 如果of为平仓这个字段要填对应的开仓订单号
        $dataInfo['action']='OrderInsert';
        $dataInfo['childid']= $data['childid'];
        $dataInfo['instrument']= $data['instrument'];
        $dataInfo['price']= $data['price'];
        $dataInfo['direction']= $data['direction'];
        $dataInfo['of']= $data['of'];
        $apiurl = getcofig('WINDOWS_URL');
        try{
            $res=http($apiurl,$dataInfo);
            $resArr=json_decode($res,true);
            if(!empty($resArr) && count($resArr)>0){
                return array('code'=>1,'data'=>$resArr,'msg'=>'操作成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！');
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！');
        }
    }

    //诺贝期货 撤单接口
    public function orderDelete($data)
    {
        //http://47.104.173.116:8888/?action=OrderDelete&childid=1&instrument=rb1810&orderref=1637030004
        $dataInfo['action']='OrderDelete';
        $dataInfo['childid']= $data['childid'];
        $dataInfo['instrument']= $data['instrument'];
        $dataInfo['orderref']= $data['orderref'];
        $apiurl = getcofig('WINDOWS_URL');
        try{
            $res=http($apiurl,$dataInfo);
            $resArr=json_decode($res,true);
            if(!empty($resArr) && count($resArr)>0){
                return array('code'=>1,'data'=>$resArr,'msg'=>'操作成功！');
            }else{
                //返回错误
                return array('code'=>-1,'msg'=>'操作失败！');
            }
        }catch (\Exception $e){
            //返回错误
            return array('code'=>-2,'msg'=>'操作失败，资管系统未开启！');
        }
    }
}