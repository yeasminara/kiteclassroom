<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("quiz_model");
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
			 
			
			
		$data['limit']=$limit;
		$data['title']=$this->lang->line('quiz');
		// fetching quiz list
	
		
		
		
	
		// fetching quiz list
		$data['class_list']=$this->qbank_model->class_list(); 
		$data['result']=$this->quiz_model->quiz_list($limit);
		/*$this->load->view('header',$data);
		$this->load->view('quiz_list',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('quiz_list',$data, true);
        $this->load->view('template', $data);
	}
	
	public function add_new()
	{
		$logged_in=$this->session->userdata('logged_in');
		 //echo $logged_in['su'];
			if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
			
			}
		$data['title']=$this->lang->line('add_new').' '.$this->lang->line('quiz');
		$data['group_type'] = $logged_in['su'];
		$data['group_id'] = $logged_in['gid'];
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$data['class_list']=$this->qbank_model->class_list(); 
		$data['class_section_list']=$this->db->where('status','1')->get('savsoft_class_section')->result_array(); 
		$data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array(); 

	/*	$this->load->view('header',$data);
		$this->load->view('new_quiz',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('new_quiz',$data, true);
        $this->load->view('template', $data);
	}
	
		
		
	
	
	
	
	
	
	
	public function edit_quiz($quid)
	{
		
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
			}
			
			
	 
		$data['title']=$this->lang->line('edit').' '.$this->lang->line('quiz');
		// fetching group list
		if($logged_in['su']=='2'){
			$data['group_list'] = $this->db->where('gid',$logged_in['gid'])->get('savsoft_group')->result_array();
		}else{
		$data['group_list']=$this->user_model->group_list();
		}
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		if($data['quiz']['question_selection']=='0'){
		$data['questions']=$this->quiz_model->get_questions($data['quiz']['qids']);
			 
		}else{
			$this->load->model("qbank_model");
	        $data['qcl']=$this->quiz_model->get_qcl($data['quiz']['quid']);
		
		 $data['category_list']=$this->qbank_model->category_list();
		 $data['level_list']=$this->qbank_model->level_list();
		
		}
		$data['class_list']=$this->qbank_model->class_list();
	    $data['class_section_list']=$this->db->where('status','1')->get('savsoft_class_section')->result_array(); 
		$data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array(); 
		/*$this->load->view('header',$data);
		$this->load->view('edit_quiz',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('edit_quiz',$data, true);
        $this->load->view('template', $data);
	}
	
	
	
	
	function no_q_available($cid,$lid){
		$val="<select name='noq[]'>";
		$query=$this->db->query(" select * from savsoft_qbank where cid='$cid' and lid='$lid' ");
		$nor=$query->num_rows();
		for($i=0; $i<= $nor; $i++){
			$val.="<option value='".$i."' >".$i."</option>";
			
			
		}
		$val.="</select>";
		echo $val;
		
	}
	
	
	
	
	function remove_qid($quid,$qid){
		
		if($this->quiz_model->remove_qid($quid,$qid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
		}
		redirect('quiz/edit_quiz/'.$quid);
	}
	
	function add_qid($quid,$qid){
		
		 $this->quiz_model->add_qid($quid,$qid);
          echo 'added';              
	}
	
	
	
	function pre_add_question($quid,$limit='0',$cid='0',$lid='0'){
		//$cid=$this->input->post('cid');
		$lid=$this->input->post('lid');
		$cid=$this->input->post('subject_id');
		$lid=$this->input->post('lid');
		$class_id= $this->input->post('class_id');
		$chapter_id= $this->input->post('chapter_id');
		$lession_id= $this->input->post('lession_id');
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
		}
			
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		$data['title']=$this->lang->line('add_question_into_quiz').': '.$data['quiz']['quiz_name'];
		if($data['quiz']['question_selection']=='0'){
			$data['result']=$this->qbank_model->question_list($limit,$cid,$lid);
			//echo $this->db->last_query();
			$data['category_list']=$this->qbank_model->category_list();
			$data['level_list']=$this->qbank_model->level_list();
		}else{
			exit($this->lang->line('permission_denied'));
		}
		$data['limit']=$limit;
		$data['cid']=$cid;
		$data['lid']=$lid;
		$data['quid']=$quid;
		$data['class_list']=$this->qbank_model->class_list();
		$data['class_id']=$class_id;
		$data['chapter_id']=$chapter_id;
		$data['lession_id']=$lession_id; 
	/*	$this->load->view('header',$data);
		$this->load->view('add_question_into_quiz',$data);
		$this->load->view('footer',$data);*/
		
			$data['middle'] = $this->load->view('add_question_into_quiz',$data, true);
        $this->load->view('template', $data);
		
		//redirect('quiz/add_question/'.$quid.'/'.$limit.'/'.$cid.'/'.$lid);
	}
	
	
	
	public function add_question($quid,$limit='0',$cid='0',$lid='0')
	{
		
	   
		
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
			}
			
			
	 
		 $data['quiz']=$this->quiz_model->get_quiz($quid);
		$data['title']=$this->lang->line('add_question_into_quiz').': '.$data['quiz']['quiz_name'];
		if($data['quiz']['question_selection']=='0'){
		$class_id = $data['quiz']['class_id'];
		$subject_id = $data['quiz']['subject_id]'];
		$data['result']=$this->qbank_model->question_list($limit,$cid,$lid,$class_id,$subject_id);
		// $data['category_list']=$this->qbank_model->category_list();
		 
		 $data['category_list']=$this->db->where('cid',$subject_id)->get('savsoft_category')->result_array(); 
		 $data['level_list']=$this->qbank_model->level_list();
			 
		}else{
			
			exit($this->lang->line('permission_denied'));
		}
		$data['limit']=$limit;
		$data['cid']=$cid;
		$data['lid']=$lid;
		$data['quid']=$quid;
		$data['class_list']=$this->db->where('id',$class_id)->get('savsoft_class')->result_array(); 
		/*$this->load->view('header',$data);
		$this->load->view('add_question_into_quiz',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('add_question_into_quiz',$data, true);
        $this->load->view('template', $data);
	}
	
	
	
	
	function up_question($quid,$qid,$not='1'){
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit($this->lang->line('permission_denied'));
	return;
	}		
	for($i=1; $i <= $not; $i++){
	$this->quiz_model->up_question($quid,$qid);
	}
	redirect('quiz/edit_quiz/'.$quid, 'refresh');
	}
	
	
	
	
	
	
	function down_question($quid,$qid,$not='1'){
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit($this->lang->line('permission_denied'));
	return;
	}	
			for($i=1; $i <= $not; $i++){
	$this->quiz_model->down_question($quid,$qid);
	}
	redirect('quiz/edit_quiz/'.$quid, 'refresh');
	}
	
	
	
	
		public function insert_quiz()
	{

			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('quiz_name', 'quiz_name', 'required');
           if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('quiz/add_new/');
                }
                else
                {
					$quid=$this->quiz_model->insert_quiz();
                   
					redirect('quiz/edit_quiz/'.$quid);
                }       

	}
	
		public function update_quiz($quid)
	{
		
		
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('quiz_name', 'quiz_name', 'required');
           if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('quiz/edit_quiz/'.$quid);
                }
                else
                {
					$quid=$this->quiz_model->update_quiz($quid);
                   
					redirect('quiz/edit_quiz/'.$quid);
                }       

	}
	
	
	
	

	
	
	
	
	
	
	public function remove_quiz($quid){

			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			} 
			
			if($this->quiz_model->remove_quiz($quid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('quiz');
                     
			
		}
	



	public function quiz_detail($quid){
		
		$logged_in=$this->session->userdata('logged_in');
		$gid=$logged_in['gid'];
		$data['title']=$this->lang->line('attempt').' '.$this->lang->line('quiz');
		
		$data['quiz']=$this->quiz_model->get_quiz($quid);
	/*	$this->load->view('header',$data);
		$this->load->view('quiz_detail',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('quiz_detail',$data, true);
        $this->load->view('template', $data);
		
	}
	
	public function validate_quiz($quid){
		 
		$logged_in=$this->session->userdata('logged_in');
		$gid=$logged_in['gid'];
		$uid=$logged_in['uid'];
		
		
		 // if this quiz already opened by user then resume it
		$open_result=$this->quiz_model->open_result($quid,$uid);
		//print_r($open_result);
		if($open_result != '0'){
			$this->session->set_userdata('rid', $open_result);
			redirect('quiz/attempt/'.$open_result);	
		}else{
				$data['quiz']=$this->quiz_model->get_quiz($quid);
		// validate assigned group
		if(!in_array($gid,explode(',',$data['quiz']['gids']))){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_assigned_to_your_group')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		}
	
		// validate start end date/time
		if($data['quiz']['start_date'] > time()){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		// validate start end date/time
		if($data['quiz']['end_date'] < time()){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }

		// validate ip address
		if($data['quiz']['ip_address'] !=''){
		$ip_address=explode(",",$data['quiz']['ip_address']);
		$myip=$_SERVER['REMOTE_ADDR'];
		if(!in_array($myip,$ip_address)){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('ip_declined')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		}
		 // validate maximum attempts
		$maximum_attempt=$this->quiz_model->count_result($quid,$uid);
		if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		
		// insert result row and get rid (result id)
		$rid=$this->quiz_model->insert_result($quid,$uid);
		
		$this->session->set_userdata('rid', $rid);
		redirect('quiz/attempt/'.$rid);	
		
		
	}
	
	
	public function attempt($rid){
		
		$srid=$this->session->userdata('rid');
						// if linked and session rid is not matched then something wrong.
			if($rid != $srid){
		 
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/');

			}

		if(!$this->session->userdata('logged_in')){
			exit($this->lang->line('permission_denied'));
		}
		// get result and quiz info and validate time period
		$data['quiz']=$this->quiz_model->quiz_result($rid);
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		

			
			
		// end date/time
		if($data['quiz']['end_date'] < time()){
		$this->quiz_model->submit_result($rid);
		$this->session->unset_userdata('rid');
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/quiz_detail/'.$data['quiz']['quid']);
		 }

		
		// end date/time
		if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
		$this->quiz_model->submit_result($rid);
		$this->session->unset_userdata('rid');
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
		redirect('quiz/quiz_detail/'.$data['quiz']['quid']);
		 }
		// remaining time in seconds 
		$data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
		// get questions
		$data['questions']=$this->quiz_model->get_questions($data['quiz']['r_qids']);
		// get options
		$data['options']=$this->quiz_model->get_options($data['quiz']['r_qids']);
		$data['title']=$data['quiz']['quiz_name'];
		$this->load->view('header',$data);
		$this->load->view('quiz_attempt',$data);
		$this->load->view('footer',$data);
		
	}
	
	function quiz_download($rid){
		$srid=$this->session->userdata('rid');
						// if linked and session rid is not matched then something wrong.
			/*if($rid != $srid){
		 
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/');

			}*/

		if(!$this->session->userdata('logged_in')){
			exit($this->lang->line('permission_denied'));
		}
		// get result and quiz info and validate time period
		$data['quiz']=$this->db->where('quid',$rid)->get('savsoft_quiz')->row_array();
		$qids = $data['quiz']['qids'];
			
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		
		 $query=$this->db->query("select * from savsoft_qbank join savsoft_category on savsoft_category.cid=savsoft_qbank.cid join savsoft_level on savsoft_level.lid=savsoft_qbank.lid 
	 where savsoft_qbank.qid in ($qids) order by FIELD(savsoft_qbank.qid,$qids) 
	 ");
	 //echo $this->db->last_query();
	 $data['questions']=$query->result_array();
		
		//$data['questions']=$this->quiz_model->get_questions($data['quiz']['r_qids']);
		// get options
		$data['options']=$this->quiz_model->get_options($data['quiz']['r_qids']);
		$data['title']=$data['quiz']['quiz_name'];
		$this->load->view('header',$data);
		$this->load->view('quiz_download',$data);
		$this->load->view('footer',$data);
	}
	/*function attempt($rid){
		
		
		  $srid=$this->session->userdata('rid');
						// if linked and session rid is not matched then something wrong.
			if($rid != $srid){
		 
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/');

			}

		if(!$this->session->userdata('logged_in')){
			exit($this->lang->line('permission_denied'));
		}
		// get result and quiz info and validate time period
		$data['quiz']=$this->quiz_model->quiz_result($rid);
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		

			
			
		// end date/time
		if($data['quiz']['end_date'] < time()){
		$this->quiz_model->submit_result($rid);
		$this->session->unset_userdata('rid');
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/quiz_detail/'.$data['quiz']['quid']);
		 }

		
		// end date/time
		if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
		$this->quiz_model->submit_result($rid);
		$this->session->unset_userdata('rid');
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
		redirect('quiz/quiz_detail/'.$data['quiz']['quid']);
		 }
		// remaining time in seconds 
		$data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
		// get questions
		$data['questions']=$this->quiz_model->get_questions($data['quiz']['r_qids']);
		// get options
		$data['options']=$this->quiz_model->get_options($data['quiz']['r_qids']);
		$data['title']=$data['quiz']['quiz_name'];
		$this->load->view('header',$data);
		$this->load->view('quiz_attempt',$data);
		$this->load->view('footer',$data);
			
		
		}
		*/
		
		
	
	
	function save_answer(){
		echo "<pre>";
		print_r($_POST);
		  // insert user response and calculate scroe
		 $this->quiz_model->insert_answer();
		
		
	}
 function set_ind_time(){
		  // update questions time spent
		$this->quiz_model->set_ind_time();
		
		
	}
 
 
 
 function upload_photo(){

if(isset($_FILES['webcam'])){
			$targets = 'photo/';
			$filename=time().'.jpg';
			$targets = $targets.''.$filename;
			if(move_uploaded_file($_FILES['webcam']['tmp_name'], $targets)){
			
				$this->session->set_flashdata('photoname', $filename);
				}
				}
}



 function submit_quiz(){
	 
				if($this->quiz_model->submit_result()){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
						
					}
			$this->session->unset_userdata('rid');		
					
 redirect('quiz');
 }
 
 
 
 function assign_score($rid,$qno,$score){
	 $logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			} 
			$this->quiz_model->assign_score($rid,$qno,$score);
			
			echo '1';
	 
 }
 
 
	
}
