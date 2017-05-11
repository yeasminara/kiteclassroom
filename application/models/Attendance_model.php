<?php
Class Attendance_model extends CI_Model{
	   
	/*public function get_student_list(){
	 
	 $this->db->where('savsoft_users.gid',$group_id);
	 $this->db->where('savsoft_student_profile.class_id',$class_id);
	 $this->db->where('savsoft_student_profile.is_current_year','1');
	 $this->db->order_by('savsoft_student_profile.class_id','asc');
	 $this->db->order_by('savsoft_student_profile.class_section_id','asc');
	 $this->db->order_by('savsoft_student_profile.roll_no','asc');
	 $this->db->order_by('savsoft_users.uid','asc');  
	 $this->db->select('*');
	 $this->db->select('(select section_name FROM savsoft_class_section where id=savsoft_student_profile.class_section_id ) as section_name');
	 $this->db->join('savsoft_student_profile','savsoft_student_profile.user_id=savsoft_users.uid');
	 
	 $query = $this->db->get('savsoft_users');
	 return $query->result_array(); 
	}*/
	
	function class_list (){
	     $logged_in=$this->session->userdata('logged_in');
		 //print_r($logged_in);
		 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		 if($result_role['role_type']=='school_teacher'){
			  $this->db->join('teacher_taken_subject','teacher_taken_subject.class_id=savsoft_class.id');
			  $this->db->where('teacher_taken_subject.user_id',$logged_in['uid']);
			  $this->db->group_by('teacher_taken_subject.class_id');
		 }
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
	function group_list(){
		$this->db->order_by('gid','desc');
		$query=$this->db->get('savsoft_group');
		return $query->result_array();
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
	function submit_attandance(){
		@$school_id = $this->input->post('gid');
		$academic_year = $this->input->post('academic_year');
		$class_id = $this->input->post('class_id');
		$class_section_id = $this->input->post('class_section_id');
		$class_group_id = $this->input->post('class_group_id');
		$attandance_type = $this->input->post('attendance_type');
		$attandance_date = $this->input->post('attandance_date');
		$selected_std = $this->input->post('selected_std');
		@$attandence_id =$this->input->post('attandence_id');
		
		
		$logged_in = $this->session->userdata('logged_in');
		if($school_id){
			$school_id = $school_id;
		}else{
			$school_id = $logged_in['gid'];
		}
		foreach($selected_std as $key => $value){
			//echo 'test';
			$this->db->where('savsoft_student_attendance.school_id',$school_id);
			$this->db->where('savsoft_student_attendance.academic_year',$academic_year);
			$this->db->where('savsoft_student_attendance.class_id',$class_id);
			$this->db->where('savsoft_student_attendance.class_section_id',$class_section_id);
			$this->db->where('savsoft_student_attendance.class_group_id',$class_group_id);
			$this->db->where('savsoft_student_attendance.attandance_date',$attandance_date);
			$this->db->where('savsoft_student_attendance.student_id',$value);
			
			$find_student_attendance = $this->db->get('savsoft_student_attendance')->row_array();
			
			 
			//echo $this->db->last_query();
			if(count($find_student_attendance)>0){
				$this->db->set('attendance_type',$attandance_type[$value]);
				$this->db->where('student_id',$value);
				$this->db->where('id',$attandence_id);
				$this->db->update('savsoft_student_attendance');
				
			}else{
				$data = array(
						'school_id' => $school_id,
						'academic_year'  => $academic_year,
						'student_id'  => $value,
						'class_id'  => $class_id,
						'class_section_id'  => $class_section_id,
						'class_group_id'  => $class_group_id,
						'attandance_date'  => $attandance_date,
						'attendance_type'  => $attandance_type[$value],
						'created'  => date("Y-m-d h:i:sa"),
						'created_by'  => $logged_in['uid']
				);
				$this->db->insert('savsoft_student_attendance', $data);
			}
		}
	}
	
	public function get_student_attendance($studentID, $schoolID, $academic_year, $class_id, $class_section_id, $class_group_id, $attandance_date){
		
		
		if($studentID){
			$this->db->where('student_id',$studentID);
		}
		if($schoolID){
			$this->db->where('school_id',$schoolID);
		}
		if($academic_year){
			$this->db->where('academic_year',$academic_year);
		}
		if($class_id){
			$this->db->where('class_id',$class_id);
		}
		if($class_section_id){
			$this->db->where('class_section_id',$class_section_id);
		}
		if($class_group_id){
			$this->db->where('class_group_id',$class_group_id);
		}
		if($attandance_date){
			$this->db->where('attandance_date',$attandance_date);
		}
		
		$query = $this->db->get('savsoft_student_attendance');
		echo $this->db->last_query();
			return $query->row_array();
		/*$where = "student_id = $studentID and school_id = $schoolID and academic_year = $academic_year and class_id = $class_id and class_section_id = $class_section_id and class_group_id = $class_group_id and attandance_date = '$attandance_date'";
		$this->db->where($where);
		
	*/
		
	}
}

?>