<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Media_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("user_model");
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

	public function index($limit='0')
	{
		$logged_in=$this->session->userdata('logged_in');
		 
		if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
		}
		$data['user_role_id'] = $logged_in['su'];	
		$data['limit']=$limit;
		$data['title']=$this->lang->line('userlist');
		// fetching user list
		$data['result']=$this->user_model->user_list($limit);
	/*	$this->load->view('header',$data);
		$this->load->view('user_list',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('user_list',$data, true);
        $this->load->view('template', $data);
	}
	
	public function new_user()
	{
		
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			  exit($this->lang->line('permission_denied'));
			  $data['class_group_list']=$this->db->where('status','1')->where('group_name1=','Administartor')->get('savsoft_class_group')->result_array();
			}else{
				$data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array();
			}
			//
		//print_r($logged_in);	
		 $data['title']=$this->lang->line('add_new').' '.$this->lang->line('user');
		// fetching group list
		$data['class_list']=$this->qbank_model->class_list();
		$data['class_section_list']=$this->qbank_model->class_section_list();
		
		$this->db->where('id',$logged_in['su']);
	    $query_role = $this->db->get('savsoft_roles');
	    $result_role = $query_role->row_array();
	  
		 if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
			 $data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
		 }else{
			$data['group_list']=$this->user_model->group_list();
		 }
		$data['user_type']=$logged_in['su'];
		
		$result = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		
		if($result['role_type'] == 'administrator'){
			$data['user_list']  = $this->db->where('status','1')->get('savsoft_roles')->result_array();
		}elseif($result['role_type'] == 'superadmin'){
			$data['user_list']  = $this->db->where('status','1')->get('savsoft_roles')->result_array();
		}elseif($result['role_type'] == 'school_admin'){
			$where = " status='1' and role_type in('school_admin', 'school_teacher','user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
		}
		elseif($result['role_type'] == 'school_teacher'){
			$where = " status='1' and role_type in('user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
		}
		//echo $this->db->last_query();
		//echo $this->db->last_query();
	  /*  $this->load->view('header',$data);
		$this->load->view('new_user',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('new_user',$data, true);
        $this->load->view('template', $data);
	}
	
	public function insert_user(){
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[savsoft_users.email]');
	
        $this->form_validation->set_rules('password', 'Password', 'required');
		if($this->input->post('su')=='parents'){
			$this->form_validation->set_rules('conform', 'Checkbox', 'required');
			$this->form_validation->set_rules('student_id', 'Student', 'required|is_unique[savsoft_parents_info.student_id]');
			$this->form_validation->set_message('student_id', 'Wrong Student');
			$this->form_validation->set_rules('contact_number1', 'SMS Number', 'required');
			
		}
          if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('user/new_user/');
                }
                else
                {
					if($this->user_model->insert_user()){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
					}else{
						$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
					}
					redirect('user/');
                }       

	}

		public function remove_user($uid){

			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
			if($uid=='1'){
					exit($this->lang->line('permission_denied'));
			}
			
			if($this->user_model->remove_user($uid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('user');
                     
			
		}

	public function edit_user($uid)
	{
		
		
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']=='0'){
			 $uid=$logged_in['uid'];
			}
			
		 $data['uid']=$uid;
		 $data['title']=$this->lang->line('edit').' '.$this->lang->line('user');
		// fetching user
		$data['user_type']=$logged_in['su'];
		 	 
		
		$data['result']=$this->user_model->get_user($uid);
		
		$this->load->model("payment_model");
		$data['payment_history']=$this->payment_model->get_payment_history($uid);
		// fetching group list
		//$data['group_list']=$this->user_model->group_list();
		
	    $data['class_list']=$this->qbank_model->class_list();
		$data['class_section_list']=$this->qbank_model->class_section_list();
		$data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array(); 
		
		$results = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		
		$data['user_type_role'] = $results;
	
		if($results['role_type'] == 'administrator'){
			$data['user_list']  = $this->db->where('status','1')->get('savsoft_roles')->result_array();
			$data['school_info']=$this->user_model->get_school_info($uid);
			$data['teacher_info']=$this->db->where('status','1')->where('user_id','$uid')->get('teacher_taken_subject')->result_array();
			$data['student_info']=$this->user_model->get_student_info($uid);
			$data['group_list']=$this->user_model->group_list();
			$data['parent_info'] = $this->db->where('user_id',$uid)->get('savsoft_parents_info')->row_array();
			//echo $this->db->last_query();
		}elseif($results['role_type'] == 'superadmin'){
			$data['user_list']  = $this->db->where('status','1')->get('savsoft_roles')->result_array();
			$data['school_info']=$this->user_model->get_school_info($uid);
			$data['teacher_info']=$this->db->where('status','1')->where('user_id','$uid')->get('teacher_taken_subject')->result_array();
			$data['student_info']=$this->user_model->get_student_info($uid);
			$data['group_list']=$this->user_model->group_list();
		}elseif($results['role_type'] == 'school_admin'){
			$where = " status='1' and role_type in('school_admin', 'school_teacher','user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['school_info']=$this->user_model->get_school_info($uid);
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
		}
		elseif($results['role_type'] == 'school_teacher'){
			$where = " status='1' and role_type in('school_teacher','user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['teacher_info']=$this->db->where('status','1')->where('user_id','$uid')->get('teacher_taken_subject')->result_array();
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
		}elseif($results['role_type'] == 'parents'){
			$where = " status='1' and role_type in('parents')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['parent_info'] = $this->db->where('user_id',$uid)->get('savsoft_parents_info')->row_array();
			
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
		}else{
			$where = " status='1' and role_type in('user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['student_info']=$this->user_model->get_student_info($uid);
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
		}
		//echo $this->db->last_query();
		
		 //$this->load->view('header',$data);
			if($results['role_type'] == 'administrator' || $results['role_type'] == 'school_admin'){
				
				$data['middle'] = $this->load->view('edit_user',$data, true);
			}else{
				$data['middle'] = $this->load->view('myaccount',$data, true);
				
			}
					
        $this->load->view('template', $data);
		//$this->load->view('footer',$data);
	}

		public function update_user($uid)
	{
		
		
			$logged_in=$this->session->userdata('logged_in');
						 
			if($logged_in['su']=='0'){
			 $uid=$logged_in['uid'];
			}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required');
           if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('user/edit_user/'.$uid);
                }
                else
                {
					if($this->user_model->update_user($uid)){
						//echo $this->db->last_query();
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>");
						
					}
					redirect(''.$_POST['url'].'');
					//redirect('user/edit_user/'.$uid);
                }       

	}


	public function edit_myprofile()
	{
		
		
		$logged_in=$this->session->userdata('logged_in');
		if(isset($logged_in['su'])){
			 $uid=$logged_in['uid'];
			}
			
		 $data['uid']=$uid;
		 $data['title']=$this->lang->line('edit').' '.$this->lang->line('user');
		// fetching user
		$data['user_type']=$logged_in['su'];
		 	 
		
		
		$this->load->model("payment_model");
		$data['payment_history']=$this->payment_model->get_payment_history($uid);
		// fetching group list
		//$data['group_list']=$this->user_model->group_list();
		
	    $data['class_list']=$this->qbank_model->class_list();
		$data['class_section_list']=$this->qbank_model->class_section_list();
		$data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array(); 
		
		$results = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		  //echo $this->db->last_query();
		$data['user_type_role'] = $results;
	   
		if($results['role_type'] == 'administrator'){
			$data['user_list']  = $this->db->where('status','1')->get('savsoft_roles')->result_array();
			$data['school_info']=$this->user_model->get_school_info($uid);
			$data['teacher_info']=$this->db->where('status','1')->where('user_id','$uid')->get('teacher_taken_subject')->result_array();
			$data['student_info']=$this->user_model->get_student_info($uid);
			$data['group_list']=$this->user_model->group_list();
			$data['result']=$this->db->where('uid',$uid)->get('savsoft_users')->row_array(); 
			
		}elseif($results['role_type'] == 'superadmin'){
			$data['user_list']  = $this->db->where('status','1')->get('savsoft_roles')->result_array();
			$data['school_info']=$this->user_model->get_school_info($uid);
			$data['teacher_info']=$this->db->where('status','1')->where('user_id','$uid')->get('teacher_taken_subject')->result_array();
			$data['student_info']=$this->user_model->get_student_info($uid);
			$data['group_list']=$this->user_model->group_list();
			$data['result']=$this->db->where('uid',$uid)->get('savsoft_users')->row->array();
		}elseif($results['role_type'] == 'school_admin'){
			$where = " status='1' and role_type in('school_admin', 'school_teacher','user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['school_info']=$this->user_model->get_school_info($uid);
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
			$data['result']=$this->user_model->get_user($uid);
		}
		elseif($results['role_type'] == 'school_teacher'){
			$where = " status='1' and role_type in('school_teacher','user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['teacher_info']=$this->db->where('status','1')->where('user_id','$uid')->get('teacher_taken_subject')->result_array();
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
			$data['result']=$this->user_model->get_user($uid);
		}else{
			$where = " status='1' and role_type in('user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['student_info']=$this->user_model->get_student_info($uid);
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
			$data['result']=$this->user_model->get_user($uid);
		//echo $this->db->last_query();
		}
		
		 //$this->load->view('header',$data);
			if($results['role_type'] == 'administrator' || $results['role_type'] == 'school_admin'){
				
				$data['middle'] = $this->load->view('edit_user',$data, true);
			}else{
				$data['middle'] = $this->load->view('myaccount',$data, true);
				
			}
			
			
        $this->load->view('template', $data);
		//$this->load->view('footer',$data);
	}
		
	
	public function group_list(){
		
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$data['title']=$this->lang->line('group_list');
		
		$data['middle'] = $this->load->view('group_list',$data, true);
		$this->load->view('template', $data);
		/*$this->load->view('header',$data);
		$this->load->view('group_list',$data);
		$this->load->view('footer',$data);*/

		
		
		
	}
	
	
		public function insert_group()
	{
		
		
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
	
				if($this->user_model->insert_group()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
						
				}
				redirect('user/group_list/');
	
	}
	
			public function update_group($gid)
	{
		
		
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
	
				if($this->user_model->update_group($gid)){
                echo "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>";
				}else{
				 echo "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>";
						
				}
				 
	
	}
	
	
	function get_expiry($gid){
		
		echo $this->user_model->get_expiry($gid);
		
	}
	
	
	
	
			public function remove_group($gid){

			$logged_in=$this->session->userdata('logged_in');
			if(empty($logged_in['su'])){
				exit($this->lang->line('permission_denied'));
			} 
			
			if($this->user_model->remove_group($gid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('user/group_list');
                     
			
		}


	public function load_subject_only(){
		$results = $this->qbank_model->subject_list();
		$subject_list .= '<label>Subject : </label>&nbsp; &nbsp;';
		
		foreach($results as $subject){
			$subject_list .='<input type="checkbox" name="subject_id['.$subject['cid'].']" value="'.$subject['cid'].'">&nbsp;'.$subject['category_name'].'&nbsp; &nbsp;';
		}
		echo $subject_list;
	}

/*========================================================================
=================Student Promotion list=============================================*/	
	public function student_promotion(){
		$logged_in=$this->session->userdata('logged_in');
		if(empty($logged_in['su'])){
			exit($this->lang->line('permission_denied'));
		} 
		$data['title']='Student List';
		$results = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		$data['class_list']=$this->qbank_model->class_list();
		$data['class_section_list']=$this->qbank_model->class_section_list();
		$data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array(); 
		$data['academic_year']=$this->db->where('status','1')->group_by('academic_year','ASC')->get('savsoft_student_profile')->result_array();
		
		if($results['role_type'] == 'administrator' || $results['role_type'] == 'superadmin'){
			$data['user_list']  = $this->db->where('status','1')->get('savsoft_roles')->result_array();
	/*		$data['school_info']=$this->user_model->get_school_info($uid);
			$data['teacher_info']=$this->db->where('status','1')->where('user_id','$uid')->get('teacher_taken_subject')->result_array();
			$data['student_info']=$this->user_model->get_student_info($uid);*/
			$data['group_list']=$this->user_model->group_list();
			$data['result']=$this->db->where('uid',$uid)->get('savsoft_users')->row_array(); 
			
			
		/*	$this->load->view('header',$data);
			$this->load->view('student_list',$data);
			$this->load->view('footer',$data);*/
			
			$data['middle'] = $this->load->view('student_list',$data, true);
		$this->load->view('template', $data);
		
			
		}elseif($results['role_type'] == 'school_admin'){
			$where = " status='1' and role_type in('school_admin', 'school_teacher','user')";
			$data['user_list']  = $this->db->where($where)->get('savsoft_roles')->result_array();
			$data['school_info']=$this->user_model->get_school_info($uid);
			$data['group_list']=$this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
			$data['result']=$this->user_model->get_user($uid);
			
			
			/*$this->load->view('header',$data);
			$this->load->view('student_list',$data);
			$this->load->view('footer',$data);*/
			
					
		$data['middle'] = $this->load->view('student_list',$data, true);
		$this->load->view('template', $data);
		}else{
		}
	
	}
	public function student_promotion_list(){
		
		$data['student_list'] = $this->user_model->student_promotion_list();
		//echo $this->db->last_query();
		$data['class_list']=$this->qbank_model->class_list();
		$data['class_section_list']=$this->qbank_model->class_section_list();
		$data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array(); 
		$data['academic_year']=$this->db->where('status','1')->group_by('academic_year','ASC')->get('savsoft_student_profile')->result_array();
		
		
		$data['middle'] = $this->load->view('student_promotion_list',$data, true);
		$this->load->view('template', $data);
		
	}
	
	public function student_promotion_submit(){
		
		
		if($this->user_model->insert_promoted_student()){
			$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
		}else{
				$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
			
		}
		//redirect(''.$_POST['url'].'');
		//redirect('user/edit_user/'.$uid);

	}

	
}
