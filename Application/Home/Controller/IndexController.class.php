<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
    	if(isset($_COOKIE['grade'])){
    		redirect(U('list/catebase'));
    	}
    	$this->initialize('MyPapers');
    	$this->display();
    }
}