<?php
/******************************************************************
 *  权限节点模型
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/30 17:58
 *+------------------------------------------------------------------
 */
namespace app\admin\model;
use think\Model;

class AuthRule extends Base{

    //节点浏览
    public function getRules(){
        $where = ['status'=>1];
        $info = AuthRule::all($where);
        foreach ($info as $v) {
            $arr[] = [
                'id'    => $v['id'],
                'pid'   => $v['pid'],
                'title' => $v['title'],
            ];
        }
        $info = $this->subtree($arr);
        return $info;
    }

    // 获取栏目
    public function getColumn($where){
        $info = AuthRule::all($where);
        $arr = [];
        foreach($info as $v){
            $arr[] =  [
                'id' 		=> $v['id'],
                'pid' 		=> $v['pid'],
                'title' 	=> $v['title'],
                'name'		=> $v['name'],
                'condition'	=> $v['condition'],
                'icon'		=> $v['icon'],
                'level'		=> $v['level'],
            ];
        }

        $info = $this->subtree($arr);
        array_shift($info);

        return $info;
    }

    //一棵树形成一个数组
    function subtree($arr=[],$id=0,$lev=1){
        $subs=array();//存放子孙数组
        if(is_array($arr)){
            foreach($arr as $v){
                if($v['pid']==$id){
                    $v['lev']=$lev;
                    $v['cate']=$this->subtree($arr,$v['id'],$lev+1 );
                    $subs[]=$v;
                }
            }
        }

        return $subs;
    }

}