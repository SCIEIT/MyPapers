<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends BaseController {
    public function index(){
    	$this->catebase();
    }
	public function search(){
    	//根据正则表达式搜索匹配的paper.....holems你补上吧我要开始收拾行李了。。。。
    }
    public function catebase(){
    	$this->initialize('PapersList');
    	$subjects=D('subjects');
    	$this->assign('subjects',$subjects->select());
        $this->assign('papers',$this->getCatPapers());
    	$this->display('catebase');
    }
    private function getCatPapers(){
        $subjectArr=D('subjects')->getField('subject_code',true);
        foreach ($subjectArr as $subject) {
            $result[$subject]=D('papers')->where(['subject_code'=>$subject])->select();
        }
        return $result;
    }
}