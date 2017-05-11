<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Media_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("qbank_model");
	   $this->load->model("Prime_model");
	   $this->lang->load('basic', $this->config->item('language'));
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
	 }

	public function index()
	{
		$data['title'] = 'All Media';
		$data['count'] = $this->db->get('savsoft_media')->num_rows();
		$logged_in=$this->session->userdata('logged_in');
		
		$result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		if($result_role['role_type'] == 'school_admin'){
			 $this->db->where('gid',$logged_in['gid']);
		}
		elseif($result_role['role_type'] == 'school_teacher'){
			 $this->db->where('gid',$logged_in['gid']);
			 $this->db->where('uid',$logged_in['uid']);
		}
		
		$data['results'] = $this->db->get('savsoft_media')->result_array();
	/*	$this->load->view('header',$data);
		$this->load->view('media/index',$data);
		$this->load->view('footer',$data);*/
		
			
			$data['middle'] = $this->load->view('media/index',$data, true);
        $this->load->view('template', $data);
	}
	


	public function add(){
		
		$this->load->helper('form');
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
		}
		
		$data['title'] = 'Add Media';
		if ($this->input->post('add')) {
			
			$config['upload_path'] = './question_images/';
			$config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX|jpg|png|gif|jpeg';
			
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('content_file')) {
				$data['error'] = $this->upload->display_errors();
				//return;
				//redirect(base_url() . 'web/config', $data);
			
			} else {
				@$featured = $this->upload->data();
			}
			//print_r($data['error']);
			$url = base_url().'question_images/'.$featured['file_name'];
			$post_data = array(
				'media_file'=> @$featured['file_name'],
				'url' => $url,
				'uid'=>$logged_in['uid'],
	 			'gid'=>$logged_in['gid'],	 
				'status'=>$this->input->post('status')
			);
			$this->db->insert('savsoft_media', $post_data);
			//echo $this->db->last_query();
			if($post_data){
				$this -> session -> set_flashdata('message', 'Information  has been successfully added.');
				redirect(base_url() . 'media', 'refresh');
			}
			return;
		}
		

		/*$this->load->view('header',$data);
		$this->load->view('media/add',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('media/add',$data, true);
        $this->load->view('template', $data);
	}
		
		public function edit($id){
			
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
			
			 
		    $data['title'] = 'Edit Media';
			$data['count'] = $this->db->get('savsoft_media')->num_rows();
			$data['results'] = $this->db->where('id',$id)->get('savsoft_media')->row_array();
			if ($this->input->post('update')) {
				 $config['upload_path'] = './question_images/';
            	$config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX|jpg|png|gif|jpeg';
	
				  //$config['max_size']    = '1000000';
				$this->load->library('upload', $config);
				//print_r($config);
				if ($this->upload->do_upload('content_file')) {
					$featured = $this->upload->data();
					 $featured_file = $featured['file_name'];
					//exit;
				} else {
					$featured_file = $data['results']['media_file'];
				}
				$url = base_url().'question_images/'.$featured_file;
				$post_data = array(
					'media_file'=> $featured_file,
					'url' => $url,
					'status'=>$this->input->post('status')
                );
			 
			  $this->db->where('id',$this->input->post('edit_id'));
	 		  $this->db->update('savsoft_media',$post_data);
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully updated.');
               redirect(base_url() . 'media', 'refresh');
             }
            return;
				//echo $this->upload->do_upload('content_file');
			 }
			
		
			 
		/*$this->load->view('header',$data);
		$this->load->view('media/add',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('media/add',$data, true);
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
		$this->db->where('id',$deletedId);
		$this->db->delete('savsoft_media');
		redirect(base_url() . 'media');
        
    }
	
	
}
