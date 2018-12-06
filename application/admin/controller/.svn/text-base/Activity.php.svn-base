<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class  Activity extends Common
{
  public function _initialize(){
    parent::_initialize();
  }


  //文章列表
  public function activityList()
  {
    if(Request()->isPost()){
    $list=Db::name('activity')->alias('a')
    ->join('ac_type w','a.type = w.id','LEFT')
    ->field('a.*,w.type_name')
    ->select();
   // echo Db('activity')->
    //print_r($list);die;
      if(!empty($list)){
        foreach ($list as $key=>$val){
          if($val['status']==0){
            $list[$key]['st']='正常';
          }else{
            $list[$key]['st']='禁用';
          }
        }
        return $result = ['code'=>0,'msg'=>'','data'=>$list];
      }
    }
    return $this->fetch();
  }



  //删除文章
  public function activityDel()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('activity')->where('id',$id)->delete();
      if($res){
        return json(['code'=>1,'msg'=>'删除成功！']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败！']);
      }
    }
  }



    //添加文章
    public function activityAdd()
    {

      if(Request()->isPost()){
      //	$data=input('post.');
         $data['img']       = input('post.img');
         $data['title']     = input('post.title');
         $data['abstract']  = input('post.abstract');
         $data['author']    = input('post.author');
         $data['content']   = input('post.content');
         $data['status']    = input('post.status');
         $data['type']      = input('post.type');
         $data['brief']     = input('post.brief');
         $data['add_date']  = date('Y-m-d',time());
         $data['add_time']  = date('Y-m-d H:i:s',time());
         $data['content']   = input('post.editorValue');
         $data['create_user']   = session('username');
         $res=db('activity')->insert($data);
       // echo db('system_set')->getLastSql();die;
    		if($res){
    			return json(['code'=>1, 'msg'=>'保存成功！', 'url'=>url('index')]);
    		}else{
    			return json(['code'=>0, 'msg'=>'保存失败！']);
    		}
    	}
      $list=Db('ac_type')->select();
      $this->assign('list',$list);   
      return $this->fetch();
    }

  //修改文章
  public function activityEdit()
  {


    if(Request()->isPost()){
      
        $img =  input('post.img');
        $where['id'] =  input('post.id');
         if(!empty($img)){
          $data['img']       = input('post.img');
         }
       
         $data['title']     = input('post.title');
         $data['abstract']  = input('post.abstract');
         $data['author']    = input('post.author');
         $data['status']    = input('post.status');
         $data['brief']     = input('post.brief');
         $data['add_date']  = date('Y-m-d',time());
         $data['add_time']  = date('Y-m-d H:i:s',time());
         $data['content']   = input('post.editorValue');
         $data['create_user']   = session('username');
        $res=db('activity')->where($where)->update($data);
      
    		if($res){
    			return json(['code'=>1, 'msg'=>'修改成功！', 'url'=>url('index')]);
    		}else{
    			return json(['code'=>0, 'msg'=>'什么也没有修改！']);
    		}
    	}


    $where['id']       = input('get.id',0);
    
    $list=Db('activity')->where($where)->find();
    $ac=Db('ac_type')->select();
    $this->assign('ac',$ac);  
    $this->assign('list',$list);      
    return $this->fetch();
  }



//图片上传

 public function uploader_img(){
 
  $file = request()->file('file');  
   //print_r($file);die;
  //$data=$_POST;  
  if(isset($file)){  
   // 获取表单上传文件 例如上传了001.jpg  
// 移动到框架应用根目录/public/uploads/ 目录下  
  $info = $file->move(ROOT_PATH . 'public/uploads');  
      

    if($info){  
            // 成功上传后 获取上传信息  
    $a=$info->getSaveName();  
    $imgp= str_replace("\\","/",$a);  
    $imgpath='uploads/'.$imgp;  
     $data['f_img']= $imgpath; 
     return json($data);
  //  $data['f_img']= $imgpath;  
  }else{  
              // 上传失败获取错误信息  
     echo $file->getError();  
  } 
 }
}


  //活动类型列表
  public function acType()
  {
    if(Request()->isPost()){
      $list=Db('ac_type')->select();
      if($list){
        return $result = ['code'=>0,'msg'=>'','data'=>$list];
      }
    }
    return $this->fetch();
  }

  //删除文章类型
  public function acTypeDel()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('ac_type')->where('id',$id)->delete();
      if($res){
        return json(['code'=>1,'msg'=>'删除成功！']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败！']);
      }
    }
  }

   //添加文章类型
    public function acTypeAdd()
    {
      if(Request()->isPost()){
        $type_name  = input('type_name');
       // echo  $type_name.'yy';
        $list = Db('ac_type')->where('type_name',$type_name)->find();
        if(empty($list)){
          $data['type_name']=trim(input('type_name'));
         
          $res=Db('ac_type')->insert($data);
          if($res){
            return json(['code'=>1,'msg'=>'添加成功！']);
          }else{
            return json(['code'=>0,'msg'=>'添加类型失败！']);
          }
        }else{
          return json(['code'=>0,'msg'=>'已经存在该类型！']);
        }
      }
    }

  //获取文章类型
  public function getType()
  {
    if(Request()->isPost()){
      $list=Db('ac_type')->select();
      if($list){
        return json($list);
      }
    }
  }

  //修改用户资料
  public function updateType()
    {
      if(Request()->isPost()){
        $id        = input('id');
        $type_name = trim(input('type_name'));
    
        $res=Db('ac_type')->where('id',$id)->find();
        if(!empty($res)){
         
          $ac = Db('ac_type')->where('type_name',$type_name)->find();     

          if(!empty($ac)){
            return json(['code'=>0,'msg'=>'已经存在，不能修改同样的']);
          }
            $result=Db('ac_type')->where('id',$id)->update(['type_name'=>$type_name]);
            if($result){
              return json(['code'=>1,'msg'=>'修改成功']);
            }else{
              return json(['code'=>0,'msg'=>'修改失败']);
            }
          
          
        }else{
          return json(['code'=>-1,'msg'=>'数据异常，刷新重试']);
        }
      }
    }
    
}
