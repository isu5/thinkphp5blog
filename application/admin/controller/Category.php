<?php
/**
 * 栏目管理
 */
namespace app\admin\controller;
use think\Validate;
class Category extends Base{

	public function _initialize(){
		parent::_initialize();
		$this->cate = model('Category');
	}

	//栏目列表
	public function index(){
		$data = $this->cate->catelist();
		
		$this->assign([
			'data' => $data,
			
			]);
		return view();
	}

	/**
	 * [add 添加]
	 */
	public function add(){
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('Category');
			if(!$validate->check($data)) $this->error($validate->getError());
			$res = $this->cate->add($data);
			$res ? $this->success('添加成功!','Category/index') : $this->error('添加失败');
		}
		return view();
	}

	/**
	 * [edit 编辑栏目]
	 * @return [type] [description]
	 */
	public function edit(){
		$id = input('param.id');
		if (request()->isPost()) {
			$data = input('post.');
			$validate = validate('Category');
			if(!$validate->check($data)) $this->error($validate->getError());
			
			$res = $this->cate->edit($data , $id);
			$res?$this->success('修改成功' , 'User/index'):$this->error('修改失败！');

		}
		if(!$id) $this->error('参数错误！');
		$info = $this->cate->getOne($id);
		//halt($info);
		$this->assign('info',$info);
		return view();
	
	}
	
	//删除
	public function del(){
		$id = input('param.id');
		if(!$id){
			$this->error('参数错误！');
		}
		$res = $this->cate->del($id);
		$res ? $this->success('删除成功！','Category/index'):$this->error('删除失败');
	}
	

}