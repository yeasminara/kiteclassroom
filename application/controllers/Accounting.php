<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("user_model");
	   $this->load->model("accounting_model");
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
		
	/*	$this->load->view('header',$data);
		$this->load->view('user_list',$data);
		$this->load->view('footer',$data);*/
		
		/*$data['middle'] = $this->load->view('user_list',$data, true);
        $this->load->view('template', $data);*/
		
		
	}
	
	public function fees_list(){
		$data['title']='Fees Category List';
		$data['fees_category_list']=$this->accounting_model->fees_category_list();
		$data['middle'] = $this->load->view('accounting/fees_category_list',$data, true);
        $this->load->view('template', $data);
	}
	

	public function add_fees(){
		
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
	
				if($this->accounting_model->insert_fees_category()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
						
				}
				redirect('accounting/fees_list/');
	}
	
	
	public function edit_fees(){
		
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
	
				if($this->accounting_model->update_category($id)){
					
                echo "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>";
				
				}else{
				 echo "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>";
						
				}
	}
	
	public function delete_fees(){
		
		
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
		} 
		
		if($this->accounting_model->remove_category($cid)){
					$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
				}else{
						$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
					
				}
				redirect('accounting/fees_list/');
	}
	
	public function fees_setup(){
	}
}
