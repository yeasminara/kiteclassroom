<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends Media_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("result_model");
	    $this->load->model("Prime_model");
	   $this->lang->load('basic', $this->config->item('language'));
	   
		// redirect if not loggedin
	/*	if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}*/
	 }

	public function index($limit='0',$status='0')
	{
		
	 
			
			
		$data['limit']=$limit;
		$data['status']=$status;
		$data['title']=$this->lang->line('resultlist');
		// fetching result list
		$data['result']=$this->result_model->result_list($limit,$status);
		// fetching quiz list
		$data['quiz_list']=$this->result_model->quiz_list();
		// group list
		 $this->load->model("user_model");
		$data['group_list']=$this->user_model->group_list();
		
		/*$this->load->view('header',$data);
		$this->load->view('result_list',$data);
		$this->load->view('footer',$data);*/
		
			$data['middle'] = $this->load->view('result_list',$data, true);
        $this->load->view('template', $data);
	}
	


	
	public function remove_result($rid){

			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
				exit($this->lang->line('permission_denied'));
			} 
			
			if($this->result_model->remove_result($rid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('result');
                     
			
		}
	

	
	function generate_report(){
		$this->load->helper('download');
		
		$quid=$this->input->post('quid');
		$gid=$this->input->post('gid');
		$result=$this->result_model->generate_report($quid,$gid);
		$csvdata=$this->lang->line('result_id').",".$this->lang->line('email').",".$this->lang->line('first_name').",".$this->lang->line('last_name').",".$this->lang->line('group_name').",".$this->lang->line('quiz_name').",".$this->lang->line('score_obtained').",".$this->lang->line('percentage_obtained').",".$this->lang->line('status')."\r\n";
		foreach($result as $rk => $val){
		$csvdata.=$val['rid'].",".$val['email'].",".$val['first_name'].",".$val['last_name'].",".$val['group_name'].",".$val['quiz_name'].",".$val['score_obtained'].",".$val['percentage_obtained'].",".$val['result_status']."\r\n";
		}
		$filename=time().'.csv';
		force_download($filename, $csvdata);

	}
	
	
	function view_result($rid){
		$logged_in=$this->session->userdata('logged_in');
			
		$data['result']=$this->result_model->get_result($rid);
		//echo $this->db->last_query();
		$data['title']=$this->lang->line('result_id').' '.$data['result']['rid'];
		$result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		if($data['result']['view_answer']=='1' || $result_role['role_type']!='user'){
		 $this->load->model("quiz_model");
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		$data['questions']=$this->quiz_model->get_questions($data['result']['r_qids']);
		$data['options']=$this->quiz_model->get_options($data['result']['r_qids']);

		}
		// top 10 results of selected quiz
	$last_ten_result = $this->result_model->last_ten_result($data['result']['quid']);
	$value=array();
     $value[]=array('Quiz Name','Percentage (%)');
     foreach($last_ten_result as $val){
     $value[]=array($val['email'].' ('.$val['first_name']." ".$val['last_name'].')',intval($val['percentage_obtained']));
     }
     $data['value']=json_encode($value);
	 
	// time spent on individual questions
	$correct_incorrect=explode(',',$data['result']['score_individual']);
	 $qtime[]=array($this->lang->line('question_no'),$this->lang->line('time_in_sec'));
    foreach(explode(",",$data['result']['individual_time']) as $key => $val){
	if($val=='0'){
		$val=1;
	}
	 if($correct_incorrect[$key]=="1"){
	 $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('correct')." ",intval($val));
	 }else if($correct_incorrect[$key]=='2' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('incorrect')."",intval($val));
	 }else if($correct_incorrect[$key]=='0' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") -".$this->lang->line('unattempted')." ",intval($val));
	 }else if($correct_incorrect[$key]=='3' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('pending_evaluation')." ",intval($val));
	 }
	}
	 $data['qtime']=json_encode($qtime);
	 $data['percentile'] = $this->result_model->get_percentile($data['result']['quid'], $data['result']['uid'], $data['result']['score_obtained']);

	  
	 
	/*	$this->load->view('header',$data);
		$this->load->view('view_result',$data);
		$this->load->view('footer',$data);*/
		
			$data['middle'] = $this->load->view('view_result',$data, true);
        $this->load->view('template', $data);	
		
	}
	
	
	
	function generate_certificate($rid){
	$data['result']=$this->result_model->get_result($rid);
	if($data['result']['gen_certificate']=='0'){
		exit();
	}
		// save qr 
	$enu=urlencode(site_url('login/verify_result/'.$rid));

	$qrname="./upload/".time().'.jpg';
	$durl="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=".$enu."&choe=UTF-8";
	copy($durl,$qrname);
	 
	
	$certificate_text=$data['result']['certificate_text'];
	$certificate_text=str_replace('{qr_code}',"<img src='".$qrname."'>",$certificate_text);
	$certificate_text=str_replace('{email}',$data['result']['email'],$certificate_text);
	$certificate_text=str_replace('{first_name}',$data['result']['first_name'],$certificate_text);
	$certificate_text=str_replace('{last_name}',$data['result']['last_name'],$certificate_text);
	$certificate_text=str_replace('{percentage_obtained}',$data['result']['percentage_obtained'],$certificate_text);
	$certificate_text=str_replace('{score_obtained}',$data['result']['score_obtained'],$certificate_text);
	$certificate_text=str_replace('{quiz_name}',$data['result']['quiz_name'],$certificate_text);
	$certificate_text=str_replace('{status}',$data['result']['result_status'],$certificate_text);
	$certificate_text=str_replace('{result_id}',$data['result']['rid'],$certificate_text);
	$certificate_text=str_replace('{generated_date}',date('Y-m-d H:i:s',$data['result']['end_time']),$certificate_text);
	
	$data['certificate_text']=$certificate_text;
	// $this->load->view('view_certificate',$data);
	$this->load->library('pdf');
	$this->pdf->load_view('view_certificate',$data);
	$this->pdf->render();
	$filename=date('Y-M-d_H:i:s',time()).".pdf";
	$this->pdf->stream($filename);

	
	}
	
	
	function preview_certificate($quid){
		 $this->load->model("quiz_model");
	  
	$data['result']=$this->quiz_model->get_quiz($quid);
	if($data['result']['gen_certificate']=='0'){
		exit();
	}
		// save qr 
	$enu=urlencode(site_url('login/verify_result/0'));
$tm=time();
	$qrname="./upload/".$tm.'.jpg';
	$durl="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=".$enu."&choe=UTF-8";
	copy($durl,$qrname);
	 $qrname2=base_url('/upload/'.$tm.'.jpg');
	
	
	$certificate_text=$data['result']['certificate_text'];
	$certificate_text=str_replace('{qr_code}',"<img src='".$qrname2."'>",$certificate_text);
	$certificate_text=str_replace('{result_id}','1023',$certificate_text);
	$certificate_text=str_replace('{generated_date}',date('Y-m-d H:i:s',time()),$certificate_text);
	
	$data['certificate_text']=$certificate_text;
	  $this->load->view('view_certificate_2',$data);
	 
	
	}
	
	function assign_score($result_id){
		$resultInfo = $this->db->where('rid',$result_id)->get('savsoft_result')->row_array();
		
		$quizInfo = $this->db->where('quid',$resultInfo['quid'])->get('savsoft_quiz')->row_array();
		$obtainedMarks = $this->input->post('obtained_score');
		$question_id_array = $this->input->post('question_id');
		
		$persectage = number_format(($obtainedMarks*100)/$quizInfo['exam_total_marks'],2);
		if($persectage>$quizInfo['pass_percentage']){
			$score_status="Pass";
		}else{
			$score_status="Fail";
		}
		$individual_score = explode(',',$resultInfo['score_individual']);
		for($i=1;$i<=$individual_score;$i++){
			$score_individual = implode(',',1);
		}
		if($this->input->post('submit')){
			
			$update_data = array(
				'score_obtained'=>$obtainedMarks,
				'percentage_obtained'=>$persectage,
				'manual_valuation'=>0,
				'result_status'=>$score_status,
				'score_individual'=>$score_individual
			);
			
			 $this->Prime_model->updater('rid', $result_id, 'savsoft_result', $update_data);
			
			 $obtain_knowledge_marks=$this->input->post('knowledge');
			 $obtain_comprehensive_marks=$this->input->post('comprehensive');
			 $obtain_application_marks=$this->input->post('application');
			 $obtain_higher_order_thinking_marks=$this->input->post('higher_order');
			 foreach($question_id_array as $question_id){
				 $totalMarks = $obtain_knowledge_marks[$question_id]+$obtain_comprehensive_marks[$question_id]+$obtain_application_marks[$question_id]+$obtain_higher_order_thinking_marks[$question_id];
				$insert_data = array(
					'result_id'=>$result_id,
					'user_id'=>$resultInfo['uid'],
					'quiz_id'=>$resultInfo['quid'],
					'question_id'=>$question_id,
					'obtain_knowledge_marks'=>$obtain_knowledge_marks[$question_id],
					'obtain_comprehensive_marks'=>$obtain_comprehensive_marks[$question_id],
					'obtain_application_marks'=>$obtain_application_marks[$question_id],
					'obtain_higher_order_thinking_marks'=>$obtain_higher_order_thinking_marks[$question_id],
					'total_obtain_marks'=>$totalMarks
			   ); 
			   
			   $this->Prime_model->insert_data('savsoft_result_deatils', $insert_data);
			 }
			 
			 if($insert_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
               redirect(base_url() . 'result', 'refresh');
             }
            return;
		}
	}
}
