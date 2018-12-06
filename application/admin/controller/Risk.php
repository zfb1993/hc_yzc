<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Risk extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    return $this->fetch();
  }
  //风控设置
  public function riskSetting()
  {
    if(Request()->isPost()){
      $fields=input('post.fields/a');
      $start_time=strtotime(date("Y-m-d",strtotime("+1 day")));
      $data=[
        'bzj_max_rate'=>$fields['bzj_max_rate'],
        'bzj_warn_rate'=>$fields['bzj_warn_rate'],
        'bzj_db_rate'=>$fields['bzj_db_rate'],
        'default_zy_rate'=>$fields['default_zy_rate'],
        'max_zy_rate'=>$fields['max_zy_rate'],
        'default_zs_rate'=>$fields['default_zs_rate'],
        'allow_max_zf'=>$fields['allow_max_zf'],
        'allow_max_df'=>$fields['allow_max_df'],
        'start_time'=>$start_time
      ];
      $res=Db('risk_setting')->where(['id'=>1])->find();
      if(!$res){
        $result=Db('risk_setting')->where(['id'=>1])->insert($data);
        if($result){
          return json(['code'=>1,'msg'=>'设置成功','url'=>url('riskSetting')]);
        }else{
          return json(['code'=>0,'msg'=>'设置失败']);
        }
      }else{
        $result=Db('risk_setting')->where(['id'=>1])->update($data,true);
        if($result){
          return json(['code'=>1,'msg'=>'设置成功','url'=>url('riskSetting')]);
        }else{
          return json(['code'=>0,'msg'=>'设置失败']);
        }
      }
    }
    $list=Db('risk_setting')->where(['id'=>1,'status'=>0])->find();
    $this->assign('list',$list);
    return $this->fetch();
  }
  //强平时间设置
  public function deliveryDate()
  {
    if(Request()->isPost()){
      $pid=input('pid');
      $listData=Db('delivery_date')->where('pid',$pid)->select();
      if($listData){
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }
  //新增强平时间
  public function add_deliveryDate()
  {
    if(Request()->isPost()){
      $data=[
        'pid'=>trim(input('pid')),
        'start_time'=>trim(input('start_time')),
        'end_time'=>trim(input('end_time')),
        'rate'=>trim(input('rate'))
      ];
      $res=Db('delivery_date')->insert($data);
      if($res){
        return json(['code'=>1,'msg'=>'添加成功']);
      }else{
        return json(['code'=>0,'msg'=>'添加失败']);
      }
    }
  }
  //编辑强平时间
  public function edit_deliveryDate()
  {
    if(Request()->isPost()){
      $id=input('id');
      $data=[
        'start_time'=>trim(input('start_time')),
        'end_time'=>trim(input('end_time')),
        'rate'=>trim(input('rate'))
      ];
      $res=Db('delivery_date')->where('id',$id)->update($data);
      if($res){
        return json(['code'=>1,'msg'=>'修改成功']);
      }else{
        return json(['code'=>0,'msg'=>'修改失败']);
      }
    }
  }
  //删除强平时间
  public function del_deliveryDate()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('delivery_date')->where('id',$id)->delete();
      if($res){
        return json(['code'=>1,'msg'=>'删除成功']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败']);
      }
    }
  }
  //品种管理 table:yp_product_manage
  public function productManage()
  {
    if(Request()->isPost()){
      $listData=Db('product_manage')->select();
      if($listData){
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }
  //获取交易所ID及Name
  public function getExId()
  {
    if(Request()->isPost()){
      $list=Db('ex_name')->order('id')->select();
      return json($list);
    }
  }
  //添加品种
  public function add_product()
  {
    if(Request()->isPost()){
      $data=[
        'ex_name'=>trim(input('ex_name')),
        'p_name'=>trim(input('p_name')),
        'min_rate'=>trim(input('min_rate')),
        'c_multiplier'=>trim(input('c_multiplier')),
        'ptglf'=>trim(input('ptglf')),
        'sxf'=>trim(input('sxf')),
        'jsfwf'=>trim(input('jsfwf'))
      ];
      $res=Db('product_manage')->insert($data);
      if($res){
        return json(['code'=>1,'msg'=>'品种添加成功']);
      }else{
        return json(['code'=>0,'msg'=>'品种添加失败']);
      }

    }
  }
  //编辑品种
  public function edit_product()
  {
    if(Request()->isPost()){
      $id=input('id');
      $data=[
        'ptglf'=>trim(input('ptglf')),
        'sxf'=>trim(input('sxf')),
        'jsfwf'=>trim(input('jsfwf'))
      ];
      $res=Db('product_manage')->where('id',$id)->update($data);
      if($res){
        return json(['code'=>1,'msg'=>'修改成功']);
      }else{
        return json(['code'=>0,'msg'=>'修改失败']);
      }
    }
  }
  //删除品种
  public function del_product()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('product_manage')->where('id',$id)->delete();
      if($res){
        return json(['code'=>1,'msg'=>'删除成功']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败']);
      }
    }
  }
  //获取当前品种数据
  public function getCurProductInfo()
  {
    if(Request()->isPost()){
      $id=input('id');
      $list=Db('product_manage')->where('id',$id)->find();
      if($list){
        return json($list);
      }
    }
  }
  //合约管理 table:yp_contract_manage
  public function contractManage()
  {
    if(Request()->isPost()){
      $listData=Db('contract_manage')->select();
      if($listData){
        foreach ($listData as $key => $value) {
          switch ($listData[$key]['status']) {
            case 0:
              $listData[$key]['status']='正常';
              break;
            case 1:
              $listData[$key]['status']='禁止';
              break;
          }
        }
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }
  //获取品种ID及Name
  public function getProId()
  {
    if(Request()->isPost()){
      $list=Db('product_manage')->order('id')->select();
      return json($list);
    }
  }
  //添加合约
  public function add_contract()
  {
    if(Request()->isPost()){
      $p_name=input('p_name');
      $product=Db('product_manage')->where(['p_name'=>$p_name,'status'=>0])->find();
      if($product){
        $data=[
          'ex_name'=>$product['ex_name'],
          'p_name'=>$product['p_name'],
          'c_name'=>trim(input('c_name')),
          'c_code'=>trim(input('c_code')),
          'copy_code'=>trim(input('copy_code')),
          'min_rate'=>trim(input('min_rate')),
          'c_multiplier'=>trim(input('c_multiplier')),
          'open_hops'=>trim(input('open_hops')),
          'flat_hopping'=>trim(input('flat_hopping')),
          'ptglf'=>$product['ptglf'],
          'sxf'=>$product['sxf'],
          'jsfwf'=>$product['jsfwf'],
          'delivery_date'=>trim(input('delivery_date')),
          'status'=>trim(input('status'))
        ];
        $res=Db('contract_manage')->insert($data);
        if($res){
          return json(['code'=>1,'msg'=>'合约添加成功']);
        }else{
          return json(['code'=>0,'msg'=>'合约添加失败']);
        }
      }else{
        return json(['code'=>0,'msg'=>'未找到该品种']);
      }
    }
  }
  //编辑合约
  public function edit_contract()
  {
    if(Request()->isPost()){
      $id=input('id');
      $data=[
        'open_hops'=>trim(input('open_hops')),
        'flat_hopping'=>trim(input('flat_hopping')),
        'delivery_date'=>trim(input('delivery_date')),
        'status'=>input('status')
      ];
      $res=Db('contract_manage')->where('id',$id)->update($data);
      if($res){
        return json(['code'=>1,'msg'=>'合约修改成功']);
      }else{
        return json(['code'=>0,'msg'=>'合约修改失败']);
      }
    }
  }
  //删除合约
  public function del_contract()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('contract_manage')->where('id',$id)->delete();
      if($res){
        return json(['code'=>1,'msg'=>'合约删除成功']);
      }else{
        return json(['code'=>0,'msg'=>'合约删除失败']);
      }
    }
  }
  //获取合约数据
  public function getContractData()
  {
    if(Request()->isPost()){
      $id=input('id');
      $list=Db('contract_manage')->where('id',$id)->find();
      if($list){
        return json($list);
      }
    }
  }
  //合约档位设置
  public function gearSetting()
  {
    if(Request()->isPost()){
      $cid=input('cid');
      $listData=Db('gear_setting')->where('cid',$cid)->select();
      if($listData){
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }
    }
    return $this->fetch();
  }
  //新增合约档位
  public function add_gearSetting()
  {
    if(Request()->isPost()){
      $data=[
        'cid'=>trim(input('cid')),
        'bzj_gear'=>trim(input('bzj_gear')),
        'stop_jump_num'=>trim(input('stop_jump_num')),
        'stop_loss_num'=>trim(input('stop_loss_num'))
      ];
      $res=Db('gear_setting')->insert($data);
      if($res){
        return json(['code'=>1,'msg'=>'添加成功']);
      }else{
        return json(['code'=>0,'msg'=>'添加失败']);
      }
    }
  }
  //编辑合约档位
  public function edit_gearSetting()
  {
    if(Request()->isPost()){
      $id=input('id');
      $data=[
        'bzj_gear'=>trim(input('bzj_gear')),
        'stop_jump_num'=>trim(input('stop_jump_num')),
        'stop_loss_num'=>trim(input('stop_loss_num'))
      ];
      $res=Db('gear_setting')->where('id',$id)->update($data);
      if($res){
        return json(['code'=>1,'msg'=>'修改成功']);
      }else{
        return json(['code'=>0,'msg'=>'修改失败']);
      }
    }
  }
  //删除合约档位
  public function del_gearSetting()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('gear_setting')->where('id',$id)->delete();
      if($res){
        return json(['code'=>1,'msg'=>'删除成功']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败']);
      }
    }
  }



  /**
    ******************************************************新增部分 willion 20180513******************************************
   */
  //交易时间设置
  public function tradeDate()
  {
    if(Request()->isPost()){
      $pid=input('pid');
      $listData=Db('trade_date')->where('pid',$pid)->select();
      if($listData){
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$listData];
      }else{
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>array()];
      }
    }
    return $this->fetch();
  }
  //新增交易时间
  public function addTradeDate()
  {
    if(Request()->isPost()){
      $data=[
          'pid'=>trim(input('pid')),
          'start_time'=>trim(input('start_time')),
          'end_time'=>trim(input('end_time')),
      ];

      $date=date('Y-m-d',time());
      if($data['start_time']>$data['end_time']){
        $beginstart1= strtotime($date.' '.$data['start_time']);
        $endtime1= strtotime($date.' '.$data['end_time'])+24*60*60;
      }else{
        $beginstart1= strtotime($date.' '.$data['start_time']);
        $endtime1= strtotime($date.' '.$data['end_time']);
      }
      $resDelivery=Db('delivery_date')->where('pid',$data['pid'])->select();
      foreach($resDelivery as $key=>$val){

        if($val['start_time']>$val['end_time']){
          $beginstart2= strtotime($date.' '.$val['start_time']);
          $endtime2= strtotime($date.' '.$val['end_time'])+24*60*60;
        }else{
          $beginstart2= strtotime($date.' '.$val['start_time']);
          $endtime2= strtotime($date.' '.$val['end_time']);
        }

        if(is_time_cross($beginstart1, $endtime1, $beginstart2 , $endtime2 )){
          return json(['code'=>1,'msg'=>'时间设置有交叉，请重新设置！']);
        }

      }

      $res=Db('trade_date')->insert($data);
      if($res){
        return json(['code'=>1,'msg'=>'添加成功']);
      }else{
        return json(['code'=>0,'msg'=>'添加失败']);
      }
    }
  }
  //编辑交易时间
  public function editTradeDate()
  {
    if(Request()->isPost()){
      $id=input('id');
      $data=[
          'start_time'=>trim(input('start_time')),
          'end_time'=>trim(input('end_time')),
      ];

      $pid=Db('trade_date')->where('id',$id)->value('pid');
      $date=date('Y-m-d',time());
      if($data['start_time']>$data['end_time']){
        $beginstart1= strtotime($date.' '.$data['start_time']);
        $endtime1= strtotime($date.' '.$data['end_time'])+24*60*60;
      }else{
        $beginstart1= strtotime($date.' '.$data['start_time']);
        $endtime1= strtotime($date.' '.$data['end_time']);
      }
      $resDelivery=Db('delivery_date')->where('pid',$pid)->select();
      foreach($resDelivery as $key=>$val){

        if($val['start_time']>$val['end_time']){
          $beginstart2= strtotime($date.' '.$val['start_time']);
          $endtime2= strtotime($date.' '.$val['end_time'])+24*60*60;
        }else{
          $beginstart2= strtotime($date.' '.$val['start_time']);
          $endtime2= strtotime($date.' '.$val['end_time']);
        }

        if(is_time_cross($beginstart1, $endtime1, $beginstart2 , $endtime2 )){
          return json(['code'=>1,'msg'=>'时间设置有交叉，请重新设置！']);
        }

      }
      $res=Db('trade_date')->where('id',$id)->update($data);
      if($res){
        return json(['code'=>1,'msg'=>'修改成功']);
      }else{
        return json(['code'=>0,'msg'=>'修改失败']);
      }
    }
  }
  //删除交易时间
  public function delTradeDate()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('trade_date')->where('id',$id)->delete();
      if($res){
        return json(['code'=>1,'msg'=>'删除成功']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败']);
      }
    }
  }

}
