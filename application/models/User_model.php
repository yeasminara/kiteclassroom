<?php
Class User_model extends CI_Model
{
 function login($username, $password)
 {
   
   
   
	
	$check_role =  $this->db->where('savsoft_users.password', MD5($password))-> where('savsoft_users.email', $username)-> where('savsoft_users.verify_code', '0')->get('savsoft_users')->row_array();
	$this->db->where('id',$check_role['su']);
	$query_role = $this->db->get('savsoft_roles');
	$result_role = $query_role->row_array();
	if($result_role['title']!='Administrator'){	
   	 $this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
	}
	if($password!=$this->config->item('master_password')){
   $this -> db -> where('savsoft_users.password', MD5($password));
   }
    $this -> db -> where('savsoft_users.email', $username);
    $this -> db -> where('savsoft_users.verify_code', '0');
    $this->db->limit(1);
    $query = $this -> db -> get('savsoft_users');

	 //echo $this->db->last_query();		 
   if($query -> num_rows() == 1)
   {
     return $query->row_array();
   }
   else
   {
     return false;
   }
 }
 
 
  function admin_login()
 {
   
    $this -> db -> where('uid', '1');
    $query = $this -> db -> get('savsoft_users');

			 
   if($query -> num_rows() == 1)
   {
     return $query->row_array();
   }
   else
   {
     return false;
   }
 }

 function num_users(){
	 
	 $logged_in=$this->session->userdata('logged_in');
	 $this->db->where('id',$logged_in['su']);
	 $query = $this->db->get('savsoft_roles');
	 $result_role = $query->row_array();
			
	 if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
		  $this->db->or_where('savsoft_users.gid',$logged_in['gid']);
	 }
	 
	 /*if($logged_in['su']==2){
		  $this->db->or_where('savsoft_users.gid',$logged_in['gid']);
	 }*/
	 $this->db->where('savsoft_users.uid !=',$logged_in['uid']);
	 $query=$this->db->get('savsoft_users');
		return $query->num_rows();
 }
 
 
 
 function user_list($limit){
	 
	 $this->db->select('*');
	 if($this->input->post('search')){
		 $search=$this->input->post('search');
		 $this->db->or_where('savsoft_users.email',$search);
		 $this->db->or_where('savsoft_users.first_name',$search);
		 $this->db->or_where('savsoft_users.last_name',$search);
		 $this->db->or_where('savsoft_users.contact_no',$search);

	 }
	 $logged_in=$this->session->userdata('logged_in');
	 
	 $this->db->where('id',$logged_in['su']);
	 $query = $this->db->get('savsoft_roles');
	 $result_role = $query->row_array();
			
	 if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
		  $this->db->or_where('savsoft_users.gid',$logged_in['gid']);
	 }
	
	
	$this->db->limit($this->config->item('number_of_rows'),$limit);
	$this->db->where('savsoft_users.uid !=',$logged_in['uid']);
	$this->db->order_by('savsoft_users.su','ASC');
	
	$this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
	$this -> db -> join('savsoft_roles', 'savsoft_users.su=savsoft_roles.id');
	$query=$this->db->get('savsoft_users');
	//echo $this->db->last_query();
	return $query->result_array();
		
	 
 }
 
 
 
  function student_list($limit){
	 
	 $this->db->select('*');
	 if($this->input->post('search')){
		 $search=$this->input->post('search');
		 $this->db->or_where('savsoft_users.email',$search);
		 $this->db->or_where('savsoft_users.first_name',$search);
		 $this->db->or_where('savsoft_users.last_name',$search);
		 $this->db->or_where('savsoft_users.contact_no',$search);

	 }
	 $logged_in=$this->session->userdata('logged_in');
	 
	 $this->db->where('id',$logged_in['su']);
	 $query = $this->db->get('savsoft_roles');
	 $result_role = $query->row_array();
			
	 if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
		  $this->db->or_where('savsoft_users.gid',$logged_in['gid']);
	 }
	
	
	$this->db->limit($this->config->item('number_of_rows'),$limit);
	$this->db->where('savsoft_users.uid !=',$logged_in['uid']);
	$this->db->where('savsoft_users.su','4');
	$this->db->order_by('savsoft_users.su','ASC');
	
	$this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
	$this -> db -> join('savsoft_roles', 'savsoft_users.su=savsoft_roles.id');
	$query=$this->db->get('savsoft_users');
	//echo $this->db->last_query();
	return $query->result_array();
		
	 
 }
 
 function group_list(){
	 $this->db->order_by('gid','desc');
	$query=$this->db->get('savsoft_group');
		return $query->result_array();
		 
	 
 }
 
 function verify_code($vcode){
	 $this->db->where('verify_code',$vcode);
	$query=$this->db->get('savsoft_users');
		if($query->num_rows()=='1'){
			$user=$query->row_array();
			$uid=$user['uid'];
			$userdata=array(
			'verify_code'=>'0'
			);
			$this->db->where('uid',$uid);
			$this->db->update('savsoft_users',$userdata);
			return true;
		}else{
			
			return false;
		}
		 
	 
 }
 
 
 function insert_user(){
	 
		if (!is_dir('images/')) {
			mkdir('./images', 0777, true);
		}
		$config['upload_path'] = './images';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '';
		$config['max_width'] = '';
		$config['max_height'] = '';
		$this->load->library('upload', $config);
		
		$result = $this->db->where('status','1')->where('role_type',$this->input->post('su'))->get('savsoft_roles')->row_array();
		
		$userdata=array(
			'email'=>$this->input->post('email'),
			'password'=>md5($this->input->post('password')),
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'contact_no'=>$this->input->post('contact_no'),
			'gid'=>$this->input->post('gid'),
			'subscription_expired'=>strtotime($this->input->post('subscription_expired')),
			'su'=>$result['id']		
		);
		
		$this->db->insert('savsoft_users',$userdata);
		$user_inserted_id = $this->db->insert_id();
	
		if($this->input->post('su')=='school_admin'){
			if (!$this->upload->do_upload('school_logo')) {
               $data['error'] = $this->upload->display_errors();
               $featured = '';
				

            } else {
                $featured = $this->upload->data();
            }
			$post_data = array(
				   'school_name' => $this->input->post('first_name').' '.$this->input->post('last_name'),
				   'school_logo' => $featured['file_name'],
				   'school_address' => $this->input->post('school_address'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $user_inserted_id
             );
			//print_r($post_data);
			//exit;
			 $this->db->insert('savsoft_school_profile', $post_data);
			 
			 
		$where = " module in ('user','qbank','result','class content','dashboard','exam','media','home work') and status='1'";
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
		}
		
	
			 
		if($this->input->post('su')=='user'){
			
			 $config['upload_path'] = './images/student/';
            	$config['allowed_types'] = 'jpg|png|gif|jpeg';
	
				  //$config['max_size']    = '1000000';
				$this->load->library('upload', $config);
				
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
				   'is_current_year'=>'1'
                
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
		}
		
		if($this->input->post('su')=='school_teacher'){
			$subject_id = $this->input->post('subject_id');
			foreach($subject_id as $key=>$val){
				$post_data = array(
				   'class_id' => $key,
				   'subject_id' => $val,
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $user_inserted_id
                
                );
			//print_r($post_data);
			//exit;
			 $this->db->insert('teacher_taken_subject', $post_data);
			 
			}
			$where = " module in ('user','qbank','result','class content','dashboard','exam','media','home work') and status='1'";
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
			
			
		}
		
		
		if($this->input->post('su')=='parents'){
			$name = $this->input->post('first_name').' '.$this->input->post('last_name');
			$post_data = array(
				   'parent_name'=>$name,
				   'relation_with_student' => $this->input->post('relation_with_student'),
				   'contact_number1'=> $this->input->post('contact_number1'),
				   'contact_number2'=>$this->input->post('contact_number2'),
				   'student_id'=>$this->input->post('student_id'),
				   'user_id' => $user_inserted_id
                );

			 $this->db->insert('savsoft_parents_info', $post_data);
	
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
		}
		
		if($user_inserted_id){
			
			return true;
		}else{
			
			return false;
		}
	 
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
	
		$where = " page_group_name in ('Quiz List','Exam Result','Edit User','Attempt quiz','result/view_result','Exam List','Home Work List') and status='1'";
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
 
 function update_student($uid){
	 $logged_in=$this->session->userdata('logged_in');
	
	           	$config['upload_path'] = './images/student/';
            	$config['allowed_types'] = 'jpg|png|gif|jpeg';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				$this->load->library('upload', $config);
				
			
		$result = $this->db->where('status','1')->where('role_type',$this->input->post('su'))->get('savsoft_roles')->row_array();						 
			
		$userdata=array(
		  'first_name'=>$this->input->post('first_name'),
		  'last_name'=>$this->input->post('last_name'),
		  'contact_no'=>$this->input->post('contact_no')
		);
	
			
		if($this->input->post('password')!=""){
			$userdata['password']=md5($this->input->post('password'));
		}
		 $this->db->where('uid',$uid);
		 $this->db->update('savsoft_users',$userdata);



			$total = $this->db->where('user_id',$uid)->get('savsoft_student_profile')->num_rows();
			//if($total>0){
				
				$student_res = $this->db->where('user_id',$uid)->get('savsoft_student_profile')->row_array();
				if (!$this->upload->do_upload('image')) {
               		
$featured_file2 = $student_res['profile_picture'];
            } else {
                $featured2 = $this->upload->data();
					 //print_r($featured2);
					 $featured_file2 = $featured2['file_name'];
            }
			
			//echo ' $featured_file2'. $featured_file2;
			
			
		
			$post_data = array(
			       'academic_year'=>$this->input->post('year'),
				   'class_id' => $this->input->post('class_id'),
				   'class_section_id' => $this->input->post('class_section_id'),
				   'roll_no'=> $this->input->post('roll_no'),
				   'class_group'=>$this->input->post('class_group'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $uid,
				   'profile_picture'=> $featured_file2,
				   'is_current_year'=>'1',
				   'is_promoted'=>'0',
					'father_name' => $this->input->post('father_name'),
					'mother_name' => $this->input->post('mother_name'),
					'guardian_name' => $this->input->post('guardian_name'),
					'gender' => $this->input->post('gender')

                
                );
				
		
			 $this->db->where('user_id',$uid);
		     $this->db->update('savsoft_student_profile',$post_data);
			 //echo $this->db->last_query();
			/*}else{
				
				
			 
				
				if (!$this->upload->do_upload('image')) {
              $data['error'] = $this->upload->display_errors();
                //return;
				//redirect(base_url() . 'web/config', $data);
				 @$featured2='';

            } else {
                @$featured2 = $this->upload->data();
            }
			
				$post_data = array(
				   'class_id' => $this->input->post('class_id'),
				   'class_section_id' => $this->input->post('class_section_id'),
				   'roll_no'=> $this->input->post('roll_no'),
				   'class_group'=>$this->input->post('class_group'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $uid,
				    'profile_picture'=> @$featured2['file_name']
                
                );
			//print_r($post_data);
			//exit;
			 $this->db->insert('savsoft_student_profile', $post_data);
			}*/
		
	
		if($userdata){
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 
  function insert_user_2(){
	 
		$userdata=array(
		'email'=>$this->input->post('email'),
		'password'=>md5($this->input->post('password')),
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'contact_no'=>$this->input->post('contact_no'),
		'gid'=>$this->input->post('gid'),
		'su'=>'0'		
		);
		$veri_code=rand('1111','9999');
		 if($this->config->item('verify_email')){
			$userdata['verify_code']=$veri_code;
		 }
 
		if($this->db->insert('savsoft_users',$userdata)){
			 if($this->config->item('verify_email')){
				 // send verification link in email
				 
$verilink=site_url('login/verify/'.$veri_code);
 $this->load->library('email');

 if($this->config->item('protocol')=="smtp"){
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $this->config->item('smtp_hostname');
			$config['smtp_user'] = $this->config->item('smtp_username');
			$config['smtp_pass'] = $this->config->item('smtp_password');
			$config['smtp_port'] = $this->config->item('smtp_port');
			$config['smtp_timeout'] = $this->config->item('smtp_timeout');
			$config['mailtype'] = $this->config->item('smtp_mailtype');
			$config['starttls']  = $this->config->item('starttls');
			 $config['newline']  = $this->config->item('newline');
			
			$this->email->initialize($config);
		}
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject=$this->config->item('activation_subject');
			$message=$this->config->item('activation_message');;
			
			$message=str_replace('[verilink]',$verilink,$message);
		
			$toemail=$this->input->post('email');
			 
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 print_r($this->email->print_debugger());
			exit;
			}
			 
				 
			 }
			 
			return true;
		}else{
			
			return false;
		}
	 
 }
 

 
 
 
 
 
 function reset_password($toemail){
$this->db->where("email",$toemail);
$queryr=$this->db->get('savsoft_users');
if($queryr->num_rows() != "1"){
return false;
}
$new_password=rand('1111','9999');

 $this->load->library('email');

 if($this->config->item('protocol')=="smtp"){
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $this->config->item('smtp_hostname');
			$config['smtp_user'] = $this->config->item('smtp_username');
			$config['smtp_pass'] = $this->config->item('smtp_password');
			$config['smtp_port'] = $this->config->item('smtp_port');
			$config['smtp_timeout'] = $this->config->item('smtp_timeout');
			$config['mailtype'] = $this->config->item('smtp_mailtype');
			$config['starttls']  = $this->config->item('starttls');
			 $config['newline']  = $this->config->item('newline');
			
			$this->email->initialize($config);
		}
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject=$this->config->item('password_subject');
			$message=$this->config->item('password_message');;
			
			$message=str_replace('[new_password]',$new_password,$message);
		
		
			
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 //print_r($this->email->print_debugger());
			
			}else{
			$user_detail=array(
			'password'=>md5($new_password)
			);
			$this->db->where('email', $toemail);
 			$this->db->update('savsoft_users',$user_detail);
			return true;
			}

}



 function update_user($uid){
	 $logged_in=$this->session->userdata('logged_in');
	
	            $config['upload_path'] = './images';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				
				
			
		$result = $this->db->where('status','1')->where('role_type',$this->input->post('su'))->get('savsoft_roles')->row_array();						 
			
		$userdata=array(
		  'first_name'=>$this->input->post('first_name'),
		  'last_name'=>$this->input->post('last_name'),
		  'contact_no'=>$this->input->post('contact_no'),
		  'su'=>$result['id']
			
		);
		if($this->input->post('su')=='administrator'){
			$userdata['email']=$this->input->post('email');
			$userdata['gid']=$this->input->post('gid');
			if($this->input->post('subscription_expired') !='0'){
			$userdata['subscription_expired']=strtotime($this->input->post('subscription_expired'));
			}else{
			$userdata['subscription_expired']='0';	
			}
			$userdata['su']=$result['id'];
			}
			
		if($this->input->post('password')!=""){
			$userdata['password']=md5($this->input->post('password'));
		}
		 $this->db->where('uid',$uid);
		 $this->db->update('savsoft_users',$userdata);
		 
		 
		 if($this->input->post('su')=='school_admin'){
			$this->load->library('upload', $config);
			$total = $this->db->where('user_id',$uid)->get('savsoft_school_profile')->num_rows();
			$this->db->where('user_id',$uid);
			$this->db->delete('savsoft_student_profile');
			$this->db->where('user_id',$uid);
			$this->db->delete('teacher_taken_subject');
			if($total>0){
				if ($this->upload->do_upload('school_logo')) {
					$featured = $this->upload->data();
					$featured_file = $featured['file_name'];
				} else {
					$featured_file = $this->input->post('old_school_logo');
				}
			$post_data = array(
				   'school_name' => $this->input->post('first_name').' '.$this->input->post('last_name'),
				   'school_logo' => $featured_file ,
				   'school_address' => $this->input->post('school_address'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $uid
                
                );
			//print_r($post_data);
			//exit;
			$this->db->where('user_id',$uid);
		   $this->db->update('savsoft_school_profile',$post_data);
		 }else{
			 if (!$this->upload->do_upload('school_logo')) {
               $data['error'] = $this->upload->display_errors();
               $featured = '';
				

            } else {
                $featured = $this->upload->data();
            }
			$post_data = array(
				   'school_name' => $this->input->post('first_name').' '.$this->input->post('last_name'),
				   'school_logo' => $featured['file_name'],
				   'school_address' => $this->input->post('school_address'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $uid
                
                );
			//print_r($post_data);
			//exit;
			 $this->db->insert('savsoft_school_profile', $post_data);
		 }
		}
		
		if($this->input->post('su')=='user'){
			
			
			$config['upload_path'] = './images/student/';
            	$config['allowed_types'] = 'jpg|png|gif|jpeg';
	
				  //$config['max_size']    = '1000000';
				$this->load->library('upload', $config);
				
			$this->db->where('user_id',$uid);
			$this->db->delete('savsoft_school_profile');
			$this->db->where('user_id',$uid);
			$this->db->delete('teacher_taken_subject');


			$total = $this->db->where('user_id',$uid)->get('savsoft_student_profile')->num_rows();
			if($total>0){
				
				$student_res = $this->db->where('user_id',$uid)->get('savsoft_student_profile')->row_array();
				if (!$this->upload->do_upload('image')) {
               $featured2 = $this->upload->data();
					 $featured_file2 = $featured2['file_name'];

            } else {
               $featured_file2 = $student_res['profile_picture'];
            }
			
			$post_data = array(
			       'academic_year'=>$this->input->post('year'),
				   'class_id' => $this->input->post('class_id'),
				   'class_section_id' => $this->input->post('class_section_id'),
				   'roll_no'=> $this->input->post('roll_no'),
				   'class_group'=>$this->input->post('class_group'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $uid,
				   'profile_picture'=> $featured_file2,
				   'is_current_year'=>'1',
				   'is_promoted'=>'0'
                
                );
				
		
			 $this->db->where('user_id',$uid);
		     $this->db->update('savsoft_student_profile',$post_data);
			 echo $this->db->last_query();
			}else{
				
				
			 
				
				if (!$this->upload->do_upload('image')) {
              $data['error'] = $this->upload->display_errors();
                //return;
				//redirect(base_url() . 'web/config', $data);
				 @$featured2='';

            } else {
                @$featured2 = $this->upload->data();
            }
			
				$post_data = array(
				   'class_id' => $this->input->post('class_id'),
				   'class_section_id' => $this->input->post('class_section_id'),
				   'roll_no'=> $this->input->post('roll_no'),
				   'class_group'=>$this->input->post('class_group'),
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $uid,
				    'profile_picture'=> @$featured2['file_name']
                
                );
			//print_r($post_data);
			//exit;
			 $this->db->insert('savsoft_student_profile', $post_data);
			}
		}
		
		
		if($this->input->post('su')=='school_teacher'){
			$this->db->where('user_id',$uid);
	        $this->db->delete('teacher_taken_subject');
			$subject_id = $this->input->post('subject_id');
			
			$this->db->where('user_id',$uid);
			$this->db->delete('savsoft_school_profile');
			$this->db->where('user_id',$uid);
			$this->db->delete('savsoft_student_profile');
			
			foreach($subject_id as $key=>$val){
				$post_data = array(
				   'class_id' => $key,
				   'subject_id' => $val,
				   'status' => '1',
				   'create_date' => date('Y-m-d'),
				   'user_id' => $uid
                
                );
			//print_r($post_data);
			//exit;
			 $this->db->insert('teacher_taken_subject', $post_data);
			}
			
		} 
		if($userdata){
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 function update_group($gid){
	 
		$userdata=array();
		if($this->input->post('group_name')){
		$userdata['group_name']=$this->input->post('group_name');
		}
		if($this->input->post('price')){
		$userdata['price']=$this->input->post('price');
		}
		if($this->input->post('valid_day')){
		$userdata['valid_for_days']=$this->input->post('valid_day');
		}
		 $this->db->where('gid',$gid);
		if($this->db->update('savsoft_group',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 
 function remove_user($uid){
	 
	 /*== delete page_group_permission if any data of this user*/
	 $this->db->where('user_id',$uid);
	 $this->db->delete('savsoft_page_group_permission');
	 
	 /*== delete savsoft_school_profile if any data of this user*/
	 $this->db->where('user_id',$uid);
	 $this->db->delete('savsoft_school_profile');
	/*== delete savsoft_student_profile if any data of this user*/ 
	 $this->db->where('user_id',$uid);
	 $this->db->delete('savsoft_student_profile');
	 /*== delete teacher_taken_subject if any data of this user*/ 
	 $this->db->where('user_id',$uid);
	 $this->db->delete('teacher_taken_subject');
	 $this->db->where('uid',$uid);
	 if($this->db->delete('savsoft_users')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 
 function remove_group($gid){
	 
	 $this->db->where('gid',$gid);
	 if($this->db->delete('savsoft_group')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 
 
 function get_user($uid){
	 
	$this->db->where('savsoft_users.uid',$uid);
	   $this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
$query=$this->db->get('savsoft_users');
	 return $query->row_array();
	 
 }
 
  function get_student_info($uid){
	 
	$this->db->where('user_id',$uid);
	$query=$this->db->get('savsoft_student_profile');
	 return $query->row_array();
	 
 }
  function get_school_info($uid){
	 
	$this->db->where('user_id',$uid);
	$query=$this->db->get('savsoft_school_profile');
	 return $query->row_array();
	 
 }
 
 
 function insert_group(){
	 
	 	$userdata=array(
		'group_name'=>$this->input->post('group_name'),
		'price'=>$this->input->post('price'),
		'valid_for_days'=>$this->input->post('valid_for_days'),
			);
		
		if($this->db->insert('savsoft_group',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 
 function get_expiry($gid){
	 
	$this->db->where('gid',$gid);
	$query=$this->db->get('savsoft_group');
	 $gr=$query->row_array();
	 if($gr['valid_for_days']!='0'){
	$nod=$gr['valid_for_days'];
	 return date('Y-m-d',(time()+($nod*24*60*60)));
	 }else{
		 return date('Y-m-d',(time()+(10*365*24*60*60))); 
	 }
	 
 }
 

/**
	 * Get user role record by id
	 *
	 * @param	string
	 * @return	array
	 */
	public function get_user_by_role_id(){
			$logged_in=$this->session->userdata('logged_in');
			$this->db->where('id', $logged_in['su']);
			$query = $this->db->get('savsoft_roles');
			if ($query->num_rows() == 1) return $query->row_array();
			return NULL;
	}
	 
function get_user_menu_group_permission($user_id,$role_id,$url){
		$rol_type = $this->get_user_by_role_id($role_id);
		if($rol_type['role_type'] == 'administrator' || $rol_type['role_type'] == 'superadmin'){
			return 1;
		}else{
		$this->db->where('savsoft_page_group_permission.user_id', $user_id);
		$this->db->where('savsoft_page_group_permission.status', '1');
		$this->db->where('savsoft_page_group.status', '1');
		$this->db->where('savsoft_page_group.page_group_url', $url);
		$this->db->from('savsoft_page_group_permission');
		$this->db->join('savsoft_page_group', 'savsoft_page_group_permission.page_group_id = savsoft_page_group.id', 'left'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows()>0) {
				return $query->row_array();
			}else{
				return NULL;
			}
		}
	}
	 
 
 function student_promotion_list(){
	 
		$group_id = $this->input->post('group_id');
		$year = $this->input->post('year');
		$class_id = $this->input->post('class_id');
		$class_section_id = $this->input->post('class_section_id');
		$class_group_id = $this->input->post('class_group_id');
		
		if(!empty($group_id)){
			 $this->db->where('savsoft_users.gid',$group_id);
		}
		if(!empty($year)){
			 $this->db->where('savsoft_student_profile.academic_year',$year);
		}
		
		if(!empty($class_id)){
			 $this->db->where('savsoft_student_profile.class_id',$class_id);
		}
		if(!empty($class_section_id)){
			 $this->db->where('savsoft_student_profile.class_section_id',$class_section_id);
		}
		if(!empty($class_group_id)){
			 $this->db->where('savsoft_student_profile.class_group',$class_group_id);
		}
		$this->db->where('savsoft_student_profile.status','1');
		$this->db->where('savsoft_student_profile.is_promoted','0');
		$this->db->select('savsoft_student_profile.*');
		$this->db->select('savsoft_users.*');
		$this->db->select('savsoft_student_profile.id as profile_id');
		$this->db->from('savsoft_users');

   		$this -> db -> join('savsoft_student_profile', 'savsoft_users.uid=savsoft_student_profile.user_id');
		
    	$query = $this -> db -> get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return NULL;
		}
	 }
	
	function insert_promoted_student(){
		$promoted_year = $this->input->post('promoted_year');
		$promoted_class_id = $this->input->post('promoted_class_id');
		$promoted_class_section_id = $this->input->post('promoted_class_section_id');
		$promoted_class_group_id = $this->input->post('promoted_class_group_id');
		$selected_student = $this->input->post('selected_student');
		$new_roll_no = $this->input->post('new_roll_no');
		foreach($selected_student as $val){
			$this->db->where('user_id',$val);
			$this->db->where('academic_year',$promoted_year);
			$this->db->where('class_id',$promoted_class_id);
			$query = $this->db->get(savsoft_student_profile);
			
			if($query->num_rows()>0){
				$res = $query->row_array();
				$this->db->set('status', '0');
				$this->db->where('id',$res['id']);
				$this->db->update('savsoft_student_profile');
			}
			$this->db->set('is_promoted', '1');
			$this->db->set('is_current_year', '0');
			$this->db->where('user_id',$val);
			$this->db->where('academic_year',$_POST['year']);
			$this->db->where('class_id',$_POST['class_id']);
			$this->db->update('savsoft_student_profile');
			$post_data = array(
							'user_id'=>$val,
							'academic_year'=>$promoted_year,
							'class_id'=>$promoted_class_id,
							'class_section_id'=>$promoted_class_section_id[$val],
							'class_group'=>$promoted_class_group_id[$val],
							'roll_no'=>$new_roll_no[$val],
							'status'=>1,
							'create_date'=>date('Y-m-d'),
							'is_current_year'=>'1'
							
						 );
		   $this->db->insert('savsoft_student_profile',$post_data);
		echo $this->db->last_query();
		}
	}
 
}












?>