 <script>
function load_subject(){
	var class_id =$('#class_id').val();
	$("#subject_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id,
		url: "<?=base_url().'loading/load_subject'?>",
		success: function(result){
			$("#subject_div_id").html(result);
		}
		
	});
}
function load_chapter(){
	var class_id =$('#class_id').val();
	var subject_id =$('#subject_id').val();
	$("#chapter_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id+'&subject_id='+subject_id,
		url: "<?=base_url().'loading/load_chapter_for_question_1'?>",
		success: function(result){
			$("#chapter_div_id").html(result);
		}
		
	});
}

function load_lesson(){
	var class_id =$('#class_id').val();
	var subject_id =$('#subject_id').val();
	var chapter_id =$('#chapter_id').val();
	$("#lesson_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id+'&subject_id='+subject_id+'&chapter_id='+chapter_id,
		url: "<?=base_url().'loading/load_lession_for_question_1'?>",
		success: function(result){
			$("#lesson_div_id").html(result);
		}
		
	});
}
</script>
 <div class="container">

 
     <script>
 $(function() {
  var height = $('#lists').height();
 
 $("#sub_menu").css("min-height",height+"px");
});
 </script>
  <!--<div class="col-md-3 panel login-panel" style="background: #fff; padding-top: 15px;" id="sub_menu">
    <?php 
	
	$CI =& get_instance();
	$CI->load->helper('site_helper');
	$urimenu = $this->uri->segment(1);
	$menus_split = explode("_", $urimenu);
	if(isset($menus_split['1'])){
		  $menu_module = $menus_split['0'].' '.$menus_split['1'];
	}else{
		
		 $menu_module =  $menus_split['0'];
	}
	$menu_module = $menu_module.'/'.$this->uri->segment(2);
	
	
	$sub_menus = get_menu_by_module('exam');
	//print_r($sub_menus);
	
	//$menus_split = explode(" ", $menu['module']);
	
						
	?>
    <ul>
      <?php foreach($sub_menus as $sub_menu) {
			 if(strpos($sub_menu['page_group_url'], 'index')){
				 $url = substr($sub_menu['page_group_url'],0 ,-6);
			 }else{
				 $url = $sub_menu['page_group_url'];
			 }
			
			?>
      <li><a class="" href="<?=base_url().$sub_menu['page_group_url']?>">
        <?=$sub_menu['page_group_name']?>
        </a></li>
      <?php }?>
    </ul>
  </div>-->
  <div class="col-md-12">
    <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >  
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('quiz/update_quiz/'.$quiz['quid']);?>">
	
<div class="col-md-12">
<br> 
 <div >
		<div > 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
        
        <div class="form-group">
              <label>Select Class</label>
              <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" >
                <option value="">Select</option>
                <?php foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>" <?php if($quiz['class_id']==$class['id']){ echo 'selected'; } ?>>
                <?=$class['class_name']?>
                </option>
                <?php }?>
              </select>
            </div>
            
             <div class="form-group">
              <label>Select Class Section</label>
              <select name="class_section_id" id="class_section_id"   class="form-control" >
                <option value="">Select</option>
                <?php foreach($class_section_list as $classSection) {?>
                <option value="<?=$classSection['id']?>"  <?php if($quiz['class_section_id']==$classSection['id']){ echo 'selected'; } ?>>
                <?=$classSection['section_name']?>
                </option>
                <?php }?>
              </select>
            </div>
            
            <div class="form-group">
              <label>Select Class Group</label>
              <select name="class_group_id" id="class_group_id"   class="form-control" >
                <option value="">Select</option>
                <?php foreach($class_group_list as $classGroup) {?>
                <option value="<?=$classGroup['id']?>" <?php if($quiz['class_group_id']==$classGroup['id']){ echo 'selected'; } ?>>
                <?=$classGroup['group_name']?>
                </option>
                <?php }?>
              </select>
            </div>
            
            <div class="form-group">
              <label   ><?php echo $this->lang->line('select_category');?></label>
              <div  id="subject_div_id">
                <?php 
					$CI = &get_instance();
					$CI->load->model('qbank_model');
		    		$subject_lists = $CI->qbank_model->get_subject_by_class_id($quiz['class_id']);
		  
				?>
                <select name="subject_id" id="subject_id" onchange="load_chapter()" required class="form-control" >
                  <option value="">Select</option>
                  <?php foreach($subject_lists as $subject){?>
                  <option value="<?=$subject['cid']?>"  <?php if($quiz['subject_id']==$subject['cid']){ echo 'selected'; } ?>>
                  <?=$subject['category_name']?>
                  </option>
                  <?php }?>
                </select>
                <?php
	
			 
			 ?>
              </div>
            </div>
            
          <!--  <div class="form-group">
              <label   >Select Chapter</label>
              <div  id="chapter_div_id">
              <?php 
			  $CI = &get_instance();
			  $CI->load->model('qbank_model');
		      $chapters = $CI->qbank_model->get_chapter_by_subject_id($quiz['class_id'],$quiz['subject_id']);
			  ?>
               <select name="chapter_id" id="chapter_id" class="form-control" onchange="load_lesson()"><option value="">Select</option>
		<?php foreach($chapters as $chapter_load){?>
        	<option value="<?=$chapter_load['id']?>" <?php if($chapter_load['id']==$quiz['chapter_id']){ echo 'selected'; } ?>><?=$chapter_load['chapter_name']?></option>
		 <?php }?>
		</select>
              </div>
            </div>
            
            
             <div class="form-group">
              <label   >Select Lesson</label>
              <div  id="lesson_div_id">
            <?php 
			  $CI = &get_instance();
			  $CI->load->model('qbank_model');
		      $lessons = $CI->qbank_model->get_lesson_by_chapter_id($quiz['class_id'],$quiz['subject_id'], $quiz['chapter_id']);
			  ?>
               <select name="lession_id" id="lession_id" class="form-control"><option value="">Select</option>
		<?php foreach($lessons as $lessons_load){?>
        	<option value="<?=$lessons_load['id']?>" <?php if($lessons_load['id']==$quiz['lession_id']){ echo 'selected'; } ?>><?=$lessons_load['lession_name']?></option>
		 <?php }?>
		</select>
              </div>
            </div>
            -->
		
		
		 			<div class="form-group">	 
					<label><?php echo $this->lang->line('quiz_name');?></label> 
					<input type="text"  name="quiz_name"  value="<?php echo $quiz['quiz_name'];?>" class="form-control" placeholder="<?php echo $this->lang->line('quiz_name');?>"  required autofocus>
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea   name="description"  class="form-control tinymce_textarea" ><?php echo $quiz['description'];?></textarea>
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('start_date');?></label> 
					<input type="text" name="start_date"  value="<?php echo date('Y-m-d H:i:s',$quiz['start_date']);?>" class="form-control" placeholder="<?php echo $this->lang->line('start_date');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('end_date');?></label> 
					<input type="text" name="end_date"  value="<?php echo date('Y-m-d H:i:s',$quiz['end_date']);?>" class="form-control" placeholder="<?php echo $this->lang->line('end_date');?>"   required >
			</div>
            
             <div class="form-group">	 
					<label for="inputEmail"  >Exam Total marks</label> 
					<input type="text" name="exam_total_marks"  value="<?php echo $quiz['exam_total_marks'];?>" class="form-control" placeholder="Exam Total marks(Ex: 50,100)"  required  >
			</div>
            
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('duration');?></label> 
					<input type="text" name="duration"  value="<?php echo $quiz['duration'];?>" class="form-control" placeholder="<?php echo $this->lang->line('duration');?>"  required  >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('maximum_attempts');?></label> 
					<input type="text" name="maximum_attempts"  value="<?php echo $quiz['maximum_attempts'];?>" class="form-control" placeholder="<?php echo $this->lang->line('maximum_attempts');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('pass_percentage');?></label> 
					<input type="text" name="pass_percentage" value="<?php echo $quiz['pass_percentage'];?>" class="form-control" placeholder="<?php echo $this->lang->line('pass_percentage');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('correct_score');?></label> 
					<input type="text" name="correct_score"  value="<?php echo $quiz['correct_score'];?>" class="form-control" placeholder="<?php echo $this->lang->line('correct_score');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('incorrect_score');?></label> 
					<input type="text" name="incorrect_score"  value="<?php echo $quiz['incorrect_score'];?>" class="form-control" placeholder="<?php echo $this->lang->line('incorrect_score');?>"  required  >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('ip_address');?></label> 
					<input type="text" name="ip_address"  value="<?php echo $quiz['ip_address'];?>" class="form-control" placeholder="<?php echo $this->lang->line('ip_address');?>"    >
			</div>
				<div class="form-group">	 
					<label for="inputEmail" ><?php echo $this->lang->line('view_answer');?></label> <br>
					<input type="radio" name="view_answer"    value="1" <?php if($quiz['view_answer']==1){ echo 'checked'; } ?>  > <?php echo $this->lang->line('yes');?>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="view_answer"    value="0"   <?php if($quiz['view_answer']==0){ echo 'checked'; } ?>  > <?php echo $this->lang->line('no');?>
			</div>
						<?php 
			if($this->config->item('webcam')==true){
				?>
				<div class="form-group">	 
					<label for="inputEmail" ><?php echo $this->lang->line('capture_photo');?></label> <br>
					<input type="radio" name="camera_req"    value="1"   <?php if($quiz['camera_req']==1){ echo 'checked'; } ?>  > <?php echo $this->lang->line('yes');?>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="camera_req"    value="0"   <?php if($quiz['camera_req']==0){ echo 'checked'; } ?>    > <?php echo $this->lang->line('no');?>
			</div>
			
						<?php 
			}else{
				?>
				<input type="hidden" name="camera_req" value="0">
				
				<?php 
			}
			?>
			
			
				<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_group');?></label> <br>
					 <?php 
					foreach($group_list as $key => $val){
						?>
						
						 <input type="checkbox" name="gids[]" value="<?php echo $val['gid'];?>" <?php if(in_array($val['gid'],explode(',',$quiz['gids']))){ echo 'checked'; } ?> > <?php echo $val['group_name'];?> &nbsp;&nbsp;&nbsp;
						<?php 
					}
					?>
					 
			</div>
			
			
							<div class="form-group">	 
					<label for="inputEmail" ><?php echo $this->lang->line('generate_certificate');?></label> <br>
					<input type="radio" name="gen_certificate"    value="1"   <?php if($quiz['gen_certificate']==1){ echo 'checked'; } ?> > <?php echo $this->lang->line('yes');?><br>
					<input type="radio" name="gen_certificate"    value="0"    <?php if($quiz['gen_certificate']==0){ echo 'checked'; } ?> > <?php echo $this->lang->line('no');?>
			</div>
			 
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('certificate_text');?></label> 
					<textarea   name="certificate_text"  class="form-control" style="height:250px;"><?php echo $quiz['certificate_text'];?></textarea><br>
					<?php echo $this->lang->line('tags_use');?> <?php echo htmlentities("<br>  <center></center>  <b></b>  <h1></h1>  <h2></h2>  <h3></h3>  <font></font>");?><br>
					{email}, {first_name}, {last_name}, {quiz_name}, {percentage_obtained}, {score_obtained}, {result}, {generated_date}, {result_id}, {qr_code}
			
			<br><br>
			<a href="<?php echo site_url('result/preview_certificate/'.$quiz['quid']);?>" target="preview_cert" class="btn btn-warning"><?php echo $this->lang->line('preview');?></a>
			 
			<span style="color:#ff0000"><?php echo $this->lang->line('preview_warning');?></span>
			</div>

			
			

		<hr>
<br><br><br>
<?php 
if($quiz['question_selection']=='0'){
 
?>
<h4><?php echo $this->lang->line('questions_added_into_quiz');?></h4>
<a href="<?php echo site_url('quiz/add_question/'.$quiz['quid']);?>" class="btn btn-danger"  ><?php echo $this->lang->line('add_question_into_quiz');?></a>
  
<table class="table table-bordered" style="margin-top:10px;">
<tr>
   <th>#</th>
 <th><?php echo $this->lang->line('question');?></th>
<th><?php echo $this->lang->line('question_type');?></th>
<th><?php echo $this->lang->line('category_name');?></th>
<th><?php echo $this->lang->line('level_name');?></th>
<th><?php echo $this->lang->line('action');?> </th>
</tr>
<?php 
if(count($questions)==0){
	?>
<tr>
 <td colspan="6"><?php echo $this->lang->line('no_question_added');?></td>
</tr>	
	
	
	<?php
}
foreach($questions as $key => $val){
?>
<tr>
 <td><?php echo $val['qid'];?></td>
 <td><?php echo substr(strip_tags($val['question']),0,50);?></td>
<td><?php echo $val['question_type'];?></td>
<td><?php echo $val['category_name'];?></td>
<td><?php echo $val['level_name'];?></td>
<td>
 
 <a href="<?php echo site_url('quiz/remove_qid/'.$quiz['quid'].'/'.$val['qid']);?>" title="<?php echo $this->lang->line('remove_from_quiz');?>"><img src="<?php echo base_url('images/cross.png');?>"></a>
 <?php 
 if($key==0){
	 ?>
	 <img src="<?php echo base_url();?>images/empty.png" title="">
	 <?php 
 }else{
	 ?>
 <a href="javascript:cancelmove('Up','<?php echo $quiz['quid'];?>','<?php echo $val['qid'];?>','<?php echo $key+1;?>');"><img src="<?php echo base_url();?>images/up.png" title="<?php echo $this->lang->line('up');?>"></a>
<?php 
 }
  
if($key==(count(explode(',',$quiz['qids']))-1)){ 
?>
<?php 
}else{
	?>
<a href="javascript:cancelmove('Down','<?php echo $quiz['quid'];?>','<?php echo $val['qid'];?>','<?php echo $key+1;?>');"><img src="<?php echo base_url();?>images/down.png" title="<?php echo $this->lang->line('down');?>"></a>
<?php 
}
?>
</td>
</tr>

<?php 
}
?>
</table>

<?php
}else{
	
	?>
<h4><?php echo $this->lang->line('questions_added_into_quiz');?></h4><br> 
	
	<?php 
if(count($qcl)==0){
	   echo $this->lang->line('no_question_added').'<br><br>'; 

}	
	foreach($qcl as $k => $vall){
		
		?>
		
						<div class="form-group">	 
				 	<select   name="cid[]" >
					<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('category_name');?></option>
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>"   <?php if($val['cid']==$vall['cid']){ echo 'selected'; } ?>  ><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					</select>
			 	<select  name="lid[]" >
				<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('level_name');?></option>
					<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>"   <?php if($val['lid']==$vall['lid']){ echo 'selected'; } ?> ><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select>
					 
					  <?php echo $this->lang->line('no_questions_added');?>
					  <select name="noq[]">
					  <option value="<?php echo $vall['noq'];?>"><?php echo $vall['noq'];?></option>
					  <option value="0">0</option>
					  </select>
			</div>
<hr>
		
		
		
		<?php 
	}
	?>
					<div class="form-group">	 
				 	<select   name="cid[]" id="cid">
					<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('category_name');?></option>
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>"   ><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					</select>
			 	<select  name="lid[]" onChange="no_q_available(this.value);">
				<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('level_name');?></option>
					<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>"   ><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select>
					 <br>
					  <?php echo $this->lang->line('no_questions_available');?>
					 <span id="no_q_available"></span>
			</div>

	
	
	
	<?php 
	
}

?>	
			 

 
	<button class="btn btn-success" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 
</div>
</div>
</div>


</div>


<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:200px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
<center><b> <?php echo $this->lang->line('to_which_position');?></b><br><input type="text" style="width:30px" id="qposition" value=""><br><br>
<a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;"><?php echo $this->lang->line('cancel');?></a> &nbsp; &nbsp; &nbsp; &nbsp;
<a href="javascript:movequestion();"   class="btn btn-info"  style="cursor:pointer;"><?php echo $this->lang->line('move');?></a>

</center>
</div>