<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_work extends CI_Controller {
	
	function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("user_model");
	   $this->load->model("qbank_model");
	  $this->load->model("homew_model");
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
	 

	function index($limit='0')
	{
		
		$logged_in=$this->session->userdata('logged_in');
	    $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();	
		$data['limit']=$limit;
		$data['title']='All Home Work List';
		// fetching quiz list
		
		
		// fetching quiz list
		$data['class_list'] = $this->qbank_model->class_list();
		//echo $this->db->last_query();
		$data['result']=$this->homew_model->home_work_list($limit);
		//$this->load->view('header',$data);
		if($result_role['role_type'] == 'user'){
			//$this->load->view('home_work/student_work_list',$data);
			
		}else{
		//$this->load->view('home_work/index',$data);
		$data['middle'] = $this->load->view('home_work/index',$data, true);
		}
		//$this->load->view('footer',$data);
		
		
		
        $this->load->view('template', $data);
	}
	public function add(){
		$data['title']='Add Home Work';
		$data['class_list'] = $this->qbank_model->class_list();
		if ($this->input->post('add')) {
			$this->homew_model->add_home_work();	
		}
		/*$this->load->view('header',$data);
		$this->load->view('home_work/add',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('home_work/add',$data, true);
        $this->load->view('template', $data);
	}
	
	
	public function edit($id){}
	/**
	 * delete message
	 *
	 * @param	string
	 * @return	void
	 */  
	 
	 public function delete() {
		$deletedId = $this->input->post('deleteId');
	
			$this->Prime_model->deleter('page_group_id', $deletedId, 'savsoft_page_group_permission'); 
			$this->Prime_model->deleter('id', $deletedId, 'savsoft_page_group');
			redirect(base_url() . 'pages');
		
        
    }
	
	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */ 
	 
	 function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/login/');
	}
	
	
	public function permission($homeWorkId){
		$data['title']='Home Work List';
		$logged_in=$this->session->userdata('logged_in');
		$data['home_work'] = $this->homew_model->get_home_work_by_id($homeWorkId);
		//echo $this->db->last_query();
		//echo $data['home_work']['class_id'];
		$data['student_list'] = $this->homew_model->get_student_list($data['home_work']['class_id'],$logged_in['gid']);
		//echo $this->db->last_query();
		if ($this->input->post('submit')) {
			$this->homew_model->assign_home_work();	
		}
		/*$this->load->view('header',$data);
		$this->load->view('home_work/student_list',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('home_work/student_list',$data, true);
        $this->load->view('template', $data);
		
	}
	
	public function evaluation_list($homeWorkId){
		$data['title']='Home Work List';
		$logged_in=$this->session->userdata('logged_in');
		$data['home_work'] = $this->homew_model->get_home_work_by_id($homeWorkId);
		//echo $this->db->last_query();
		//echo $data['home_work']['class_id'];
		$data['student_list'] = $this->homew_model->get_student_list($data['home_work']['class_id'],$logged_in['gid']);
		//echo $this->db->last_query();
		if ($this->input->post('submit')) {
			$this->homew_model->assign_home_work();	
		}
		/*$this->load->view('header',$data);
		$this->load->view('home_work/evaluation_student_list',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('home_work/evaluation_student_list',$data, true);
        $this->load->view('template', $data);
		
	}
	
	
	public function answer($home_work_id, $details_id){
		$data['title']='Answer Home Work ';
		$logged_in=$this->session->userdata('logged_in');
		$data['home_work'] = $this->homew_model->home_work_details($home_work_id, $details_id);
		if ($this->input->post('submit')) {
			$this->homew_model->submit_answer($home_work_id, $details_id,$logged_in['uid']);
			//echo $this->db->last_query();	
		}
		/*$this->load->view('header',$data);
		$this->load->view('home_work/answer_sheet',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('home_work/answer_sheet',$data, true);
        $this->load->view('template', $data);
		
	}
	
	
	public function evaluation($home_work_id, $details_id,$userID){
		$data['title']='Answer Home Work ';
		$logged_in=$this->session->userdata('logged_in');
		$data['home_work'] = $this->homew_model->home_work_details($home_work_id, $details_id,$userID);
		//echo $this->db->last_query();	
		if ($this->input->post('submit')) {
			$this->homew_model->submit_evaluation($home_work_id, $details_id,$userID);
			//echo $this->db->last_query();	
		}
		/*$this->load->view('header',$data);
		$this->load->view('home_work/answer_sheet_evaluation',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('home_work/answer_sheet_evaluation',$data, true);
        $this->load->view('template', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */