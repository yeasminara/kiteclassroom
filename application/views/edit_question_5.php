 <div class="container">

   
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
  <h3><a href="<?=base_url()?>qbank">Question Bank</a> &raquo;<?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('qbank/edit_question_5/'.$question['qid']);?>">
	
<div class="col-md-8">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		
	 
		
				<div class="form-group">	 
					<?php echo $this->lang->line('long_answer');?>

			</div>

			   	<div class="form-group">
              <label>Select Class</label>
              <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" >
                <option value="">Select</option>
                <?php foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>" <?php if($question['class_id']==$class['id']){ echo 'selected'; } ?>>
                <?=$class['class_name']?>
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
		    		$subject_lists = $CI->qbank_model->get_subject_by_class_id($question['class_id']);
		  
				?>
                <select name="subject_id" id="subject_id" onchange="load_chapter()" required class="form-control" >
                  <option value="">Select</option>
                  <?php foreach($subject_lists as $subject){?>
                  <option value="<?=$subject['cid']?>"  <?php if($question['cid']==$subject['cid']){ echo 'selected'; } ?>>
                  <?=$subject['category_name']?>
                  </option>
                  <?php }?>
                </select>
                <?php
	
			 
			 ?>
              </div>
            </div>
            
            <div class="form-group">
              <label   >Select Chapter</label>
              <div  id="chapter_div_id">
              <?php 
			  $CI = &get_instance();
			  $CI->load->model('qbank_model');
		      $chapters = $CI->qbank_model->get_chapter_by_subject_id($question['class_id'],$question['cid']);
			  ?>
               <select name="chapter_id" id="chapter_id" class="form-control" onchange="load_lesson()"><option value="">Select</option>
		<?php foreach($chapters as $chapter_load){?>
        	<option value="<?=$chapter_load['id']?>" <?php if($chapter_load['id']==$question['chapter_id']){ echo 'selected'; } ?>><?=$chapter_load['chapter_name']?></option>
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
		      $lessons = $CI->qbank_model->get_lesson_by_chapter_id($question['class_id'],$question['cid'], $question['chapter_id']);
			  ?>
               <select name="lession_id" id="lession_id" class="form-control"><option value="">Select</option>
		<?php foreach($lessons as $lessons_load){?>
        	<option value="<?=$lessons_load['id']?>" <?php if($lessons_load['id']==$question['lession_id']){ echo 'selected'; } ?>><?=$lessons_load['lession_name']?></option>
		 <?php }?>
		</select>
              </div>
            </div>
		<!--<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_category');?></label> 
					<select class="form-control" name="cid">
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>"  <?php if($question['cid']==$val['cid']){ echo 'selected'; } ?> ><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>-->
			
			
			<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_level');?></label> 
					<select class="form-control" name="lid">
					<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>" <?php if($question['lid']==$val['lid']){ echo 'selected'; } ?> ><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>

			

			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('question');?></label> 
					<textarea  name="question"  class="form-control"  style="height: 400px;" ><?php echo $question['question'];?></textarea>
			</div>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea  name="description"  class="form-control"><?php echo $question['description'];?></textarea>
			</div>

 	 
<div class="form-group">	 
					<label for="inputEmail"  >Answer</label> 
					<textarea  name="question_answer"  class="form-control"><?php echo $question['question_answer'];?></textarea>
			</div>
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
	  
	  	  <div class="col-md-3">
		
		
			<div class="form-group">	 
			<table class="table table-bordered">
			<tr><td><?php echo $this->lang->line('no_times_corrected');?></td><td><?php echo $question['no_time_corrected'];?></td></tr>
			<tr><td><?php echo $this->lang->line('no_times_incorrected');?></td><td><?php echo $question['no_time_incorrected'];?></td></tr>
			<tr><td><?php echo $this->lang->line('no_times_unattempted');?></td><td><?php echo $question['no_time_unattempted'];?></td></tr>

			</table>

			</div>


	  </div>
</div>

 



</div>