<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class Media_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $core_path = 'DOCUMENT_ROOT' . '/app/core';
		$this->ci =& get_instance();

		
		$this->ci->load->model('user_model');
		$logged_in=$this->session->userdata('logged_in');
		
       if ($logged_in['uid']) {
		   /*if($this->ci->router->method == 'index'){
			    $url = $this->ci->router->class;
		   }else{
		        $url = $this->ci->router->class.'/'.$this->ci->router->method;
		   }*/
		   //$this->uri->segment(2);
		   if($this->uri->segment(2) !=''){
			$url = $this->uri->segment(1).'/'.$this->uri->segment(2);
		   }else{
			   $url = $this->uri->segment(1);
		   }
		   $val=$this->ci->user_model->get_user_menu_group_permission($logged_in['uid'], $logged_in['su'],$url);
		   //print_r($val);
		   if($val >0){
			     return true;
		   }else{
			   //return ;
			   $msg = "Don&prime;t have permission. Please ask adminstartion for permission";
			   redirect(base_url().'login/show_messages');
		   }
         
        } else {
            redirect(base_url().'login');
        }
    }

}

/*class MY_Controller extends CI_Controller {

        function __construct() {
            parent::__construct();

            //include custom core classes
            $core_path = DOCUMENT_ROOT . '/application/core';
            $this->load->helper('file');

            foreach(get_filenames($core_path) as $file) {
                if ($file != 'MY_Controller.php') {
                    if(file_exists($file)) {
                        include_once($file);
                    }
                }
            }
        }

}*/
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */