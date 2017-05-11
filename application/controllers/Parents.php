<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parents extends CI_Controller {
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
	public function index(){
		$data['title']='Parent Dashboard';
		$logged_in=$this->session->userdata('logged_in');
	    $sql = "SELECT *,
					(select class_name from savsoft_class where id=ssp.class_id) as class_name,
					(select section_name from savsoft_class_section where id=ssp.class_section_id) as section_name,
					(select group_name from savsoft_class_group where group_name=ssp.class_group) as group_name
					 FROM `savsoft_parents_info` AS spi
					 INNER JOIN `savsoft_users` AS su ON su.`uid`=spi.`student_id`
					 INNER JOIN `savsoft_student_profile` AS ssp ON ssp.`user_id`=spi.`student_id`
					 WHERE spi.`user_id`='$logged_in[uid]' AND ssp.`is_current_year`='1'";
		$query = $this->db->query($sql);
		$data['student'] = $query->row_array();
		$data['subjectList'] = $this->qbank_model->get_subject_by_class_id($data['student']['class_id']);
		//$data['subjectList'] = $this->db->where('class_id',$data['student']['class_id'])->get('savsoft_category')->result_array();
		$this->load->view('header',$data);
		$this->load->view('parent/dashboard',$data);
		$this->load->view('footer',$data);
	}
	
	public function message($teacherID,$studentID,$subjectID){
		$data['title']='Send Message';
		$logged_in=$this->session->userdata('logged_in');
		$data['teacherInfo'] = $this->qbank_model->get_teacher_information($teacherID);
		$data['subjectInfo'] = $this->qbank_model->get_subject_information($subjectID);
		
	
		
		
		 $sql = "SELECT *,
					(select class_name from savsoft_class where id=ssp.class_id) as class_name,
					(select section_name from savsoft_class_section where id=ssp.class_section_id) as section_name,
					(select group_name from savsoft_class_group where group_name=ssp.class_group) as group_name
					 FROM `savsoft_parents_info` AS spi
					 INNER JOIN `savsoft_users` AS su ON su.`uid`=spi.`student_id`
					 INNER JOIN `savsoft_student_profile` AS ssp ON ssp.`user_id`=spi.`student_id`
					 WHERE spi.`user_id`='$logged_in[uid]' AND ssp.`is_current_year`='1'";
		$query = $this->db->query($sql);
		$data['student'] = $query->row_array();
		
		//$data['subjectInfo'] = $this->db->where('cid',$subjectID)->get('savsoft_category')->row_array();
		$data['messageInfo'] =  $this->qbank_model->get_message_information($teacherID,$studentID,$subjectID);
		
		$data['messageReplyInfo'] = $this->qbank_model->get_message_reply_information($data['messageInfo']['id']);
		

		 $countReply = $this->db->where('message_id',$data['messageInfo']['id'])->where('replied_user_id',$teacherID)->where('is_view','0')->get('savsoft_message_reply')->num_rows();
		 /* echo $this->db->last_query();
		  echo '$countReply'.$countReply;*/
		 if($countReply>0){
		 	$this->qbank_model->update_message($data['messageInfo']['id']);
		 }
		if($this->input->post('send') && $this->input->post('send')=='Send'){
			 $this->qbank_model->send_teacher_message();
			 //echo $this->db->last_query();
			  $this->session->set_flashdata('message', "<div class='alert alert-success'>Message send successfully</div>");
			 redirect('parents/');
		}
		if($this->input->post('reply') && $this->input->post('reply')=='Reply'){
			 $this->qbank_model->reply_message();
			 //echo $this->db->last_query();
			  $this->session->set_flashdata('message', "<div class='alert alert-success'>Message send successfully</div>");
			 redirect('parents/');
		}
		$this->load->view('header',$data);
		$this->load->view('parent/messages',$data);
		$this->load->view('footer',$data);
	}
	
}
?>