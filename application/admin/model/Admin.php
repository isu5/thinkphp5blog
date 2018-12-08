<?php
/******************************************************************
 *  管理模型
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/20 11:48
 *+------------------------------------------------------------------
 */

namespace app\admin\model;
use think\Model;
use think\Db;
class Admin extends Base{

    // 关联
    public function profile(){
        return $this->hasOne('AuthGroupAccess','uid')->bind('group_id');
    }

    //添加数据
    public function add($data){
        db()->startTrans();  //事务

        $map1 = $this->setAdminArr($data);

        $res1 = $this->insertGetId($map1);

        $map2 = $this->setAuthGroupAccessArr($res1,$data['group_id']);
        //halt($map2);
        $res2 = db('AuthGroupAccess')->insert($map2);

        if($res1 && $res2){
            //提交事务
            db()->commit();
            return true;
        }else{
            //回滚事务
            db()->rollback();
            return false;
        }


    }
    //获取单条
    public function getOne($id){
        $data = Admin::get($id , 'profile');
        $info = [
            'id'        => $data->id,
            'username'  => $data->username,
            'aid'       => $data->group_id
        ];
        return $info;

    }
    //修改管理员
    public function edit($data,$id){
        $info = Admin::get($id);
        $info->data = $this->setAdminArr($data);
	unset($info->data['addtime']);
        $info->data['id'] = $id;
        $info->profile->data = ['group_id'=>$data['group_id']];
        $res = $info->together('profile')->save();
        return $res;

    }
    //删除管理员
    public function del($id){
        $info = Admin::get($id);
        $res = $info->together('profile')->delete();
        return $res;
    }

    //修改密码
    public function editPwd($pwd){
        $info = createPassword($pwd);
        $res = $this->where('id',session(config('AUTH_KEY')))->update($info);
        return $res;
    }



    // 组合会员数据
    protected function setAdminArr($data){
        $a = createPassword($data['password']);

        $arr = [
            'username'	=>	$data['username'],
            'password'	=>	$a['password'],
            'lasttime'	=>	time(),
            'lastip'	=>	request()->ip(),
            'encrypt'	=>	$a['encrypt'],
	    'addtime'	=>	time(),
        ];

        return $arr;
    }

    // 组合权限组数据
    protected function setAuthGroupAccessArr($uid , $gid){
        $arr = [
            'uid'		=>	$uid,
            'group_id'	=>	$gid,
        ];

        return $arr;
    }


}