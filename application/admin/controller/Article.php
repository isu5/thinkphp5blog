<?php
namespace app\admin\controller;
use think\Validate;
class Article extends Base{
	
	//
	public function _initialize(){
		parent::_initialize();
		$this->art = model('Article');
	}
	//列表页
	public function index(){
		$data = $this->art->artlist();
	}
	
}