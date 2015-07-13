<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends BaseController {
    public function index(){
    	$this->catebase();
    }
    public function catebase(){
    	$Data=M('subjects');
    	$subjects=D('subjects');
    	$this->assign('subjects',$subjects->select());
    	$this->display('catebase');
    }
}