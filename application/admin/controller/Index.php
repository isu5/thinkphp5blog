<?php
/******************************************************************
 *  后台首页
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/20 14:26
 *+------------------------------------------------------------------
 */
namespace app\admin\controller;
use think\controller;
use third\Log;

class Index extends Base{

    public function index(){
        //halt(session(config('AUTH_KEY')));


        return view();
    }

}