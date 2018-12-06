<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Search extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function insList()
    {
	   if(Request()->isPost()){
		    $level=Db('agent_config')->select();
			$list=[];
			foreach($level as $key=>$value){
				$agent=Db('agentor')->field('id,tid,pid,true_name,p_name,ins_name')->where(['status'=>0,'aid'=>$level[$key]['id']])->select();
				array_push($list,$agent);
			}
			return json($list);
	   }
       
    }
}
