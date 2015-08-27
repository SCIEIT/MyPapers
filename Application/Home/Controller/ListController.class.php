<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends BaseController {
    public function index(){
    	$this->catebase();
    }
	public function search(){
		ini_set("memory_limit","-1");
		if(empty($_POST['year'])&&empty($_POST['paper'])&&empty($_POST['summer'])&&empty($_POST['qp'])&&empty($_POST['winter'])&&empty($_POST['subject'])&&empty($_POST['ms'])){
			$this->catebase();
			exit();
		}
    	$this->initialize('PapersList');
		$subjects=D('subjects');
		if (!empty($_POST['year']))
			$con['paper_year']=$_POST['year'];
		if (!empty($_POST['summer'])&&empty($_POST['winter']))
			$con['paper_month']='s';
		else if (empty($_POST['summer'])&&!empty($_POST['winter']))
			$con['paper_month']='w';
	    if (!empty($_POST['qp'])&&empty($_POST['ms']))
			$con['paper_type']='qp';
		else if (empty($_POST['qp'])&&!empty($_POST['ms']))
			$con['paper_type']='ms'; 
		if (!empty($_POST['subject']))
		{
			$con['subject_code']=$_POST['subject'];
			$subjects=$subjects->where(['subject_code'=>$_POST['subject']])->select();
			foreach ($subjects as $subject)
			{
				$result[$_POST['subject']]=$subject;
				$yearArr=D('papers')->where($con)->group('paper_year')->getField('paper_year',true);
				foreach ($yearArr as $year) 
				{
                	$con['suject_code']=$suject['subject_code'];
					$con['paper_year']=$year;
					$data=D('papers')->where($con)->select();
                	if (!empty($data))
                		$result[$subject['subject_code']]['years'][$year]=$data;
				}
			}
			if (!empty($_POST['paper']))
			{
				foreach ($result[$_POST['subject']]['years'] as $index=>$r)
				{
					foreach ($r as $num=>$p)
					{
						if ($p['paper_num'][0]!=$_POST['paper'])  unset($result[$_POST['subject']]['years'][$index][$num]);
					}
				}
			}
		}
		else 
		{
			$subjects=D('papers')->where($con)->group('subject_code')->getField('subject_code',true);
			foreach ($subjects as $subject)
			{
				$result[$subject]=D('subjects')->find($subject);
				$yearArr=D('papers')->where($con)->where(['subject_code'=>$subject])->group('paper_year')->getField('paper_year',true);
				$tmp=$con;
				foreach ($yearArr as $year) 
				{
					$tmp['suject_code']=$subject;
					$tmp['paper_year']=$year;
					$data=D('papers')->where($tmp)->select();
                	if (!empty($data))
                		$result[$subject]['years'][$year]=$data;
				}			
			}
			if (!empty($_POST['paper']))
			{
				foreach ($result as $i=>$d)
					foreach ($d['years'] as $index=>$r)
						foreach ($r as $num=>$p)
							if ($p['paper_num'][0]!=$_POST['paper'])  unset($result[$i]['years'][$index][$num]);
					
			}
		}
		$found=false;
		foreach ($result as $index=>$r){
		  	foreach ($r['years'] as $i=>$data)
			{
				if (!empty($data)) 
					$found=true;
				else {
					unset($result[$index]['years'][$i]);
				}
			}
			if(empty($r['years'])){
				unset($result[$index]);
			}
		}
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