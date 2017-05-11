<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_attendance extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("attendance_model");
	   $this->lang->load('basic', $this->config->item('language'));
	   $this->load->helper('form');
	   $this->load->helper('site_helper');
	   //$this->load->model("std_attendance");
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


	public function index($limit='0',$cid='0',$lid='0')
	{
		echo 'test';
	}
	
	
	public function take_attendance(){
		$logged_in=$this->session->userdata('logged_in');
		//print_r($logged_in);
		$data['class_list']=$this->attendance_model->class_list();
		$data['class_section_list']=$this->attendance_model->class_section_list();
		$data['class_group_list']=$this->attendance_model->class_group_list();
		$data['school_list']=$this->attendance_model->group_list();
		$data['student_list']=$this->attendance_model->get_student();
		//$data['student_list'] = search_student();
		//print_r($data['school_list']);
		$data['title']='Take Student Attendance';
		/*$this->load->view('header',$data);
		$this->load->view('attendance/student_list',$data);
		$this->load->view('footer',$data);*/
		
		
		$data['middle'] = $this->load->view('attendance/student_list',$data, true);
        $this->load->view('template', $data);
	}
	public function add(){
		
		//echo $this->input->post('save');
		if ($this->input->post('save')) {
			//echo 'test';
		  $data['list'] =  $this->attendance_model->submit_attandance();
		   //echo $this->db->last_query();
		   $this->session->set_flashdata('message', 'Data Updated Successfully');
			redirect(base_url() . 'student_attendance/take_attendance');
		   
		}
	}
		
		public function search_student(){
			//echo 'test.....';
			$data['attandance_date'] = $this->input->post('attandance_date');
			//@$data['school_id'] = $this->input->post('gid');
			$data['academic_year'] = $this->input->post('academic_year');
			$data['class_id'] = $this->input->post('class_id');
			$data['class_section_id'] = $this->input->post('class_section_id');
			$data['class_group_id'] = $this->input->post('class_group_id');
			
			$logged_in=$this->session->userdata('logged_in');
			if($this->input->post('gid')){
				$data['school_id'] = $this->input->post('gid');
			}else{
				$data['school_id'] = $logged_in['gid'];
			}
		
			$data['student_list']=$this->attendance_model->get_student();
			//print_r($data['student_list']);
			$this->load->view('attendance/load_student',$data);
		}
	 

	
}
