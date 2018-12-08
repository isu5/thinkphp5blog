<?php
/******************************************************************
 *  节点模型
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

class AuthGroupAccess extends Base{
	// 关联
	public function profile(){
		return $this->hasOne('AuthGroup');
	}
	
	public function admin(){
		return $this->belongsTo('Admin' , 'uid');
	}
	
	// 获取权限节点
	public function getRules($uid){
		$where = ['a.uid'=>$uid];
		$join = [['tp5_auth_group b' , 'b.id = a.group_id']];
		$rules = db('AuthGroupAccess')->alias('a')->where($where)->join($join)->value('b.rules');
		
		return $rules;
	}
}
?>