<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;
use think\Loader;

class Customer extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    
    return $this->fetch();
  }
  //客户注册
  public function register()
  {
    if(Request()->isPost()){
      $id=input('id');
      $agentor=Db('agentor')->where('id',$id)->find();
      if($agentor){
        $data=[
          'aid'=>$agentor['id'],
          'tid'=>$agentor['tid'],
          'pid'=>$agentor['pid'],
          'user_name'=>trim(input('mobile')),
          'user_pwd'=>md5(trim(input('user_pwd'))),
          'true_name'=>trim(input('true_name')),
          'p_name'=>$agentor['true_name'],
          'ins_name'=>$agentor['ins_name'],
          'mobile'=>trim(input('mobile')),
          'code'=>mt_rand(1000,9999),
          'add_time'=>time()
        ];
        $res=Db('customer')->insert($data);
        if($res){
          return json(['code'=>1,'msg'=>'用户注册成功！']);
        }else{
          return json(['code'=>0,'msg'=>'用户注册失败！']);
        }
      }
    }
  }
  //搜索
  public function user_search(){
  if(Request()->isPost()){
    $keywords=input('keywords');
    $start_time=input('start_time');
    $e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
    $end_time=input('end_time');
    if($end_time!=''){
      $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
    }
    $ins_name=input('ins_name');
	if($ins_name!=''&&$start_time!=''&&$end_time!=''&&$keywords!=''){
	  $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
      $aid=[];
      foreach ($agent as $key => $value) {
        array_push($aid, $agent[$key]['id']);
      }
      $list=Db('customer')->where('aid','IN',$aid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->select();
	}else if($ins_name!=''&&$start_time!=''&&$end_time!=''){
	  $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
      $aid=[];
      foreach ($agent as $key => $value) {
        array_push($aid, $agent[$key]['id']);
      }
      $list=Db('customer')->where('aid','IN',$aid)->where('add_time','between time',[$start_time,$end_time])->select();
	}else if($ins_name!=''&&$start_time!=''){
	  $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
      $aid=[];
      foreach ($agent as $key => $value) {
        array_push($aid, $agent[$key]['id']);
      }
      $list=Db('customer')->where('aid','IN',$aid)->where('add_time','between time',[$start_time,$e_time])->select();
	}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
      $list=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->select();
    }else if($start_time!=''&&$keywords!=''){
      $list=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$e_time])->select();
    }else if($start_time!=''&&$end_time!=''){
      $list=Db('customer')->where('add_time','between time',[$start_time,$end_time])->select();
    }else if($start_time!=''){
      $list=Db('customer')->where('add_time','between time',[$start_time,$e_time])->select();
    }else if($ins_name!=''){
      $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
      $aid=[];
      foreach ($agent as $key => $value) {
        array_push($aid, $agent[$key]['id']);
      }
      $list=Db('customer')->where('aid','IN',$aid)->select();
    }else if($keywords!=''){
      $list=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
    }else{
		$list=false;
	}
    
    if($list){
		  foreach($list as $key=>$value){
			$zg=Db('zg_sys')->where('id',$list[$key]['zg_id'])->find();
			if($zg){
			  $list[$key]['zname']=$zg['name'];
			}else{
			  $list[$key]['zname']='';
			}
			$mzh=Db('mzh_config')->where('id',$list[$key]['mzh_id'])->find();
			if($mzh){
			  $list[$key]['mzh']=$mzh['account'];
			}else{
			  $list[$key]['mzh']='';
			}
			$fk=Db('fk_config')->where('id',$list[$key]['fk_id'])->find();
			if($fk){
			  $list[$key]['bh']=$fk['account'];
			}else{
			  $list[$key]['bh']='';
			}
			$sxf_mb=Db('sxf_mb')->where('id',$list[$key]['sxf_id'])->find();
			if($sxf_mb){
			  $list[$key]['zsxf']=$sxf_mb['bh'];
			}else{
			  $list[$key]['zsxf']='';
			}
			switch ($list[$key]['status']) {
			  case 1:
			  $list[$key]['status']='锁定';
			  break;
			  case -1:
			  $list[$key]['status']='黑名单';
			  break;
			  default:
			  $list[$key]['status']='正常';
			  break;
			}
			if($list[$key]['add_time']!=NULL){
			  $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
			}else{
			  $list[$key]['add_time']='';
			}
		  }
		$export_data=Db('export_data')->count();
		if($export_data>0){
			Db('export_data')->delete(true);
		}
		foreach($list as $i=>$v){
			Db('export_data')->insert([
				'id'=>$i+1,
				'a1'=>$v['true_name'],
				'a2'=>$v['zid'],
				'a3'=>$v['mobile'],
				'a4'=>$v['ins_name'],
				'a5'=>$v['total_money'],
				'a6'=>$v['add_time']
			]);
		}
		return $result = ['code'=>0,'msg'=>'','count'=>count($list),'data'=>$list];
      }else{
		return $result = ['code'=>-1,'msg'=>'没有搜索到相关数据'];
	  }
    }
  }
  //客户列表
  public function userList()
  {
    if(Request()->isPost()|| !empty(input('export'))){
		$page=input('page');
		$limit=input('limit');
		$pre=($page-1)*$limit;
	  $count=Db('customer')->where('status','IN',[0,1])->count();
	  if($count>$limit){
		  $list=Db('customer')->where('status','IN',[0,1])->order('add_time desc')->limit($pre,$limit)->select();
	  }else{
		  $list=Db('customer')->where('status','IN',[0,1])->order('add_time desc')->select();
	  }
      if($list){
		foreach($list as $key=>$value){
			$zg=Db('zg_sys')->where('id',$list[$key]['zg_id'])->find();
			if($zg){
				$list[$key]['zname']=$zg['name'];
			}else{
				$list[$key]['zname']='';
			}
			$list[$key]['mobile']=str_hide(array('str'=>$list[$key]['mobile']));
			$mzh=Db('mzh_config')->where('id',$list[$key]['mzh_id'])->find();
			if($mzh){
				$list[$key]['mzh']=$mzh['account'];
			}else{
				$list[$key]['mzh']='';
			}
			$fk=Db('fk_config')->where('id',$list[$key]['fk_id'])->find();
			if($fk){
				$list[$key]['bh']=$fk['account'];
			}else{
				$list[$key]['bh']='';
			}
			$sxf_mb=Db('sxf_mb')->where('id',$list[$key]['sxf_id'])->find();
			if($sxf_mb){
				$list[$key]['zsxf']=$sxf_mb['bh'];
			}else{
				$list[$key]['zsxf']='';
			}
			switch ($list[$key]['status']) {
			  case 1:
				$list[$key]['status']='锁定';
				break;
			  case -1:
				$list[$key]['status']='黑名单';
				break;
			  default:
				$list[$key]['status']='正常';
				break;
			}
			if($list[$key]['add_time']!=NULL){
			  $list[$key]['add_time']=date('Y-m-d H:i:s',$list[$key]['add_time']);
			}else{
			  $list[$key]['add_time']='';
			}
		}

          if(!empty(input('export'))){
//              {field:'true_name',align:'center',title:'姓名', width:100},
//              {field:'zid',align:'center',title:'账号', width:100},
//              {field:'mobile',align:'center',title:'手机号',width:120},
//              {field:'ins_name',align:'center',title:'所属机构', width:140},
//              {field:'p_name',align:'center', title:'上级代理',width:140},
//              {field:'total_money',align:'center', title:'账户余额',width:140},
//              {field:'id_card', align:'center',title:'身份证号',width:150},
//              {field:'bank_name', align:'center',title:'开户银行',width:150},
//              {field:'bank_addr', align:'center',title:'开户支行',width:150},
//              {field:'bank_card', align:'center',title:'银行卡号',width:150},
//              {field:'mzh', align:'center',title:'母账号',width:100},
//              {field:'add_time',align:'center',title:'注册时间', width:170, sort: true},
//              {field:'status', align:'center', title:'状态',width:120},
              $xlsName  = "客户列表";
              $xlsCell  = array(
                  array('true_name','姓名'),
                  array('zid','账号'),
                  array('mobile','手机号'),
                  array('p_name','上级代理'),
                  array('ins_name','所属机构'),
                  array('total_money','账户余额'),
                  array('id_card','身份证号'),
                  array('bank_name','开户银行'),
                  array('bank_addr','开户支行'),
                  array('bank_card','银行卡号'),
                  array('mzh','母账号'),
                  array('add_time','注册时间'),
                  array('status','状态')
              );
              $xlsData  = $list;
              $this->exportExcel($xlsName,$xlsCell,$xlsData);
          }
        return $result = ['code'=>0,'msg'=>'','count'=>$count,'data'=>$list];
      }else{
		return $result = ['code'=>-1,'msg'=>'暂无客户列表数据...'];
	  }
    }
    return $this->fetch();
  }
  //导出Excel
    public function export(){
		$num=input('num');
		switch($num){
			case 0:
				//姓名  账号   手机号    所属机构   账户余额  注册时间
				$xlsName  = "客户列表查询";
				$xlsCell  = array(
					array('id','序号'),
					array('a1','姓名'),
					array('a2','账号'),
					array('a3','手机'),
					array('a4','所属机构'),
					array('a5','账户余额'),
					array('a6','注册时间')
				);
				$xlsData  = Db::name('export_data')->Field('id,a1,a2,a3,a4,a5,a6')->select();
				break;
			case 1:
				//时间   账号   姓名  手机号    可用资金   出入金   客户权益   手续费   保证金   平仓盈亏  持仓盈亏  总盈亏
				$xlsName  = "客户资金查询";
				$xlsCell  = array(
					array('id','序号'),
					array('a1','时间'),
					array('a2','账号'),
					array('a3','姓名'),
					array('a4','手机号'),
					array('a5','可用资金'),
					array('a6','出入金'),
					array('a7','客户权益'),
					array('a8','手续费'),
					array('a9','保证金'),
					array('a10','平仓盈亏'),
					array('a11','持仓盈亏'),
					array('a12','总盈亏')
				);
				$xlsData  = Db::name('export_data')->Field('id,a1,a2,a3,a4,a5,a6,a7,a8,a9,a10,a11,a12')->select();
				break;
		}
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
        //dump($file);die;
    }
    public function exportExcel($expTitle,$expCellName,$expTableData){
        //Loader::import("PHPExcel\PHPExcel",EXTEND_PATH);
        include_once EXTEND_PATH.'PHPExcel/PHPExcel.php';//方法二
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        //$objPHPExcel = new PHPExcel();//方法一
        $objPHPExcel = new \PHPExcel();//方法二
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.' '.date('Y-m-d H:i:s'));
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        ob_end_clean();//这一步非常关键，用来清除缓冲区防止导出的excel乱码
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//"xls"参考下一条备注
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//"Excel2007"生成2007版本的xlsx，"Excel5"生成2003版本的xls
        $objWriter->save('php://output');
        exit;
    }
  //开户审核
  public function checkOpenUser()
  {
    $where=array();
    if(!empty(input('update_time_start'))) $where['w.update_time']=array('gt',input('update_time_start').' 00:00:00');
    if(!empty(input('update_time_end')))  $where['w.update_time']=array('lt',input('update_time_end').' 23:59:59');

    if(!empty(input('update_time_end'))&&!empty(input('update_time_start'))){
      $where['w.update_time']=array('between',array(input('update_time_start').' 00:00:00',input('update_time_end').' 23:59:59'));
    }
    if(!empty(input('phone')))  $where['a.user_name']=input('phone');
    $status=input('status',0);
    if($status !=3){
      $where['w.status']=$status;
    }

    if(Request()->isPost()){
      $list=Db('customer')->alias('a')
          ->join('openaccount_apply w','a.id = w.userid','INNER')
          ->join('agentor z','a.pid = z.id','LEFT')
          ->join('fk_config f','a.fk_id = f.id','LEFT')
          ->join('sxf_mb s','a.sxf_id = s.id','LEFT')
          ->join('mzh_config m','a.mzh_id = m.id','LEFT')
          ->where('a.status','IN',[0,1])
          ->where($where)
          ->field(['a.*','w.userid','w.remark','w.update_time','w.status','w.status','f.name as fk_acc','m.account as mzh_id','s.memo as sxf_id'])
          ->select();

      $count=Db('customer')->alias('a')
          ->join('openaccount_apply w','a.id = w.userid','INNER')
          ->join('agentor z','a.pid = z.id','LEFT')
          ->where('a.status','IN',[0,1])
          ->where($where)
          ->count();
        return $result = ['code'=>0,'msg'=>'','count'=>$count,'data'=>$list];

    }else{
      if(!empty(input('export'))){
        //姓名  账号   手机号    所属机构   账户余额  注册时间
        $xlsName  = "客户列表查询";
        $xlsCell  = array(
            array('id','序号'),
            array('userid','用户id'),
            array('true_name','姓名'),
            array('mobile','手机号'),
            array('ins_name','所属机构'),
            array('p_name','上级代理'),
            array('total_money','账户余额'),
            array('sxf_id','手续费模板ID'),
            array('zg_id','代理模板ID'),
            array('mzh_id','主账号ID'),
            array('update_time','开户时间'),
            array('status','状态'),
            array('remark','备注')
        );
        $xlsData  = Db('customer')->alias('a')
            ->join('openaccount_apply w','a.id = w.userid','INNER')
            ->join('agentor z','a.pid = z.id','LEFT')
            ->where('a.status','IN',[0,1])
            ->where($where)
            ->field(['a.mobile','a.true_name','a.ins_name','a.p_name','a.total_money','w.userid','w.remark','w.update_time','w.status','w.status','z.zg_id','z.mzh_id','z.sxf_id','z.fk_id'])
            ->select();
        $i=1;
        foreach($xlsData as $key=>&$val){

          $val['id']=$i;
          if($val['status']==0){
            $val['status']= '待审核';
          }else if($val['status']==1){
            $val['status']='审核通过';
          }else if($val['status']==2){
            $val['status']= '审核拒绝';
          }else{
            $val['status']= '状态异常';
          }

          $i++;
        }
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
      }else{
        return $this->fetch();
      }
    }
  }


  //拒绝开户
  public function openUserDel(){
    $data['userid']=input('id');
    $remark=input('remark');
    if(empty($remark)) $remark=':后台拒绝开户申请，暂时未通过审核!';
    //判断是否已经提交申请开户，或者审核已经通过
    $num= Db::name('openaccount_apply')->where('userid',$data['userid'])->where('status','=',0)->count();
    if($num<1){
      return json(array('code'=>-4,'msg'=>'状态错误！'));
    }
    //插入数据库记录
    Db::startTrans();
    try{
      Db::commit();
      Db::name('customer')->where('id',$data['userid'])->update(array('is_open'=>0));
      Db::name('openaccount_apply')->where('userid',$data['userid'])->update(array('status'=>2,'remark'=>$remark));
      $userInfo= Db::name('customer')->where('id',$data['userid'])->find();
      $content=$remark;
      $resSms=aliSmsNotice($userInfo['user_name'],$content,$skin=1);
      Db('sms')->insert(['mobile'=>$userInfo['user_name'],'code'=>$content,'type'=>'开户审核拒绝，'.$content,'add_time'=>time(),'result'=>$resSms['msg']]);
      return json(array('code'=>1,'msg'=>'处理成功！'));
    }catch (\Exception $e){
      Db::rollback();
      return json(array('code'=>-1,'msg'=>'处理失败！'));
    }
  }
  //审核通过开户
  public function openUserPass(){
    $dataInput['userid']=input('id');
    //判断是否已经提交申请开户，或者审核已经通过
    $applyInfo= Db::name('openaccount_apply')->where('userid',$dataInput['userid'])->where('status','=',0)->find();

    if(empty($applyInfo)){
      return json(array('code'=>-4,'msg'=>'状态错误！'));
    }
    //插入数据库记录
    Db::startTrans();
    try{
      //$account=input('account');
      $data['Action']='ReqCreateAccount';
      $data['ChdPassword']=rand(100000,999999);
      if(!empty($applyInfo['nikename'])) $data['ChdName']=$applyInfo['nikename'];
      $uidInfo=Db::name('customer')->where('id',$dataInput['userid'])->find();
      $pidInfo=Db::name('agentor')->where('id',$uidInfo['pid'])->find();
      $mzh=Db::name('mzh_config')->where('id',$pidInfo['mzh_id'])->find();
      $data['AccountID']=$mzh['account'];
      $data['BrokderID']=$mzh['bh'];
      $data['ChdAccountID']=868000+$uidInfo['id'];
      $zgSys=Db::name('zg_sys')->where('id',$pidInfo['zg_id'])->find();
      $data['UserID']=$zgSys['account'];

      //风控账号
      $fkSys=Db::name('fk_config')->where('id',$pidInfo['fk_id'])->find();
      $data['MonitorID']=$fkSys['account'];

      if(empty($data['UserID'])||empty($zgSys['server_ip'])){
        return json(array('code'=>-1,'msg'=>'资管未配置！'));
      }
      $res= ReqCreateAccount($data,$zgSys['server_ip']);
      if($res['code']==1){
        //接口设置手续费
        $sxfSys=Db::name('sxf_mb')->where('id',$pidInfo['sxf_id'])->find();
        $sxfdata['UserID']=$zgSys['account'];
        $sxfdata['Action']='ReqSetMarginCommission';
        $sxfdata['ChdAccountID']=$res['ChdAccountID'];
        $sxfdata['Source']=$sxfSys['bh'];
        $resSxf=ReqSetMarginCommission($sxfdata,$zgSys['server_ip']);
        $msg='';
        if($resSxf['code']!=1){
          $msg=',自动设置手续费失败';
        }else{
          $msg=',自动设置手续费成功';
        }

        //接口设置风控

        $fkdata['UserID']=$zgSys['account'];
        $fkdata['Action']='ReqSetRiskControl';
        $fkdata['ChdAccountID']=$res['ChdAccountID'];
        $fkdata['Source']=$sxfSys['bh'];
        $resfk= ReqSetRiskControl($fkdata,$zgSys['server_ip']);
        if($resfk['code']!=1){
          $msg.=',自动设置风控失败！'.$resfk['msg'];
        }else{
          $msg.=',自动设置风控成功！';
        }

        Db::name('customer')->where('id',$dataInput['userid'])
            ->update(array('is_open'=>1,'zg_id'=>$pidInfo['zg_id'],'mzh_id'=>$pidInfo['mzh_id'],'sxf_id'=>$pidInfo['sxf_id'],'fk_id'=>$pidInfo['fk_id'],
                'zid'=>$res['ChdAccountID'],'bid'=>$mzh['bh'],'zpwd'=>$res['ChdPassword']));
        Db::name('openaccount_apply')->where('userid',$dataInput['userid'])->update(array('status'=>1,'remark'=>'资管账号：'.$res['ChdAccountID'],'memo'=>json_encode($res)));
        Db::commit();

        $content=$res['ChdAccountID']."|".$res['ChdPassword'];
        $resSms=aliSmsNotice($uidInfo['user_name'],$content,$skin=2);//一起赢33702福期33657
        Db('sms')->insert(['mobile'=>$uidInfo['user_name'],'code'=>$res['ChdAccountID'],'type'=>'开户审核通过'.$res['ChdAccountID']."|".$res['ChdPassword'],'add_time'=>time(),'result'=>$resSms['msg']]);
      
        return json(array('code'=>1,'msg'=>'资管开户成功！'.$msg));
      }else{
        Db::rollback();
        return json(array('code'=>-1,'msg'=>'资管开户失败！'.json_encode($res)));
      }

    }catch (\Exception $e){
      Db::rollback();
      return json(array('code'=>-1,'msg'=>'处理失败！'.$e->getMessage()));
    }
  }

  //客户资料
  public function userInfo()
  {
    $id=input('id');
    $list=$this->getCustomerInfo($id);
    if($list){
		$zg=Db('zg_sys')->where('id',$list['zg_id'])->find();
		if($zg){
			$list['zname']=$zg['name'];
		}else{
			$list['zname']='';
		}
		$mzh=Db('mzh_config')->where('id',$list['mzh_id'])->find();
		if($mzh){
			$list['mzh']=$mzh['account'];
		}else{
			$list['mzh']='';
		}
		$fk=Db('fk_config')->where('id',$list['fk_id'])->find();
		if($fk){
			$list['fkbh']=$fk['account'];
		}else{
			$list['fkbh']='';
		}
		$sxf_mb=Db('sxf_mb')->where('id',$list['sxf_id'])->find();
		if($sxf_mb){
			$list['sxfbh']=$sxf_mb['bh'];
		}else{
			$list['sxfbh']='';
		}
      
      $this->assign('list',$list);
    }
    return $this->fetch();
  }

  //客户资料
  public function ajaxuserInfo()
  {
    $id=input('id');
    $list=$this->getCustomerInfo($id);
    if($list){
		$zg=Db('zg_sys')->where('id',$list['zg_id'])->find();
		if($zg){
			$list['zname']=$zg['name'];
		}else{
			$list['zname']='';
		}
		$mzh=Db('mzh_config')->where('id',$list['mzh_id'])->find();
		if($mzh){
			$list['mzh']=$mzh['account'];
		}else{
			$list['mzh']='';
		}
		$fk=Db('fk_config')->where('id',$list['fk_id'])->find();
		if($fk){
			$list['fkbh']=$fk['account'];
		}else{
			$list['fkbh']='';
		}
		$sxf_mb=Db('sxf_mb')->where('id',$list['sxf_id'])->find();
		if($sxf_mb){
			$list['sxfbh']=$sxf_mb['bh'];
		}else{
			$list['sxfbh']='';
		}
      if($list){
        return $result = ['code'=>0,'msg'=>'','data'=>$list];
      }
    }
  }
  //获取客户交易所账号和密码
  public function customerData()
  {
    if(Request()->isPost()){
      $id=input('id');
      $list=$this->getCustomerInfo($id);
      if($list){
        return $result = ['code'=>0,'msg'=>'','data'=>$list];
      }
    }
  }
  //获取期货公司数据
  public function getCompany()
  {
    if(Request()->isPost()){
      $list=Db('company')->where('status',0)->select();
      if($list){
        return json($list);
      }
    }
  }
  //修改用户资料
   public function alterInfo()
  {
    if(Request()->isPost()){
      $id=input('id');
      $password=trim(input('password'));
      $zid=trim(input('zid'));
      /*$zpwd=trim(input('zpwd'));*/
     // $zg_id=input('zg_id');
	  $mzh_id=input('mzh_id');
	  //$sxf_id=input('sxf_id');
	  //$fk_id=input('fk_id');
	  $status=input('status');
      $true_name=input('true_name');
      $id_card=input('id_card');
      $bank_name=input('bank_name');
      $bank_addr=input('bank_addr');
      $bank_card=input('bank_card');

      $res=Db('customer')->where('id',$id)->find();
      if(!empty($res)){
        if($password!=''){
            $dataInfo['childid']= $res['zid'];
            $dataInfo['password']= $password;
            $nbeApi=new \app\admin\model\NbeApi();
            $res= $nbeApi->UpdateAccount($dataInfo);
            if(empty($res)||$res['code']!=1){
                return json(['code'=>0,'msg'=>'用户修改密码失败,资管系统同步失败！'.$res['msg']]);
            }
          $result=Db('customer')->where('id',$id)->update(['user_pwd'=>md5($password),
              'zid'=>$zid, 'mzh_id'=>$mzh_id,
              'status'=>$status,'true_name'=>$true_name,'id_card'=>$id_card,'bank_name'=>$bank_name,'bank_addr'=>$bank_addr,'bank_card'=>$bank_card]);
          if($result){
            return json(['code'=>1,'msg'=>'修改成功']);
          }else{
            return json(['code'=>0,'msg'=>'修改失败']);
          }
        }else{
          $result=Db('customer')->where('id',$id)->update(['zid'=>$zid,
              'mzh_id'=>$mzh_id,
              'status'=>$status,'true_name'=>$true_name,'id_card'=>$id_card,'bank_name'=>$bank_name,'bank_addr'=>$bank_addr,'bank_card'=>$bank_card]);
          if($result){
            return json(['code'=>1,'msg'=>'修改成功']);
          }else{
            return json(['code'=>0,'msg'=>'修改失败']);
          }
        }
        
      }else{
        return json(['code'=>-1,'msg'=>'数据异常，刷新重试']);
      }
    }
  }
  //删除客户,加入黑名单管理
  public function userDel()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=$this->setCustomer($id,-1);//加入黑名单
      if($res){
        return json(['code'=>1,'msg'=>'黑名单添加成功！']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败！']);
      }
    }
  }

  //客户黑名单
  public function userBlack()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=$this->setCustomer($id,2);//彻底删除
      if($res){
        return json(['code'=>1,'msg'=>'删除成功！']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败！']);
      }
    }
    return $this->fetch();
  }
  //恢复删除的黑名单
  public function replyUserBlack()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('customer')->where('id',$id)->update(['status'=>0]);
      if($res){
        return json(['code'=>1,'msg'=>'恢复成功！']);
      }else{
        return json(['code'=>0,'msg'=>'恢复失败！']);
      }
    }
  }
  //获取所有黑名单用户
  public function getUserBlack()
  {
    $list=Db('customer')->where('status',-1)->select();
    if($list){
      foreach ($list as $k => $v) {
        switch ($list[$k]['status']) {
          case 1:
            $list[$k]['status']='锁定';
            break;
          case -1:
            $list[$k]['status']='黑名单';
            break;
          default:
            $list[$k]['status']='正常';
            break;
        }
        if($list[$k]['add_time']!=NULL){
          $list[$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
        }else{
          $list[$k]['add_time']='';
        }
      }
      return $result=['code'=>0,'msg'=>'','data'=>$list];
    }else{
		return $result = ['code'=>-1,'msg'=>'暂无黑名单列表数据...'];
	}
  }

  //获取所有代理ID
  public function getAgentId()
  {
    $agent=Db('agentor')->field('id,true_name')->select();
    if($agent){
      return json($agent);
    }
  }
  //用户流水日志
  public function cusFlow()
  {
    if(Request()->isPost()){
      $id=input('id');
      $list=Db('flow_log')->where('uid',$id)->select();
      if($list){
        foreach ($list as $key => $value) {
          $res=Db('customer')->where('id',$list[$key]['uid'])->find();
          $list[$key]['user_name']=$res['user_name'];
          $list[$key]['true_name']=$res['true_name'];
          $list[$key]['p_name']=$res['p_name'];
          switch ($list[$key]['type']) {
            case 0:
              $list[$key]['type']='充值';
              break;
            case 1:
              $list[$key]['type']='提现';
              break;
          }
          if($list[$key]['add_time']!=NULL){
            $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
          }else{
            $list[$key]['add_time']='';
          }
          if($list[$key]['check_time']!=NULL){
            $list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
          }else{
            $list[$key]['check_time']='';
          }
        }
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list];
      }else{
		  return $result = ['code'=>-1,'msg'=>'暂无用户流水数据...'];
	  }
    }
  }
   //当前持仓单
  public function curPositionOrder()
  {
    if(Request()->isPost()){
      $uid=input('id');
      $listData=Db('position_order')->where('uid',$uid)->select();
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
             // $listData[$key]['tradetime']=date('Y-m-d H:i:s',$value['tradetime']);
          }
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }else{
		  return $result = ['code'=>-1,'msg'=>'暂无当前持仓数据...'];
	  }
    }
  }
  //客户资金查询
  public function myMoneySearch()
  {
    if(Request()->isPost()){
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		$uid=input('id');
		$list=Db('account_info')->where('uid',$uid)->whereTime('create_time','today')->select();
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']=$user['mobile'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available'])/100;  //可以资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
				$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
				$list[$key]['fxd']=strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无今日资金数据...'];
		}
	}
    return $this->fetch();
  }
  //客户资金查询
  public function moneySearch()
  {
    if(Request()->isPost()){
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		$count=Db('account_info')->whereTime('create_time','today')->count();
		if($count>$limit){
			$list=Db('account_info')->whereTime('create_time','today')->limit($pre,$limit)->select();
		}else{
			$list=Db('account_info')->whereTime('create_time','today')->select();
		}
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$list[$key]['uid'])->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']=$user['mobile'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available'])/100;  //可以资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
				$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
				$list[$key]['fxd']=strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}

			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'今日暂无客户资金数据...'];
		}
	}
    return $this->fetch();
  }
  //搜索客户资金
  public function search_money()
  {
	if(Request()->isPost()){
		$keywords=input('keywords');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		$ins_name=input('ins_name');
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		if($ins_name!=''&&$keywords!=''&&$start_time!=''&&$end_time!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				$list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
			}
		}else if($ins_name!=''&&$keywords!=''&&$start_time!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
			}
			
		}else if($ins_name!=''&&$keywords!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info')->where('uid','IN',$uid)->count();
			if($count>$limit){
				$list=Db('account_info')->where('uid','IN',$uid)->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info')->where('uid','IN',$uid)->select();
			}
		}else if($ins_name!=''&&$start_time!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
			}
			
		}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
		  $user=Db('customer')->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			  $list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		  }
		}else if($start_time!=''&&$keywords!=''){
		  $user=Db('customer')->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			  $list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		  }
		}else if($start_time!=''&&$end_time!=''){
		  $count=Db('account_info')->where('create_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			$list=Db('account_info')->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('account_info')->where('create_time','between time',[$start_time,$end_time])->select();
		  }
		}else if($start_time!=''){
		  $count=Db('account_info')->where('create_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			$list=Db('account_info')->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('account_info')->where('create_time','between time',[$start_time,$e_time])->select();
		  }
		}else if($ins_name!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $user=Db('customer')->where('pid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			  $list=Db('account_info')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info')->where('uid','IN',$uid)->select();
		  }
		}else if($keywords!=''){
		  $user=Db('customer')->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			  $list=Db('account_info')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info')->where('uid','IN',$uid)->select();
		  }
		}else{
			$list=false;
		}
        if($list){
			foreach($list as $key=>$value){
				$user=Db('customer')->where('id',$list[$key]['uid'])->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']=$user['mobile'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available'])/100;  //可用资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
				$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
				$list[$key]['fxd']=strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}
			$export_data=Db('export_data')->count();
			if($export_data>0){
				Db('export_data')->delete(true);
			}
			foreach($list as $i=>$v){
				Db('export_data')->insert([
					'id'=>$i+1,
					'a1'=>$v['create_time'],
					'a2'=>$v['zid'],
					'a3'=>$v['true_name'],
					'a4'=>$v['mobile'],
					'a5'=>$v['available'],
					'a6'=>$v['crj'],
					'a7'=>$v['balance'],
					'a8'=>$v['commission'],
					'a9'=>$v['currmargin'],
					'a10'=>$v['closeprofit'],
					'a11'=>$v['positionprofit'],
					'a12'=>$v['total_profit']
				]);
			}
        	return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'未搜索到客户资金数据...'];
		}
    }
  }
   //客户成交查询
  public function myMoneyFlow()
  {
    if(Request()->isPost()){
		$uid=input('id');
		$list=Db('user_trade')->where('uid',$uid)->whereTime('create_time','today')->select();
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
				//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
				$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无今日成交数据...'];
		}
	}
    return $this->fetch();
  }
  //客户成交查询
  public function moneyFlow()
  {
    if(Request()->isPost()){
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		$count=Db('user_trade')->whereTime('create_time','today')->count();
		if($count>$limit){
			$list=Db('user_trade')->whereTime('create_time','today')->limit($pre,$limit)->select();
		}else{
			$list=Db('user_trade')->whereTime('create_time','today')->select();
		}
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$list[$key]['uid'])->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
				//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
				$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'今日暂无客户成交数据...'];
		}
	}
    return $this->fetch();
  }
  //搜索
  public function mySearchMoney()
  {
	if(Request()->isPost()){
		$uid=input('id');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		if($start_time!=''&&$end_time!=''){
			$list=Db('account_info')->where('uid',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		}else if($start_time!=''){
			$list=Db('account_info')->where('uid',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		}else{
			$list=false;
		}

		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']=$user['mobile'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available'])/100;  //可以资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
				$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
				$list[$key]['fxd']=strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂未搜索到成交数据...'];
		}
		
	}
  }
  //搜索
  public function mySearchMoneyFlow()
  {
	if(Request()->isPost()){
		$uid=input('id');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		if($start_time!=''&&$end_time!=''){
			$list=Db('user_trade')->where('uid',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		}else if($start_time!=''){
			$list=Db('user_trade')->where('uid',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		}else{
			$list=false;
		}
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
				//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
				$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂未搜索到成交数据...'];
		}
	}
  }
  //搜索客户成交记录
  public function search_flow()
  {
	if(Request()->isPost()){
		$keywords=input('keywords');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		$ins_name=input('ins_name');
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		if($ins_name!=''&&$start_time!=''&&$end_time!=''&&$keywords!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $user=Db('customer')->where('pid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		  }
		}else if($ins_name!=''&&$start_time!=''&&$end_time!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $user=Db('customer')->where('pid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			  $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		  }
		  
		}else if($ins_name!=''&&$start_time!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $user=Db('customer')->where('pid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		  }
		  
		}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
		  $user=Db('customer')->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		}else if($start_time!=''&&$keywords!=''){
		  $user=Db('customer')->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		  }
		  
		}else if($start_time!=''&&$end_time!=''){
			$count=Db('user_trade')->where('create_time','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				 $list=Db('user_trade')->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
			}else{
				 $list=Db('user_trade')->where('create_time','between time',[$start_time,$end_time])->select();
			}
		 
		}else if($start_time!=''){
			$count=Db('user_trade')->where('create_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('user_trade')->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('user_trade')->where('create_time','between time',[$start_time,$e_time])->select();
			}
		  
		}else if($ins_name!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $user=Db('customer')->where('pid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->select();
		  }
		  
		}else if($keywords!=''){
		  $user=Db('customer')->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			  $list=Db('user_trade')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('user_trade')->where('uid','IN',$uid)->select();
		  }
		  
		}else{
			$list=false;
		}
    
        if($list){
			foreach($list as $key=>$value){
				$user=Db('customer')->where('id',$list[$key]['uid'])->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
				//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
				$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
			}
        	return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'未搜索到客户成交数据...'];
		}
    }	
  }
  //删除或禁用客户
  private function setCustomer($id,$flag)
  {
    //$flag=2为彻底删除，-1为软删除即加入黑名单，1为禁用；
    if($flag==1){//设置禁用
      $res=Db('customer')->where('id',$id)->update(['status'=>1]);
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==-1){//加入黑名单
      $res=Db('customer')->where('id',$id)->update(['status'=>-1]);
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==2){//彻底删除
      $res=Db('customer')->where('id',$id)->delete();
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==0){//设置启用
      $res=Db('customer')->where('id',$id)->update(['status'=>0]);
      if($res){
        return true;
      }else{
        return false;
      }
    }
  }
  //获取某一客户的资料
  private function getCustomerInfo($id)
  {
    $res=Db('customer')->where('id',$id)->find();
    if($res){
      switch ($res['status']) {
        case 0:
          $res['status']='正常';
          break;
        case -1:
          $res['status']='黑名单';
          break;
        case 1:
          $res['status']='禁用';
          break;
      }
      if($res['add_time']!=NULL){
        $res['add_time']=date('Y-m-d H:i:s',$res['add_time']);
      }else{
        $res['add_time']='';
      }
    }
    return $res;
  }


  //获取所有客户数据
  private function getCustomerData($page,$limit)
  {
    $res=Db('customer')->where('status','IN',[0,1])->limit($page,$limit)->select();
    if($res){
      foreach ($res as $k => $v) {
        switch ($res[$k]['status']) {
          case 1:
            $res[$k]['status']='锁定';
            break;
          case -1:
            $res[$k]['status']='黑名单';
            break;
          default:
            $res[$k]['status']='正常';
            break;
        }
        if($res[$k]['add_time']!=NULL){
          $res[$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
        }else{
          $res[$k]['add_time']='';
        }
      }
    }
    return $res;
  }

   //获取数据
  public function getData()
  {
	if(Request()->isPost()){
		$zg=Db('zg_sys')->where('status',0)->select();
		$mzh=Db('mzh_config')->where('status',0)->select();
		$fk=Db('fk_config')->where('status',0)->select();
		$sxf_mb=Db('sxf_mb')->where('status',0)->select();
		return json(['zg'=>$zg,'mzh'=>$mzh,'fk'=>$fk,'sxf_mb'=>$sxf_mb]);
	}
  }

    public function baobiao(){
        $day = date('Ymd',time());
        $id = input('id');
        $account = db('customer')->where('id',$id)->value('mobile');
        $accountInfoLog=Db::connect(config('db_trade'))->table('yp_account_info_log')->where('zaccount',$account)->where('tradedate',$day)->find();
        if(empty($accountInfoLog)){
            $accountInfoLog['prebalance'] = 0;
            $accountInfoLog['balance'] = 0;
            $accountInfoLog['available'] = 0;
            $accountInfoLog['positionprofit'] = 0;
            $accountInfoLog['closeprofit'] = 0;
            $accountInfoLog['commission'] = 0;
            $accountInfoLog['currmargin'] = 0;
            $accountInfoLog['deposit'] = 0;
            $accountInfoLog['frozenmargin'] = 0;
            $accountInfoLog['withdraw'] = 0;
            $accountInfoLog['zaccount'] = $account;
        }
        $accountInfoLog['day'] = $day;
        $this->assign('list',$accountInfoLog);
        return $this->fetch();
    }

    //持仓明细yp_trade_position_detail
    public function chiming(){
        $id = input('id');
        $day = input('day');
        if($day == ''){
            $day = date('Ymd',time());
        }
        $account = db('customer')->where('id',$id)->value('zid');
        $tradePositionDetail=Db::connect(config('db_trade'))->table('yp_trade_position_detail')->where('zaccount',$account)->where('tradedate',$day)->select();
        $data['code'] = 0;
        $data['data'] = $tradePositionDetail;
        return json($data);
    }

    public function jiben(){
        $id = input('id');
        $day = input('day');
        if($day == ''){
            $day = date('Ymd',time());
        }
        $account = db('customer')->where('id',$id)->value('mobile');
        $accountInfoLog=Db::connect(config('db_trade'))->table('yp_account_info_log')->where('zaccount',$account)->where('tradedate',$day)->find();
        $accountInfoLog['day'] = $day;
        return json($accountInfoLog);
    }

    //持仓汇总 yp_trade_position
    public function chihui(){
        $id = input('id');
        $day = input('day');
        if($day == ''){
            $day = date('Ymd',time());
        }
        $account = db('customer')->where('id',$id)->value('zid');
        $tradePosition=Db::connect(config('db_trade'))->table('yp_trade_position')->where('zaccount',$account)->where('tradedate',$day)->select();
        $data['code'] = 0;
        $data['data'] = $tradePosition;
        return json($data);
    }

    //成交明细
    public function chengming(){
        $id = input('id');
        $day = input('day');
        if($day == ''){
            $day = date('Ymd',time());
        }
        $account = db('customer')->where('id',$id)->value('zid');
        $batchTrade=Db::connect(config('db_trade'))->table('yp_batch_trade')->where('zaccount',$account)->where('tradedate',$day)->select();
        $data['code'] = 0;
        $data['data'] = $batchTrade;
        return json($data);
    }

    //平仓明细
    public function pingming(){
        $id = input('id');
        $day = input('day');
        if($day == ''){
            $day = date('Ymd',time());
        }
        $account = db('customer')->where('id',$id)->value('zid');
        $closePosition=Db::connect(config('db_trade'))->table('yp_close_position')->where('zaccount',$account)->where('tradedate',$day)->select();
        $data['code'] = 0;
        $data['data'] = $closePosition;
        return json($data);
    }

}
