<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class System extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
    	if(Request()->isPost()){
    		$data=input('post.');
    		$res=db('system_set')->where('id',1)->update($data);
    		if($res){
    			return json(['code'=>1, 'msg'=>'保存成功！', 'url'=>url('index')]);
    		}else{
    			return json(['code'=>0, 'msg'=>'没有修改内容，保存失败！']);
    		}
    	}
    	$sys=db('system_set')->where('id',1)->find();
    	$this->assign('sys',$sys);
        return $this->fetch();
    }

    //管理员列表
    public function manageList()
    {
        if(Request()->isPost()){
            $list=Db('admin')->where('admin_id','NEQ',1)->select();
			if($list){
				foreach($list as $key=>$value){
					$list[$key]['is_open']=($list[$key]['is_open']==0)?'开启':'禁止';
					$list[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
				}
				return $result = ['code'=>0,'msg'=>'','data'=>$list];
			}
        }

        return $this->fetch();
    }
	//添加管理员
	public function addManager()
	{
		if(Request()->isPost()){
			$data=[
				'group_id'=>input('gid'),
				'username'=>trim(input('user_name')),
				'pwd'=>md5(trim(input('user_pwd'))),
				'create_time'=>time()
			];
			$res=Db('admin')->insert($data);
			if($res){
				return json(['code'=>1,'msg'=>'添加成功']);
			}else{
				return json(['code'=>1,'msg'=>'添加失败']);
			}
		}
	}
	public function getGroupData(){
		if(Request()->isPost()){
			$list=Db('auth_group')->field('group_id,title')->select();
			return $list;
		}
	}
	//编辑管理员
	public function editManager()
	{
		if(Request()->isPost()){
			$admin_id=input('id');
			if(input('user_pwd')!==''){
				$data=[
					'group_id'=>input('gid'),
					'realname'=>trim(input('realname')),
					'tel'=>trim(input('tel')),
					'email'=>trim(input('email')),
					'pwd'=>md5(trim(input('user_pwd'))),
					'update_time'=>time()
				];
			}else{
				$data=[
					'group_id'=>input('gid'),
					'realname'=>trim(input('realname')),
					'tel'=>trim(input('tel')),
					'email'=>trim(input('email')),
					'update_time'=>time()
				];
			}
			$res=Db('admin')->where('admin_id',$admin_id)->update($data);
			if($res){
				return json(['code'=>1,'msg'=>'修改成功']);
			}else{
				return json(['code'=>0,'msg'=>'修改失败']);
			}
		}
	}
	//删除管理员
	public function delManager()
	{
		if(Request()->isPost()){
			$admin_id=input('id');
			$res=Db('admin')->where('admin_id',$admin_id)->delete();
			if($res){
				return json(['code'=>1,'msg'=>'删除成功']);
			}else{
				return json(['code'=>0,'msg'=>'删除失败']);
			}
		}
	}

	/**系统消息*/
	public function systemMsg(){
		if(Request()->isPost()){
			$msgArr= \think\Db::name('system_msg')->where('status','in',array(1,2))->order('status asc,id desc')->limit(0,15)->select();
			if($msgArr){
				foreach($msgArr as $key=>$value){
					$msgArr[$key]['status']=($msgArr[$key]['status']==1)?'未读':'已读';
					if(strpos($value['content'],'提现') !==false){
						$msgArr[$key]['content'] = '<span style="color:red">'.$value['content'].'</span>';
					}
				}
				return $result = ['code'=>0,'msg'=>'','data'=>$msgArr];
			}else{
				return $result = ['code'=>0,'msg'=>'','data'=>$msgArr];
			}
		}
		return $this->fetch();
	}

}
