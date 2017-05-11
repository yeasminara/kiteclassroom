<?php
Class Homew_model extends CI_Model
{
 
 function home_work_list($limit){
	
	 $logged_in=$this->session->userdata('logged_in');
	 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
	// $info =  $this->db->where('user_id',$logged_in['uid'])->get('savsoft_student_profile')->row_array();
	
	 if($result_role['role_type'] == 'school_admin'){
		
		 $this->db->where('group_id',$logged_in['gid']);
	 }elseif($result_role['role_type'] == 'school_teacher'){
		  $this->db->where('user_id',$logged_in['uid']);
	 }elseif($result_role['role_type'] == 'user'){
		 $current_class = $this->db->where('user_id',$logged_in['uid'])->where('is_current_year','1')->get('savsoft_student_profile')->row_array();
		 $this->db->where('group_id',$logged_in['gid']);
		 $this->db->where('savsoft_home_work_permission.user_id',$logged_in['uid']);
		  $this->db->where('savsoft_home_work_permission.status','1');
		 $this->db->join('savsoft_home_work_permission','savsoft_home_work_permission.home_work_id=savsoft_home_work.home_work_id');
		 
	 }else{
	 }
	
	 if($this->input->post('search') || $this->input->post('class_id') || $this->input->post('subject_id')){
		 $search=$this->input->post('search');
		 $this->db->or_where('class_id',$this->input->post('class_id'));
		 $this->db->or_like('home_work_title',$this->input->post('search'));
		 $this->db->or_like('subject_id',$this->input->post('subject_id'));

	 }
		
	$this->db->limit($this->config->item('number_of_rows'),$limit);
	$this->db->order_by('savsoft_home_work.class_id','ASC');
	$this->db->order_by('savsoft_home_work.subject_id','ASC');
	$this->db->select('*');
	$this->db->select('(select category_name FROM savsoft_category where cid=savsoft_home_work.subject_id ) as category_name');
	$this->db->select('(select class_name FROM savsoft_class where id=savsoft_home_work.class_id ) as class_name');
	$query=$this->db->get('savsoft_home_work');
	//echo $this->db->last_query();
	return $query->result_array();
		
	 
 }

 function add_home_work(){
	     $logged_in=$this->session->userdata('logged_in');
	     $post_data = array(
		   'home_work_title' => $this->input->post('home_work_title'),
		   'home_work_content' =>$this->input->post('home_work_content'), 
		   'specefic_instruction' => $this->input->post('specefic_instruction'),
		   'materials' => $this->input->post('materials'),
		   'submission_date' => $this->input->post('submission_date'),
		   'submission_time' => $this->input->post('submission_time'),
		   'status' => $this->input->post('mstatus'),
		   'class_id'=>$this->input->post('class_id'),
		   'subject_id'=>$this->input->post('subject_id'),
		   'create_date' => date('Y-m-d'),
		   'user_id' => $logged_in['uid'],
		   'group_id' => $logged_in['gid'],
		   'total_marks'=>$this->input->post('total_marks')
		
		);
		
	 $this->db->insert('savsoft_home_work',$post_data);
	 if($post_data){
	   $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
	   redirect(base_url() . 'home_work', 'refresh');
	 }
	return;
 }
 
 function get_home_work_by_id($ID){
	 $this->db->where('home_work_id',$ID);
	 $query = $this->db->get('savsoft_home_work');
	 return $query->row_array();
 }
 function get_student_list($class_id,$group_id){
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
	 
 }


	function assign_home_work(){
	     $logged_in=$this->session->userdata('logged_in');
		 $selected_student = $this->input->post('selected_student');
		 foreach($selected_student as $value){
			$this->db->where('user_id',$value);
			$this->db->where('home_work_id',$this->input->post('home_work_id')); 
			$this->db->where('is_complete','0');
			$this->db->delete('savsoft_home_work_permission');
		   $post_data = array(
		   'home_work_id' => $this->input->post('home_work_id'),
		   'user_id' =>$value, 
		   'status'=>'1',
		   'is_complete'=>'0'
		);
		
	 $this->db->insert('savsoft_home_work_permission',$post_data);
	 
		 }
	     
	 if($post_data){
	   $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
	   redirect(base_url() . 'home_work', 'refresh');
	 }
	return;
 }
 
 function home_work_details($home_work_id, $details_id,$userID=FALSE){
	 $logged_in=$this->session->userdata('logged_in');
	 $this->db->where('savsoft_home_work_permission.home_work_id',$home_work_id);
	 $this->db->where('savsoft_home_work_permission.id',$details_id);
	 if(!empty($userID)){ 
	 $this->db->where('savsoft_home_work_permission.user_id',$userID);
	 }else{ 
	 	$this->db->where('savsoft_home_work_permission.user_id',$logged_in['uid']);
	 }
	 $this->db->select('*');
	 $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_home_work.subject_id ) as category_name');
	 $this->db->select('(select class_name FROM savsoft_class where id=savsoft_home_work.class_id ) as class_name');
	 $this->db->select('(select first_name FROM savsoft_users where uid=savsoft_home_work.user_id ) as first_teacher_name');
	 $this->db->select('(select last_name FROM savsoft_users where uid=savsoft_home_work.user_id ) as last_teacher_name');
	
	$this->db->select('(select first_name FROM savsoft_users where uid=savsoft_home_work_permission.user_id ) as first_student_name');
	$this->db->select('(select last_name FROM savsoft_users where uid=savsoft_home_work_permission.user_id ) as last_student_name');
	
	 $this->db->join('savsoft_home_work','savsoft_home_work.home_work_id=savsoft_home_work_permission.home_work_id');
	 $query = $this->db->get('savsoft_home_work_permission'); 
	 return $query->row_array();
 }
 
 function submit_answer($home_work_id, $details_id,$userID){
	 
	 
	 		$config['upload_path'] = './images/content/';
            $config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX|jpg|png|gif|jpeg';
        
			$this->load->library('upload', $config);
				/* upload other content file*/	 
			if (!$this->upload->do_upload('content_file')) {
              $data['error'] = $this->upload->display_errors();
			  @$featured='';

            } else {
                @$featured = $this->upload->data();
            }
				/* end upload other content file*/
			
			/* start image upload*/
			
			if (!$this->upload->do_upload('image')) {
              $data['error'] = $this->upload->display_errors();
			  @$featured2='';

            } else {
                @$featured2 = $this->upload->data();
            }
			
			 $post_data = array(
				   'answer' => $this->input->post('home_work_content'),
				   'file'=> @$featured['file_name'],
				   'image'=> @$featured2['file_name'],
				   'status' => '1',
				   'is_complete' =>'1'
                
                );
			$this->db->where('id',$details_id);	
			$this->db->update('savsoft_home_work_permission',$post_data);
			
			if($post_data){
			   $this -> session -> set_flashdata('message', 'Answer  has been successfully submitted.');
			  redirect(base_url() . 'home_work', 'refresh');
			 }
			return;
 }
 
 	public function check_home_work_status($user_id,$home_work_id){
		$this->db->where('home_work_id', $home_work_id);
		$this->db->where('user_id', $user_id);
		/*$this->db->where('is_complete', '0');
		$this->db->where('is_evaluate', '0');*/
		$query = $this->db->get('savsoft_home_work_permission');
		//echo $this->db->last_query();	
		if ($query->num_rows() == 1) return $query->row_array();
		return NULL;
	}
	
	 function submit_evaluation($home_work_id, $details_id,$userID){
			 $post_data = array(
				   'segment' => $this->input->post('segment'),
				 	'mark_achived' => $this->input->post('mark_achived'),
				   'weak_point' => $this->input->post('weak_point'),
				   'strong_point' => $this->input->post('strong_point'),
				    'action_to_take' => $this->input->post('action_to_take'),
				   'is_evaluate' =>'1'
                
                );
			$this->db->where('id',$details_id);	
			$this->db->update('savsoft_home_work_permission',$post_data);
			
			if($post_data){
			   $this -> session -> set_flashdata('message', 'Evaluation successfully submitted.');
			  redirect(base_url() . 'home_work/permission/'.$home_work_id, 'refresh');
			 }
			return;
 }
	
}
?>