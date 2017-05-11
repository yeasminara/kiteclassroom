<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Media_Controller
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
	 

	function index()
	{
		
		$data['title'] = 'All Page List';
		$data['count'] = $this->db->get('savsoft_page_group')->num_rows();
		$data['results'] = $this->Prime_model->get_data('savsoft_page_group', FALSE, FALSE, 'id', 'ASC');
		
			
		/*$this->load->view('header',$data);
		$this->load->view('page/index',$data);
		$this->load->view('footer',$data);*/
		$data['middle'] = $this->load->view('page/index',$data, true);
		$this->load->view('template', $data);
	}
	public function add(){
		$this->load->helper('date');
		$data['title'] = 'All New Page';
		$logged_in=$this->session->userdata('logged_in');
	
		$data['count'] = $this->db->get('savsoft_page_group')->num_rows();
		$data['results'] = $this->Prime_model->get_data('savsoft_page_group');
		if ($this->input->post('add')) {
			 $post_data = array(
				   'page_group_name' => $this->input->post('page_group_name'),
				   'page_group_name_bn' =>$this->input->post('page_group_name_bn'), 
				   'page_group_url' => $this->input->post('page_group_url'),
				   'module' => $this->input->post('module'),
				   'position' => $this->input->post('position'),
				   'status' => $this->input->post('mstatus'),
				   'page_type'=>$this->input->post('page_type'),
				   'create_date' => date('Y-m-d'),
				   'create_by' => $logged_in['uid']
                
                );
				
			 $this->Prime_model->insert_data('savsoft_page_group', $post_data);
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
               redirect(base_url() . 'pages', 'refresh');
             }
            return;
		  }
			 
	/*	$this->load->view('header',$data);
		$this->load->view('page/add',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('page/add',$data, true);
		$this->load->view('template', $data);
	 }
	
	public function edit($id){
		$this->load->helper('date');
		$data['title'] = 'Edit Page';
		

			$data['count'] = $this->db->get('savsoft_page_group')->num_rows();
			$data['results'] = $this->Prime_model->get_row_data('savsoft_page_group','id',$id);
		
			 if ($this->input->post('update')) {
				 $post_data = array(
				   'page_group_name' => $this->input->post('page_group_name'),
				   'page_group_name_bn' =>$this->input->post('page_group_name_bn'), 
				   'page_group_url' => $this->input->post('page_group_url'),
				   'position' => $this->input->post('position'),
				   'module' => $this->input->post('module'),
				   'status' => $this->input->post('mstatus'),
				   'page_type'=>$this->input->post('page_type'),
				   'modified_date' => date('Y-m-d'),
				   'create_by' => $logged_in['uid']
                
                );
			 $this->Prime_model->updater('id', $this->input->post('edit_id'), 'savsoft_page_group', $post_data);
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
               redirect(base_url() . 'pages', 'refresh');
             }
            return;
		  }
			 
		/*$this->load->view('header',$data);
		$this->load->view('page/add',$data);
		$this->load->view('footer',$data);*/
		$data['middle'] = $this->load->view('page/add',$data, true);
		$this->load->view('template', $data);
			
	 }
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
	
	
	public function permission($user_id){
		$data['title'] = 'Give User Permission';
		$data['count'] = $this->db->get('savsoft_page_group')->num_rows();
		$data['results'] = $this->Prime_model->get_data('savsoft_page_group', FALSE, FALSE, 'module', 'ASC','status');
		$data['users'] = $this->Prime_model->get_row_data('savsoft_users', 'uid', $user_id);
		//echo $this->db->last_query();
	    $logged_in=$this->session->userdata('logged_in');
		if ($this->input->post('submit')) {
				//echo 'test'.$this->input->post('submit');
			$this->Prime_model->deleter('user_id', $user_id, 'savsoft_page_group_permission');
			$selected_page = $this->input->post('selected_page');
			//print_r($selected_page);
			foreach($selected_page as $page){
				//echo $page;
				$post_data = array(
				   'page_group_id' => $page,
				   'user_id' => $user_id,
				   'status' => 1,
				   'create_date' => date('Y-m-d'),
				   'create_by' => $logged_in['uid']
                
                );
				//print_r($post_data);
			  $this->Prime_model->insert_data('savsoft_page_group_permission', $post_data);
			 
			}
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Permission  has been changed and approved.');
               redirect(base_url() . 'user', 'refresh');
             }
             return;
		}
		/*$this->load->view('header',$data);
		$this->load->view('page/pages_list',$data);
		$this->load->view('footer',$data);
		*/
		$data['middle'] = $this->load->view('page/pages_list',$data, true);
		$this->load->view('template', $data);
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */