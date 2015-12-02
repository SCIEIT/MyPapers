<?php
namespace Home\Controller;
use Think\Controller;
class AdvancedsearchController extends BaseController {
    public function index(){
    	$this->initialize('Advanced Search Beta');
    	$this->display();
    }
	public function search(){
		$this->initialize('Advanced Search');
		ini_set("memory_limit","-1");
		if(empty($_POST['subject'])||empty($_POST['keywords'])){
			redirect(U('Advancedsearch/index'));
		}
		$con=array();
		$keyArr=preg_split('/;/', I('post.keywords'));
		if(count($keyArr)>=1&&!empty($keyArr)){
			foreach ($keyArr as $key=>$value) {
				if(empty($value)){
					unset($keyArr[$key]);
				}else{
					$keyArr[$key]='%'.$value.'%';
				}
			}
			$con['paper_content']=array('like',$keyArr,'AND');
		}else{
			redirect(U('Advancedsearch/index'));
		}
		if (!empty($_POST['year']))
			$con['paper_year']=$_POST['year'];
		if (!empty($_POST['paper']))
			$con['paper_num']=array('like',$_POST['paper'].'%');
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
		$con['subject_code']=$_POST['subject'];
		if(D('papers')->where($con)->count()<=10){
			$result=D('papers')->where($con)->order('paper_type desc,paper_num asc')->select();
			$this->assign('con',true);
			foreach ($result as $key => $paper) {
				$arr=[];
				foreach ($keyArr as $keyword) {
					$keyword=substr($keyword, 1,strlen($keyword)-2);
					$pos=-1;
					while($pos=stripos($paper['paper_content'],$keyword,$pos+1)){
						$arr[]=preg_replace('/\n/','<br/>',str_ireplace($keyword,'<strong class="red-text">'.$keyword.'</strong>',substr($paper['paper_content'], max($pos-250,0), 500)));

					}
				}
				$result[$key]['modified_content']=$arr;
			}
		}else{
			$result=D('papers')->where($con)->field('paper_content',true)->order('paper_type desc,paper_num asc')->select();
			$this->assign('con',false);
		}
		$this->assign('result',$result);
		// $subjects=D('papers')->where(['subject_code'=>$_POST['subject']])->field('paper_content',true)->find();
		// $result[$_POST['subject']]=$subjects;
		// $yearArr=D('papers')->where($con)->group('paper_year')->getField('paper_year',true);
		// foreach ($yearArr as $year) 
		// {
  //       	$con['subject_code']=$_POST['subject'];
		// 	$con['paper_year']=$year;
		// 	$data=D('papers')->where($con)->field('paper_content',true)->order('paper_type desc,paper_num asc')->select();
  //       	if (!empty($data))
  //       		$result[$_POST['subject']]['years'][$year]=$data;
		// }
		// if (!empty($_POST['paper']))
		// {
		// 	foreach ($result[$_POST['subject']]['years'] as $index=>$r)
		// 	{
		// 		foreach ($r as $num=>$p)
		// 		{
		// 			if ($p['paper_num'][0]!=$_POST['paper'])  unset($result[$_POST['subject']]['years'][$index][$num]);
		// 		}
		// 	}
		// }
		// $found=false;
		// foreach ($result as $index=>$r){
		//   	foreach ($r['years'] as $i=>$data)
		// 	{
		// 		if (!empty($data)) 
		// 			$found=true;
		// 		else {
		// 			unset($result[$index]['years'][$i]);
		// 		}
		// 	}
		// 	if(empty($r['years'])){
		// 		unset($result[$index]);
		// 	}
		// }
		// if ($found)
  //       	$this->assign('papers',$result);
		// else 
		// 	$this->assign('papers',null);
		$this->display('index');
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
                $result[$subject['subject_code']]['years'][$year]=D('papers')->where(['subject_code'=>$subject['subject_code'],'paper_year'=>$year])->order('paper_type desc,paper_num asc')->select();
            }
        }
        //$this->subjects=$subjects;
        $this->result=$result;
    }
}