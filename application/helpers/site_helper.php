<?php

   
function get_menu_group_name($id){
	$CI = &get_instance();
	$CI->load->model('Prime_model');
    return $CI->Prime_model->get_menu_group_name($id);
}


function get_menu_group_permission($page_group_id,$user_id){
	$CI = &get_instance();
	$CI->load->model('Prime_model');
	return $CI->Prime_model->get_menu_group_permission($page_group_id,$user_id);
}

function get_user_menu_group(){
	$CI = &get_instance();
	$CI->load->model('Prime_model');
	return $CI->Prime_model->get_user_menu_group();
}

function get_menu_by_module($module){
	$CI = &get_instance();
	$CI->load->model('Prime_model');
	return $CI->Prime_model->get_menu_by_module($module);
}

function get_user_role_name(){
	$CI = &get_instance();
	$CI->load->model('Prime_model');
	return $CI->Prime_model->get_user_role_name();
}
function get_teacher_by_subject($subejctID){
	$CI = &get_instance();
	$CI->load->model('qbank_model');
	return $CI->qbank_model->get_teacher_by_subject($subejctID);
}
function get_student_attendance($studentID, $schoolID,$academic_year,$class_id,$class_section_id,$class_group_id,$attandance_date){
	$CI = &get_instance();
	$CI->load->model('attendance_model');
	return $CI->attendance_model->get_student_attendance($studentID, $schoolID,$academic_year,$class_id,$class_section_id,$class_group_id,$attandance_date);
}
?>