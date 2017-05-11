<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loading extends CI_Controller {
	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("qbank_model");
	   $this->lang->load('basic', $this->config->item('language'));
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
	 }

	public function load_chapter_for_question_1(){
		$results = $this->qbank_model->chapter_list_load();
		$subject_list = '<select name="chapter_id" id="chapter_id" class="form-control" onchange="load_lesson()"><option value="">Select</option>';
		foreach($results as $subject){
			$subject_list .='<option value="'.$subject['id'].'">'.$subject['chapter_name'].'</option>';
		}
		echo $subject_list .='</select>';
	}
	
	public function load_lession_for_question_1(){
		$results = $this->qbank_model->load_lession_for_question_1();
		if(count($results)>0){
		$subject_list = '<select name="lession_id" id="lession_id" class="form-control" ><option value="">Select</option>';
		foreach($results as $subject){
			$subject_list .='<option value="'.$subject['id'].'">'.$subject['lession_name'].'</option>';
		}
		echo $subject_list .='</select>';
		}else{ echo 'No results found';}
	}
	
	public function load_subject_only(){
	$results = $this->qbank_model->subject_list();
	$subject_list = '<select name="subject_id" id="subject_id" class="form-control" ><option value="">Select</option>';
	foreach($results as $subject){
		$subject_list .='<option value="'.$subject['cid'].'">'.$subject['category_name'].'</option>';
	}
	echo $subject_list .='</select>';
}


public function load_subject(){
	$results = $this->qbank_model->subject_list();
	$subject_list = '<select name="subject_id" id="subject_id" onchange="load_chapter()"  class="form-control" ><option value="">Select</option>';
	foreach($results as $subject){
		$subject_list .='<option value="'.$subject['cid'].'">'.$subject['category_name'].'</option>';
	}
	echo $subject_list .='</select>';
}

public function load_chapter(){
	$results = $this->qbank_model->chapter_list_load();
	$subject_list = '<select name="chapter_id" id="chapter_id" class="form-control" ><option value="">Select</option>';
	foreach($results as $subject){
		$subject_list .='<option value="'.$subject['id'].'">'.$subject['chapter_name'].'</option>';
	}
	echo $subject_list .='</select> &nbsp; &nbsp; &nbsp; Or  &nbsp; &nbsp; &nbsp; <input type="text"   class="form-control"   name="chapter_name" value="" placeholder=""  >';
}


public function load_subject1(){
	$results = $this->qbank_model->subject_list();
	//echo $this->db->last_query();
	$subject_list = '<select name="subject_id1" id="subject_id1" onchange="load_chapter1()"  ><option value="">Select</option>';
	foreach($results as $subject){
		$subject_list .='<option value="'.$subject['cid'].'">'.$subject['category_name'].'</option>';
	}
	echo $subject_list .='</select>';
}

public function load_chapter1(){
	$results = $this->qbank_model->chapter_list_load();
	$subject_list = '<select name="chapter_id1" id="chapter_id1"   onchange="load_lesson1()"><option value="">Select</option>';
	foreach($results as $subject){
		$subject_list .='<option value="'.$subject['id'].'">'.$subject['chapter_name'].'</option>';
	}
	echo $subject_list .='</select>';
}

public function load_lesson1(){
		$results = $this->qbank_model->load_lession_for_question_1();
		if(count($results)>0){
		$subject_list = '<select name="lession_id1" id="lession_id1" ><option value="">Select</option>';
		foreach($results as $subject){
			$subject_list .='<option value="'.$subject['id'].'">'.$subject['lession_name'].'</option>';
		}
		echo $subject_list .='</select>';
		}else{ echo 'No results found';}
	}
	
public function load_subject_for_class_content(){
	$results = $this->qbank_model->subject_list();
	$subject_list = '<select name="subject_id" id="subject_id" onchange="load_chapter()"  class="form-control" ><option value="">Select</option>';
	foreach($results as $subject){
		$subject_list .='<option value="'.$subject['cid'].'">'.$subject['category_name'].'</option>';
	}
	echo $subject_list .='</select>';
 }
 
 public function json_events(){
	
	$logged_in=$this->session->userdata('logged_in');
	$result=$this->qbank_model->content_list($limit=0,$logged_in['uid']);
	
	$arr = array();
	$inc = 0;
    foreach($result as $value){
	   $year = date('Y',strtotime($value['class_time_date']));
	   $month = date('m',strtotime($value['class_time_date']));
	   $day = date('d',strtotime($value['class_time_date']));
		$jsonArrayObject = (array('id' => $value["id"], 'title' => $value['title'].'('.$value['category_name'].')', 'start' =>"$year-$month-$day",'url' => base_url()."loading/content_details/".$value['id']));
		$arr[$inc] = $jsonArrayObject;
		$inc++;
	}
	$json_array = json_encode($arr);
	echo $json_array;
	
 }
 
 public function content_details($contentID){
	 $data['title']='Class Content Deatils';
	 $data['result']=$this->qbank_model->content_deatils($contentID);
	 
	 $this->load->view('header',$data);
	 $this->load->view('content/content_deatils',$data);
	 $this->load->view('footer',$data);
 }
 
  public function view_content($contentID){
		 
		$logged_in=$this->session->userdata('logged_in');
			
		$data['title']='Class Content Deatils';
	
			
		 
		 $data['result']=$this->qbank_model->smart_content_details($contentID);
		 
		 $this->load->view('header',$data);
		 $this->load->view('content/smart_content_deatils',$data);
		 $this->load->view('footer',$data);
 }
 
 public function check_student(){
	 $class_id = $this->input->post('class_id');
	 $year = $this->input->post('year');
	 $class_section_id = $this->input->post('class_section_id');
	 $roll_no = $this->input->post('roll_no');
	 $class_group = $this->input->post('class_group');
	 $gid = $this->input->post('gid');
	 $sql = "SELECT * FROM `savsoft_users` AS su
			INNER JOIN `savsoft_student_profile` AS ssp ON ssp.`user_id`=su.`uid`
			WHERE ssp.`academic_year`= '$year' AND ssp.`class_id` = '$class_id' AND ssp.`class_section_id` = '$class_section_id' AND 		
			ssp.`class_group`= '$class_group' AND ssp.`roll_no` = '$roll_no' and su.`gid`= '$gid' and ssp.status='1'";
	 $query = $this->db->query($sql);
	  //$query = $this->db->get();
	  $result = $query->row_array();
	 // echo $this->db->last_query();
	 if($query->num_rows()>0){
	  echo $result['first_name'].' '.$result['last_name'];
	  echo '<input type="hidden" name="student_id" id="student_id" value="'.$result['user_id'].'">';
	 }else{
		 echo 'No Student Found';
	 }
	 
 }	
}
?>