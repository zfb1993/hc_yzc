<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;
use think\Loader;
class Index extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
		//导航
        // 获取缓存数据
        $authRule = cache('authRule');
		//dump($authRule);die;
        if(!$authRule){
            $authRule = db('auth_rule')->where('menustatus=1')->order('sort')->select();
            cache('authRule', $authRule, 3600);
        }
        //声明数组
        $menus = array();
        foreach ($authRule as $key=>$val){
            $authRule[$key]['href'] = url($val['href']);
            if($val['pid']==0){
                if(session('aid')!=1){
                    if(in_array($val['id'],$this->adminRules)){
                        $menus[] = $val;
                    }
                }else{
                    $menus[] = $val;
                }
            }
        }
        foreach ($menus as $k=>$v){
            foreach ($authRule as $kk=>$vv){
                if($v['id']==$vv['pid']){
                    if(session('aid')!=1) {
                        if (in_array($vv['id'], $this->adminRules)) {
                            $menus[$k]['children'][] = $vv;
                        }
                    }else{
                        $menus[$k]['children'][] = $vv;
                    }
                }else{
					if(!isset($menus[$k]['children'])){
						$menus[$k]['children'] = [];
					}
				}
            }
        }
		//dump($menus);die;
        $this->assign('menus',$menus);

        $user=db('admin')->where('admin_id',session('aid'))->find();
        $sysinfo=db('system_set')->find();

        $this->assign(['user'=>$user,'sysinfo'=>$sysinfo]);
        return $this->fetch();
    }
    public function index2()
    {
        $user=db('admin')->where('admin_id',session('aid'))->find();
        $sysinfo=db('system_set')->find();

        $this->assign(['user'=>$user,'sysinfo'=>$sysinfo]);
        return $this->fetch();
    }

    //控制面板
    public function main(){
        $config  = [
            'url'             => $_SERVER['HTTP_HOST'],
            'document_root'   => $_SERVER['DOCUMENT_ROOT'],
            'server_os'       => PHP_OS,
            'server_port'     => $_SERVER['SERVER_PORT']
        ];
        $this->assign('config', $config);
        return $this->fetch();
    }
    //清除缓存
    public function clear(){
        $R = RUNTIME_PATH;
        if ($this->_deleteDir($R)) {
            $result['info'] = '清除缓存成功!';
            $result['status'] = 1;
        } else {
            $result['info'] = '清除缓存失败!';
            $result['status'] = 0;
        }
        $result['url'] = url('admin/index/index');
        return $result;
    }
    private function _deleteDir($R)
    {
        $handle = opendir($R);
        while (($item = readdir($handle)) !== false) {
            if ($item != '.' and $item != '..') {
                if (is_dir($R . '/' . $item)) {
                    $this->_deleteDir($R . '/' . $item);
                } else {
                    if (!unlink($R . '/' . $item))
                        die('error!');
                }
            }
        }
        closedir($handle);
        return rmdir($R);
    }
	//每日结算
	public function jieSuan_day(){
		if(Request()->isPost()){
			$list=Db('user_settlement_log')->where(['status'=>0,'jszq'=>'日'])->select();
			//dump($list);die;
			if($list){
				foreach($list as $key=>$value){
					$agent=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
					if($agent){
						Db('agentor')->where(['id'=>$list[$key]['aid']])->setInc('total_money',$list[$key]['money']);
						$res=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
						Db('flow_log')->insert([
							'aid'=>$list[$key]['aid'],
							'money'=>$list[$key]['money'],
							'total_money'=>$res['total_money'],
							'type'=>1,
							'add_time'=>time(),
							'check_time'=>time(),
							'remark'=>'返佣结算',
							'memo'=>'返佣结算'
						]);
						Db('user_settlement_log')->where(['id'=>$list[$key]['id'],'jszq'=>'日'])->update(['status'=>1]);
						Db('agent_settlement_log')->where(['aid'=>$agent['id'],'jszq'=>'日'])->update(['status'=>1]);
					}
				}
				return json(['code'=>1,'msg'=>'成功完成日结算']);
			}else{
				return json(['code'=>0,'msg'=>'暂无日结算数据']);
			}
		}
	}
	//每周结算
	public function jieSuan_week(){
		if(Request()->isPost()){
			$list=Db('user_settlement_log')->where(['status'=>0,'jszq'=>'周'])->select();
			if($list){
				foreach($list as $key=>$value){
					$agent=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
					if($agent){
						Db('agentor')->where(['id'=>$list[$key]['aid']])->setInc('total_money',$list[$key]['money']);
						$res=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
						Db('flow_log')->insert([
							'aid'=>$list[$key]['aid'],
							'money'=>$list[$key]['money'],
							'total_money'=>$res['total_money'],
							'type'=>1,
							'add_time'=>time(),
							'check_time'=>time(),
							'remark'=>'返佣结算',
							'memo'=>'返佣结算'
						]);
						//Db('user_settlement')->where(['id'=>$list[$key]['id']])->update(['status'=>1]);
						Db('user_settlement_log')->where(['aid'=>$agent['id'],'jszq'=>'周'])->update(['status'=>1]);
						Db('agent_settlement_log')->where(['aid'=>$agent['id'],'jszq'=>'周'])->update(['status'=>1]);
					}
				}
				return json(['code'=>1,'msg'=>'成功完成周结算']);
			}else{
				return json(['code'=>0,'msg'=>'暂无周结算数据']);
			}
		}
	}
	//每月结算
	public function jieSuan_month(){
		if(Request()->isPost()){
			$list=Db('user_settlement_log')->where(['status'=>0,'jszq'=>'月'])->select();
			if($list){
				foreach($list as $key=>$value){
					$agent=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
					if($agent){
						Db('agentor')->where(['id'=>$list[$key]['aid']])->setInc('total_money',$list[$key]['money']);
						$res=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
						Db('flow_log')->insert([
							'aid'=>$list[$key]['aid'],
							'money'=>$list[$key]['money'],
							'total_money'=>$res['total_money'],
							'type'=>1,
							'add_time'=>time(),
							'check_time'=>time(),
							'remark'=>'返佣结算',
							'memo'=>'返佣结算'
						]);
						//Db('user_settlement')->where(['id'=>$list[$key]['id']])->update(['status'=>1]);
						Db('user_settlement_log')->where(['aid'=>$agent['id'],'jszq'=>'月'])->update(['status'=>1]);
						Db('agent_settlement_log')->where(['aid'=>$agent['id'],'jszq'=>'月'])->update(['status'=>1]);
					}
				}
				return json(['code'=>1,'msg'=>'成功完成月结算']);
			}else{
				return json(['code'=>0,'msg'=>'暂无月结算数据']);
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

	
    //退出登陆
    public function loginout(){
        session(null);
        return $result=['info'=>'退出成功','url'=>url('admin/login/index')];
    }

	//导出Excel
    public function export(){
        $xlsName  = "结算数据";
        $xlsCell  = array(
            array('id','账号ID'),
            array('true_name','名字'),
            array('mobile','手机'),
        );
        $xlsData  = Db::name('customer')->Field('id,true_name,mobile')->select();
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
    
}
