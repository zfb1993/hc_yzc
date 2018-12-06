<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Otherapi extends controller
{
    private $cacke_key_pre='hq';

    public function index()
    {
      return $this->fetch();
    }

    //系统消息
    //获取最近消息/index/Tools/getMsg
    public function getMsg(){
        $msg='后台有新的行权请求,来自测试';
        $msgArr= \think\Db::name('system_msg')->where('status','1')->order('id','desc')->limit(0,5)->select();
        if(empty($msg)){
            return json(array('code'=>1,'msg'=>'无未读消息','data'=>$msgArr));
        }else{
            return json(array('code'=>0,'msg'=>'有新未读消息','data'=>$msgArr));
        }

    }

    public function getCountMsg(){
        $count= \think\Db::name('system_msg')->where('status','1')->count();
        if(!empty($count)){
            return json(array('code'=>1,'count'=>$count));
        }else{
            return json(array('code'=>0,'count'=>0));
        }

    }
    //获取最近消息/index/Tools/getMsg
    public function updateMsg(){
        $id=input('id');
        $where=array();
        if(!empty($id)) $where['id']=$id;
        \think\Db::name('system_msg')->where('status','1')->where($where)->update(array('status'=>2));
        return json(array('code'=>0,'msg'=>'已经刷新未读消息'));
    }

    //获取最近消息/index/Tools/getMsg
    public function delMsg(){
        $id=input('id');
        $where=array();
        if(!empty($id)) $where['id']=$id;
        \think\Db::name('system_msg')->where($where)->update(array('status'=>-1));
        return json(array('code'=>0,'msg'=>'该消息已经删除'));
    }

    //index/otherapi/qrcode
    //二维码推广地址
    public function qrcode(){
        $userid=input('userid');
        $auth=input('auth');
        if(empty($userid)){
            $this->error('未找到对应用户');
            exit;
        }

        $userinfo=Db::name('agentor')->where('id','=',$userid)->find();
        if(empty($userinfo)){
            $this->error('目前只对代理开放此功能！');
            exit;
        }

        if(!isset($userinfo['code'])){
            $this->error('目前只对代理开放此功能！');
            exit;
        }

        //获取我的对应的推广码，可用提现额度
        $this->assign('money',$userinfo['total_money']);
        $this->assign('ext_code',$userinfo['code']);

        //获取用户对应的推广人数
        $count=Db::name('customer')->where('pid','=',$userinfo['id'])->count();
        $this->assign('count',$count);
        if(!empty($_SERVER['HTTPS'])){
            $http='https://';
        }else{
            $http='http://';
        }
        $url=$http.$_SERVER['HTTP_HOST'].'/index/index/reg?ext_code='.$userinfo['code'];
        $this->assign('url',$url);
        return view();
    }

    //获取对应类型的公告以及协议内容
    //index/otherapi/getActivityContent?type=1
    public function getActivityContent(){
        $type=input('type');

        $list=Db('activity')->where('type',$type)->where('status','0')->order('id','asc')->find();

        if(!empty($list)){
            $result = ['code'=>1,'msg'=>'成功返回','data'=>$list];
            return json($result);
        }else{
            $result = ['code'=>-1,'msg'=>'未找到对应内容','data'=>array()];
            return json($result);
        }
    }


    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:申请开户接口
     * @url:/index/otherapi/openAccount?userid=10&auth=11f648552BDTaE63RfYS0mtR3fV6CAU4gi7CPRlIvJaE5[a]rT5[a]ds
     * @params_remark:userid:用户ID，auth:登陆返回签名
     * @returnRes:{"code":1,"msg":"申请成功！"}，code:1表示成功，其他表示失败
     */
    public function openAccount(){
        $data['userid']=input('userid');
        $data['auth']=input('auth');
        //判断签名是否正确
        $res=Db('customer')->where(['id'=>$data['userid'],'auth'=>$data['auth']])->find();

        if(empty($res)||$res['auth']!=$data['auth']){
            return json(array('code'=>0,'msg'=>'签名验证错误'));
        }

        //判断是否有实名认证通过
        if($res['is_true']!=1 || empty($res['true_name'])){
            return json(array('code'=>-2,'msg'=>'账号未实名认证，无法申请！'));
        }
        if($res['is_open']==1){
            return json(array('code'=>-3,'msg'=>'该账号已经开户，无法重复申请！'));
        }

        //判断是否已经提交申请开户，或者审核已经通过
        $num= Db::name('openaccount_apply')->where('userid',$data['userid'])->where('status','in',array(0,1))->count();
        if($num>0){
            return json(array('code'=>-4,'msg'=>'无法重复申请开户！'));
        }
        //插入数据库记录
        Db::startTrans();
        try{
            Db::commit();
            Db::name('customer')->where('id',$data['userid'])->update(array('is_open'=>2));
            Db::name('openaccount_apply')->insert(array('userid'=>$data['userid'],'nikename'=>$res['true_name']));
            //插入信息提示信息
            $insertData['content']=$res['user_name'].'提出开户申请，请及时审核';
            $insertData['url']="{:url('customer/checkOpenUser')}";
            $insertData['domain']='';
            $insertData['type']=1;
            $insertData['status']=1;
            \think\Db::name('system_msg')->insert($insertData);
            Db::commit();
            return json(array('code'=>1,'msg'=>'申请成功！'));
        }catch (\Exception $e){
            Db::rollback();
            return json(array('code'=>-1,'msg'=>'申请失败，稍后重试！'));
        }

    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取开户状态接口
     * @url:/index/otherapi/getopenAccountStatus?userid=10&auth=11f648552BDTaE63RfYS0mtR3fV6CAU4gi7CPRlIvJaE5[a]rT5[a]ds
     * @params_remark:userid:用户ID，auth:登陆返回签名
     * @returnRes:{"code":1,"status":3,"msg":"开户成功！","zid":"255475546","pwd":"nb123456"}，
     * code:1表示成功，其他表示失败
     * status:1 未申请开户,2 审核中,3 开户成功,zid 账号，pwd 密码
     */
    public function getopenAccountStatus(){
        $data['userid']=input('userid');
        $data['auth']=input('auth');
        //判断签名是否正确
        $res=Db('customer')->where(['id'=>$data['userid'],'auth'=>$data['auth']])->find();

        if(empty($res)||$res['auth']!=$data['auth']){
            return json(array('code'=>0,'msg'=>'签名验证错误'));
        }

        //判断是否有实名认证通过
        if($res['is_true']!=1 || empty($res['true_name'])){
            return json(array('code'=>1,'status'=>1,'msg'=>'未申请开户！'));
        }
        if($res['is_open']==1){
            return json(array('code'=>1,'status'=>3,'msg'=>'开户成功！','zid'=>$res['zid'],'pwd'=>$res['zpwd']));
        }

        //判断是否已经提交申请开户，或者审核已经通过
        $num= Db::name('openaccount_apply')->where('userid',$data['userid'])->where('status',0)->count();
        if($num>0){
            return json(array('code'=>1,'status'=>2,'msg'=>'审核中！'));
        }else{
            return json(array('code'=>1,'status'=>1,'msg'=>'未申请开户！'));
        }

    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取用户状态
     * @url:/index/otherapi/getUserMoney?userid=10&auth=11f648552BDTaE63RfYS0mtR3fV6CAU4gi7CPRlIvJaE5[a]rT5[a]ds
     * @params_remark:userid:用户ID，auth:登陆返回签名
     * @returnRes:{"code":1,"status":3,"msg":"开户成功！","zid":"255475546","pwd":"nb123456"}，
     * code:1表示成功，其他表示失败
     * status:1 未申请开户,2 审核中,3 开户成功,zid 账号，pwd 密码
     */
    public function getUserMoney(){
        if(\think\Request::instance()->isAjax()){
            $userid=input('userid');
            $auth=input('auth');
            $userinfo=Db::name('customer')->where('id',$userid)->find();
            if(empty($userinfo)||$userinfo['auth']!=$auth || empty($userinfo['zid'])){
                return json(array('code'=>2,'data'=>array()));
            }
            $data['UserID']='superadmin';
            $data['Action']='ReqQryAccountInfo';
            $data['ChdAccountID']=$userinfo['zid'];
            if(empty($userinfo['zg_id'])){
                return json(array('code'=>-1,'money'=>0));
            }

            $serverip= Db::name('zg_sys')->where('id',$userinfo['zg_id'])->value('server_ip');
            if(empty($serverip)){
                return json(array('code'=>-2,'money'=>0));
            }
            $url=$serverip;
            $res= ReqQryAccountInfo($data,$url);
            $res['Balance']=$res['Balance']/100;
            $res['Balance']=round($res['Balance'],2);
            return json($res);
        }else{
            return json(array('code'=>0,'money'=>0));
        }
    }

    /**
     * ******************************************PHP版本交易接口*********************************
     */

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取行情
     * @url:/index/otherapi/getHq?userid=37&auth=a054kYj6A[a]gt6aNAYUMtT4nUL839zZcRjgQIOgg1XAUaIRixntaB&instrumentid=rb1810
     * @params_remark:userid:用户ID，auth:登陆返回签名
     * @returnRes:[{"instrumentid":"rb1810","data":null},{"instrumentid":"ru1809","data":null}]
     * code:1表示成功，其他表示失败
     */
    public function getHq(){
        $instrumentid=input('instrumentid');
        $resTmp=array();
        $heyueRes=Db::name('contract_manage')->select();
        if(empty($heyueRes)){
            $instrumentIDArr = ['ag1812','cu1806','m1809','IF1805','rb1810','ni1807','au1806','ru1809'];
        }else{
            $hyArr=array();
            foreach ($heyueRes as $key=>$val){
                $hyArr[]=$val['c_code'];
            }
            $instrumentIDArr = $hyArr;
        }
        if(!empty($instrumentid)){
            $instrumentid=strtoupper($instrumentid);
            $hq=\think\Cache::store('redis')->get($this->cacke_key_pre.$instrumentid);
            if(empty($hq)){
                 $instrumentid=strtolower($instrumentid);
                 $hq=\think\Cache::store('redis')->get($this->cacke_key_pre.$instrumentid);
            }
            $hqArr=json_decode($hq);
            $tmpArr['instrumentid']=$instrumentid;
            $tmpArr['data']=$hqArr;
            $resTmp[]=$tmpArr;
        }else{
            foreach($instrumentIDArr as $k=>$val){
                $hq=\think\Cache::store('redis')->get($this->cacke_key_pre.$val);
                $hqArr=json_decode($hq);
                $tmpArr['instrumentid']=$val;
                $tmpArr['data']=$hqArr;
                $resTmp[]=$tmpArr;
            }
        }

        return json($resTmp);
    }

    /**
     * @brief:获取持仓
     * @url:/index/otherapi/getChicang?userid=37&auth=a054kYj6A[a]gt6aNAYUMtT4nUL839zZcRjgQIOgg1XAUaIRixntaB&type=1
     * @params_remark:userid:用户ID，auth:登陆返回签名,type:1获取已成交，2获取持仓，3，历史报单数据
     * @returnRes:{"code":1,"msg":"成功返回","data":[{"id":2393,"uid":37,"zid":null,"direction":"买","offset":"开仓","commission":"180","instrumentid":"rb1810","closeprofit":"0","tradedate":"20180515","tradeid":"3791920180515225221","tradeprice":"3701.00","tradetime":"225221000","ip":"127.0.0.1","status":1,"tradevolume":1,"create_time":"2018-05-15 22:52:21","update_time":"2018-05-15 22:52:21","stop_profit":100,"stop_loss":100,"bond":450},
     * {"id":2394,"uid":37,"zid":null,"direction":"买","offset":"开仓","commission":"180","instrumentid":"rb1810","closeprofit":"0","tradedate":"20180515","tradeid":"3773920180515225252","tradeprice":"3701.00","tradetime":"225252000","ip":"127.0.0.1","status":1,"tradevolume":2,"create_time":"2018-05-15 22:52:52","update_time":"2018-05-15 22:52:52","stop_profit":100,"stop_loss":100,"bond":450}]}
     * code:1表示成功，其他表示失败
     */
    public function getChicang(){
        $data['type']=trim(input('type'));
        $data['userid']=trim(input('userid'));
        $data['auth']=trim(input('auth'));
        if(empty($data)||empty($data['userid'])||empty($data['type'])||empty($data['auth'])){
            $resArr=array('code'=>-1,'msg'=>'参数错误');
            return json($resArr);
        }

        if($data['type']==1){
            $whereStatus['status']=array('in',array('1','2'));
            $userInfo=Db::name('trade_order')->where(array('uid'=>$data['userid']))->where($whereStatus)->select();
        }elseif($data['type']==2){
            $whereStatus['status']=1;
            $userInfo=Db::name('trade_order')->where(array('uid'=>$data['userid']))->where($whereStatus)->select();
        }else{
            $whereStatus=array();
            $userInfo=Db::name('user_trade')->where(array('uid'=>$data['userid']))->where($whereStatus)->select();

        }
        $resArr['code']=1;
        $resArr['msg']='成功返回';
        $resArr['data']=$userInfo;
        return json($resArr);
    }

    /**
     * @brief:下单接口
     * @url:/index/otherapi/trade?userid=37&auth=a054kYj6A[a]gt6aNAYUMtT4nUL839zZcRjgQIOgg1XAUaIRixntaB&instrumentid=rb1810&type=3&orderid=2395
     * @params_remark:userid:用户ID，auth:登陆返回签名,num:下单手数，默认1手，instrumentid合约号，
     * type：1.买一手涨 ,2.买一首跌, 3.平一手涨,4.平一首跌, 平单时需要带上订单号orderid，由持仓获取时候返回
     * @returnRes:{"code":1,"msg":"下单成功！"}，
     * code:1表示成功，其他表示失败
     */
    public function trade(){
        $data['instrumentid']=trim(input('instrumentid'));
        $data['type']=trim(input('type'));
        $data['userid']=trim(input('userid'));
        $data['num']=intval(trim(input('num',1)));
        $data['auth']=trim(input('auth'));
        $orderid=trim(input('orderid'));
        if(empty($data)||empty($data['userid'])||empty($data['instrumentid'])||empty($data['type'])||empty($data['auth'])){
            $resArr=array('code'=>-1,'msg'=>'参数错误');
            return json($resArr);
        }
        //获取签名验证，以及对应的资管账号
        $userInfo=Db::name('customer')->where(array('id'=>$data['userid']))->find();
        if(empty($userInfo) || $userInfo['auth'] !=$data['auth']){
            $resArr=array('code'=>-2,'msg'=>'签名验证错误!');
            return json($resArr);
        }

        //判断手续费，以及个人金额是否够
        $heyue=Db::name('contract_manage')->where(array('c_code'=>$data['instrumentid']))->find();
        if(empty($heyue)){
            $resArr=array('code'=>-3,'msg'=>'该合约不存在或不支持的合约!');
            return json($resArr);
        }
        //根据合约查询当前最低档保证金
        $bzj=Db::name('gear_setting')->where(array('cid'=>$heyue['id']))->order('bzj_gear','ASC')->find();
        if(empty($bzj)){
            $resArr=array('code'=>-3,'msg'=>'该合约未配置最低保证金!');
            return json($resArr);
        }

        //判断是否有行情，根据行情最后更新时间来判断
        $hq=\think\Cache::store('redis')->get($this->cacke_key_pre.$data['instrumentid']);
        if(!empty($hq)){
            //当前不是交易时间，无法交易
            $resArr=array('code'=>-4,'msg'=>'当前无法连接行情服务器，下单失败!');
            return json($resArr);
        }
        $hqArr=json_decode($hq);
        //$hqArr=array('LastPrice'=>"3701.00");
        //获取当日是否是交易日

        //判断当前是否是交易时间内

        //根据type类型赋值对应参数
        /** 1.买一手涨= ,2.买一首跌= ,3.平一手涨=,4.平一首跌= */
        $tradeDataArr['instrumentid']=$data['instrumentid'];
        $flag=1;//买卖标记，默认买
        switch($data['type']){
            case 1:
                $tradeDataArr['direction']='买';
                $tradeDataArr['offset']='开仓';
                $sxfFee=$heyue['ptglf']+$heyue['sxf']+$heyue['jsfwf'];
                $tradeDataArr['commission']=$sxfFee*$data['num'];

                break;
            case 2:
                $tradeDataArr['direction']='卖';
                $tradeDataArr['offset']='开仓';
                $sxfFee=$heyue['ptglf']+$heyue['sxf']+$heyue['jsfwf'];
                $tradeDataArr['commission']=$sxfFee*$data['num'];
                break;
            case 3:
                $tradeDataArr['direction']='买';
                $tradeDataArr['offset']='平仓';
                //接受订单ID，是否为未平状态，不扣手续费
                $tradeDataArr['commission']=0;
                $sxfFee=0;
                $flag=2;
                break;
            case 4:
                $tradeDataArr['direction']='卖';
                $tradeDataArr['offset']='平仓';
                $tradeDataArr['commission']=0;
                $sxfFee=0;
                $flag=2;
                break;
            default:
                $resArr=array('code'=>0,'msg'=>'报单类型错误');
                return json($resArr);
                break;
        }

        if($userInfo['total_money']<($sxfFee+$bzj['bzj_gear'])*$data['num']){
            $resArr=array('code'=>-5,'msg'=>'可用余额不够!');
            return json($resArr);
        }
       // echo($hqArr['LastPrice']);exit;
        $tradeDataArr['tradeprice']=$hqArr['LastPrice'];
        $tradeDataArr['tradevolume']=$data['num'];
        $tradeDataArr['tradedate']=date('Ymd');
        $tradeDataArr['tradeid']=$userInfo['id'].rand(100,999).date('YmdHis');
        $tradeDataArr['ip']=get_client_ip();
        $insertData = array(
            'uid' => $userInfo['id'],
            'zid' => $userInfo['zid'],
            'direction' => $tradeDataArr['direction'],
            'offset' => $tradeDataArr['offset'],
            'commission' => $tradeDataArr['commission'],
            'instrumentid' => $tradeDataArr['instrumentid'],
            'tradedate' => $tradeDataArr['tradedate'],
            'tradeid' => $tradeDataArr['tradeid'],
            'tradeprice' => $tradeDataArr['tradeprice'],
            'ip' => $tradeDataArr['ip'],
            'stop_profit'=>$bzj['stop_jump_num'],
            'stop_loss'=>$bzj['stop_loss_num'],
            'bond'=>$bzj['bzj_gear']*$data['num'],
            'tradetime'=>date('His',time()).'000',
            'tradevolume' => $tradeDataArr['tradevolume']
        );

        Db::startTrans();
        try{
            if($flag!==1){
                //平仓
                $orderInfo=Db::name('trade_order')->where('id',$orderid)->where('status',1)->find();
                if(empty($orderInfo)){
                    $resArr=array('code'=>-4,'msg'=>'该持仓订单不存在，无法卖出!');
                    return json($resArr);
                }
                if($data['type']==3){
                    //买涨需要用卖跌平
                    if( $orderInfo['direction']!='卖' || $orderInfo['offset']!='开仓'){
                        $resArr=array('code'=>-4,'msg'=>'该持仓订单无法平跌卖出!');
                        return json($resArr);
                    }
                }else{
                    //买涨需要用卖跌平
                    if( $orderInfo['direction']!='买' || $orderInfo['offset']!='开仓'){
                        $resArr=array('code'=>-4,'msg'=>'该持仓订单无法平跌卖出!');
                        return json($resArr);
                    }
                }
                $insertData['tradeprice']=$tradeDataArr['tradeprice'];
                //平仓盈亏，买涨=买入价-卖出价   大于0就是赚钱 小于零就是负数，买跌 =买入价-卖出价  小于0就是赚钱  大于0就是亏钱
                $closeprofit=$orderInfo['tradeprice']-$tradeDataArr['tradeprice'];
                if(Db::name('trade_order')->where('id',$orderid)->update(array('status'=>2,'closeprice'=>$tradeDataArr['tradeprice'],'closeprofit'=>$closeprofit))){
                    $resArr=array('code'=>1,'msg'=>'操作成功！!');
                    $insertData['closeprofit']=$closeprofit;
                    $insertData['stop_profit']=$orderInfo['stop_profit'];
                    $insertData['stop_loss']=$orderInfo['stop_loss'];
                    $insertData['bond']=$orderInfo['bond'];
                    $insertData['tradevolume']=$orderInfo['tradevolume'];
                    $insertData['tradeid']=$orderInfo['id'];
                    Db::name('user_trade')->insert($insertData,false,true);
                    Db::commit();
                    return json($resArr);
                }else{
                    Db::rollback();
                    $resArr=array('code'=>-4,'msg'=>'操作失败!');
                    return json($resArr);
                }
            }else{
                //开仓
                $insertData['status']=1;
                if(Db::name('trade_order')->insert($insertData,false,true)){
                    $resArr=array('code'=>1,'msg'=>'报单已成交！!');
                    Db::name('user_trade')->insert($insertData,false,true);
                    Db::commit();
                    return json($resArr);
                }else{
                    Db::rollback();
                    $resArr=array('code'=>-4,'msg'=>'报单失败，请重新报单!');
                    return json($resArr);
                }
            }
        }catch (\Exception $e){
            Db::rollback();
            $resArr=array('code'=>-4,'msg'=>'操作失败!');
            return json($resArr);
        }

    }
}
