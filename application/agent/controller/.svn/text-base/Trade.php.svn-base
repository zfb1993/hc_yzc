<?php
namespace app\agent\controller;
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
    public function getMotherAccount(){
        //http://47.104.173.116:8888/?action=QueryMotherAccount
        $data['action']='QueryMotherAccount';
        $apiurl = getcofig('WINDOWS_URL');
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
        $m=input('motherid');
        $page = 0;
        $arr = [];
        do{
            $page++;
            $resArr = $this->getchild($m,$page);
            array_push($arr,$resArr['TradingAccount']);
        }while(count($resArr['TradingAccount'])>60);

        $cus = new Customer();
        $user=$cus->getAllCustomer();

        if(!empty($user)){
            foreach($user as $v){
                $agent[] = $v['user_name'];
            }
            $childrArr=array();

            foreach($arr as $vv){
                foreach($vv as $v){
                    if(in_array($v['account'],$agent)) {
                        $childrArrTmp['id'] = $v['id'];
                        $childrArrTmp['account'] = $v['account'];
                        $childrArrTmp['name'] = Db('customer')->where('user_name', $v['account'])->value('true_name');
                        $childrArr[] = $childrArrTmp;
                    }
                }
            }

        }else{
            $childrArr = [];
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
        $data['type']=input('type',1);
        $apiurl = getcofig('WINDOWS_URL');
        if($data['type']==4){
            $data['action']='QueryAccountInfo';
            $res=http($apiurl,$data,'GET');
          /*  $res=gbkToUtf8($res);
            $resArrTmp=json_decode($res,true);*/

            $res=gbkToUtf8($res);
            $res= substr($res,1);
            $resArrTmp=explode(',[',$res);
            if(isset($resArrTmp[1])){
                $res ='['.$resArrTmp[1];
                $res = substr($res,0,strlen($res)-1);
            }
            $resArrTmp=json_decode($res,true);
            if(!empty($resArrTmp['TradingAccount'])) {
                $resArr= $resArrTmp['TradingAccount'];
            }else{
                $resArr=array('msg'=>json_encode($resArrTmp));
            }
        }else{
            $res=http($apiurl,$data,'GET');
            $res=gbkToUtf8($res);
            $res= substr($res,1);
            $resArrTmp=explode(',[',$res);
            if(isset($resArrTmp[1])){
                $res ='['.$resArrTmp[1];
                $res = substr($res,0,strlen($res)-1);
            }
            $resArr=json_decode($res,true);
        }

        return json(array('code'=>0,'msg'=>'成功返回','count'=>count($resArr),'data'=>$resArr,'org'=>$res));
    }

    public function getPosition(){
        //http://47.104.173.116:8888/?action=QueryTrader&motherid=100&type=1
        $data['action']='QueryTrader';
        if(!empty(input('mother_acc'))) $data['motherid']=input('mother_acc');
        if(!empty(input('childid')))  $data['childid']=input('childid');
        $data['type']=input('type',1);
        $data['page']=input('page',1);
        $apiurl = getcofig('WINDOWS_URL');
		$cus = new Customer();
		$user=$cus->getAllCustomer();
		if(!empty($user)){
			foreach($user as $v){
				$agent[] = $v['user_name'];
			}
		}else{
			$agent = [];
		}
        if($data['type']==4){
            $data['action']='QueryAccountInfo';
            $res=http($apiurl,$data,'GET');
            $res=gbkToUtf8($res);
            $resArrTmp=json_decode($res,true);
			$data_model=Db::name('trade_accountinfo');
			$data_model->where(array('id'=>array('gt','0')))->delete();
			$local_data_count=0;
			$total_page=ceil($resArrTmp['Count']/64);
			oplog('total_page---'.$total_page);
			oplog('getPosition--->1');
			oplog('总数据量--->'.$resArrTmp['Count']);
			oplog('已有数据量--->'.$local_data_count);
			if($local_data_count<$resArrTmp['Count']){
				if(empty($local_data_count)){
					$i=1;
				}else{
					$i=ceil($local_data_count/64);
				}
				for($i;$i<=$total_page ;$i++ ){
					$data['page']=$i;
					$res_temp=http($apiurl,$data,'GET');
					$res_temp_arr=json_decode($res_temp,true);
					if(!empty($res_temp_arr['TradingAccount'])){
						foreach($res_temp_arr['TradingAccount'] as $key=>$val) {
							$temp_re='';
							$res_temp_arr['TradingAccount'][$key]['id']=intval($res_temp_arr['TradingAccount'][$key]['id']);
							$res_temp_arr['TradingAccount'][$key]['account']=$res_temp_arr['TradingAccount'][$key]['account'];
							$res_temp_arr['TradingAccount'][$key]['enablefollow']=intval($res_temp_arr['TradingAccount'][$key]['enablefollow']);
							$res_temp_arr['TradingAccount'][$key]['motherid']=intval($res_temp_arr['TradingAccount'][$key]['motherid']);
							$res_temp_arr['TradingAccount'][$key]['cash']=floatval($res_temp_arr['TradingAccount'][$key]['cash']);
							$res_temp_arr['TradingAccount'][$key]['control']=floatval($res_temp_arr['TradingAccount'][$key]['control']);
							$res_temp_arr['TradingAccount'][$key]['FrozenMargin']=floatval($res_temp_arr['TradingAccount'][$key]['FrozenMargin']);
							$res_temp_arr['TradingAccount'][$key]['FrozenCommission']=floatval($res_temp_arr['TradingAccount'][$key]['FrozenCommission']);
							$res_temp_arr['TradingAccount'][$key]['CurrMargin']=floatval($res_temp_arr['TradingAccount'][$key]['CurrMargin']);
							$res_temp_arr['TradingAccount'][$key]['Commission']=floatval($res_temp_arr['TradingAccount'][$key]['Commission']);
							$res_temp_arr['TradingAccount'][$key]['CloseProfit']=floatval($res_temp_arr['TradingAccount'][$key]['CloseProfit']);
							$res_temp_arr['TradingAccount'][$key]['Available']=floatval($res_temp_arr['TradingAccount'][$key]['Available']);
							$res_temp_arr['TradingAccount'][$key]['DynamicCash']=floatval($res_temp_arr['TradingAccount'][$key]['DynamicCash']);
							$res_temp_arr['TradingAccount'][$key]['InCash']=floatval($res_temp_arr['TradingAccount'][$key]['InCash']);
							$res_temp_arr['TradingAccount'][$key]['OutCash']=floatval($res_temp_arr['TradingAccount'][$key]['OutCash']);
							$res_temp_arr['TradingAccount'][$key]['InitCash']=floatval($res_temp_arr['TradingAccount'][$key]['InitCash']);
							$res_temp_arr['TradingAccount'][$key]['PositionMarket']=floatval($res_temp_arr['TradingAccount'][$key]['PositionMarket']);
							$temp_re=$data_model->where(array('id'=>$val['id']))->find();
							if(empty($temp_re)){
								oplog('账号信息记录插入数据----'.json_encode($res_temp_arr['TradingAccount'][$key]));
								$re=$data_model->insert( $res_temp_arr['TradingAccount'][$key]);
								if(!$re){
									oplog('记录插入数据错误----'.Db::name('trade_accountinfo')->getlastsql());
								}
							}
						}
					}
				}
			}

			$page=input('page',1);
			$agent_str=join($agent,',');
			if(!empty(input('investid'))){
				$where['InvestorID']=input('investid');
			}
			if(!empty(input('keyword'))){
				$where['Account']=array('like','%'.input('keyword').'%');
				if(!empty(input('mother_acc'))){
					$where['motherid']=input('mother_acc');
				}
			}else{
				if(!empty(input('childid'))){
					$data['childid']=Db::name('customer')->where(array('zid'=>$data['childid']))->value('user_name');;
					$where['Account']=array(array('eq',$data['childid']),array('in',$agent_str));
				}else{
					$where['Account']=array('in',$agent_str);
					if(!empty(input('mother_acc'))){
						$where['motherid']=input('mother_acc');
					}
				}
			}
			
			$count=$data_model->where($where)->count();
			$res=$data_model->alias('a')->join('yp_customer c','a.Account = c.user_name','INNER')->where($where)->field('a.*,c.true_name')->page($page, 10)->select();
        }else{
            $res=http($apiurl,$data,'GET');
			$encode = mb_detect_encoding($res, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5')); 
            $res=str_replace(',[',',"data":[',$res);
            $resArr=json_decode($res,true);
            $res=$resArr['TraderList'];
			if($data['type']==2){
				//成交记录
				$data_model=Db::name('trade_chengjiao');
			}elseif($data['type']==3){
				//委托记录
				$data_model=Db::name('trade_weituo');
			}elseif($data['type']==1){
				//持仓信息
				$data_model=Db::name('trade_chicang');
				$data_model->where(array('id'=>array('gt',0)))->delete();
			}
			$local_data_count=$data_model->count();
			$total_page=ceil($resArr['Count']/40);
			oplog('total_page---'.$total_page);
			oplog('getPosition--->1');
			oplog('总数据量--->'.$resArr['Count']);
			oplog('已有数据量--->'.$local_data_count);
			if($local_data_count<$resArr['Count']){
				if(empty($local_data_count)){
					$i=1;
				}else{
					$i=ceil($local_data_count/40);
				}
				
				for($i;$i<=$total_page ;$i++ ){
					$data['page']=$i;
					$res_temp=http($apiurl,$data,'GET');
					$res_temp_arr=json_decode($res_temp,true);
					if(!empty($res_temp_arr['TraderList'])){
						foreach($res_temp_arr['TraderList'] as $key=>$val) {
							$temp_re='';
							$res_temp_arr['TraderList'][$key]['Direction']=intval($res_temp_arr['TraderList'][$key]['Direction']);
							$res_temp_arr['TraderList'][$key]['InsertDate']=intval($res_temp_arr['TraderList'][$key]['InsertDate']);
							$res_temp_arr['TraderList'][$key]['LimitPrice']=floatval($res_temp_arr['TraderList'][$key]['LimitPrice']);
							$res_temp_arr['TraderList'][$key]['VolumeTotalOriginal']=intval($res_temp_arr['TraderList'][$key]['VolumeTotalOriginal']);
							$res_temp_arr['TraderList'][$key]['OrderStatus']=intval($res_temp_arr['TraderList'][$key]['OrderStatus']);
							$res_temp_arr['TraderList'][$key]['CombOffsetFlag']=intval($res_temp_arr['TraderList'][$key]['CombOffsetFlag']);
							$res_temp_arr['TraderList'][$key]['Status']=intval($res_temp_arr['TraderList'][$key]['Status']);
							$res_temp_arr['TraderList'][$key]['OpenPrice']=floatval($res_temp_arr['TraderList'][$key]['OpenPrice']);
							$res_temp_arr['TraderList'][$key]['ClosePrice']=floatval($res_temp_arr['TraderList'][$key]['ClosePrice']);
							$res_temp_arr['TraderList'][$key]['Volume']=intval($res_temp_arr['TraderList'][$key]['Volume']);
							$res_temp_arr['TraderList'][$key]['Profit']=floatval($res_temp_arr['TraderList'][$key]['Profit']);
							$temp_re=$data_model->where(array('OrderRef'=>$val['OrderRef']))->find();
							if(empty($temp_re)){
								oplog('记录插入数据----'.json_encode($res_temp_arr['TraderList'][$key]));
								$re=$data_model->insert( $res_temp_arr['TraderList'][$key]);
								if(!$re){
									oplog('记录插入数据错误----'.Db::name('trade_chengjiao')->getlastsql());
								}
							}
						}
					}
				}
			}
			oplog('getPosition--->2');
			$page=input('page',1);
			$agent_str=join($agent,',');
			if(!empty(input('keyword'))){
				$where['Account']=array('like','%'.input('keyword').'%');
				if(!empty(input('investid'))){
						$where['InvestorID']=input('investid');
					}
			}else{
				if(!empty(input('childid'))){
					$data['childid']=Db::name('customer')->where(array('zid'=>$data['childid']))->value('user_name');;
					$where['Account']=array(array('eq',$data['childid']),array('in',$agent_str));
				}else{
					$where['Account']=array('in',$agent_str);
					if(!empty(input('investid'))){
						$where['InvestorID']=input('investid');
					}
				}
			}
			$count=$data_model->where($where)->count();
			oplog('getPosition--->3');
			$res=$data_model->where($where)->page($page, 10)->select();
        }
		oplog('getPosition--->4');
        return json(array('code'=>0,'msg'=>'成功返回','count'=>$count,'data'=>$res,'org'=>$res));
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
    
}
