<?php
Class Accounting_model extends CI_Model{
	   
	
	function class_list (){
	 
		 $this->db->select('savsoft_class.*'); 
			
		 $this->db->order_by('savsoft_class.id','asc');
		 $query=$this->db->get('savsoft_class');
		 return $query->result_array();
	 
 	} 
 
 
  // Class section  function start
	 function class_section_list (){
		 $this->db->order_by('id','asc');
		 $query=$this->db->get('savsoft_class_section');
		 return $query->result_array();
	 } 
	 function class_group_list (){
		 $this->db->order_by('id','asc');
		 $query=$this->db->get('savsoft_class_group');
		 return $query->result_array();
	 }
	function group_list($school_id){
		$this->db->where('gid',$school_id);
		$query=$this->db->get('savsoft_group');
		return $query->row_array();
	}
	function school_information($school_id){
			$this->db->where('savsoft_users.gid',$school_id);
			$this->db->where('savsoft_users.su',6);
	
	$this -> db -> join('savsoft_school_profile', 'savsoft_users.uid=savsoft_school_profile.user_id');
	$query=$this->db->get('savsoft_users');
	//echo $this->db->last_query();
	return $query->row_array();
		
	}

	
	function fees_category_list (){
		 $this->db->order_by('fees_category.id','asc');
		 $query=$this->db->get('fees_category');
		 return $query->result_array();
	 
 	} 
	
	function insert_fees_category(){
		$logged_in=$this->session->userdata('logged_in');
		$userdata=array(
		'category_name'=>$this->input->post('category_name'),
		'create_date'=>date('Y-m-d'),
		'status' =>'1',
		'create_by'=>$logged_in['uid']
			);
		
		if($this->db->insert('fees_category',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	}
	
	 function update_category($id){
	 
		$userdata=array(
		'category_name'=>$this->input->post('category_name')
		 	
		);
	 
		 $this->db->where('id',$cid);
		if($this->db->update('fees_category',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
	 function remove_category($cid){
	 
	 $this->db->where('id',$cid);
	 if($this->db->delete('fees_categorys')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
}

?>