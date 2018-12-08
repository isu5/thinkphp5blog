<?php

namespace app\admin\model;

class Category extends Base{
	
	//列表
	public function catelist(){
		/*$data['list'] = $this->order('id desc')->paginate(config('PAGE_COUNT') , false , ['query'=>request()->param()]);
        //halt($this->getLastSql());
        //$data['page'] = $data['list']->render();
        //return $data;
        $data['page'] = [
            'render'    =>  $data['list']->render(),
            'lastPage'  =>  $data['list']->lastPage(),
            'total'     =>  $data['list']->total(),
        ];*/
        $where = [];
        $list = Category::all(function($query) use($where){
             $query->where($where)->order('id' , 'desc');
         });
        
        return $list;
	}

    //获取单条数据
    public function getOne($id){
        return Category::get($id);
    }
	//添加
	public function add($data){
		return Category::create($data);
	}
	// 修改
    public function edit($id , $data){
        return Category::where('id' , $id)->update($data);
    }

    //删除
    public function del($id){
        return Category::where(['id' => ['in' , $id]])->delete();
   
    }
}