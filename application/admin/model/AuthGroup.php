<?php
/******************************************************************
 *  角色模型
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/23 17:51
 *+------------------------------------------------------------------
 */
namespace app\admin\model;
use think\Model;
use think\Db;

class AuthGroup extends Base{

    //自动完成
    public function setRulesAttr($value){
        return implode(',', $value);
    }
    //自动获取修改
    public function getStatusAttr($value){
        $status = [0=>'关闭',1=>'启用'];
        return $status[$value];
    }

    public function getRulesAttr($value){
        return explode(',', $value);
    }

    //插入数据
    public function add($data){
        $res = $this->save($data);
        return $res;
    }

    //修改数据
    public function edit($data,$id){
        $res = $this->save($data,['id'=>$id]);
        return $res;
    }

    // 获取所有数据
    public function getAll(){
        $info = AuthGroup::all();
       // halt($info);
       $arr = [];
       if (!empty($info)) {
           foreach($info as $v){
                $arr[] = [
                    'id'    => $v['id'],
                    'title' => $v['title'],
                    'status'=> $v->status,
                ];
            }
       }
      
        return $arr;
    }
    
	// 获取单条信息
    public function getOne($id){
        $info = AuthGroup::get($id);
        $res = [
            'id' => $info->id,
            'title' => $info->title,
            'status' => $info->data['status'],
            'rules' => $info->rules,
        ];
        return $res;
    }
}