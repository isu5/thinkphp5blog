<?php
/**
* 权限认证
* @return  boolean true-有权限，false-没有权限
*/
 
function Is_Auth($Auth_Rule){
	$Auth = new \third\Auth();	//实例化权限认证类
	$AUTH_KEY = session( config('AUTH_KEY') );	//获取用户登录ID
	//判断当前认证key是否不在 超级管理组配置中,或者当前模块是否为非认证模块
	if(!is_admin($AUTH_KEY)){
		if(!$Auth->check($Auth_Rule , $AUTH_KEY)){
			return false;
		}else{
			return true;
		}
	}else{
		return true;
	}
}

/**
 * 检测当前用户是否为超级管理员
 * @return boolean true-管理员，false-非管理员
 */

function is_admin($uid = null){
	$uid = is_null($uid) ? is_login() : $uid;
	if(in_array($uid , config('AUTH_ADMIN'))){
		return true;
	}else{
		return false;
	}
}
?>