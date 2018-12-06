<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Index extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
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
			$list=Db('user_settlement')->where(['status'=>0,'jszq'=>'日'])->select();
			if($list){
				foreach($list as $key=>$value){
					$agent=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
					if($agent){
						Db('agentor')->where(['id'=>$list[$key]['aid']])->setInc('total_money',$list[$key]['money']);
						Db('user_settlement')->where(['id'=>$list[$key]['id']])->update(['status'=>1]);
						Db('user_settlement_log')->where(['aid'=>$agent['id'],'jszq'=>'日'])->update(['status'=>1]);
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
			$list=Db('user_settlement')->where(['status'=>0,'jszq'=>'周'])->select();
			if($list){
				foreach($list as $key=>$value){
					$agent=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
					if($agent){
						Db('agentor')->where(['id'=>$list[$key]['aid']])->setInc('total_money',$list[$key]['money']);
						Db('user_settlement')->where(['id'=>$list[$key]['id']])->update(['status'=>1]);
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
			$list=Db('user_settlement')->where(['status'=>0,'jszq'=>'月'])->select();
			if($list){
				foreach($list as $key=>$value){
					$agent=Db('agentor')->where(['id'=>$list[$key]['aid']])->find();
					if($agent){
						Db('agentor')->where(['id'=>$list[$key]['aid']])->setInc('total_money',$list[$key]['money']);
						Db('user_settlement')->where(['id'=>$list[$key]['id']])->update(['status'=>1]);
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
		foreach($list as $key=>$value)
		{
			$user=Db('customer')->where('id',$list[$key]['uid'])->find();
			$agent=Db('agentor')->where('id',$user['pid'])->find();
			switch($agent['aid']){
				case 1:
					$sxf=intval($list[$key]['commission']);
					$z_name=Db('zg_sys')->where('id',$agent['zg_id'])->value('name');
					$mzh=Db('mzh_config')->where('id',$agent['mzh_id'])->value('account');
					$money=$sxf*($agent['sxf']/100);
					Db('user_settlement_log')->insert([
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
			$log=Db('user_settlement_log')->where('aid',$agent[$i]['id'])->select();
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
				$res=Db('user_settlement')->where('aid',$agent[$i]['id'])->find();
				if(!$res){
					Db('user_settlement')->insert([
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
				}else{
					Db('user_settlement')->where('aid',$agent[$i]['id'])->setInc('sum_money',$sum_money);
					Db('user_settlement')->where('aid',$agent[$i]['id'])->setInc('money',$money);
					Db('user_settlement')->where('aid',$agent[$i]['id'])->update([
						'total_money'=>$agent[$i]['total_money'],
						'date'=>time()
					]);
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
    
}
