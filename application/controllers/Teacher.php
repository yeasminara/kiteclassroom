<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("user_model");
	   $this->load->model("qbank_model");
	   $this->load->model("quiz_model");
	   $this->load->model("result_model");
	   $this->load->model("homew_model");
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

	public function index()
	{
		$data['title']='Teacher Dashboard';
		
		$logged_in=$this->session->userdata('logged_in');
		$this->db->where('id',$logged_in['su']);
		$query = $this->db->get('savsoft_roles');
		$result_role = $query->row_array();
		
		if($result_role['role_type']=='administrator' || $result_role['role_type']=='superadmin' || $result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
			$data['result']=$this->user_model->user_list(0);
			//echo $this->bd->last_query();	
			$data['num_users']=$this->user_model->num_users();
			$data['num_qbank']=$this->qbank_model->num_qbank();
			$data['num_quiz']=$this->quiz_model->num_quiz();
		}
		$data['home_work_list']=$this->homew_model->home_work_list($limit=0);
		$data['teacher_message']=$this->qbank_model->get_parent_message();
		//echo $this->db->last_query();
		$this->load->view('header',$data);
		$this->load->view('teacher/dashboard',$data);
		$this->load->view('footer',$data);
	}
	
	
		public function config(){
		
		$logged_in=$this->session->userdata('logged_in');

			if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
			}
			if($this->config->item('frontend_write_admin') > $logged_in['su']){
			exit($this->lang->line('permission_denied'));
			}			
			
		if($this->input->post('config_val')){
		if($this->input->post('force_write')){
		if(chmod("./application/config/config.php",0777)){ } 	
		}
		
		$file="./application/config/config.php";
		$content=$this->input->post('config_val');
		 file_put_contents($file,$content);
		if($this->input->post('force_write')){
		if(chmod("./application/config/config.php",0644)){ } 	
		}

		 	 redirect('dashboard/config');
		} 
		 
		$data['result']=file_get_contents('./application/config/config.php');
		$data['title']=$this->lang->line('config');
		$this->load->view('header',$data);
		$this->load->view('config',$data);
		$this->load->view('footer',$data);

		}



		public function css(){
		
		$logged_in=$this->session->userdata('logged_in');

			if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
			}
			
			
		if($this->input->post('config_val')){
		if($this->input->post('force_write')){
		if(chmod("./css/style.css",0777)){ } 	
		}

		$file="./css/style.css";
		$content=$this->input->post('config_val');
		 file_put_contents($file,$content);
		if($this->input->post('force_write')){
		if(chmod("./css/style.css",0644)){ } 	
		}

		 redirect('dashboard/css');
		} 
		 
		$data['result']=file_get_contents('./css/style.css');
		$data['title']=$this->lang->line('config');
		$this->load->view('header',$data);
		$this->load->view('css',$data);
		$this->load->view('footer',$data);

		}		
		
		
public function message($messageID){
		$data['title']='Send Message';
		$logged_in=$this->session->userdata('logged_in');
		
		
		
		 
		
		//$data['subjectInfo'] = $this->db->where('cid',$subjectID)->get('savsoft_category')->row_array();
		$data['messageInfo'] =  $this->qbank_model->get_parent_message($messageID);
		
		$data['teacherInfo'] = $this->qbank_model->get_teacher_information($logged_in['uid']);
		$data['subjectInfo'] = $this->qbank_model->get_subject_information($data['messageInfo'][0]['subject_id']);
		
		//echo $this->db->last_query();
		$data['messageReplyInfo'] = $this->qbank_model->get_message_reply_information($messageID);
		
		$data['updateMessage'] = $this->qbank_model->update_message($messageID);
		
		$sql = "SELECT *,
					(select class_name from savsoft_class where id=ssp.class_id) as class_name,
					(select section_name from savsoft_class_section where id=ssp.class_section_id) as section_name,
					(select group_name from savsoft_class_group where group_name=ssp.class_group) as group_name
					 FROM `savsoft_parents_info` AS spi
					 INNER JOIN `savsoft_users` AS su ON su.`uid`=spi.`student_id`
					 INNER JOIN `savsoft_student_profile` AS ssp ON ssp.`user_id`=spi.`student_id`
					 WHERE spi.`user_id`='".$data['messageInfo'][0]['student_id']."' AND ssp.`is_current_year`='1'";
		$query = $this->db->query($sql);
		$data['student'] = $query->row_array();
		
		if($this->input->post('send') && $this->input->post('send')=='Send'){
			 $this->qbank_model->send_teacher_message();
			 //echo $this->db->last_query();
			  $this->session->set_flashdata('message', "<div class='alert alert-success'>Message send successfully</div>");
			 redirect('teacher/');
		}
		if($this->input->post('reply') && $this->input->post('reply')=='Reply'){
			 $this->qbank_model->reply_message();
			 //echo $this->db->last_query();
			  $this->session->set_flashdata('message', "<div class='alert alert-success'>Message send successfully</div>");
			 redirect('teacher/');
		}
		$this->load->view('header',$data);
		$this->load->view('teacher/messages',$data);
		$this->load->view('footer',$data);
	}
		
}
