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
			$subjects=$subjects->where(['subject_code'=>$_GET['subject']])->select();
			foreach ($subjects as $subject)
			{
				$result[$_GET['subject']]=$subject;
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
			if (!empty($_GET['paper']))
			{
				foreach ($result[$_GET['subject']]['years'] as $index=>$r)
				{
					foreach ($r as $num=>$p)
					{
						if ($p['paper_num'][0]!=$_GET['paper'])  unset($result[$_GET['subject']]['years'][$index][$num]);
					}
				}
			}
		}
		else 
		{
			$subjects=$subjects->select();
			foreach ($subjects as $subject)
			{
				$result[$subject['subject_code']]=$subject;
				$yearArr=D('papers')->where($con)->where(['subject_code'=>$subject['subject_code']])->group('paper_year')->getField('paper_year',true);
				
				foreach ($yearArr as $year) 
				{
					$con['suject_code']=$suject['subject_code'];
					$con['paper_year']=$year;
					$data=D('papers')->where($con)->select();
                	if (!empty($data))
                		$result[$subject['subject_code']]['years'][$year]=$data;
				}			
			}
			if (!empty($_GET['paper']))
			{
				foreach ($result as $i=>$d)
					foreach ($d['years'] as $index=>$r)
						foreach ($r as $num=>$p)
							if ($p['paper_num'][0]!=$_GET['paper'])  unset($result[$i]['years'][$index][$num]);
					
			}
		}
		$found=false;
		foreach ($result as $index=>$r)
		  	foreach ($r['years'] as $i=>$data)
			{
				if (!empty($data)) 
					$found=true;
				else {
					unset($result[$index]['years'][$i]);
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
		var_dump($this->result);
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