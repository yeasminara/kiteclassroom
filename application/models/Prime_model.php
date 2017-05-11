<?php

class Prime_model extends CI_Model {

    /**
     * insert data to any table
     * @param type $table
     * @param type $data
     */
    public function insert_data($table, $data) {
      
        $this->db->insert($table, $data);
    }

    /**
     * Get data from any table
     * @param type $table_name
     * @param type $id_name
     * @param type $id
     * @param type $order_by
     * @param type $sorter
     * @param type $start
     * @param type $how_many
     * @return type
     */
    public function get_data($table_name, $id_name = FALSE, $id = FALSE, $order_by = FALSE, $sorter = FALSE, $status = FALSE) {
        if ($id_name) {
            $query = $this->db->where($id_name, $id);
        }
		if ($status) {
            $query = $this->db->where($status, '1');
        }
		
        if ($order_by) {
            $query = $this->db->order_by($order_by, $sorter);
        }
        
		
        $query = $this->db->get($table_name);
		//echo $this->db->last_query();
		//exit;
        return $query->result_array();
    }

    /**
     * Get a singile data by id  from any table
     * @param type $table_name
     * @param type $id_name
     * @param type $id
     * @param type $status
     * @return type row array
     */
    public function get_row_data($table_name, $id_name = FALSE, $id = FALSE, $status = FALSE) {
        if ($id_name) {
            $query = $this->db->where($id_name, $id);
        }
		if ($status) {
            $query = $this->db->where($status, '1');
        }
		
        $query = $this->db->get($table_name);
		//echo $this->db->last_query();
		//exit;
        return $query->row_array();
    }
	
    /**
     * update data to specific table
     * @param type $id_name
     * @param type $id
     * @param type $tbl_name
     * @param type $data
     */
    public function updater($id_name, $id, $tbl_name, $data) {
        $this->db->where($id_name, $id);
        $this->db->update($tbl_name, $data);
    }

    /**
     * delete table
     * @param type $id_name
     * @param type $id
     * @param type $table
     */
    public function deleter($id_name, $id, $table) {
        $this->db->where($id_name, $id)->delete($table);
    }

     public function get_menu_group_name($id){
		$query = $this->db->where('id', $id);
		$query = $this->db->get('menu_group');
		return $query->row_array();
		
	}
	
	/**
	 * Get user role record by id
	 *
	 * @param	string
	 * @return	array
	 */
	public function get_user_by_role_id($role_id){
			$this->db->where('id', $role_id);
			$query = $this->db->get('savsoft_roles');
			if ($query->num_rows() == 1) return $query->row_array();
			return NULL;
	}


	public function get_menu_group_permission($page_group_id,$user_id){
		$this->db->where('page_group_id', $page_group_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('savsoft_page_group_permission');
		if ($query->num_rows() == 1) return $query->num_rows();
		return NULL;
	}
	
	
	
	function get_user_menu_group(){
		
		//echo 'test';
		$logged_in=$this->session->userdata('logged_in');
		$role_id = $logged_in['su'];
		$user_id = $logged_in['uid'];
		$rol_type = $this->get_user_by_role_id($role_id);
		if($rol_type['role_type'] == 'administrator'){
			$this->db->where('savsoft_page_group.status', '1');
			$this->db->group_by('savsoft_page_group.module');
			$this->db->order_by('savsoft_page_group.position','ASC'); 
			$query = $this->db->get('savsoft_page_group'); 
			//echo $this->db->last_query();
			return $query->result_array();
			//return NULL;
			//return 1;
			
		}else{
		$this->db->where('savsoft_page_group_permission.user_id', $user_id);
		$this->db->where('savsoft_page_group_permission.status', '1');
		$this->db->where('savsoft_page_group.status', '1');
		$this->db->group_by('savsoft_page_group.module'); 
		$this->db->order_by('savsoft_page_group.position','ASC'); 
		$this->db->from('savsoft_page_group_permission');
		$this->db->join('savsoft_page_group', 'savsoft_page_group_permission.page_group_id = savsoft_page_group.id', 'left'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
		}
	}
	
	function get_menu_by_module($module){
		$logged_in=$this->session->userdata('logged_in');
		$role_id = $logged_in['su'];
		$user_id = $logged_in['uid'];
		$rol_type = $this->get_user_by_role_id($role_id);
		if($rol_type['role_type'] == 'administrator'){
		//$this->db->where('status', '1');
		//$this->db->where('savsoft_page_group.status', '1');
		$this->db->where('module', $module);
		$this->db->where('page_type !=', 'edit');
		$this->db->where('page_type !=', 'delete');
		$this->db->order_by('position','ASC'); 
		$query = $this->db->get('savsoft_page_group'); 
		//echo $this->db->last_query();
		return $query->result_array();
			
		}else{
		$this->db->where('savsoft_page_group_permission.user_id', $user_id);
		$this->db->where('savsoft_page_group_permission.status', '1');
		$this->db->where('savsoft_page_group.status', '1');
		$this->db->where('savsoft_page_group.module', $module);
		$this->db->where('savsoft_page_group.page_type !=', 'edit');
		$this->db->where('savsoft_page_group.page_type !=', 'delete');
		$this->db->order_by('savsoft_page_group.position','ASC');  
		$this->db->from('savsoft_page_group_permission');
		$this->db->join('savsoft_page_group', 'savsoft_page_group_permission.page_group_id = savsoft_page_group.id', 'left'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
		}
		
		
		
		
	}
	function get_user_role_name(){
		$logged_in=$this->session->userdata('logged_in');
		$role_id = $logged_in['su'];
		$rol_type = $this->get_user_by_role_id($role_id);
		return $rol_type;
	}
	
}