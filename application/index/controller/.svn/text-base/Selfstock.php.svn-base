<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Cache;
use think\Db;
class Selfstock extends Controller
{

    private  $appcode='46b8a3ea6ab245c0b35c5fd355c5dfcd';//华升46b8a3ea6ab245c0b35c5fd355c5dfcd ，诺贝'76926a3c90c3421da7066eed62ec6d5e';
    static $df_url='http://nuff.eastmoney.com/EM_Finance2015TradeInterface/JS.ashx?id=';
    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取我的自选表单中的股票数据
     * @url:/index/Selfstock/myStockList?user_id=2&auth=XXX
     * @params_remark:user_id用户ID，auth:签名验证
     * @returnRes:{"code":1,"msg":"获取成功！","data":[{"stockID":"600300","stock":"维维股份","now_price":"\"4.35\"","updown_rate":"\"3.08\""},{"stockID":"000030","stock":"富奥股份","now_price":"\"7.68\"","updown_rate":"\"1.05\""}]}
     */
    public function myStockList(){
        $userid=input('user_id');
        $returnArr=array('code'=>1,'msg'=>'获取成功','data'=>array());
        $stockInfo=Db::table('imps_selfstock_conf')->where('user_id',$userid)->field(['stockID','stock'])->select();
        if(!empty($stockInfo)){
            foreach($stockInfo as $key => &$val){
                $stockid=$val['stockID'];
                $begin=substr($stockid, 0, 1);
                if($begin==0){
                    $stockid.=0;
                }elseif($begin==6){
                    $stockid.=1;
                }else{
                    $stockid.=2;
                }
                $url=self::$df_url.$stockid;
                $content=http($url);
                $arr=explode('Value',$content);
                if(is_array($arr)){
                    $stockPriceArr=explode(',',$arr[1]);

                    if(is_array($stockPriceArr)&&isset($stockPriceArr[25])) {
                        $val['now_price']=$stockPriceArr[25];
                        $val['updown_rate']=$stockPriceArr[29];
                    }else{
                        $url=self::$df_url.$val['stockID'].'2';
                        $content=http($url);
                        $arr=explode('Value',$content);
                        if(is_array($arr)){
                            $stockPriceArr=explode(',',$arr[1]);
                            if(is_array($stockPriceArr)&&isset($stockPriceArr[25])) {
                                $val['now_price']=$stockPriceArr[25];
                                $val['updown_rate']=$stockPriceArr[29];
                            }else{
                                $val['now_price']='-';
                                $val['updown_rate']='-';
                            }
                        }else{
                            $val['now_price']='-';
                            $val['updown_rate']='-';
                        }

                    }
                }else{
                    $val['now_price']='-';
                    $val['updown_rate']='-';
                }
            }
            $returnArr['msg']='获取成功！';
            $returnArr['data']=$stockInfo;
        }else{
            $returnArr['code']=0;
            $returnArr['msg']='您还没有自选股票数据！';
        }

        return json($returnArr);
    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:添加自选股票接口
     * @url:/index/Selfstock/myStockAdd?user_id=2&stockID=300025&stock=华天股份&auth=XXXX
     * @params_remark:stockID：股票ID，stock：股票名字，user_id：用户Id
     * @returnRes:{"code":1,"msg":"添加成功"}，code  1为成功，0为失败
     */
    public function myStockAdd()
    {
        $userid=input('user_id');
        $stockID=input('stockID');
        $stock=input('stock');
        $auth=input('auth');
        $returnArr=array('code'=>0,'msg'=>'添加失败');
        $authcode= Db::table( 'promotion_user' )->where(array('id'=>intval($userid)))->value('auth');
        if(empty($stockID)||empty($userid)||empty($authcode) || $authcode!=$auth){
            $returnArr['msg']='非法请求';
            return json($returnArr);
        }
        $stockInfo=Db::table('imps_selfstock_conf')->where('user_id',$userid)->where('stockID',$stockID)->find();
        if(!empty($stockInfo)){
            $returnArr['msg']='不能重复添加';
            return json($returnArr);
        }else{
            //判断每个账号添加的自选股不能超过规定的额度
            $count=Db::table('imps_selfstock_conf')->where('user_id',$userid)->count();
            if($count>=MAX_ZX_NUM){
                $returnArr['msg']='每个账号最多只能添加'.MAX_ZX_NUM.'条自选';
                return json($returnArr);
            }
            if(Db::table('imps_selfstock_conf')->insert(array('user_id'=>$userid,'stockID'=>$stockID,'stock'=>$stock))){
                $returnArr['code']=1;
                $returnArr['msg']='添加成功';
                return json($returnArr);
            }else{
                $returnArr['msg']='添加失败';
                return json($returnArr);
            }
        }

    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:删除自选股
     * @url:/index/Selfstock/myStockAddDelete?user_id=2&stockID=300025,300024&auth=XXXX
     * @params_remark:stockID：股票ID，多个股票用逗号隔开，user_id：用户Id,auth:签名
     * @returnRes:{"code":1,"msg":"删除成功"}，code  1为成功，0为失败
     */
    public function myStockAddDelete(){
        $userid=input('user_id');
        $stockID=input('stockID');
        $auth=input('auth');
        $returnArr=array('code'=>0,'msg'=>'删除失败');
        $authcode= Db::table( 'promotion_user' )->where(array('id'=>intval($userid)))->value('auth');
        if(empty($stockID)||empty($userid)||empty($authcode) || $authcode!=$auth){
            $returnArr['msg']='非法请求';
            return json($returnArr);
        }

        $stockID=explode(',',$stockID);

        $stockInfo=Db::table('imps_selfstock_conf')->where('user_id',$userid)->where('stockID','in',$stockID)->find();
        if(empty($stockInfo)){
            $returnArr['msg']='已经删除的自选股票';
            return json($returnArr);
        }else{

            if(Db::table('imps_selfstock_conf')->where('user_id',$userid)->where('stockID','in',$stockID)->delete()){
                $returnArr['code']=1;
                $returnArr['msg']='删除成功';
                return json($returnArr);
            }else{
                $returnArr['msg']='删除失败';
                return json($returnArr);
            }
        }
    }


    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取股票K数据格式
     * @url:/index/Selfstock/getStockKlineData?stockid=000003&type=day
     * @params_remark:stockid:股票代码,type:day 日K，week 周线，month 月线,默认不填，为day
        @returnRes:[["2017/10/31",28.8,28.96,28.28,29.28],["2017/11/01",28.96,29.15,28.73,30.54]]
     */
    public function getStockKlineData(){

        $stockId=input('stockid');
        $type=input('type','day');
        $dayKlineUrl='http://data.gtimg.cn/flashdata/hushen/latest/daily/';
        $weekKlineUrl='http://data.gtimg.cn/flashdata/hushen/latest/weekly/';
        $monthKlineUrl='http://data.gtimg.cn/flashdata/hushen/monthly/';
        $stock=$this->get_stock($stockId);
        $monthKlineUrl.=$stock.'.js?maxage=43201';
        $weekKlineUrl.=$stock.'.js?maxage=43201&visitDstTime=1';
        $dayKlineUrl.=$stock.'.js?maxage=43201&visitDstTime=1';

        switch($type){
            case 'day':
                $reqUrl=$dayKlineUrl;
                break;
            case 'week':
                $reqUrl=$weekKlineUrl;
                break;
            case 'month':
                $reqUrl=$monthKlineUrl;
                break;
            default:
                echo '类型错误';
                exit;
                break;
        }
        $content=http($reqUrl);
        $arr=explode('=',$content);
        if(is_array($arr)){
            $stockKArr=explode('\n\\',$arr[1]);
            $i=0;
            $dataArr= $tmpArr=array();
            $today=date('Y/m/d',time());
            $hasToday=0;
            foreach($stockKArr as $key=>$val){
                //循环读取配置数据，从第二行开始
                $i++;
                if($i>2){

                    $lineArr = explode(' ',$val);
                    if(is_array($lineArr) && count($lineArr)>=4){
                       $date= intval($lineArr[0]);
                       $Y=substr($date,0,2);
                       $m=substr($date,2,2);
                       $d=substr($date,4,2);
                       $date='20'.$Y.'/'.$m.'/'.$d;
                        if($date==$today) $hasToday=1;
                       $tmpArr=array($date,floatval($lineArr[1]),floatval($lineArr[2]),floatval($lineArr[4]),floatval($lineArr[3]),floatval($lineArr[5]));
                    }else{
                        if($hasToday==0){
                            $resSina= $this->get_sina($stock);
                            if(is_array($resSina)) $tmpArr=array($today,floatval($resSina[1]),floatval($resSina[2]),floatval($resSina[5]),floatval($resSina[4]));
                        }
                    }
                    if(!empty($tmpArr)) $dataArr[]=$tmpArr;
                    $tmpArr=array();
                }
            }

        }else{
            return '-';
        }
        echo json_encode($dataArr,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取股票K数据格式
     * @url:/index/Selfstock/getQihuoKlineData?stockid=RB0Y00.XSGE&candle_period=6
     * @params_remark:stockid:股票代码
     * candle_period:必选K线周期	取值可以是数字1-9，表示含义如下： 1：1分钟K线 2：5分钟K线 3：15分钟K线 4：30分钟K线 5：60分钟K线 6：日K线 7：周K线 8：月K线 9：年K线
       @returnRes:[["2017/10/31",28.8,28.96,28.28,29.28],["2017/11/01",28.96,29.15,28.73,30.54]]
     */
    public function getQihuoKlineData(){
        $prodCode=strtoupper(input('stockid'));
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


    //http://demo-stock.api51.cn/20180416/api/real/?en_prod_code=RB1805.XSGE
    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取分时数据
     * @url:/index/Selfstock/getQihuoMinuteData?stockid=RB1805.XSGE
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

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取分时数据
     * @url:/index/Selfstock/getMinuteData?stockid=000001
     * @params_remark:stockid:股票代码
     * @returnRes:[["93:0","93:1","93:2","93:3","93:4],["10.85","10.89","10.88","10.86","10.86"]]
     */
    public  function getMinuteData(){
        $stockId=input('stockid');
        $Url='http://data.gtimg.cn/flashdata/hushen/minute/';
        $stock=$this->get_stock($stockId);
        $Url.=$stock.'.js?maxage=110&0.28163905744440854';
        $content=http($Url);
        $arr=explode('=',$content);
        if(is_array($arr)){

            $stockKArr=explode('\n\\',$arr[1]);
            $i=0;
            $dataArr= $timeTmpArr=$stockTmpArr=array();
            foreach($stockKArr as $key=>$val){
                //循环读取配置数据，从第二行开始
                $i++;
                if($i>2){
                    $lineArr = explode(' ',$val);
                    if(is_array($lineArr) && count($lineArr)>=3){
                        $date= intval($lineArr[0]);
                        $h=substr($date,0,2);
                        $m=substr($date,2,2);
                        $time=$h.':'.$m;
                        $timeTmpArr[]=$time;
                        $stockTmpArr[]=$lineArr[1];
                    }
                }
            }
            $dataArr[0]=$timeTmpArr;
            $dataArr[1]=$stockTmpArr;
        }else{
            return '-';
        }
        echo json_encode($dataArr,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取主力资金流入流出
     * @url:/index/Selfstock/getMainCapital?stockid=000001
     * @params_remark:stockid:股票代码
     * @returnRes:[10.03,11.63,9.15,7.55] 主力流入，主力流出，散户流入，散户流出
     */
    public function getMainCapital(){
        $stockId=input('stockid');
        $Url='http://qt.gtimg.cn/q=ff_';
        $stock=$this->get_stock($stockId);
        $Url.=$stock;
        $content=http($Url);
        $arr=explode('=',$content);
        $dataArr=array();
        if(is_array($arr)){
            $stockKArr=explode('~',$arr[1]);
           if(is_array($stockKArr)&&count($stockKArr)>4){
               $dataArr=array(round($stockKArr[1]/10000,2),round($stockKArr[2]/10000,2),round($stockKArr[5]/10000,2),round($stockKArr[6]/10000,2));
           }

        }else{
            return '-';
        }
        echo json_encode($dataArr,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    public function getStockKlineDetail(){
        return view();
    }

    //index/selfstock/qrcode
    public function qrcode(){
        $userid=input('userid');
        $auth=input('auth');
        if(empty($userid)){
            $this->error('未找到对应用户');
            exit;
        }

        $userinfo=Db::table('promotion_user')->where('id','=',$userid)->find();
        if(empty($userinfo)){
            $this->error('未找到对应用户');
            exit;
        }

        if($userinfo['level']>=5){
            $this->error('目前只对代理开放此功能！');
            exit;
        }

        //获取我的对应的推广码，可用提现额度
        $this->assign('money',$userinfo['money']);
        $this->assign('ext_code',$userinfo['ext_code']);
        //获取用户对应的推广人数
        $count=Db::table('promotion_user')->where('email_code','=',$userinfo['ext_code'])->count();
        $this->assign('count',$count);
        if(!empty($_SERVER['HTTPS'])){
            $http='https://';
        }else{
            $http='http://';
        }
        $url=$http.$_SERVER['HTTP_HOST'].'/index/qiquand/reg.html?ext_code='.$userinfo['ext_code'];
        $this->assign('url',$url);
        return view();
    }
    public function get_stock($value)
    {
        if (strlen($value) == 6) {
            $top = substr($value, 0, 1);
            if ($top == '0' || $top == '2' || $top == '4' || $top == '8' || $top == '3') {
                $pre = 'sz';
            } elseif ($top == '6' || $top == '9' || $top == '5' || $top == '7') {
                $pre = 'sh';
            } else {
                return "-";
            }
            return $pre.$value;
        }else{
            return "-";
        }
    }

    public function get_sina($value){
            $url="https://hq.sinajs.cn/list=".$value;
            $html=http($url);
            $html=gbkToUtf8($html);
            $arr=explode('=',$html);
            if(is_array($arr)){
                $stockPriceArr=explode(',',$arr[1]);
            }else{
                return '-';
            }

            if(is_array($stockPriceArr)) {
               // $stockPrice=$stockPriceArr[3];
                //计算盈亏
                return $stockPriceArr;
            }else{
                return "-";
            }
    }

    //index/Selfstock/get_stock_value?stockid=55555
    public function get_stock_value(){
        $value=input('stockid');
        if(strlen($value)==6){
            $top=substr($value,0,1);
            if($top=='0' || $top=='2' || $top=='4' || $top=='8' || $top=='3'){
                $pre= 'sz';
            } elseif($top=='6' || $top=='9' || $top=='5' || $top=='7'){
                $pre=  'sh';
            }else{
                return "-";
            }
            $url="https://hq.sinajs.cn/list=".$pre.$value;
            $html=http($url);
            $html=gbkToUtf8($html);
            $arr=explode('=',$html);
            if(is_array($arr)){
                $stockPriceArr=explode(',',$arr[1]);
            }else{
                return '-';
            }

            if(is_array($stockPriceArr)) {
                $stockPrice=$stockPriceArr[3];
                //计算盈亏
                return json(array('code'=>0,'price'=>$stockPrice));
            }else{
                return   json(array('code'=>0,'price'=>""));
            }

        }else{
            return   json(array('code'=>0,'price'=>""));
        }
    }

    /** 东方财富网，股票期货K线数据来源 */
    const EASTMONEY_K_URL ='http://pdfm.eastmoney.com/EM_UBG_PDTI_Fast/api/js?rtntype=5&';//id=ag18121&type=mk
    const NB_K_URL='http://k.xyufu.com/index/Selfstock/getKlineByEm?';
    const API_K_URL='https://data.api51.cn/apis/futures/chart/?token=02b1895b50a9168ca57b53a87df2b699&future_code=';//API51
    /**
     * @brief:获取K线图数据。
     * @url: 期货：/index/Selfstock/getKlineData?id=sc1809&type=mk&catid=2
     * 50ETF: /index/Selfstock/getKlineByEm?id=10001413&type=k&catid=3
     * @params_remark: id：股票，期货，ETF对应的ID，
     * type: m5k：5分钟k线，m15k：15分钟k线，m30k：30分钟k线， m60k：60分钟k线，
     * k:日k线，wk：周K线，mk:月k线,r:分时图
     * catid:1股票，2期货，3，ETF指数，4其他，默认股票
        @returnRes:返回格式，日期，今开，昨收，最低，最高，成交量，成交额
     */
    public function getKlineData1(){
        ini_set("memory_limit","-1");
        $id=input('id');
        $type=input('type');
        $catid=input('catid',1);
        if(empty($id) ||empty($type)){
            return json(array());
        }
        $url=self::NB_K_URL.'id='.$id.'&type='.$type.'&catid='.$catid;
        $html=http($url);
        echo $html;
    }


    public function getKline(){//使用API51的
        ini_set("memory_limit","-1");
        $id=input('id');
        if(empty($id)){
            return json(array());
        }
        $cc = $id.'kl';
        $rr = Cache::get($cc);
        if(empty($rr)){
            $type = 1;//分时图
            $abc=substr($id,-4);
            if(!is_numeric($abc)){
                $thr = substr($id,-3);
                $a = substr($id,0,-3);
                $a = strtoupper($a);
                $id = $a.'1'.$thr;
            }else{
                $a = substr($id,0,-4);
                $a = strtoupper($a);
                $id = $a.$abc;
            }
            $url=self::API_K_URL.$id.'&type='.$type;
            $html=http($url);
            $arr = json_decode($html,true);
            $date = [];
            $num = [];
            $cj = [];
            foreach($arr as $v){
                $date[] = $arr[0][6].' '.$v[0];
                $num[] = $v[1];
                $cj[] = $v[3];
            }
            $rr = array($date,$num,$cj);
            $rr = json_encode($rr);
            $g = date('G');
            if(($g>=3&&$g<9)||($g>=15&&$g<21)){
                $time = 7200;
            }elseif($g==12){
                $time = 3600;
            }else{
                $time = 60;
            }
            Cache::set($cc,$rr,$time);
        }
       echo $rr;
    }

    public function getKlineData(){//使用API51的
        ini_set("memory_limit","-1");
        $id=input('id');
        $type=input('type');
        if(empty($id) ||empty($type)){
            return json(array());
        }

        $cc = $id.'kd'.$type;
        $rr = \think\Cache::get($cc);
        if(empty($rr)){

            if($type == 'r'){
                $type = 1;//分时图
            }elseif($type == 'm5k'){
                $type = 2;
            }elseif($type == 'm15k'){
                $type = 3;
            }elseif($type == 'm30k'){
                $type = 4;
            }elseif($type == 'm60k'){
                $type = 5;
            }elseif($type == 'k'){
                $type = 7;
            }

            $abc=substr($id,-4);
            if(!is_numeric($abc)){
                $thr = substr($id,-3);
                $a = substr($id,0,-3);
                $a = strtoupper($a);
                $id = $a.'1'.$thr;
            }else{
                $a = substr($id,0,-4);
                $a = strtoupper($a);
                $id = $a.$abc;
            }

            $url=self::API_K_URL.$id.'&type='.$type;
            $html=http($url);
            $html=str_replace('h','"h"',$html);
            $html=str_replace('d','"d"',$html);
            $html=str_replace('o','"o"',$html);
            $html=str_replace('c','"c"',$html);
            $html=str_replace('l','"l"',$html);
            $html=str_replace('v','"v"',$html);
            $arr = json_decode($html,true);
            $date = [];
            $data = [];
            $num = [];
            $cj = [];
            foreach($arr as $v){
                if($type == 1){
                    $date[] = $arr[0][6].' '.$v[0];
                    $num[] = $v[1];
                    $cj[] = $v[3];
                }else{
                    $data[] = $v['d'];
                    $data[] = $v['o'];
                    $data[] = $v['c'];
                    $data[] = $v['l'];
                    $data[] = $v['h'];
                    $data[] = $v['v'];
                    $rr[] = $data;
                    $data = [];
                }
            }
            if($type == 1){
                $rr = array($date,$num,$cj);
            }
            $g = date('G');
            if(($g>=3&&$g<9)||($g>=15&&$g<21)){
                $time = 7200;
            }elseif($g==12){
                $time = 3600;
            }else{
                $time = 60;
            }
            \think\Cache::set($cc,$rr,$time);
        }
        echo json_encode($rr);
    }

    /**
     * ################################## 阿里接口数据 #################################################
     */

    /**************************OpenAPI接入****************************/
    public function token(){
        header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求

        echo '{"token_type":"token","access_token":"wangjikeji","expires_in":86400,"scope":"futures,trade,hkstock,sim,info,trade_entrust"}';

    }

    /**************************会话接入****************************/
    public function account_token(){
        header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
        $exp_time=time()+3000;
        echo '{"err_no":0,"data":{"update_time":'.time().',"exp_time":'.$exp_time.',"app_key":"wangjikeji","access_token":"wangjikeji"}}';
    }


    public function real(){
        // +----------------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        $host = "http://stock.api51.cn/real";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        $url = $host . $path;
        if($_GET){
            $data = array(
                'en_prod_code'=>$_GET['en_prod_code'],//接收手机号
                'fields'=>$_GET['fields'],//模板变量，多个以英文逗号隔开
            );
        }
        if($_POST){
            $data = array(
                'en_prod_code'=>$_POST['en_prod_code'],//接收手机号
                'fields'=>$_POST['fields'],//模板变量，多个以英文逗号隔开
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }


    public function sort(){
        // +----------根据某个字段值对产品代码进行排序------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/sort";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        $url = $host . $path;
        if($_GET){
            $data = array(
                'en_hq_type_code'=>$_GET['en_hq_type_code'],//类型代码集 可以输入一个或者多个类型代码，使用逗号（,）连接。 类型代码可以是交易所识别码或交易所识别码和金融品种分类识别码两者组合而成， 详细请参阅《api_商品代码命名规范》 。 示例： SS 表示上海证券交易所的所有代码, SS.ESA 表示上海证券交易所的所有 A 股 必须输入en_hq_type_code或en_prod_code。
                'en_prod_code'=>$_GET['en_prod_code'],//产品代码集	可以输入一个或多个代码证券代码包含交易所代码做后缀，作为该代码的唯一标识。如：600570.SS； 必须输入en_hq_type_code或en_prod_code，但en_prod_code优先级高于 en_hq_type_code。
                'sort_field_name'=>$_GET['sort_field_name'],//排序字段名称
                //按照该字段进行排序 允许的字段： 加权平均价：wavg_px 每股收益：eps 每股净资产：bps 昨收价：preclose_px 开盘价：open_px 最新价：last_px 最高价：high_px 最低价：low_px 成交金额：business_balance 成交数量：business_amount 成交笔数：business_count 国债基金净值：debt_fund_value 基金净值：iopv 涨跌额：px_change 涨跌幅：px_change_rate 振幅：amplitude 换手率：turnover_ratio 量比：vol_ratio 市盈率：pe_rate 市净率：dyn_pb_rate 市值：market_value 流通市值：circulation_value 内盘成交量：business_amount_in 外盘成交量：business_amount_out 委比：entrust_rate 委差：entrust_diff 财务季度：fin_quarter 财务截至日期：fin_end_date 总股本：total_shares 流通股本：circulation_amount 五分钟涨跌幅：min5_chgpct
                'sort_type'=>$_GET['sort_type'],//排序方式	0：表示升序； 1：表示降序(默认)
                'fields'=>$_GET['fields'],
                'start_pos'=>$_GET['start_pos'],//起始位置
                'data_count'=>$_GET['data_count'],//	数据个数
                'special_marker'=>$_GET['special_marker'],//	特殊标志
            );
        }
        if($_POST){
            $data = array(
                'en_hq_type_code'=>$_POST['en_hq_type_code'],//类型代码集 可以输入一个或者多个类型代码，使用逗号（,）连接。 类型代码可以是交易所识别码或交易所识别码和金融品种分类识别码两者组合而成， 详细请参阅《api_商品代码命名规范》 。 示例： SS 表示上海证券交易所的所有代码, SS.ESA 表示上海证券交易所的所有 A 股 必须输入en_hq_type_code或en_prod_code。
                'en_prod_code'=>$_POST['en_prod_code'],//产品代码集	可以输入一个或多个代码证券代码包含交易所代码做后缀，作为该代码的唯一标识。如：600570.SS； 必须输入en_hq_type_code或en_prod_code，但en_prod_code优先级高于 en_hq_type_code。
                'sort_field_name'=>$_POST['sort_field_name'],//排序字段名称
                //按照该字段进行排序 允许的字段： 加权平均价：wavg_px 每股收益：eps 每股净资产：bps 昨收价：preclose_px 开盘价：open_px 最新价：last_px 最高价：high_px 最低价：low_px 成交金额：business_balance 成交数量：business_amount 成交笔数：business_count 国债基金净值：debt_fund_value 基金净值：iopv 涨跌额：px_change 涨跌幅：px_change_rate 振幅：amplitude 换手率：turnover_ratio 量比：vol_ratio 市盈率：pe_rate 市净率：dyn_pb_rate 市值：market_value 流通市值：circulation_value 内盘成交量：business_amount_in 外盘成交量：business_amount_out 委比：entrust_rate 委差：entrust_diff 财务季度：fin_quarter 财务截至日期：fin_end_date 总股本：total_shares 流通股本：circulation_amount 五分钟涨跌幅：min5_chgpct
                'sort_type'=>$_POST['sort_type'],//排序方式	0：表示升序； 1：表示降序(默认)
                'fields'=>$_POST['fields'],
                'start_pos'=>$_POST['start_pos'],//起始位置
                'data_count'=>$_POST['data_count'],//	数据个数
                'special_marker'=>$_POST['special_marker'],//	特殊标志
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;

    }

    public function blockSort(){
        // +----------板块成份股排序------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/block/sort";//如需
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//类型代码集 可以输入一个或者多个类型代码，使用逗号（,）连接。 类型代码可以是交易所识别码或交易所识别码和金融品种分类识别码两者组合而成， 详细请参阅《api_商品代码命名规范》 。 示例： SS 表示上海证券交易所的所有代码, SS.ESA 表示上海证券交易所的所有 A 股 必须输入en_hq_type_code或en_prod_code。
                'sort_field_name'=>$_GET['sort_field_name'],//排序字段名称
                //按照该字段进行排序 允许的字段： 加权平均价：wavg_px 每股收益：eps 每股净资产：bps 昨收价：preclose_px 开盘价：open_px 最新价：last_px 最高价：high_px 最低价：low_px 成交金额：business_balance 成交数量：business_amount 成交笔数：business_count 国债基金净值：debt_fund_value 基金净值：iopv 涨跌额：px_change 涨跌幅：px_change_rate 振幅：amplitude 换手率：turnover_ratio 量比：vol_ratio 市盈率：pe_rate 市净率：dyn_pb_rate 市值：market_value 流通市值：circulation_value 内盘成交量：business_amount_in 外盘成交量：business_amount_out 委比：entrust_rate 委差：entrust_diff 财务季度：fin_quarter 财务截至日期：fin_end_date 总股本：total_shares 流通股本：circulation_amount 五分钟涨跌幅：min5_chgpct
                'sort_type'=>$_GET['sort_type'],//排序方式	0：表示升序； 1：表示降序(默认)
                'fields'=>$_GET['fields'],
                'start_pos'=>$_GET['start_pos'],//起始位置
                'data_count'=>$_GET['data_count'],//	数据个数

            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//类型代码集 可以输入一个或者多个类型代码，使用逗号（,）连接。 类型代码可以是交易所识别码或交易所识别码和金融品种分类识别码两者组合而成， 详细请参阅《api_商品代码命名规范》 。 示例： SS 表示上海证券交易所的所有代码, SS.ESA 表示上海证券交易所的所有 A 股 必须输入en_hq_type_code或en_prod_code。
                'sort_field_name'=>$_POST['sort_field_name'],//排序字段名称
                //按照该字段进行排序 允许的字段： 加权平均价：wavg_px 每股收益：eps 每股净资产：bps 昨收价：preclose_px 开盘价：open_px 最新价：last_px 最高价：high_px 最低价：low_px 成交金额：business_balance 成交数量：business_amount 成交笔数：business_count 国债基金净值：debt_fund_value 基金净值：iopv 涨跌额：px_change 涨跌幅：px_change_rate 振幅：amplitude 换手率：turnover_ratio 量比：vol_ratio 市盈率：pe_rate 市净率：dyn_pb_rate 市值：market_value 流通市值：circulation_value 内盘成交量：business_amount_in 外盘成交量：business_amount_out 委比：entrust_rate 委差：entrust_diff 财务季度：fin_quarter 财务截至日期：fin_end_date 总股本：total_shares 流通股本：circulation_amount 五分钟涨跌幅：min5_chgpct
                'sort_type'=>$_POST['sort_type'],//排序方式	0：表示升序； 1：表示降序(默认)
                'fields'=>$_POST['fields'],
                'start_pos'=>$_POST['start_pos'],//起始位置
                'data_count'=>$_POST['data_count'],//	数据个数
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function fundflow_order_rank(){
        // +----------查询个股分时资金流------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/fundflow_order_rank";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0
        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'en_prod_code'=>$_GET['en_prod_code'],//产品代码
                'en_hq_type_code'=>$_GET['en_hq_type_code'],//产品代码
                'sort_type'=>$_GET['sort_type'],//产品代码
                'sort_field_name'=>$_GET['sort_field_name'],//产品代码
                'data_count'=>$_GET['data_count'],//产品代码
                'start_pos'=>$_GET['start_pos'],//产品代码
                'fields'=>$_GET['fields'],//产品代码


            );
        }
        if($_POST){
            $data = array(
                'en_prod_code'=>$_POST['en_prod_code'],//产品代码
                'en_hq_type_code'=>$_POST['en_hq_type_code'],//产品代码
                'sort_type'=>$_POST['sort_type'],//产品代码
                'sort_field_name'=>$_POST['sort_field_name'],//产品代码
                'data_count'=>$_POST['data_count'],//产品代码
                'start_pos'=>$_POST['start_pos'],//产品代码
                'fields'=>$_POST['fields'],//产品代码
            );
        }
        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function query(){
        // +----------查询某支代码所属的版块------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/block/query";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0
        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//产品代码

            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//产品代码

            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function trend(){
        // +----------请求分时信息------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/trend";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0
        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//产品代码
                'fields'=>$_GET['fields'],
                'crc'=>$_GET['crc'],//循环冗余校验码
                'date'=>$_GET['date'],//	日期
                'min_time'=>$_GET['min_time'],//	分时分钟时间
            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//产品代码
                'fields'=>$_POST['fields'],
                'crc'=>$_POST['crc'],//循环冗余校验码
                'date'=>$_POST['date'],//	日期
                'min_time'=>$_POST['min_time'],//	分时分钟时间
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function trend5day(){
        // +----------获取五日分时信息------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/trend5day";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//产品代码
                'fields'=>$_GET['fields'],

            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//产品代码
                'fields'=>$_POST['fields'],

            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function kline(){
        // +----------------------------------------------------------------------
        //get_type=offset&prod_code=600570.SS&candle_period=6&fields=open_px,high_px,low_px,close_px,business_amount,business_balance,min_time&candle_mode=1&data_count=225&_=1510563259482
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/kline";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//产品代码	有且仅能有 1 个代码；证券代码包含交易所代码做后缀，作为该代码的唯一标识。如：600570.SS
                'fields'=>$_GET['fields'],//字段集合	允许的字段： 开盘价：open_px 最高价：high_px 最低价：low_px 收盘价：close_px 成交量：business_amount 成交额：business_balance 如果没有指定任何有效的字段，则返回所有字段
                'candle_mode'=>$_GET['candle_mode'],//K线模式	0：原始K线 1：前复权K线 2：后复权K线
                'candle_period'=>$_GET['candle_period'],//K线周期	取值可以是数字1-9，表示含义如下： 1：1分钟K线 2：5分钟K线 3：15分钟K线 4：30分钟K线 5：60分钟K线 6：日K线 7：周K线 8：月K线 9：年K线
                'get_type'=>$_GET['get_type'],//查找类别	offset 按偏移查找；range 按日期区间查找；必须输入其中一个值
                'data_count'=>$_GET['data_count'],//数据个数	需要取得的 K 线的根数，如果该字段不存在，取值范围[1, 1000]，默认为 10 个。 仅在 get_type=offset 时有效。
                'search_direction'=>$_GET['search_direction'],//	搜索方向	1 表示向前查找（默认值） ，2 表示向后查找。 仅在 get_type=offset 时有效。
                'date'=>$_GET['date'],//	日期	不输入默认为当前日期；请求日K线时，如果输入日期，不返回该日期的K线 get_type=offset时有效
                'min_time'=>$_GET['min_time'],//分时分钟时间(HHMM)	分钟 K 线的时间 HHMM,对于 短 周期 K 线 类型 使用(1min,5min 等)，不填写表示最新的市场时间，若填写必须同时填写 date 字段。请求分钟K线时，如果输入该字段，不返回输入分钟的K线 仅在 get_type=offset 且candle_period=1~5（分钟 K线）时有效。
                'start_date'=>$_GET['start_date'],//开始日期	1、 start_date 和 end_date 均不填， 返回距离当前日期的1000 根 K 线； 2、 仅填 start_date， 当 start_date和最新日期之间的数据不足1000 根，返回 start_date 和最新日期之间的数据；如果数据超过 1000 根 K 线， 则返回距离当前日期的 1000 根 K线； 3、 仅填 end_date ， 返 回end_date 之前存在的的最多1000 根 K 线； 4、 start_date 和 end_date 均填充，返回该日期区间（闭区间）的数据，最多 1000 根。 仅在 get_type=range 时有效。
                'end_date'=>$_GET['end_date'],//截止日期	默认为当前日期； 1、 start_date 和 end_date 均不填， 返回距离当前日期的1000 根 K 线； 2、 仅填 start_date， 当 start_date和最新日期之间的数据不足1000 根，返回 start_date 和最新日期之间的数据；如果数据超过 1000 根 K 线， 则返回距离当前日期的 1000 根 K线； 3、 仅填 end_date ， 返 回end_date 之前存在的的最多1000 根 K 线； 4、 start_date 和 end_date 均填充，返回该日期区间（闭区间）的数据，最多 1000 根。 仅在 get_type=range 时有效。

            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//产品代码	有且仅能有 1 个代码；证券代码包含交易所代码做后缀，作为该代码的唯一标识。如：600570.SS
                'fields'=>$_POST['fields'],//字段集合	允许的字段： 开盘价：open_px 最高价：high_px 最低价：low_px 收盘价：close_px 成交量：business_amount 成交额：business_balance 如果没有指定任何有效的字段，则返回所有字段
                'candle_mode'=>$_POST['candle_mode'],//K线模式	0：原始K线 1：前复权K线 2：后复权K线
                'candle_period'=>$_POST['candle_period'],//K线周期	取值可以是数字1-9，表示含义如下： 1：1分钟K线 2：5分钟K线 3：15分钟K线 4：30分钟K线 5：60分钟K线 6：日K线 7：周K线 8：月K线 9：年K线
                'get_type'=>$_POST['get_type'],//查找类别	offset 按偏移查找；range 按日期区间查找；必须输入其中一个值
                'data_count'=>$_POST['data_count'],//数据个数	需要取得的 K 线的根数，如果该字段不存在，取值范围[1, 1000]，默认为 10 个。 仅在 get_type=offset 时有效。
                'search_direction'=>$_POST['search_direction'],//	搜索方向	1 表示向前查找（默认值） ，2 表示向后查找。 仅在 get_type=offset 时有效。
                'date'=>$_POST['date'],//	日期	不输入默认为当前日期；请求日K线时，如果输入日期，不返回该日期的K线 get_type=offset时有效
                'min_time'=>$_POST['min_time'],//分时分钟时间(HHMM)	分钟 K 线的时间 HHMM,对于 短 周期 K 线 类型 使用(1min,5min 等)，不填写表示最新的市场时间，若填写必须同时填写 date 字段。请求分钟K线时，如果输入该字段，不返回输入分钟的K线 仅在 get_type=offset 且candle_period=1~5（分钟 K线）时有效。
                'start_date'=>$_POST['start_date'],//开始日期	1、 start_date 和 end_date 均不填， 返回距离当前日期的1000 根 K 线； 2、 仅填 start_date， 当 start_date和最新日期之间的数据不足1000 根，返回 start_date 和最新日期之间的数据；如果数据超过 1000 根 K 线， 则返回距离当前日期的 1000 根 K线； 3、 仅填 end_date ， 返 回end_date 之前存在的的最多1000 根 K 线； 4、 start_date 和 end_date 均填充，返回该日期区间（闭区间）的数据，最多 1000 根。 仅在 get_type=range 时有效。
                'end_date'=>$_POST['end_date'],//截止日期	默认为当前日期； 1、 start_date 和 end_date 均不填， 返回距离当前日期的1000 根 K 线； 2、 仅填 start_date， 当 start_date和最新日期之间的数据不足1000 根，返回 start_date 和最新日期之间的数据；如果数据超过 1000 根 K 线， 则返回距离当前日期的 1000 根 K线； 3、 仅填 end_date ， 返 回end_date 之前存在的的最多1000 根 K 线； 4、 start_date 和 end_date 均填充，返回该日期区间（闭区间）的数据，最多 1000 根。 仅在 get_type=range 时有效。

            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function fundflow_trademin(){
        // +----------查询个股分时资金流------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/fundflow_trademin";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//产品代码
                'date'=>$_GET['date'],//日期

            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//产品代码
                'date'=>$_POST['date'],//日期
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function fundflow_order_snapshot(){
        // +----------查询个股分时资金流------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/fundflow_order_snapshot";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        $url = $host . $path;
        if($_GET){
            $data = array(
                'en_prod_code'=>$_GET['en_prod_code'],//产品代码


            );
        }
        if($_POST){
            $data = array(
                'en_prod_code'=>$_POST['en_prod_code'],//产品代码

            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function fundflow_day(){
        // +----------查询个股分时资金流------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/fundflow_day";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//产品代码
                'get_type'=>$_GET['get_type'],//产品代码
                'data_count'=>$_GET['data_count'],//产品代码



            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//产品代码
                'get_type'=>$_POST['get_type'],//产品代码
                'data_count'=>$_POST['data_count'],//产品代码
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function markdetail() {
         // +----------获取市场详细信息------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/market/detail";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'finance_mic'=>$_GET['finance_mic'],//交易所识别码	一次只能请求一个市场

            );
        }
        if($_POST){
            $data = array(
                'finance_mic'=>$_POST['finance_mic'],//产品代码

            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function ma10_inflexion(){
        // +----------查询个股分时资金流------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/ma10_inflexion";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'en_prod_code'=>$_GET['en_prod_code'],//产品代码




            );
        }
        if($_POST){
            $data = array(
                'en_prod_code'=>$_POST['en_prod_code'],//产品代码

            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function wizard(){
        // +----------查询个股分时资金流------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/wizard";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0
        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'prod_code'=>$_GET['prod_code'],//产品代码
                'en_finance_mic'=>$_GET['en_finance_mic'],//交易所识别码集合	多个交易所识别码,逗号(,)分割。 如： finance_mic=SS,SZ表示优先查询上交所和深交所的代码，且按照参数的先后顺序优先查找 注：返回结果不按查找的市场顺序排序
                'data_count'=>$_GET['data_count'],//产品代码



            );
        }
        if($_POST){
            $data = array(
                'prod_code'=>$_POST['prod_code'],//产品代码
                'en_finance_mic'=>$_POST['en_finance_mic'],//产品代码
                'data_count'=>$_POST['data_count'],//产品代码
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function news(){
        // +----------查询个股分时资金流------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/news_list";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0
        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'symbols'=>$_GET['symbols'],//产品代码
                'page_no'=>$_GET['page_no'],//产品代码
                'page_count'=>$_GET['page_count'],//产品代码
                'type'=>'news',

            );
        }
        if($_POST){
            $data = array(
                'symbols'=>$_POST['symbols'],//产品代码
                'page_no'=>$_POST['page_no'],//产品代码
                'page_count'=>$_POST['page_count'],//产品代码
            );
        }

        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function notices(){
        // +----------获取A股公司公告列表（包括临时公告和定期公告），默认发布时间倒序排序，如果公告内容超过3000个字，我们会截取操作，建议客户端pdf下载------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/news_list";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0
        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'symbols'=>$_GET['symbols'],//产品代码
                'page_no'=>$_GET['page_no'],//产品代码
                'page_count'=>$_GET['page_count'],//产品代码
                'type'=>'notices',

            );
        }
        if($_POST){
            $data = array(
                'symbols'=>$_POST['symbols'],//产品代码
                'page_no'=>$_POST['page_no'],//产品代码
                'page_count'=>$_POST['page_count'],//产品代码
                'start_id'=>$_POST['start_id'],
                'start_date'=>$_POST['start_date'],
                'end_date'=>$_POST['end_date'],
                'fields'=>$_POST['fields'],
            );
        }
        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function reports(){
        // +----------获取A股公司公告列表（包括临时公告和定期公告），默认发布时间倒序排序，如果公告内容超过3000个字，我们会截取操作，建议客户端pdf下载------------------------------------------------------------
        //wangjikeji.com
        // 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/news_list";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0

        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'symbols'=>$_GET['symbols'],//产品代码
                'page_no'=>$_GET['page_no'],//产品代码
                'page_count'=>$_GET['page_count'],//产品代码
                'type'=>'reports',

            );
        }
        if($_POST){
            $data = array(
                'symbols'=>$_POST['symbols'],//产品代码
                'page_no'=>$_POST['page_no'],//产品代码
                'page_count'=>$_POST['page_count'],//产品代码
                'start_id'=>$_POST['start_id'],
                'start_date'=>$_POST['start_date'],
                'end_date'=>$_POST['end_date'],
                'fields'=>$_POST['fields'],
            );
        }
        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }

    public function newsinfo(){
        // +----------获取A股公司公告列表（包括临时公告和定期公告），默认发布时间倒序排序，如果公告内容超过3000个字，我们会截取操作，建议客户端pdf下载------------------------------------------------------------
//wangjikeji.com
// 接口调用示例代码 － 网极科技
        error_reporting(0);
        $host = "http://stock.api51.cn/news_info";//如需https请修改为 https://smsapi51.cn
        $path = "";//path为 single_sms_get 时为GET请求
        $path = "";//path为 single_sms_get 时为GET请求
        $method = "0";//post=1 get=0
        include '../appcode.php';
        //get_type=offset&prod_code=600570.SS&data_count=5
        $url = $host . $path;
        if($_GET){
            $data = array(
                'symbols'=>$_GET['symbols'],//产品代码
                'id'=>$_GET['id'],//产品代码

                'type'=>$_GET['type'],

            );
        }


        $data = http_build_query($data);
        $timeOut=$this->getCacheTime();
        $result = $this->api51_curl($url,$data,$method,$this->appcode,$timeOut,md5($host.$data));
        echo $result;
    }


    public function getCacheTime(){
        //如果当前时间是在9-12 13-15交易时间则实时发送，否则缓存5个小时
        $checkDayStr = date('Y-m-d ',time());
        $timeBegin1 = strtotime($checkDayStr."09:00".":00");
        $timeEnd1 = strtotime($checkDayStr."15:00".":00");
        $curr_time = time();
        if($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1)
        {
            $timeOut=2;
        }else{
            $timeOut=7200;
        }
        return $timeOut;
    }
    function  api51_curl($url,$data=false,$ispost=0,$appcode,$cahcetime=1,$Cachekey=''){
        if(empty($Cachekey)){
            $Cachekey=md5($url).time();
        }
        $response=\think\Cache::get($Cachekey);
        if(empty($cacheShowJson)){
            $response= $this->api51_curl_do($url,$data,$ispost,$appcode);
            \think\Cache::set($Cachekey,$response,$cahcetime);
        }
        return $response;
    }

    function api51_curl_do($url,$data=false,$ispost=0,$appcode){
        $headers = array();
        //根据阿里云要求，定义Appcode
        array_push($headers, "Authorization:APPCODE " . $appcode);
        array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");

        $httpInfo = array();

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'api51.cn' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 300 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 300);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        if (1 == strpos("$".$url, "https://"))
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if($ispost)
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $data );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            if($data){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$data );

            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }

        }
        $response = curl_exec( $ch );

        if ($response === FALSE) {
            // echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;

    }
}
