<?php
/******************************************************************
 *  管理员权限
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

use think\Validate;
use third\Tree;

class Admin extends Base{

	//
	public function _initialize(){
		parent::_initialize();
		$this->admin = model('Admin');
		$this->ag = model('AuthGroup');
		$this->aga = model('AuthGroupAccess');
		$this->ar = model('AuthRule');
	}

	//用户列表
	public function index(){
		$field = ['a.id' , 'a.username' , 'a.lastip' , 'a.lasttime' , 'a.addtime' , 'c.title'];
		$join = [
			['tp5_auth_group_access b' , 'b.uid = a.id'],
			['tp5_auth_group c' , 'c.id = b.group_id']
		];

		$list =  db('Admin')->alias('a')->field($field)->join($join)->paginate(10);
		$this->assign('list' , $list);
		
		return view();
	}

	//管理员添加
	public function add(){
		if(request()->isPost()){
			$data= input('post.');

			$validate = validate('Admin');
			if(!$validate->check($data)) $this->error($validate->getError());
			
			$res = $this->admin->add($data);
			$res?$this->success('管理员添加成功' , 'Admin/index'):$this->error('管理员添加失败！');
			exit;
		}

		$info = $this->ag->getAll();
		//print_r($info);
		$this->assign('info' , $info);
		return view();
	}

	//管理员修改
	public function edit(){
	
		if(request()->isPost()){

			$data = input('post.');
			//halt($data);
			$validate = validate('Admin');
			if(!$validate->check($data)) $this->error($validate->getError());
		
			$res = $this->admin->edit($data,$id);
			$res ? $this->success('管理员修改成功','Admin/index') : $this->error('修改失败');
			exit;
		}

		$id = input('param.id');
		if (!$id) {
			$this-error('参数错误');
		}

		$list = $this->ag->getAll();
		$info = $this->admin->getOne($id);
		//print_r($info);die;
		$this->assign([
			'list' => $list,
			'info' => $info
		]);
		return view();
	}

	//管理员删除

	public function del(){
		$id = input('param.id' , 0);
		if(!$id) $this->error('参数不正确');
		if($id == 1) $this->error('超级管理员不可删除');

		$res = $this->admin->del($id);
		$res?$this->success('数据删除成功'):$this->error('数据删除失败');
	}

	//角色列表
	public function role(){
		$info = $this->ag->getAll();
		//print_r($info);
		$this->assign('info' , $info);
		
		return view();
	}

	//添加角色
	public function role_add(){
		if(request()->isPost()){
			$data = input('post.');
			//halt($data);
			$validate = validate('AuthGroup');
			if (!$validate->check($data)) {
				$this->error($validate->getError());
			}
			$res = $this->ag->add($data);
			$res?$this->success('角色添加成功' , 'Admin/role'):$this->error('角色添加失败');
			exit;
		}
		//获取所有节点
		$AuthRule = $this->ar->getRules();
		//halt($AuthRule);
		$this->assign('AuthRule',$AuthRule);

		return view();
	}

	//编辑角色
	public function role_edit(){
        $id = input('param.id',0);
        if(request()->isPost()){

            $data = input('post.');
            //halt($data);
            $validate = validate('AuthGroup');
            if(!$validate->check($data)) $this->error($validate->getError());

            $res = $this->ag->edit($data,$id);
            $res ? $this->success('角色修改成功','Admin/index') : $this->error('修改失败');
            exit;
        }
        if (!$id) $this->error('参数不正确');
        $info = model('AuthGroup')->getOne($id);
        $this->assign('info' , $info);

        // 获取所有节点
        $AuthRule = model('AuthRule')->getRules();
        $this->assign('AuthRule' , $AuthRule);
		return view();
	}

	//删除角色
	public function role_del(){
        $id = input('param.id',0);
        if(!$id) $this->error('参数不正确');
        if($id == 1) $this->error('超级管理员权限不能删除！');
        $res = db('AuthGroup')->delete($id);
        $res?$this->success('删除成功'):$this->error('删除失败');

	}

	//节点列表
	public function node(){
		$this->getAuthRule();
		return view();
	}

	//添加权限节点
	public function node_add(){

		if(request()->isPost()){
			$data = input('post.');
			$validate =  validate('Node');
			if(!$validate->check($data)) $this->error($validate->getError());
			$res = db('AuthRule')->insert($data);
			$res?$this->success('添加成功' , 'Admin/node'):$this->error('添加失败！');

		}
		$this->getSelect();
		return view();
	}

	//编辑权限节点
	public function node_edit(){
		if(request()->isPost()){
			$data = input('post.');

			$validate = validate('Node');
			if(!$validate->check($data)) $this->error($validate->getError());

			$res = db('AuthRule')->where('id' , $data['id'])->update($data);
			$res?$this->success('修改成功' , 'Admin/node'):$this->error('修改失败！');
		}
		$id = input('param.id',0);
		if(!$id){
			$this->error('参数错误');
		}
		//单个信息
		$info = db('AuthRule')->find($id);
		$this->getSelect();
		
		//print_r($data);
		$this->assign('info',$info);
		return view();
	}

	//删除节点
	public function node_del(){
		$id = input('param.id' , 0);
		if(!$id) $this->error('参数不正确');
		$pro = db('AuthRule')->where('pid='.$id)->count();
		//print_r($pro);
		if($pro){
			$this->error('该权限还有子权限，无法删除');
		}
		
		$res = db('AuthRule')->delete($id);
		$res?$this->success('数据删除成功'):$this->error('数据删除失败');

	}

	//获取节点列表
	public function getAuthRule(){
		$info = db('AuthRule')->select();
		//halt($info);
		foreach ($info as $v) {
			$arr[] = [
				'id'		=>	$v['id'],
				'pid'		=>	$v['pid'],
				'name'		=>	$v['name'],
				'title'		=>	$v['title'],
				'level'		=>	$v['level'] == 1?'项目':($v['level'] == 2?'模块':'操作'),
				'condition'	=>	$v['condition'] == 1?'是':'否',
				'status'	=>	$v['status'] == 1?'开启':'关闭',
				'icon'		=>	"<i class='fa ".$v['icon']."'></i>",
				'sort'		=>	$v['sort'],
				'add'		=>	$v['id']==1?"<a href='javascript:void()'><i class='fa fa-plus'></i> 添加子节点</a>":"<a href=".url('Admin/node_add' , array('pid'=>$v['id']))."><i class='fa fa-plus'></i> 添加子节点</a>",
				'edit'		=>	$v['id']==1?"<a href='javascript:void()'><i class='fa fa-pencil'></i> 编辑</a>":"<a href=".url('Admin/node_edit' , array('id'=>$v['id'],'pid'=>$v['pid']))."><i class='fa fa-pencil'></i> 编辑</a>",
				'del'		=>	$v['id']==1?"<a href='javascript:void()'><i class='fa fa-trash-o'></i> 删除</a>":"<a href='javascript:dels(".$v['id'].");'><i class='fa fa-trash-o'></i> 删除</a>",
			

			];
		}

		$str  = "<tr class='tr'>
				    <td>\$spacer \$title</td>
				    <td>\$name</td>
				    <td>\$level</td>
				    <td>\$status</td>
				    <td>\$condition</td>
				    <td>\$icon</td>
				    <td>\$sort</td>
				    <td>\$add &nbsp;&nbsp; \$edit &nbsp;&nbsp; \$del</td>
				</tr>";
		
		$Tree = new Tree();
		$Tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $Tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $Tree->init($arr);
        $html_tree = $Tree->get_tree(0, $str);
		$this->assign('html_tree',$html_tree);


	}
	//获取所有节点
	public function getSelect(){
		$info = db('authRule')->field('id,pid,title')->select();
		$pid = input('param.pid' , 0); //选择子菜单
		 
		foreach($info as $v) {
            $arr[$v['id']] = [
				'id'	=>	$v['id'],
				'pid'	=>	$v['pid'],
				'title'	=>	$v['title']
			];
        }
		
		$str  = "<option value='\$id' \$selected>\$spacer \$title</option>";
        $Tree = new Tree();
        $Tree->init($arr);
        $select_categorys = $Tree->get_tree(0, $str , $pid);
        $this->assign('select_categorys' , $select_categorys);
	}

	// 清楚缓存
	public function cache(){
		$path = RUNTIME_PATH;
		delDir($path);
		$this->success('清除缓存成功');
	}
}