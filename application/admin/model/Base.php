<?php
/******************************************************************
 *  基础公共模型
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/31 13:20
 *+------------------------------------------------------------------
 */
namespace app\admin\model;
use think\Model;
use third\Data;

class Base extends Model{

    /**
     * 获取全部数据
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序方式
     * @return array         结构数据
     */
    public function getTree($type='tree',$order='',$name='title',$child='id',$parent='pid'){
        // 判断是否需要排序
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order($order.' is null,'.$order)->select();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data= Data::tree($data,$name,$child,$parent);
        }elseif($type="level"){
            $data= Data::channelLevel($data,0,'&nbsp;',$child);
        }
        return $data;
    }


}