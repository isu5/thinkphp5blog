<?php
/******************************************************************
 *  登录控制器
 * +-----------------------------------------------------------------
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
use think\Validate;

class Login extends controller{

    //登录
    public function index(){
        if (request()->isPost()) {
            $username = input('username');
            $password = input('password');
            //验证规则
            $data = ['username'=>$username,'password'=>$password];
            $validate = validate('Login');
            if(!$validate->scene('login')->check($data)){
                $this->error($validate->getError());
            }
            //判断用户名密码
            $res = db('admin')->where('username',$data['username'])->find();
            //halt($res);
            if(!$res) $this->error('用户名不存在');
            if($res['password'] != createPassword($password, $res['encrypt'])) $this->error('密码错误');
            //判断验证码
            if(captcha_check(input('captcha'))){
                session(config('AUTH_KEY') , $res['id']);
                session('fadminusername', $username);
                session('fadminlasttime', $res['lasttime']);
                session('fadminlastip', $res['lastip']);
                session('fadminlogintime', request()->time());
                db('admin')->where('username', $data['username'])->update(['lastip' => request()->ip(), 'lasttime' => request()->time()]);

                $this->success('登录成功','Index/index');
            }else{

                $this->error('验证码错误');
            }

        }
        return view();
    }

    //退出登录
    public function logout(){
        session(config('AUTH_KEY'), null);
        session('fadminusername', null);
        session('fadminlasttime', null);
        session('fadminlogintime', null);
        session('fadminlastip', null);
        $this->success('退出成功', 'Login/index');
    }



}
