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
		$con=array();
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
		else if (!empty($_POST['qp'])&&!empty($_POST['ms']))
			$con['paper_type']=array(array('EQ','qp'),array('EQ','ms'),'or'); 
		if (!empty($_POST['subject']))
		{
			$con['subject_code']=$_POST['subject'];
			$subjects=$subjects->where(['subject_code'=>$_POST['subject']])->find();
			$result[$_POST['subject']]=$subjects;
			$yearArr=D('papers')->where($con)->group('paper_year')->getField('paper_year',true);
			foreach ($yearArr as $year) 
			{
            	$con['subject_code']=$_POST['subject'];
				$con['paper_year']=$year;
				$data=D('papers')->where($con)->field('paper_content',true)->order('paper_type desc,paper_num asc')->select();
            	if (!empty($data))
            		$result[$_POST['subject']]['years'][$year]=$data;
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
					$tmp['subject_code']=$subject;
					$tmp['paper_year']=$year;
					if(!empty($_POST['paper'])){
						$tmp['paper_num']=$_POST['paper'];
					}
					$data=D('papers')->where($tmp)->field('paper_content',true)->order('paper_type desc,paper_num asc')->select();
                	if (!empty($data))
                		$result[$subject]['years'][$year]=$data;
				}			
			}
			// if (!empty($_POST['paper']))
			// {
			// 	foreach ($result as $i=>$d)
			// 		foreach ($d['years'] as $index=>$r)
			// 			foreach ($r as $num=>$p)
			// 				if ($p['paper_num'][0]!=$_POST['paper'])  unset($result[$i]['years'][$index][$num]);
					
			// }
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
    public function catebase($page=1,$grade=null){
    	if(!isset($grade)){
    		if(!isset($_COOKIE['grade'])){
    			$grade='1';
    		}else{
    			$grade=cookie('grade');
    		}
    	}else{
    		cookie('grade',$grade,3600000);
    	}
    	$this->initialize('PapersList');
        $maxpage=ceil(D('subjects')->where(['subject_grade'=>$grade])->count()/7);
        $subjects=D('subjects')->where(['subject_grade'=>$grade])->page($page,'7')->select();
        $result=[];
        $this->assign('page',$page);
        $this->assign('maxpage',$maxpage);
        foreach ($subjects as $subject) {
            $db=D('papers');
            $where=array('subject_code'=>$subject['subject_code']);
            $yearArr=D('papers')->where($where)->group('paper_year')->getField('paper_year',true);
            $result[$subject['subject_code']]=$subject;
            foreach ($yearArr as $year) {
                $result[$subject['subject_code']]['years'][$year]=D('papers')->where(['subject_code'=>$subject['subject_code'],'paper_year'=>$year])->field('paper_content',true)->order('paper_type desc,paper_num asc')->select();
            }
        }
    	//$this->assign('subjects',$this->subjects);
        $this->assign('papers',$result);
    	$this->display('catebase');
    }
}