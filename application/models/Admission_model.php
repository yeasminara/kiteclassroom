<?php
Class Admission_model extends CI_Model{
	   
	
	function class_list (){
	 
		 $this->db->select('savsoft_class.*'); 
			
		 $this->db->order_by('savsoft_class.id','asc');
		 $query=$this->db->get('savsoft_class');
		 return $query->result_array();
	 
 	} 
 
  // Class section  function start
	 function class_section_list (){
		 $this->db->order_by('id','asc');
		 $query=$this->db->get('savsoft_class_section');
		 return $query->result_array();
	 } 
	 function class_group_list (){
		 $this->db->order_by('id','asc');
		 $query=$this->db->get('savsoft_class_group');
		 return $query->result_array();
	 }
	function group_list($school_id){
		$this->db->where('gid',$school_id);
		$query=$this->db->get('savsoft_group');
		return $query->row_array();
	}
	function school_information($school_id){
			$this->db->where('savsoft_users.gid',$school_id);
			$this->db->where('savsoft_users.su',6);
	
	$this -> db -> join('savsoft_school_profile', 'savsoft_users.uid=savsoft_school_profile.user_id');
	$query=$this->db->get('savsoft_users');
	//echo $this->db->last_query();
	return $query->row_array();
		
	}
	function get_student(){
		@$school_id = $this->input->post('gid');
		$academic_year = $this->input->post('academic_year');
		$class_id = $this->input->post('class_id');
		$class_section_id = $this->input->post('class_section_id');
		$class_group_id = $this->input->post('class_group_id');
		
		//$attandance_date = $this->input->post('attandance_date');
		
		$logged_in=$this->session->userdata('logged_in');
		if($school_id){
			$this->db->where('savsoft_users.gid',$school_id);
		}else{
			$this->db->where('savsoft_users.gid',$logged_in['gid']);
		}
		if($academic_year){
		$this->db->where('savsoft_student_profile.academic_year',$academic_year);
		}
		if($class_id){
			$this->db->where('savsoft_student_profile.class_id',$class_id);
		}
		if($class_section_id){
			$this->db->where('savsoft_student_profile.class_section_id',$class_section_id);
		}
		if($class_group_id){
			$this->db->where('savsoft_student_profile.class_group=(select group_name from savsoft_class_group where id='.$class_group_id.')', NULL, FALSE);
		}
		
		
		$this->db->order_by('savsoft_student_profile.class_id','asc');
		$this->db->order_by('savsoft_student_profile.class_section_id','asc');
		$this->db->order_by('savsoft_student_profile.roll_no','asc');
		$this->db->order_by('savsoft_users.uid','asc');  
		$this->db->select('*');
		$this->db->select('(select section_name FROM savsoft_class_section where id=savsoft_student_profile.class_section_id ) as section_name');
		$this->db->join('savsoft_student_profile','savsoft_student_profile.user_id=savsoft_users.uid');
		
		$query = $this->db->get('savsoft_users');
		//echo $this->db->last_query();
		return $query->result_array(); 
	}
	
	function insert_student(){
	 
		if (!is_dir('images/student/')) {
			mkdir('./images/student/', 0777, true);
		}
		 $config['upload_path'] = './images/student/';
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = '';
		$config['max_width'] = '';
		$config['max_height'] = '';
		$this->load->library('upload', $config);
		
		//@$result = $this->db->where('status','1')->where('role_type',$this->input->post('su'))->get('savsoft_roles')->row_array();
		
		$userdata=array(
			'email'=>$this->input->post('email'),
			'password'=>md5($this->input->post('password')),
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'contact_no'=>$this->input->post('contact_no'),
			'gid'=>$this->input->post('gid'),
			'subscription_expired'=>0,
			'su'=>4		
		);
		
		$this->db->insert('savsoft_users',$userdata);
		$user_inserted_id = $this->db->insert_id();

			
		 if (!$this->upload->do_upload('image')) {
		  $data['error'] = $this->upload->display_errors();
			//return;
			//redirect(base_url() . 'web/config', $data);
			 @$featured2='';

		} else {
			@$featured2 = $this->upload->data();
		}
			
			$post_data = array(
				   'academic_year'=>$this->input->post('year'),
				   'class_id' => $this->input->post('class_id'),
				   'class_section_id' => $this->input->post('class_section_id'),
				   'roll_no'=> $this->input->post('roll_no'),
				   'class_group'=>$this->input->post('class_group'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $user_inserted_id,
				   'profile_picture'=> @$featured2['file_name'],
				   'is_current_year'=>'1',
				   'father_name' => $this->input->post('father_name'),
				   'mother_name' => $this->input->post('mother_name'),
				   'guardian_name' => $this->input->post('guardian_name'),
				   'gender' => $this->input->post('gender'),
				   'is_promoted'=>'0'
                
                );
			//print_r($post_data);
			//exit;
			 $this->db->insert('savsoft_student_profile', $post_data);
	
		$where = " page_group_name in ('Quiz List','Exam Result','Edit User','Attempt quiz') and status='1'";
		$this->db->where($where);
		$queryAccess = $this->db->get('savsoft_page_group');
		
			 foreach($queryAccess->result_array() as $resAccess){
				$post_data1 = array(
				   'page_group_id' => $resAccess['id'],
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $user_inserted_id
                ); 
			$this->db->insert('savsoft_page_group_permission', $post_data1);
			 }

		if($user_inserted_id){
			
			return true;
		}else{
			
			return false;
		}
	}
}

?>