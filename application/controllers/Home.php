<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
    }
	public function index(){
		
		$data['title'] = 'Welcome';

       // $this->load->view('templates/header', $data);
        $this->load->view('templates/home', $data);
     //   $this->load->view('templates/footer');
	}
	
	public function online_exam(){
	   $data['title'] = 'Online Examination';
       $this->load->view('templates/header', $data);
	   $this->load->view('templates/online_exam', $data);
	   $this->load->view('templates/footer');
	}
	
	public function homework_administration(){
	   $data['title'] = 'Homework Administration';
       $this->load->view('templates/header', $data);
	   $this->load->view('templates/homework_administration', $data);
	   $this->load->view('templates/footer');
	}
	
	
	public function classroom_activity(){
	   $data['title'] = 'Daily Classroom Activity';
       $this->load->view('templates/header', $data);
	    $this->load->view('templates/classroom_activity', $data);
	   $this->load->view('templates/footer');
	}
	public function smart_classroom_content(){
	   $data['title'] = 'Smart Classroom Content';
       $this->load->view('templates/header', $data);
	    $this->load->view('templates/smart_classroom_content', $data);
	   $this->load->view('templates/footer');
	}
	public function result(){
	   $data['title'] = 'Result';
       $this->load->view('templates/header', $data);
	    $this->load->view('templates/result', $data);
	   $this->load->view('templates/footer');
	}
	public function question_bank(){
	   $data['title'] = 'Question Bank';
       $this->load->view('templates/header', $data);
	    $this->load->view('templates/question_bank', $data);
	   $this->load->view('templates/footer');
	}
}
?>