<?php
/******************************************************************
 *  基础公共控制器
 * * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/20 11:01
 *+------------------------------------------------------------------
 */
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Loader;
use think\Db;

class Base extends controller{
	//初始化
	protected function _initialize(){

		if(!session(config('AUTH_KEY')) || !session('fadminusername') || request()->time() - session('fadminlogintime') > 2 * 60 * 60){
			$this->redirect('Login/index');
			exit;

		}

		$AUTH_KEY = session( config('AUTH_KEY') );

		//判断认证key如果小于1 或 Admin模块登录Key不为1，跳转到后台登录网关
		if($AUTH_KEY < 1){
			$this->redirect(config('AUTH_USER_GATEWAY'));
		}else{
			//判断当前认证key是否不在 超级管理组配置中,或者当前模块是否为非认
			$request = Request::instance();
			$Auth_Rule = $request->controller() . '/' . $request->action();
			if(!Is_Auth($Auth_Rule)) $this->error('你没有权限进行' . $Auth_Rule . ' 操作！');
		}

		//左边栏目
		$this->getColumn(session(config('AUTH_KEY')));  //  获取栏目
		 

	}


	// 获取栏目
	public function getColumn($key){
		$where = ['status'=>1];
		if($key > 1){
			$id = model('AuthGroupAccess')->getRules($key);
			$where['id'] = ['in' , $id];
		}
		$info = model('AuthRule')->getColumn($where);
		
		$this->assign('column' , $info);

	}

}