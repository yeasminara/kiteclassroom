<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_content extends Media_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("qbank_model");
	   $this->lang->load('basic', $this->config->item('language'));
		// redirect if not loggedin
		/*if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}*/
	 }

	public function index($limit='0',$cid='0',$lid='0')
	{
		$this->load->helper('form');
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
			}
			
		 $data['category_list']=$this->qbank_model->category_list();
		 $data['level_list']=$this->qbank_model->level_list();
		
		
		
		$data['limit']=$limit;
		$data['cid']=$cid;
		$data['lid']=$lid;
		$data['class_id']=$class_id;
		$data['chapter_id']=$chapter_id;
		$data['lession_id']=$lession_id;
		$data['class_list']=$this->qbank_model->class_list(); 
		
		$data['title']='Class Content';
		
		// fetching user list
		
		
		$data['result']=$this->qbank_model->content_list($limit,$logged_in['uid']);
		
		//$data['result_by_user']=$this->qbank_model->content_list_by_user($limit,$logged_in['uid']);
		//echo $this->db->last_query();
		$result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array(); 
		/*if($result_role['role_type'] == 'user'){
			$this->load->view('content/content_calender',$data);
		}else{ 
			$this->load->view('content_list',$data);
		}*/
/*		$this->load->view('header',$data);
		$this->load->view('content/content_calender',$data);
		$this->load->view('footer',$data);*/
		
		$data['middle'] = $this->load->view('content/content_calender',$data, true);
        $this->load->view('template', $data);
	}
	
	

	public function add(){
		
		$this->load->helper('form');
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
			}
			
		$data['title'] = 'Add Content';
		if ($this->input->post('add')) {
		
		    $config['upload_path'] = './images/content/';
            $config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX|jpg|png|gif|jpeg';
        
			$this->load->library('upload', $config);
				/* upload other content file*/	 
			if (!$this->upload->do_upload('content_file')) {
				 @$featured='';

            } else {
                @$featured = $this->upload->data();
            }
				/* end upload other content file*/
				/* start lesson plan upload*/
			if (!$this->upload->do_upload('lesson_plan')) {
				 @$featured1='';

            } else {
                @$featured1 = $this->upload->data();
            }
			/* end lesson plan upload*/
			
			/* start image upload*/
			
			if (!$this->upload->do_upload('image')) {
				 @$featured2='';

            } else {
                @$featured2 = $this->upload->data();
            }
			
		/* end image upload*/
				 $post_data = array(
				   'class_id' => $this->input->post('class_id'),
				   'class_section_id' => $this->input->post('class_section_id'),
				   'class_group_id' => $this->input->post('class_group_id'),
				   'subject_id' => $this->input->post('subject_id'),
				   'title' => $this->input->post('title'),
				   'description' => $this->input->post('description'),
				   'file'=> @$featured['file_name'],
				   'lesson_plan'=> @$featured1['file_name'],
				   'image'=> @$featured2['file_name'],
				   'vedio_link'=>$this->input->post('vedio_link'),
				   'audio_file'=>$this->input->post('audio_file'),
				   'class_time_date' => $this->input->post('start_date'),
				   'duration' => $this->input->post('duration'),
				   'status' => '1',
				   'user_id' => $logged_in['uid'],
				   'school_id'=>$logged_in['gid'],
				   'is_display'=>$this->input->post('is_display')
                
                );
			 $this->db->insert('savsoft_content', $post_data);
			//echo $this->db->last_query();
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
              redirect(base_url() . 'class_content', 'refresh');
             }
            return;
		  }
		  
		    $data['class_list']=$this->qbank_model->class_list();
		    $data['class_section_list']=$this->qbank_model->class_section_list();
		    $data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array();
		  	/*$this->load->view('header',$data);
			$this->load->view('content/add',$data);
			$this->load->view('footer',$data);*/
			
			$data['middle'] = $this->load->view('content/add',$data, true);
        $this->load->view('template', $data);
		}
		
		public function edit($id){
			
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
				exit($this->lang->line('permission_denied'));
			}
			
			 
		    $data['title'] = 'Edit Content';
			
			$data['count'] = $this->db->get('savsoft_content')->num_rows();
			$data['results'] = $this->db->where('id',$id)->get('savsoft_content')->row_array();
			
			$this->db->where('user_id',$logged_in['uid']);
			$this->db->where('id',$id);
			$query=$this->db->get('savsoft_content');
			$content_found = $query->num_rows();
			if($content_found>0){
				if ($this->input->post('update')) {
				 $config['upload_path'] = './images/content/';
            	$config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX|jpg|png|gif|jpeg';
	
				  //$config['max_size']    = '1000000';
				$this->load->library('upload', $config);
				//print_r($config);
				if ($this->upload->do_upload('content_file')) {
					$featured = $this->upload->data();
					 $featured_file = $featured['file_name'];
					//exit;
				} else {
					$featured_file = $data['results']['file'];
				}
				
							/* end upload other content file*/
				/* start lesson plan upload*/
			if (!$this->upload->do_upload('lesson_plan')) {
              $featured1 = $this->upload->data();
					 $featured_file1 = $featured1['file_name'];

            } else {
               $featured_file1 = $data['results']['lesson_plan'];
            }
			/* end lesson plan upload*/
			
			/* start image upload*/
			
			if (!$this->upload->do_upload('image')) {
               $featured2 = $this->upload->data();
					 $featured_file2 = $featured2['file_name'];

            } else {
               $featured_file2 = $data['results']['image'];
            }
			
		/* end image upload*/
		
				$post_data = array(
				 	'class_id' => $this->input->post('class_id'),
				   'class_section_id' => $this->input->post('class_section_id'),
				   'class_group_id' => $this->input->post('class_group_id'),
				   'subject_id' => $this->input->post('subject_id'),
				   'title' => $this->input->post('title'),
				   'description' => $this->input->post('description'),
				   'file'=> $featured_file,
				   'lesson_plan'=> $featured1,
				   'image'=> $featured2,
				   'vedio_link'=>$this->input->post('vedio_link'),
				   'audio_file'=>$this->input->post('audio_file'),
				   'class_time_date' => $this->input->post('start_date'),
				   'duration' => $this->input->post('duration'),
				   'status' => '1',
				   'user_id' => $logged_in['uid'],
				   'school_id'=>$logged_in['gid'],
				   'is_display'=>$this->input->post('is_display')
                
                );
			 
			  $this->db->where('id',$this->input->post('edit_id'));
	 		  $this->db->update('savsoft_content',$post_data);
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully updated.');
               redirect(base_url() . 'class_content', 'refresh');
             }
            return;
				//echo $this->upload->do_upload('content_file');
			 }
			} else{
			   $this -> session -> set_flashdata('message', 'You dont have permission to edit this content.');
               redirect(base_url() . 'class_content', 'refresh');
			}
		
			 
		    $data['class_list']=$this->qbank_model->class_list();
		    $data['class_section_list']=$this->qbank_model->class_section_list();
		    $data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array();
		  	/*$this->load->view('header',$data);
			$this->load->view('content/add',$data);
			$this->load->view('footer',$data);*/	
			
			
			$data['middle'] = $this->load->view('content/add',$data, true);
        $this->load->view('template', $data);
		}
	/**
	 * delete message
	 *
	 * @param	string
	 * @return	void
	 */  
	 
	 public function delete() {
		 $logged_in=$this->session->userdata('logged_in');
		 $this->db->where('user_id',$logged_in['uid']);
			$this->db->where('id',$id);
			$query=$this->db->get('savsoft_content');
			$content_found = $query->num_rows();
			if($content_found>0){
				$deletedId = $this->input->post('deleteId');
				$this->db->where('content_id',$deletedId);
				$this->db->delete('savsoft_content_permission');
				
				$this->db->where('id',$deletedId);
				$this->db->delete('savsoft_content');
				redirect(base_url() . 'class_content');
			} else{
			   $this -> session -> set_flashdata('message', 'You dont have permission to delete this content.');
               redirect(base_url() . 'class_content', 'refresh');
			}
		
        
    }
	
	public function permission_list(){
		$logged_in=$this->session->userdata('logged_in');
		 $this->db->where('user_id',$logged_in['uid']);
		 $query=$this->db->get('savsoft_content');
		 $content_found = $query->num_rows();
			if($logged_in['su']=='0' && $content_found==0){
				exit($this->lang->line('permission_denied'));
			}
			
			 
		    $data['title'] = 'Content Permission List';
			
			$sql = "SELECT *,(SELECT class_name FROM savsoft_class WHERE id=sc.`class_id`) AS class_name,
(SELECT category_name FROM savsoft_category WHERE cid=sc.`subject_id`) AS subject_name,
(SELECT first_name FROM savsoft_users WHERE uid=scp.`user_id`) AS first_name,
(SELECT last_name FROM savsoft_users WHERE uid=scp.`user_id`) AS last_name,
scp.id as scpid,scp.content_id as content_id,scp.user_id as user_id
 FROM `savsoft_content` AS sc 
INNER JOIN `savsoft_content_permission` AS scp ON scp.`content_id`=sc.`id` where sc.user_id=".$logged_in['uid'];
			$content_query = $this->db->query($sql);
			$data['result'] = $content_query->result_array();
		/*	$this->load->view('header',$data);
			$this->load->view('content_permission_list',$data);
			$this->load->view('footer',$data);*/
			
			
		$data['middle'] = $this->load->view('content_permission_list',$data, true);
        $this->load->view('template', $data);
	}
	
	public function send_permission($id){
		$logged_in=$this->session->userdata('logged_in');
		if(empty($logged_in['su'])){
			exit($this->lang->line('permission_denied'));
		}
		
		
		$post_data = array(
				   'content_id' => $id,
				   'permission_status' => '2',
				   'user_id' => $logged_in['uid']
                
                );
			 $this->db->insert('savsoft_content_permission', $post_data);
		 if($post_data){
               $this -> session -> set_flashdata('message', 'Permission send successfully.');
               redirect(base_url() . 'class_content', 'refresh');
             }
            return;
	}
	
	public function update_permission($id){
		$logged_in=$this->session->userdata('logged_in');
		if(empty($logged_in['su'])){
			exit($this->lang->line('permission_denied'));
		}
		
		
		$post_data = array(
				   'permission_status' => '1',
                
                );
				$this->db->where('id',$id);
			 $this->db->update('savsoft_content_permission', $post_data);
		 if($post_data){
               $this -> session -> set_flashdata('message', 'Permission send successfully.');
               redirect(base_url() . 'class_content', 'refresh');
             }
            return;
	}
	
/*================================== Content List==============================================================================*/

public function content_list($limit='0',$cid='0',$lid='0')
	{
		
		
		$this->load->helper('form');
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			exit($this->lang->line('permission_denied'));
			}
			
		 $data['category_list']=$this->qbank_model->category_list();
		 $data['level_list']=$this->qbank_model->level_list();
		
		
		$cid=$this->input->post('subject_id');
		$lid=$this->input->post('lid');
		$class_id= $this->input->post('class_id');
		$chapter_id= $this->input->post('chapter_id');
		$lession_id= $this->input->post('lession_id');
		
		
		$data['cid']=$cid;
		$data['lid']=$lid;
		$data['class_id']=$class_id;
		$data['chapter_id']=$chapter_id;
		$data['lession_id']=$lession_id;
		
		$data['class_list']=$this->qbank_model->class_list(); 
		
		$data['title']='Smart Classroom Content';
		
		// fetching user list
		
		
		$data['result']=$this->qbank_model->smart_content_list($limit,$logged_in['uid']);
		
		//$data['result_by_user']=$this->qbank_model->content_list_by_user($limit,$logged_in['uid']);
		//echo $this->db->last_query();
		$result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array(); 
	
	/*	$this->load->view('header',$data);
		$this->load->view('content/content_list',$data);
		$this->load->view('footer',$data);*/
		
		
		$data['middle'] = $this->load->view('content/content_list',$data, true);
        $this->load->view('template', $data);
	}
	
	

	public function add_content(){
		
		$this->load->helper('form');
		$logged_in=$this->session->userdata('logged_in');
		$result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array(); 
		if($result_role['role_type']=='administrator' || $result_role['role_type']=='superadmin'){
			$created_by = 'kiteBD';
		}else{
			$created_by = 'teacher';
		}

			
		$data['title'] = 'Add Smart Classroom Content';
		if ($this->input->post('add')) {
		
		    $config['upload_path'] = './images/content/';
            $config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX|jpg|png|gif|jpeg|swf|ppt|pptx';
        
			$this->load->library('upload', $config);
				/* upload other content file*/	 
			if (!$this->upload->do_upload('content_file')) {
				 @$featured='';

            } else {
                @$featured = $this->upload->data();
            }
				/* end upload other content file*/
				/* start lesson plan upload*/
			if (!$this->upload->do_upload('lesson_plan')) {
				 @$featured1='';

            } else {
                @$featured1 = $this->upload->data();
            }
			/* end lesson plan upload*/
			
			/* start image upload*/
			
			if (!$this->upload->do_upload('image')) {
				 @$featured2='';

            } else {
                @$featured2 = $this->upload->data();
            }
			
		/* end image upload*/
				 $post_data = array(
				   'class_id' => $this->input->post('class_id'),
				   'subject_id' => $this->input->post('subject_id'),
				   'chapter_id' => $this->input->post('chapter_id'),
				   'lesson_id' => $this->input->post('lession_id'),
				   'title' => $this->input->post('title'),
				   'description' => $this->input->post('description'),
				   'file'=> @$featured['file_name'],
				   'flash_file'=> @$featured1['file_name'],
				   'image'=> @$featured2['file_name'],
				   'vedio_link'=>$this->input->post('vedio_link'),
				   'audio_file'=>$this->input->post('audio_file'),
				   'status' => '1',
				   'user_id' => $logged_in['uid'],
				   'school_id'=>$logged_in['gid'],
				   'created_by'=>$created_by
                
                );
			 $this->db->insert('savsoft_smart_class_content', $post_data);
			//echo $this->db->last_query();
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully added.');
              redirect(base_url() . 'class_content/content_list', 'refresh');
             }
            return;
		  }
		  
		    $data['class_list']=$this->qbank_model->class_list();
		    $data['class_section_list']=$this->qbank_model->class_section_list();
		    $data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array();
		  /*	$this->load->view('header',$data);
			$this->load->view('content/add_smart_content',$data);
			$this->load->view('footer',$data);*/
			
			
			$data['middle'] = $this->load->view('content/add_smart_content',$data, true);
        $this->load->view('template', $data);
		}
		
		public function edit_content($id){
			
			$logged_in=$this->session->userdata('logged_in');
			
		    $data['title'] = 'Edit Smart Classroom Content';
			
			$data['count'] = $this->db->get('savsoft_smart_class_content')->num_rows();
			$data['results'] = $this->db->where('id',$id)->get('savsoft_smart_class_content')->row_array();
			
			$this->db->where('user_id',$logged_in['uid']);
			$this->db->where('id',$id);
			$query=$this->db->get('savsoft_smart_class_content');
			$content_found = $query->num_rows();
			if($content_found>0){
				if ($this->input->post('update')) {
				 $config['upload_path'] = './images/content/';
            	$config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX|jpg|png|gif|jpeg|swf|ppt|pptx';
	
				  //$config['max_size']    = '1000000';
				$this->load->library('upload', $config);
				//print_r($config);
		
							/* end upload other content file*/
				/* start lesson plan upload*/
			if ($this->upload->do_upload('lesson_plan')) {
              $featured1 = $this->upload->data();
					 $featured_file1 = $featured1['file_name'];

            } else {
               $featured_file1 = $data['results']['flash_file'];
            }
			//print_r( $featured_file1);
			/* end lesson plan upload*/
			
			/* start image upload*/
			
			if ($this->upload->do_upload('image')) {
               $featured2 = $this->upload->data();
					 $featured_file2 = $featured2['file_name'];

            } else {
               $featured_file2 = $data['results']['image'];
            }
			
		/* end image upload*/
		
				if ($this->upload->do_upload('content_file')) {
					$featured = $this->upload->data();
					 $featured_file = $featured['file_name'];
					// echo 'test';
					//exit;
				} else {
					$featured_file = $data['results']['file'];
					 //echo 'test2';
				}
				
				//print_r($featured_file);
				$post_data = array(
				
				
				   'class_id' => $this->input->post('class_id'),
				   'subject_id' => $this->input->post('subject_id'),
				   'chapter_id' => $this->input->post('chapter_id'),
				   'lesson_id' => $this->input->post('lession_id'),
				   'title' => $this->input->post('title'),
				   'description' => $this->input->post('description'),
				   'file'=> $featured_file,
				   'flash_file'=> $featured_file1,
				   'image'=> $featured_file2,
				   'vedio_link'=>$this->input->post('vedio_link'),
				   'audio_file'=>$this->input->post('audio_file'),
				   'status' => '1',
				   'user_id' => $logged_in['uid'],
				   'school_id'=>$logged_in['gid']
				                 
                );
			 
			// print_r($post_data);
			  $this->db->where('id',$this->input->post('edit_id'));
	 		  $this->db->update('savsoft_smart_class_content',$post_data);
			  //echo $this->db->last_query();
			 if($post_data){
               $this -> session -> set_flashdata('message', 'Information  has been successfully updated.');
               redirect(base_url() . 'class_content/content_list', 'refresh');
             }
            return;
				//echo $this->upload->do_upload('content_file');
			 }
			} else{
			   $this -> session -> set_flashdata('message', 'You dont have permission to edit this content.');
               redirect(base_url() . 'class_content/content_list', 'refresh');
			}
		
			 
		    $data['class_list']=$this->qbank_model->class_list();
		    $data['class_section_list']=$this->qbank_model->class_section_list();
		    $data['class_group_list']=$this->db->where('status','1')->get('savsoft_class_group')->result_array();
		  	/*$this->load->view('header',$data);
			$this->load->view('content/add_smart_content',$data);
			$this->load->view('footer',$data);*/	
			
			$data['middle'] = $this->load->view('content/add_smart_content',$data, true);
        $this->load->view('template', $data);
		}
	/**
	 * delete message
	 *
	 * @param	string
	 * @return	void
	 */  
	 
	 public function delete_content() {
		    $logged_in=$this->session->userdata('logged_in');
		    $this->db->where('user_id',$logged_in['uid']);
			$this->db->where('id',$id);
			$query=$this->db->get('savsoft_smart_class_content');
			$content_found = $query->num_rows();
			if($content_found>0){
				$this->db->where('id',$deletedId);
				$this->db->delete('savsoft_smart_class_content');
				redirect(base_url() . 'class_content/content_list');
			} else{
			   $this -> session -> set_flashdata('message', 'You dont have permission to delete this content.');
               redirect(base_url() . 'class_content/content_list', 'refresh');
			}
		
        
    }
	 

	
}
