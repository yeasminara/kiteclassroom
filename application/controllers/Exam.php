<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exam extends Media_Controller
{
	
	function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("user_model");
	   $this->load->model("qbank_model");
	   $this->load->model("quiz_model");
	   $this->load->model("result_model");
	   $this->load->helper('url');
	   $this->load->helper('site_helper');
		$this->load->model('Prime_model');
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
	 

	function build_paper($quizID){
		$data['title'] = 'Build Question paper';
		$logged_in=$this->session->userdata('logged_in');
		$gid=$logged_in['gid'];
		$resultRole = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		if($resultRole['role_type'] == 'school_teacher' || $resultRole['role_type'] == 'school_admin'){
			
			$where="FIND_IN_SET('".$gid."', gids)"; 
			$this->db->where($where); 
		}
		$result_exam = $this->db->where('quid',$quizID)->get('savsoft_quiz')->row_array();
		//echo $this->db->last_query();
		$where1 = "qid in (".$result_exam['qids'].")";
		$data['resultQuestion'] = $this->db->where($where1)->get('savsoft_qbank')->result_array();
		$data['resultExam'] = $result_exam;
		$data['subjectList'] = $this->db->where('cid',$result_exam['subject_id'])->get('savsoft_category')->row_array();
		$data['schoolInfo'] = $this->db->where('gid',$result_exam['gids'])->get('savsoft_group')->row_array();
		///echo $this->db->last_query();
		$this->load->view('header',$data);
		$this->load->view('exam/exam_paper',$data);
		$this->load->view('footer',$data);
	}
	
	function submit($quizID){
		if ($this->input->post('submit')) {
			$post_data = array(
				   'full_question_pattern' => $this->input->post('full_question_pattern')
                
                );
			 $this->Prime_model->updater('quid', $quizID, 'savsoft_quiz', $post_data);
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
               redirect(base_url() . 'quiz', 'refresh');
             }
            return;
		}
	}
	
	function question_preview($quizID){
		$data['title'] = 'Preview Question Paper';
		$data['resultExam'] = $this->db->where('quid',$quizID)->get('savsoft_quiz')->row_array();
		//$this->load->view('header',$data);
		$this->load->view('exam/preview_exam_paper',$data);
		//$this->load->view('footer',$data);
	}
	
	function download_question($quizID){
		$data['title'] = 'Download Question Paper';
		$data['resultExam'] = $this->db->where('quid',$quizID)->get('savsoft_quiz')->row_array();
		$this->load->view('exam/download_exam_paper',$data);
		
	}
	function _show_message($message){
		$this->session->set_flashdata('message', $message);
		redirect('/login/');
	}
	
	
	
}

/* End of file Exam.php */
/* Location: ./application/controllers/Exam.php */