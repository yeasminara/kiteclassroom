<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admission extends CI_Controller {

	
	function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("admission_model");
	   
		// redirect if not loggedin
		
		
	 }
	public function index()
	{
	$this->load->view('admission/index');
		
	}
	public function admission_form(){
		
		$school_id = base64_decode($this->input->get('school'));
		$data['school_name'] = $this->admission_model->group_list($school_id);
		$data['school_other_information'] = $this->admission_model->school_information($school_id);
		$data['class_information'] = $this->admission_model->class_list();
		$data['class_section_information'] = $this->admission_model->class_section_list();
		$data['class_group_information'] = $this->admission_model->class_group_list();
		$this->load->view('admission/admission_form',$data);
	}
	public function form_submit(){
		$academic_year=$this->input->post('academic_year');
		$class_id=$this->input->post('class_id');
		$class_grp=$this->input->post('class_grp');
		$father_name=$this->input->post('father_name');
		$father_nid=$this->input->post('father_nid');
		$mother_name=$this->input->post('mother_name');
		$mother_nid=$this->input->post('mother_nid');
		$birth_date=$this->input->post('birth_date');
		$birth_certificate=$this->input->post('birth_certificate');
		$gender=$this->input->post('gender');
		$tribal=$this->input->post('tribal');
		$tribal_status=$this->input->post('tribal_status');
		$religion=$this->input->post('religion');
		$disability=$this->input->post('disability');
		$disability_status=$this->input->post('disability_status');
		$other=$this->input->post('other');
		$others_status=$this->input->post('others_status');
		$psc_roll=$this->input->post('psc_roll');
		$psc_thana=$this->input->post('psc_thana');
		$psc_post=$this->input->post('psc_post');
		$psc_gpa=$this->input->post('psc_gpa');
		$psc_year=$this->input->post('psc_year');
		$jsc_roll=$this->input->post('jsc_roll');
		$jsc_thana=$this->input->post('jsc_thana');
		$jsc_post=$this->input->post('jsc_post');
		$jsc_year=$this->input->post('psc_year');
		$ssc_roll=$this->input->post('ssc_roll');
		$ssc_thana=$this->input->post('ssc_thana');
		$ssc_post=$this->input->post('ssc_post');
		$ssc_year=$this->input->post('ssc_year');
		$gurdian_name=$this->input->post('gurdian_name');
		$gurdian_occupation=$this->input->post('gurdian_occupation');
		$guardian_occupation_level=$this->input->post('guardian_occupation_level');
		$gurdian_income=$this->input->post('gurdian_income');
		$gurdian_mobile=$this->input->post('gurdian_mobile');
		$gudian_email=$this->input->post('gudian_email');
		$present_house=$this->input->post('present_house');
		$present_road=$this->input->post('present_road');
		$present_area=$this->input->post('present_area');
		$present_post=$this->input->post('present_post');
		$present_post=$this->input->post('present_post');
		$present_code=$this->input->post('present_code');
		$present_ward=$this->input->post('present_ward');
		$present_district=$this->input->post('present_district');
		$present_catch_area=$this->input->post('present_catch_area');
		$parmanent_house=$this->input->post('parmanent_house');
		$parmanent_road=$this->input->post('parmanent_road');
		$parmanent_email=$this->input->post('parmanent_email');
		$parmanent_post=$this->input->post('parmanent_post');
		$parmanent_uposila=$this->input->post('parmanent_uposila');
		$parmanent_ward=$this->input->post('parmanent_ward');
		$parmanent_district=$this->input->post('parmanent_district');
		$parmanent_catchement=$this->input->post('parmanent_catchement');

	}
}
