<?php
Class Result_model extends CI_Model
{
	
 
 function result_list($limit,$status='0'){
	$result_open=$this->lang->line('open');
	$logged_in=$this->session->userdata('logged_in');
	$uid=$logged_in['uid'];
	$gid=$logged_in['gid']; 
	
	$result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
	$info =  $this->db->where('user_id',$logged_in['uid'])->get('savsoft_student_profile')->row_array();
	
	//$teacherinfo =  $this->db->where('user_id',$logged_in['uid'])->get('teacher_taken_subject')->result_array();
	 	
	if($this->input->post('search')){
		 $search=$this->input->post('search');
		 $this->db->or_where('savsoft_users.email',$search);
		 $this->db->or_where('savsoft_users.first_name',$search);
		 $this->db->or_where('savsoft_users.last_name',$search);
		 $this->db->or_where('savsoft_users.contact_no',$search);
		 $this->db->or_where('savsoft_result.rid',$search);
		 $this->db->or_where('savsoft_quiz.quiz_name',$search);
 
	 }else{
		 $this->db->where('savsoft_result.result_status !=',$result_open);
	 }
	 	
		
		if($result_role['role_type'] == 'school_admin'){
			$this->db->where('savsoft_users.gid',$gid);
			
		}
		elseif($result_role['role_type'] == 'school_teacher'){
			
			 $this->db->where('savsoft_users.gid',$gid);
			
			 
		}elseif($result_role['role_type'] == 'user'){
			 $this->db->where('savsoft_result.uid',$uid);
			 /*$this->db->where('class_id',$info['class_id']);
			 $this->db->where('class_section_id',$info['class_section_id']);*/
		}
		
		/*if($logged_in['su']=='0'){
			$this->db->where('savsoft_result.uid',$uid);
		}
		
		if($logged_in['su']=='2'){
			$this->db->where('savsoft_users.gid',$gid);
		}*/
		
	 	if($status !='0'){
			$this->db->where('savsoft_result.result_status',$status);
		}
		
		
		
		$this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('rid','desc');
		$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid');
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		if($result_role['role_type'] == 'school_teacher'){
			 $this->db->join('teacher_taken_subject','teacher_taken_subject.subject_id=savsoft_quiz.subject_id');
		}
		$query=$this->db->get('savsoft_result');
		
		//echo $this->db->last_query();
		return $query->result_array();
		
	 
 }
 
 function quiz_list(){
	 $this->db->order_by('quid','desc');
$query=$this->db->get('savsoft_quiz');	
return $query->result_array();	 
 }
 
 
 
 
 function remove_result($rid){
	 
	 $this->db->where('savsoft_result.rid',$rid);
	 if($this->db->delete('savsoft_result')){
		  $this->db->where('rid',$rid);
		  $this->db->delete('savsoft_answers');
		 return true;
	 }else{
		 
		 return false; 
	 }
	 
	 
	 
 }
 
 
 function generate_report($quid,$gid){
	$logged_in=$this->session->userdata('logged_in');
	$uid=$logged_in['uid'];
	$date1=$this->input->post('date1');
	 $date2=$this->input->post('date2');
		
		if($quid != '0'){
			$this->db->where('savsoft_result.quid',$quid);
		}
		if($gid != '0'){
			$this->db->where('savsoft_users.gid',$gid);
		}
		if($date1 != ''){
			$this->db->where('savsoft_result.start_time >=',strtotime($date1));
		}
		if($date2 != ''){
			$this->db->where('savsoft_result.start_time <=',strtotime($date2));
		}

	 	$this->db->order_by('rid','desc');
		$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid');
		$this->db->join('savsoft_group','savsoft_group.gid=savsoft_users.gid');
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		$query=$this->db->get('savsoft_result');
		return $query->result_array();
 }
 
 
 
 
 
 function get_result($rid){
	$logged_in=$this->session->userdata('logged_in');
	$uid=$logged_in['uid'];
	 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
			 
		if($result_role['role_type']=='user'){
			$this->db->where('savsoft_result.uid',$uid);
		}
		$this->db->where('savsoft_result.rid',$rid);
	 	$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid');
		$this->db->join('savsoft_group','savsoft_group.gid=savsoft_users.gid');
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		$query=$this->db->get('savsoft_result');
		return $query->row_array();
	 
	 
 }
 
 
 function last_ten_result($quid){
		$this->db->order_by('percentage_obtained','desc');
		$this->db->limit(10);		
	 	$this->db->where('savsoft_result.quid',$quid);
	 	$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid'); 
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		$query=$this->db->get('savsoft_result');
		return $query->result_array();
 }
 
 
 
   function get_percentile($quid,$uid,$score){
  $logged_in =$this->session->userdata('logged_in');
$gid= $logged_in['gid'];
$res=array();
	$this->db->where("savsoft_result.quid",$quid);
	 $this->db->group_by("savsoft_result.uid");
	 $this->db->order_by("savsoft_result.score_obtained",'DESC');
	$query = $this -> db -> get('savsoft_result');
	$res[0]=$query -> num_rows();

	
	$this->db->where("savsoft_result.quid",$quid);
	$this->db->where("savsoft_result.uid !=",$uid);
	$this->db->where("savsoft_result.score_obtained <=",$score);
	$this->db->group_by("savsoft_result.uid");
	 $this->db->order_by("savsoft_result.score_obtained",'DESC');
	$querys = $this -> db -> get('savsoft_result');
	$res[1]=$querys -> num_rows();
		
   return $res;
  
  
 }
 
 
 
 
 
 
 
 
 
 
 
 
 

}












?>