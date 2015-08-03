<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends BaseController {
    public function index(){
    	$this->catebase();
    }
    public function catebase(){
    	$this->initialize('PapersList');
        $this->getThings();
    	//$this->assign('subjects',$this->subjects);
        $this->assign('papers',$this->result);
    	$this->display('catebase');
    }
    private function getThings(){
        $db=D('subjects');
        $subjects=$db->select();
        foreach ($subjects as $subject) {
            $db=D('papers');
            $where=array('subject_code'=>$subject['subject_code']);
            $yearArr=D('papers')->where($where)->group('paper_year')->getField('paper_year',true);
            $result[$subject['subject_code']]=$subject;
            foreach ($yearArr as $year) {
                $result[$subject['subject_code']]['years'][$year]=D('papers')->where(['subject_code'=>$subject['subject_code'],'paper_year'=>$year])->select();
            }
        }
        //$this->subjects=$subjects;
        $this->result=$result;
    }
}