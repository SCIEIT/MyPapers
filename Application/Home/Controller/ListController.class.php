<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends BaseController {
    public function index(){
    	$this->catebase();
    }
	public function search(){
    	$this->initialize('PapersList');
		$subjects=D('subjects');
		if (!empty($_GET['year']))
			$con['paper_year']=$_GET['year'];
		if (!empty($_GET['paper']))
			$con['paper_num']=$_GET['paper'];
		if (!empty($_GET['summer'])&&empty($_GET['winter']))
			$con['paper_month']='s';
		else if (empty($_GET['summer'])&&!empty($_GET['winter']))
			$con['paper_month']='w';
	    if (!empty($_GET['qp'])&&empty($_GET['ms']))
			$con['paper_type']='qp';
		else if (empty($_GET['qp'])&&!empty($_GET['ms']))
			$con['paper_type']='ms'; 
		if (!empty($_GET['subject']))
		{
			$con['subject_code']=$_GET['subject'];
			$this->assign('subjects',$subjects->where(['subject_code'=>$_GET['subject']])->select());
			$result[$_GET['subject']]=D('papers')->where($con)->select();
		}
		else 
		{
			$this->assign('subjects',$subjects->select());
			$subjectArr=D('subjects')->getField('subject_code',true);
        	foreach ($subjectArr as $subject) 
            	$result[$subject]=D('papers')->where($con)->where(['subject_code'=>$subject])->select();
		}
		$found=false;
		foreach ($result as $r)
			if (!empty($r)) $found=true;
		if ($found)
        	$this->assign('papers',$result);
		else 
			$this->assign('papers',null);
    	$this->display('catebase');
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