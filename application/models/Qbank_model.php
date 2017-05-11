<?php
Class Qbank_model extends CI_Model
{
 
  function question_list($limit,$cid='0',$lid='0',$class_id=FALSE,$subject_id=FALSE){
	 // print_r($this->input->post());
	 $logged_in=$this->session->userdata('logged_in');
	 //print_r($logged_in);
	 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
	 
	  //echo $this->db->last_query();
	  
	 if($this->input->post('search')){
		 $search=$this->input->post('search');
		 $this->db->or_where('savsoft_qbank.qid',$search);
		 $this->db->or_like('savsoft_qbank.question',$search);
		 $this->db->or_like('savsoft_qbank.description',$search);
		  
	 }
	
	 if(!empty($cid)){
		 $this->db->where('savsoft_qbank.cid',$cid);
	 }
	 if(!empty($lid)){
		 $this->db->where('savsoft_qbank.lid',$lid);
	 }
	
	if($this->input->post('class_id')){
		$this->db->where('savsoft_qbank.class_id',$this->input->post('class_id'));
	 }
	
	if($class_id){
		$this->db->where('savsoft_qbank.class_id',$class_id);
	 }
	 
	 if($subject_id){
		$this->db->where('savsoft_qbank.subject_id',$subject_id);
	 }
	 	 
	 if($this->input->post('chapter_id')){
		 $this->db->where('savsoft_qbank.chapter_id',$this->input->post('chapter_id'));
	 }
	 if($this->input->post('lession_id')){
		 $this->db->where('savsoft_qbank.lession_id',$this->input->post('lession_id'));
	 }
	 
	
	
	if($result_role['role_type'] == 'school_admin'){
		 //$this->db->where('savsoft_qbank.gid',$logged_in['gid']);
		 $where = "  savsoft_qbank.gid IS NULL OR savsoft_qbank.gid = $logged_in[gid] ";
		 $this->db->where($where);
	}
	elseif($result_role['role_type'] == 'school_teacher'){
		// $this->db->where('savsoft_qbank.gid',$logged_in['gid']);
		 $this->db->where('savsoft_qbank.uid',$logged_in['uid']);
		 $where = "  savsoft_qbank.gid IS NULL OR savsoft_qbank.gid = $logged_in[gid] ";
		 $this->db->where($where);
	}
		
	/* $this->db->join('savsoft_category','savsoft_category.cid=savsoft_qbank.cid');
	 $this->db->join('savsoft_level','savsoft_level.lid=savsoft_qbank.lid');*/
	 $this->db->select('*');
	 $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_qbank.cid ) as category_name');
	 $this->db->select('(select level_name FROM savsoft_level where lid=savsoft_qbank.lid ) as level_name');
	  $this->db->select('(select class_name FROM savsoft_class where id=savsoft_qbank.class_id ) as class_name');
	 $this->db->limit($this->config->item('number_of_rows'),$limit);
	 $this->db->order_by('savsoft_qbank.qid','desc');
	 $query=$this->db->get('savsoft_qbank');
	 //echo $this->db->last_query();
	 return $query->result_array();
		
	 
 }
 
 
 function num_qbank(){
	
	 $logged_in=$this->session->userdata('logged_in');
	 
	 $this->db->where('id',$logged_in['su']);
	 $query_role = $this->db->get('savsoft_roles');
	 $result_role = $query_role->row_array();
			
	 if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
		  $this->db->or_where('savsoft_qbank.gid',$logged_in['gid']);
	 }
	
	  
	 $query=$this->db->get('savsoft_qbank');
		return $query->num_rows();
 }
 
 
 
 function get_question($qid){
	 $this->db->where('qid',$qid);
	 $query=$this->db->get('savsoft_qbank');
	 return $query->row_array();
	 
	 
 }
 function get_option($qid){
	 $this->db->where('qid',$qid);
	 $query=$this->db->get('savsoft_options');
	 return $query->result_array();
	 
	 
 }
 
 function remove_question($qid){
	 $where="FIND_IN_SET('".$qid."', qids)"; 
	 $res = $this->db->where($where)->get('savsoft_quiz')->result_array();
	 
	 foreach($res as $allQuize){
		 $new_qid=array();
		 foreach(explode(',',$allQuize['qids']) as $key => $oqid){
			 if($oqid != $qid){
				$new_qid[]=$oqid; 
			 }
		 }
	
		 $new_qid=array_filter(array_unique($new_qid));
		 $noq=count($new_qid);
		 $userdata=array(
		 	'qids'=>implode(',',$new_qid),
			'noq'=>$noq
		 );
		 $this->db->where('quid',$allQuize['quid']);
		 $this->db->update('savsoft_quiz',$userdata);
	 // echo $this->db->last_query(); 
	 }
	
	 $this->db->where('qid',$qid);
	 if($this->db->delete('savsoft_qbank')){
		  $this->db->where('qid',$qid);
		  $this->db->delete('savsoft_options');
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 function insert_question_1(){
	 
	 $logged_in=$this->session->userdata('logged_in');
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_single_answer'),
	 'class_id'=>$this->input->post('class_id'),
	 'cid'=>$this->input->post('subject_id'),
	 'chapter_id'=>$this->input->post('chapter_id'),
	 'question_code'=>$this->session->userdata('question_code'),
	 'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid'),
	 'uid'=>$logged_in['uid'],
	 'gid'=>$logged_in['gid']	 
	 );
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 foreach($this->input->post('option') as $key => $val){
		 if($this->input->post('score')==$key){
			 $score=1;
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	$this->session->unset_userdata('question_code'); 
	 return true;
	 
 }

 function insert_question_2(){
	 $logged_in=$this->session->userdata('logged_in'); 
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_multiple_answer'),
	 'class_id'=>$this->input->post('class_id'),
	 'cid'=>$this->input->post('subject_id'),
	 'chapter_id'=>$this->input->post('chapter_id'),
	 'question_code'=>$this->session->userdata('question_code'),
	 'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid'),
	  'uid'=>$logged_in['uid'],
	 'gid'=>$logged_in['gid']	 	 
	 );
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 foreach($this->input->post('option') as $key => $val){
		 if(in_array($key,$this->input->post('score'))){
			 $score=(1/count($this->input->post('score')));
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 $this->session->unset_userdata('question_code');
	 return true;
	 
 }
 
 
 function insert_question_3(){
	  $logged_in=$this->session->userdata('logged_in');
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('match_the_column'),
	 'class_id'=>$this->input->post('class_id'),
	 'cid'=>$this->input->post('subject_id'),
	 'chapter_id'=>$this->input->post('chapter_id'),
	 'question_code'=>$this->session->userdata('question_code'),
	 'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid'),
	  'uid'=>$logged_in['uid'],
	 'gid'=>$logged_in['gid']	 	 
	 );
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 foreach($this->input->post('option') as $key => $val){
	  $score=(1/count($this->input->post('option')));
	$userdata=array(
	 'q_option'=>$val,
	 'q_option_match'=>$_POST['option2'][$key],
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 $this->session->unset_userdata('question_code');
	 return true;
	 
 }
 
 
 
 
 function insert_question_4(){
	 $logged_in=$this->session->userdata('logged_in'); 
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('short_answer'),
	 'class_id'=>$this->input->post('class_id'),
	 'cid'=>$this->input->post('subject_id'),
	 'chapter_id'=>$this->input->post('chapter_id'),
	 'question_code'=>$this->session->userdata('question_code'),
	 'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid'),
	  'uid'=>$logged_in['uid'],
	 'gid'=>$logged_in['gid']	 	 
	 );
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 foreach($this->input->post('option') as $key => $val){
	  $score=1;
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 $this->session->unset_userdata('question_code');
	 return true;
	 
 }
 
 
 function insert_question_5(){
	  $logged_in=$this->session->userdata('logged_in');
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('long_answer'),
	 'class_id'=>$this->input->post('class_id'),
	 'cid'=>$this->input->post('subject_id'),
	 'chapter_id'=>$this->input->post('chapter_id'),
	 'question_code'=>$this->session->userdata('question_code'),
	  'question_answer'=>$this->lang->line('question_answer'),
	 'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid'),
	  'uid'=>$logged_in['uid'],
	 'gid'=>$logged_in['gid']	 
		 
	 );
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 $this->session->unset_userdata('question_code');
	 
	 return true;
	 
 }
 
 
 
  function update_question_1($qid){
	 
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_single_answer'),
	 'class_id'=>$this->input->post('class_id'),
	'cid'=>$this->input->post('subject_id'),
	'chapter_id'=>$this->input->post('chapter_id'),
	
	'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid')	 
	 );
	 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
	 foreach($this->input->post('option') as $key => $val){
		 
		 
		 if($this->input->post('score')==$key){
			 $score=1;
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }

 
 
 
 
  function update_question_2($qid){
	 
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_multiple_answer'),
	 'class_id'=>$this->input->post('class_id'),
	'cid'=>$this->input->post('subject_id'),
	'chapter_id'=>$this->input->post('chapter_id'),
	
	'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid')	 
	 );
	 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
	 foreach($this->input->post('option') as $key => $val){
		 if(in_array($key,$this->input->post('score'))){
			 $score=(1/count($this->input->post('score')));
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 function update_question_3($qid){
	 
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('match_the_column'),
	 'class_id'=>$this->input->post('class_id'),
	'cid'=>$this->input->post('subject_id'),
	'chapter_id'=>$this->input->post('chapter_id'),
	
	'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid')	 
	 );
	 	 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
	foreach($this->input->post('option') as $key => $val){
	  $score=(1/count($this->input->post('option')));
	$userdata=array(
	 'q_option'=>$val,
	 'q_option_match'=>$_POST['option2'][$key],
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 
 
 function update_question_4($qid){
	 
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('short_answer'),
	 'class_id'=>$this->input->post('class_id'),
	'cid'=>$this->input->post('subject_id'),
	'chapter_id'=>$this->input->post('chapter_id'),
	
	'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid')	 
	 );
		 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
 foreach($this->input->post('option') as $key => $val){
	  $score=1;
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 function update_question_5($qid){
	 
	 
	 $userdata=array(
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('long_answer'),
	 'class_id'=>$this->input->post('class_id'),
	'cid'=>$this->input->post('subject_id'),
	'chapter_id'=>$this->input->post('chapter_id'),
	'question_answer'=>$this->lang->line('question_answer'),
	'lession_id'=>$this->input->post('lession_id') ? $this->input->post('lession_id'):'',
	 'lid'=>$this->input->post('lid')	 
	 );
		 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');

	 
	 return true;
	 
 }
 
 
 
 
 // category function start
 function category_list(){
	 $logged_in=$this->session->userdata('logged_in');
		 //print_r($logged_in);
		 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		 if($result_role['role_type']=='school_teacher'){
			  $this->db->join('teacher_taken_subject','teacher_taken_subject.subject_id=savsoft_category.cid');
		 }
		$this->db->select('*'); 
		
	 $this->db->order_by('savsoft_category.cid','asc');
	 $query=$this->db->get('savsoft_category');
	 return $query->result_array();
	 
 }

 
 function insert_category(){
	 
	 	$userdata=array(
		'category_name'=>$this->input->post('category_name'),
		'class_id'=>$this->input->post('class_id'),
			);
		
		if($this->db->insert('savsoft_category',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 
 
 function update_category($cid){
	 
		$userdata=array(
		'category_name'=>$this->input->post('category_name'),
		 	
		);
	 
		 $this->db->where('cid',$cid);
		if($this->db->update('savsoft_category',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
  
 function update_category1($cid){
	 
		$userdata=array(
		'class_id'=>$this->input->post('class_id'),
		 	
		);
	 
		 $this->db->where('cid',$cid);
		if($this->db->update('savsoft_category',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 } 
 
 function remove_category($cid){
	 
	 $this->db->where('cid',$cid);
	 if($this->db->delete('savsoft_category')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
  

 // category function end
 
 
 
/**/
 // Class function start
 function class_list (){
	 
	  $logged_in=$this->session->userdata('logged_in');
		 //print_r($logged_in);
		 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		 if($result_role['role_type']=='school_teacher'){
			  $this->db->join('teacher_taken_subject','teacher_taken_subject.class_id=savsoft_class.id');
			   $this->db->where('teacher_taken_subject.user_id',$logged_in['uid']);
			  $this->db->group_by('teacher_taken_subject.class_id');
		 }
	 $this->db->select('savsoft_class.*'); 
		
	 $this->db->order_by('savsoft_class.id','asc');
	 $query=$this->db->get('savsoft_class');
	 return $query->result_array();
	 
 } 
 function insert_class(){
	 $userdata=array(
		'class_name'=>$this->input->post('class_name'),
		'create_date'=>date('Y-m-d')
			);
		
		if($this->db->insert('savsoft_class',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
 }
 
  function update_class($cid){
	 
		$userdata=array(
		'class_name'=>$this->input->post('class_name'),
		 	
		);
	 
		 $this->db->where('id',$cid);
		
		
		if($this->db->update('savsoft_class',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
  
 
 
 function remove_class($cid){
	 
	 $this->db->where('id',$cid);
	 if($this->db->delete('savsoft_class')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 /**/
 
 
 
 
  // Class section  function start
 function class_section_list (){
	 $this->db->order_by('id','asc');
	 $query=$this->db->get('savsoft_class_section');
	 return $query->result_array();
	 
 } 
 function insert_class_section(){
	 $userdata=array(
		'section_name'=>$this->input->post('section_name'),
		'create_date'=>date('Y-m-d')
			);
		
		if($this->db->insert('savsoft_class_section',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
 }
 
  function update_class_section($cid){
	 
		$userdata=array(
		'section_name'=>$this->input->post('section_name'),
		 	
		);
	 
		 $this->db->where('id',$cid);
		
		
		if($this->db->update('savsoft_class_section',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
  
 
 
 function remove_class_section($cid){
	 
	 $this->db->where('id',$cid);
	 if($this->db->delete('savsoft_class_section')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 /**/
 
 
// level function start
 function level_list(){
	  $query=$this->db->get('savsoft_level');
	 return $query->result_array();
	 
 }
 
 
 
 
 function update_level($lid){
	 
		$userdata=array(
		'level_name'=>$this->input->post('level_name'),
		 	
		);
	 
		 $this->db->where('lid',$lid);
		if($this->db->update('savsoft_level',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
  
 
 
 function remove_level($lid){
	 
	 $this->db->where('lid',$lid);
	 if($this->db->delete('savsoft_level')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
  
 
 function insert_level(){
	 
	 	$userdata=array(
		'level_name'=>$this->input->post('level_name'),
			);
		
		if($this->db->insert('savsoft_level',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 // level function end
 

 
 
 
 
 function import_question($question){
//echo "<pre>"; print_r($question);exit;
 $questioncid=$this->input->post('subject_id1');
 $class_id = $this->input->post('class_id1');
 $chapter_id = $this->input->post('chapter_id1');
 $lession_id = $this->input->post('lession_id1');
$questiondid=$this->input->post('did');
foreach($question as $key => $singlequestion){
	//$ques_type= 
	
//echo $ques_type; 

if($key != 0){
echo "<pre>";print_r($singlequestion);
$question= str_replace('"','&#34;',$singlequestion['1']);
$question= str_replace("`",'&#39;',$question);
$question= str_replace("‘",'&#39;',$question);
$question= str_replace("’",'&#39;',$question);
$question= str_replace("â€œ",'&#34;',$question);
$question= str_replace("â€˜",'&#39;',$question);



$question= str_replace("â€™",'&#39;',$question);
$question= str_replace("â€",'&#34;',$question);
$question= str_replace("'","&#39;",$question);
$question= str_replace("\n","<br>",$question);
$description= str_replace('"','&#34;',$singlequestion['2']);
$description= str_replace("'","&#39;",$description);
$description= str_replace("\n","<br>",$description);
$ques_type= $singlequestion['0'];
if($ques_type=="0" || $ques_type==""){
$question_type=$this->lang->line('multiple_choice_single_answer');	
}
if($ques_type=="1"){
$question_type=$this->lang->line('multiple_choice_multiple_answer');	
}
if($ques_type=="2"){
$question_type=$this->lang->line('match_the_column');	
}
if($ques_type=="3"){
$question_type=$this->lang->line('short_answer');	
}
if($ques_type=="4"){
$question_type=$this->lang->line('long_answer');	
}


	$insert_data = array(
	'cid' => $questioncid,
	'lid' => $questiondid,
	'question' =>$question,
	'description' => $description,
	'question_type' => $question_type,
	'class_id'=> $class_id,
	'chapter_id'=> $chapter_id,
	'lession_id'=> $lession_id
	);
	
	if($this->db->insert('savsoft_qbank',$insert_data)){
		$qid=$this->db->insert_id();
		$optionkeycounter = 4;
		if($ques_type=="0" || $ques_type==""){
		for($i=1;$i<=10;$i++){
			if($singlequestion[$optionkeycounter] != ""){
				if($singlequestion['3'] == $i){ $correctoption ='1'; }
				else{ $correctoption = 0; }
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $singlequestion[$optionkeycounter],
				"score" => $correctoption
				);
				$this->db->insert("savsoft_options",$insert_options);
				$optionkeycounter++;
				}
			
			}
	}
	//multiple type
	if($ques_type=="1"){
			$correct_options=explode(",",$singlequestion['3']);
			$no_correct=count($correct_options);
			$correctoptionm=array();
			for($i=1;$i<=10;$i++){
			if($singlequestion[$optionkeycounter] != ""){
			foreach($correct_options as $valueop){
				if($valueop == $i){ $correctoptionm[$i-1] =(1/$no_correct);
					break;
					}
				else{ $correctoptionm[$i-1] = 0; }
			}
			}
			}
			
			//print_r($correctoptionm);
			
		for($i=1;$i<=10;$i++){
		
			if($singlequestion[$optionkeycounter] != ""){
			
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $singlequestion[$optionkeycounter],
				"score" => $correctoptionm[$i-1]
				);
				$this->db->insert("savsoft_options",$insert_options);
				$optionkeycounter++;
				
				
				}
			
			}
	}
	
	//multiple type end	
	
 //match Answer
		if($ques_type=="2"){
			$qotion_match=0;
			for($j=1;$j<=10;$j++){
			
			if($singlequestion[$optionkeycounter] != ""){
				
				$qotion_match+=1;
				$optionkeycounter++;
				}
				
				}
			///h
			$optionkeycounter=4;
		for($i=1;$i<=10;$i++){
			
			if($singlequestion[$optionkeycounter] != ""){
				$explode_match=explode('=',$singlequestion[$optionkeycounter]);
				 $correctoption =1/$qotion_match; 
				$insert_options = array(
				"qid" =>$qid,
				"q_option" =>$explode_match[0] ,
				"q_option_match" =>$explode_match[1] ,
				 "score" => $correctoption
				);
				$this->db->insert("savsoft_options",$insert_options);
				$optionkeycounter++;
				}
				
				}
			
			}
	
	//end match answer
	
	//short Answer
		if($ques_type=="3"){
		for($i=1;$i<=1;$i++){
			
			if($singlequestion[$optionkeycounter] != ""){
				if($singlequestion['3'] == $i){ $correctoption ='1'; }
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $singlequestion[$optionkeycounter],
				"score" => $correctoption
				);
				$this->db->insert("savsoft_options",$insert_options);
				$optionkeycounter++;
				}
				
				}
			
			}
	
	//end Short answer
	
	
	
		}//
		}
	}

 
}

/*======functions written by yeasmin================*/

	function chapter_list(){
		
		if($this->input->post('class_id')){
			$this->db->where('class_id',$this->input->post('class_id'));
		}
		if($this->input->post('subject_id')){
			$this->db->where('subject_id',$this->input->post('subject_id'));
		}
		/*$sql = "select *,(select class_name from savsoft_class where id=ch.class_id) as class_name,
		(select category_name from savsoft_category where cid=ch.subject_id) as category_name,
		(select chapter_name from savsoft_chapter where id=ch.chapter_id) as chapter_name
		  from savsoft_lession as ch order by ch.class_id asc, ch.subject_id asc,ch.id asc";*/
		$this->db->order_by('class_id','asc');
		$this->db->order_by('subject_id','asc');
		$this->db->order_by('id','asc');  
		$this->db->select('*');
		$this->db->select('(select category_name FROM savsoft_category where cid=subject_id) as category_name');
		$this->db->select('(select chapter_name from savsoft_chapter where id=chapter_id) as chapter_name');
		$this->db->select('(select class_name FROM savsoft_class where id=class_id ) as class_name');
	    $query=$this->db->get('savsoft_lession');
		
		//$query = $this->db->query($sql);
		/*
		 $query=$this->db->get('savsoft_class');*/
		 //echo $this->db->last_query();
		 return $query->result_array();
	}

	function subject_list(){
		
		 $logged_in=$this->session->userdata('logged_in');
		 //print_r($logged_in);
		 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		 if($result_role['role_type']=='school_teacher'){
			  $this->db->join('teacher_taken_subject','teacher_taken_subject.subject_id=savsoft_category.cid');
			  $this->db->where('teacher_taken_subject.user_id',$logged_in['uid']);
		 }
		 if($this->input->post('class_id1')){
			$this->db->where('savsoft_category.class_id',$this->input->post('class_id1'));
		 }else{
			$this->db->where('savsoft_category.class_id',$this->input->post('class_id'));
		 }
		  $this->db->select('savsoft_category.*');
		 $this->db->order_by('savsoft_category.cid','asc');
		 $query=$this->db->get('savsoft_category');
		 
		 //echo $this->db->last_query();
		 return $query->result_array();
	}


	function chapter_list_load(){
		
		if($this->input->post('class_id1')){
			$this->db->where('class_id',$this->input->post('class_id1'));
			$this->db->where('subject_id',$this->input->post('subject_id1'));
		}else{
		$this->db->where('class_id',$this->input->post('class_id'));
		$this->db->where('subject_id',$this->input->post('subject_id'));
		}
		
		
		$this->db->where('status','1');
		$this->db->group_by('chapter_name');
		$this->db->order_by('id','asc');
		$query=$this->db->get('savsoft_chapter');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function load_lession_for_question_1(){
		
		if($this->input->post('class_id1')){
			$this->db->where('class_id',$this->input->post('class_id1'));
			$this->db->where('subject_id',$this->input->post('subject_id1'));
			$this->db->where('chapter_id',$this->input->post('chapter_id1'));
		}else{
		$this->db->where('class_id',$this->input->post('class_id'));
		$this->db->where('subject_id',$this->input->post('subject_id'));
		$this->db->where('chapter_id',$this->input->post('chapter_id'));
		}
		
		
		$this->db->where('status','1');
		$this->db->order_by('id','asc');
		$query=$this->db->get('savsoft_lession');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function get_subject_by_class_id($class_id){
		$logged_in=$this->session->userdata('logged_in');
		 //print_r($logged_in);
		 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
		 if($result_role['role_type']=='school_teacher'){
			  $this->db->join('teacher_taken_subject','teacher_taken_subject.subject_id=savsoft_category.cid');
		 }
		$this->db->select('*'); 
		$this->db->where('savsoft_category.class_id',$class_id);
		$this->db->order_by('savsoft_category.cid','asc');
		
		$query=$this->db->get('savsoft_category');
		return $query->result_array();
	}


	function get_chapter_by_subject_id($class_id,$subject_id){
		$this->db->where('class_id',$class_id);
		$this->db->where('subject_id',$subject_id);
		$this->db->where('status','1');
		$this->db->order_by('id','asc');
		$query=$this->db->get('savsoft_chapter');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function get_lesson_by_chapter_id($class_id,$subject_id, $chapter_id){
		$this->db->where('class_id',$class_id);
		$this->db->where('subject_id',$subject_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('status','1');
		$this->db->order_by('id','asc');
		$query=$this->db->get('savsoft_lession');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function chapter_list_by_id($id){
	
		$this->db->where('id',$id);
		 $query=$this->db->get('savsoft_chapter');
		 return $query->row_array();
	}

  function insert_chapter(){
	 $chapter_id = $this->input->post('chapter_id');
	 $chapter_name =  $this->input->post('chapter_name');
	 
	  if(!empty($chapter_name)){ 
	  
	  $userdata=array(
			'class_id'=>$this->input->post('class_id'),
			'subject_id'=>$this->input->post('subject_id'),
			'chapter_name'=>$chapter_name,
			
			'status'=>$this->input->post('mstatus') ? $this->input->post('mstatus') : '0',
			'create_date'=>date('Y-m-d')
		  ); 
		$this->db->insert('savsoft_chapter',$userdata);
		$inserted_id = $this->db->insert_id();
		//echo $this->db->last_query();
		
		 $userdata=array(
			'class_id'=>$this->input->post('class_id'),
			'subject_id'=>$this->input->post('subject_id'),
			'lession_name'=>$this->input->post('lession_name'),
			'classification'=>$this->input->post('classification'),
			'chapter_id'=>$inserted_id,
			'status'=>$this->input->post('mstatus') ? $this->input->post('mstatus') : '0',
			'create_date'=>date('Y-m-d')
		  ); 
		$this->db->insert('savsoft_lession',$userdata);
		$id = $this->db->insert_id();
		
	
	 } elseif(empty($chapter_name) && !empty($chapter_id)){
		 
		 $userdata=array(
			'class_id'=>$this->input->post('class_id'),
			'subject_id'=>$this->input->post('subject_id'),
			'chapter_id'=>$chapter_id,
			'lession_name'=>$this->input->post('lession_name'),
			'classification'=>$this->input->post('classification'),
			'status'=>$this->input->post('lession_name') ? $this->input->post('mstatus') : '0',
			'create_date'=>date('Y-m-d')
		  ); 
		$this->db->insert('savsoft_lession',$userdata);
		$id = $this->db->insert_id();
		//echo $this->db->last_query();
	 }
	 
		
		if(!empty($id)){
			
			return true;
		}else{
			
			return false;
		}
  
  }
    function update_chapter($cid){
		 $chapter_id = $this->input->post('chapter_id');
		 $this->db->where('chapter_name',$chapter_id);
		 $query=$this->db->get('savsoft_chapter');
		 $row = $query->row_array();
		
		
		$userdata=array(
			'class_id'=>$this->input->post('class_id'),
			'subject_id'=>$this->input->post('subject_id'),
			'chapter_id'=>$chapter_id,
			'lession_name'=>$this->input->post('lession_name'),
			'classification'=>$this->input->post('classification'),
			'status'=>$this->input->post('mstatus') ? $this->input->post('mstatus') : '0',
			'create_date'=>date('Y-m-d')
		  ); 
		   
		
	 
		$this->db->where('id',$cid);
		if($this->db->update('savsoft_lession',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	}
  function remove_chapter($cid){
	 
	 $this->db->where('id',$cid);
	 if($this->db->delete('savsoft_lession')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 
 
 
  function content_list($limit,$userID){
	 // print_r($this->input->post());
	$logged_in=$this->session->userdata('logged_in'); 
	
	if($this->input->post('class_id')){
		$this->db->where('savsoft_qbank.class_id',$this->input->post('class_id'));
	 }
	
	if($class_id){
		$this->db->where('savsoft_qbank.class_id',$class_id);
	 }
	 
	 if($subject_id){
		$this->db->where('savsoft_qbank.subject_id',$subject_id);
	 }
	 	 
	 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array(); 
	
	if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
		 $this->db->where('savsoft_content.user_id',$userID);
		 
	 }else if($result_role['role_type']=='user'){
		 $this->db->where('savsoft_student_profile.is_current_year','1');
		 $this->db->where('savsoft_student_profile.status','1');
		 $this->db->where('savsoft_content.school_id',$logged_in['gid']);
		 $this->db->where('savsoft_content.is_display','0');
		  $this->db->where('savsoft_student_profile.user_id',$userID);
		 $this->db->join('savsoft_student_profile','savsoft_student_profile.class_id=savsoft_content.class_id');		 
	 }
	  
	/* $this->db->join('savsoft_category','savsoft_category.cid=savsoft_qbank.cid');
	 $this->db->join('savsoft_level','savsoft_level.lid=savsoft_qbank.lid');*/
	 $this->db->select('savsoft_content.*');
	 $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_content.subject_id ) as category_name');
	  $this->db->select('(select class_name FROM savsoft_class where id=savsoft_content.class_id ) as class_name');
	  $this->db->select('(select first_name FROM savsoft_users where uid=savsoft_content.user_id ) as first_name');
	   $this->db->select('(select last_name FROM savsoft_users where uid=savsoft_content.user_id ) as last_name');
	 $this->db->limit($this->config->item('number_of_rows'),$limit);
	 $this->db->order_by('savsoft_content.id','desc');
	 $query=$this->db->get('savsoft_content');
	 //echo $this->db->last_query();
	 return $query->result_array();
		
	 
 }
 
 
   function content_deatils($contentID){
	 // print_r($this->input->post());
	$logged_in=$this->session->userdata('logged_in'); 
		 	 
   $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array(); 
	/*
	if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
		 $this->db->where('savsoft_content.user_id',$userID);
	 }else if($result_role['role_type']=='user'){
		 $this->db->where('savsoft_student_profile.is_current_year','1');
		 $this->db->where('savsoft_student_profile.status','1');
		 $this->db->where('savsoft_content.school_id',$logged_in['gid']);
		  $this->db->where('savsoft_student_profile.user_id',$userID);
		 $this->db->join('savsoft_student_profile','savsoft_student_profile.class_id=savsoft_content.class_id');		 
	 }*/

	 $this->db->where('savsoft_content.id',$contentID);
	 $this->db->where('savsoft_content.is_display','0');
	 $this->db->select('*');
	 $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_content.subject_id ) as category_name');
	  $this->db->select('(select class_name FROM savsoft_class where id=savsoft_content.class_id ) as class_name');
	  $this->db->select('(select first_name FROM savsoft_users where uid=savsoft_content.user_id ) as first_name');
	   $this->db->select('(select last_name FROM savsoft_users where uid=savsoft_content.user_id ) as last_name');
	 $this->db->limit($this->config->item('number_of_rows'),$limit);
	 $this->db->order_by('savsoft_content.id','desc');
	 $query=$this->db->get('savsoft_content');
	 //echo $this->db->last_query();
	 return $query->row_array();
		
	 
 }


/*===============smart content list================*/
 function smart_content_list($limit,$userID){
	 // print_r($this->input->post());
	$logged_in=$this->session->userdata('logged_in'); 
	
	 //print_r($this->input->post());
		 	 
	 $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array(); 
	
	if($result_role['role_type']=='school_teacher' || $result_role['role_type']=='school_admin'){
		$where = "savsoft_smart_class_content.user_id = $userID OR savsoft_smart_class_content.created_by='kiteBD'";
		$this->db->where($where);
		 //$this->db->where('savsoft_smart_class_content.user_id',$userID);
		 //$this->db->where_or('savsoft_smart_class_content.created_by','kiteBD');
	 }else if($result_role['role_type']=='user'){
		 $this->db->where('savsoft_student_profile.is_current_year','1');
		 $this->db->where('savsoft_student_profile.status','1');
		 $this->db->where('savsoft_smart_class_content.school_id',$logged_in['gid']);
		  $this->db->where('savsoft_student_profile.user_id',$userID);
		 $this->db->join('savsoft_student_profile','savsoft_student_profile.class_id=savsoft_content.class_id');		 
	 }
	  
	/* $this->db->join('savsoft_category','savsoft_category.cid=savsoft_qbank.cid');
	 $this->db->join('savsoft_level','savsoft_level.lid=savsoft_qbank.lid');*/
	 
	  if(!empty($this->input->post('class_id'))){
		 $this->db->where('savsoft_smart_class_content.class_id',$this->input->post('class_id'));
	 }
	 
	 if(!empty($this->input->post('subject_id'))){
		 $this->db->where('savsoft_smart_class_content.subject_id',$this->input->post('subject_id'));
	 }
	 if(!empty($this->input->post('chapter_id'))){
		 $this->db->where('savsoft_smart_class_content.chapter_id',$this->input->post('chapter_id'));
	 }
	 if(!empty($this->input->post('lession_id'))){
		 $this->db->where('savsoft_smart_class_content.lesson_id',$this->input->post('lession_id'));
	 }
	 $this->db->select('savsoft_smart_class_content.*');
	 $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_smart_class_content.subject_id ) as category_name');
	  $this->db->select('(select class_name FROM savsoft_class where id=savsoft_smart_class_content.class_id ) as class_name');
	  $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_smart_class_content.subject_id ) as subject_name');
	  $this->db->select('(select chapter_name FROM savsoft_chapter where id=savsoft_smart_class_content.chapter_id ) as chapter_name');
	  $this->db->select('(select lession_name FROM savsoft_lession where id=savsoft_smart_class_content.lesson_id ) as lesson_name');
	  $this->db->select('(select first_name FROM savsoft_users where uid=savsoft_smart_class_content.user_id ) as first_name');
	   $this->db->select('(select last_name FROM savsoft_users where uid=savsoft_smart_class_content.user_id ) as last_name');
	 $this->db->limit($this->config->item('number_of_rows'),$limit);
	 $this->db->order_by('savsoft_smart_class_content.subject_id','ASC');
	 $this->db->order_by('savsoft_smart_class_content.subject_id','ASC');
	 $this->db->order_by('savsoft_smart_class_content.chapter_id','ASC');
	 $this->db->order_by('savsoft_smart_class_content.lesson_id','ASC');
	
	 $query=$this->db->get('savsoft_smart_class_content');
	// echo $this->db->last_query();
	 return $query->result_array();
		
	 
 }
 
 
 function smart_content_details($contentID){
	 // print_r($this->input->post());
	$logged_in=$this->session->userdata('logged_in'); 
	
	 $this->db->where('savsoft_smart_class_content.id',$contentID);
	 $this->db->select('savsoft_smart_class_content.*');
	 $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_smart_class_content.subject_id ) as category_name');
	  $this->db->select('(select class_name FROM savsoft_class where id=savsoft_smart_class_content.class_id ) as class_name');
	  $this->db->select('(select category_name FROM savsoft_category where cid=savsoft_smart_class_content.subject_id ) as subject_name');
	  $this->db->select('(select chapter_name FROM savsoft_chapter where id=savsoft_smart_class_content.chapter_id ) as chapter_name');
	  $this->db->select('(select lession_name FROM savsoft_lession where id=savsoft_smart_class_content.lesson_id ) as lesson_name');
	  $this->db->select('(select first_name FROM savsoft_users where uid=savsoft_smart_class_content.user_id ) as first_name');
	   $this->db->select('(select last_name FROM savsoft_users where uid=savsoft_smart_class_content.user_id ) as last_name');
	
	 $this->db->order_by('savsoft_smart_class_content.id','desc');
	 $query=$this->db->get('savsoft_smart_class_content');
	 //echo $this->db->last_query();
	 return $query->row_array();
		
	 
 }
 
 function get_teacher_by_subject($subejctID){
	$sql = "SELECT * FROM `teacher_taken_subject` AS tts
		INNER JOIN `savsoft_users` AS su ON su.uid=tts.user_id
		WHERE tts.subject_id=$subejctID AND tts.status='1' ";
	$query = $this->db->query($sql);
	if($query->num_rows()>0){
		return $query->result_array();
	}else{
		return NULL;
	}
 }
 
 
  function get_teacher_information($teacherID){
	$this->db->where('uid',$teacherID);
	$query = $this->db->get('savsoft_users');
	if($query->num_rows()>0){
		return $query->row_array();
	}else{
		return NULL;
	}
 }
 
 function get_subject_information($subjectID){
	$this->db->where('cid',$subjectID);
	$query = $this->db->get('savsoft_category');
	if($query->num_rows()>0){
		return $query->row_array();
	}else{
		return NULL;
	}
 }
 
 function get_message_information($teacherID,$studentID,$subjectID){
	 $logged_in=$this->session->userdata('logged_in');
	 $this->db->where('sender_id',$logged_in['uid']);
	 $this->db->where('teacher_id',$teacherID);
	 $this->db->where('subject_id',$subjectID);
	  $this->db->where('student_id',$studentID);
	 $query = $this->db->get('savsoft_message');
	 if($query->num_rows()>0){
		return $query->row_array();
	}else{
		return NULL;
	}
 }
 
 function get_message_reply_information($message_id){
	 $logged_in=$this->session->userdata('logged_in');
	 
	 $this->db->select('*');
	 $this->db->select('(select first_name FROM savsoft_users where uid=savsoft_message_reply.replied_user_id ) as first_name');
	 $this->db->select('(select last_name FROM savsoft_users where uid=savsoft_message_reply.replied_user_id ) as last_name');
	 $this->db->where('savsoft_message_reply.message_id',$message_id);
	 $this->db->order_by('savsoft_message_reply.id','ASC');
	 $query = $this->db->get('savsoft_message_reply');
	 if($query->num_rows()>0){
		return $query->result_array();
	}else{
		return NULL;
	}
 }
 
 function send_teacher_message(){
	  $logged_in=$this->session->userdata('logged_in');
	  $postData=array(
			'sender_id'=>$logged_in['uid'],
			'parent_id'=>$logged_in['uid'],
			'teacher_id'=>$this->input->post('teacher_id'),
			'student_id'=>$this->input->post('student_id'),
			'subject_id'=>$this->input->post('subject_id'),
			'message'=>$this->input->post('main_message'),
			'is_view'=>'0',
			'send_date'=>date('Y-m-d')
		  ); 
		$this->db->insert('savsoft_message',$postData);
		$id = $this->db->insert_id();
 }
 
 function reply_message(){
	  $logged_in=$this->session->userdata('logged_in');
	  $postData=array(
			'replied_user_id'=>$logged_in['uid'],
			'message_id'=>$this->input->post('message_id'),
			'message'=>$this->input->post('replay_message'),
			'is_view'=>'0',
			'reply_date'=>date('Y-m-d')
		  ); 
		$this->db->insert('savsoft_message_reply',$postData);
		$id = $this->db->insert_id();
 }
 
 function get_parent_message($messageID=false){
	 $logged_in=$this->session->userdata('logged_in');
	 
	 $this->db->select('*');
	 $this->db->select('(select first_name FROM savsoft_users where uid=savsoft_message.parent_id ) as first_name');
	 $this->db->select('(select last_name FROM savsoft_users where uid=savsoft_message.parent_id ) as last_name');
	 $this->db->select('(SELECT category_name FROM savsoft_category WHERE cid=savsoft_message.subject_id ) AS subject_name');
	 $this->db->where('savsoft_message.teacher_id',$logged_in['uid']);
	 if($messageID){
		 $this->db->where('savsoft_message.id',$messageID);
	 }
	 $this->db->order_by('savsoft_message.send_date','DESC');
	 $query = $this->db->get('savsoft_message');
	 
	  if($query->num_rows()>0){
		return $query->result_array();
	}else{
		return NULL;
	}
 }
 
 function update_message($messageID){
	    $logged_in=$this->session->userdata('logged_in');
		$this->db->where('message_id',$message['id']);
		$this->db->where('replied_user_id',$logged_in['uid']);
		$this->db->where('is_view','0');
		$query = $this->db->get('savsoft_message_reply');
		$countReplyMessage = $query->num_rows();
		//echo $this->db->last_query();
		if($countReplyMessage==0){ 
			$userdata=array(
				'is_view'=>'1'
			);
			$this->db->where('id',$messageID);
			$this->db->update('savsoft_message',$userdata);	
			
			$userdata1=array(
				'is_view'=>'1'
			);
			$this->db->where('message_id',$messageID);
			$this->db->update('savsoft_message_reply',$userdata1);	 
		}
 }
}







 



?>