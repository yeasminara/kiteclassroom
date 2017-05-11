<script>
function load_subject(){
	var class_id =$('#class_id').val();
	$("#subject_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id,
		url: "<?=base_url().'loading/load_subject_only'?>",
		success: function(result){
			$("#subject_div_id").html(result);
		}
		
	});
}
</script>

<div class="container">
  <div class="login-panel panel panel-default"  id="lists">
    <div class="panel-body" >
      <?php 
$logged_in=$this->session->userdata('logged_in');
			 
			
			?>
      <h3><?php echo $title;?></h3>
      <?php 
	if($logged_in['su']=='1' || $logged_in['su']=='2'){
		?>
      <div class="row">
        <div class="col-lg-8">
          <form method="post" action="<?php echo site_url('quiz/index/');?>">
            <div class="input-group" style="float: left; width: 200px;">
              <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" >
                <option value="">Select class</option>
                <?php foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>" <?php if($this->input->post('class_id') && $this->input->post('class_id')==$class['id']){ echo 'selected="selected"';}?> >
                <?=$class['class_name']?>
                </option>
                <?php }?>
              </select>
            </div>
            <div class="input-group" style="float: left; width: 200px;">
              <div  id="subject_div_id">
                <?php 
					$CI = &get_instance();
					$CI->load->model('qbank_model');
		    		$subject_lists = $CI->qbank_model->get_subject_by_class_id($this->input->post('class_id'));
		  
				?>
                <select name="subject_id" id="subject_id" required class="form-control" >
                  <option value="">Select Subject</option>
                  <?php foreach($subject_lists as $subject){?>
                  <option value="<?=$subject['cid']?>" <?php if($this->input->post('subject_id') && $this->input->post('subject_id')==$subject['cid']){ echo 'selected="selected"';}?>>
                  <?=$subject['category_name']?>
                  </option>
                  <?php }?>
                </select>
              </div>
            </div>
            <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
              <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
              </span> </div>
            <!-- /input-group -->
          </form>
        </div>
        <!-- /.col-lg-6 --> 
      </div>
      <!-- /.row -->
      
      <?php 
	}
?>
      <div class="row">
        <div class="col-md-12"> <br>
          <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>
          <table class="table table-bordered">
            <tr>
              <th>#</th>
              <th><?php echo $this->lang->line('quiz_name');?></th>
              <th>Class</th>
              <th>Section</th>
              <th>Group</th>
              <th>Subject</th>
              <!--<th>Chapter</th>
 <th>Lesson</th>-->
              <th>Ques</th>
              <th align="center"><?php echo $this->lang->line('action');?> </th>
            </tr>
            <?php 
if(count($result)==0){
	?>
            <tr>
              <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
            </tr>
            <?php
}
foreach($result as $key => $val){
	
	$CI = &get_instance();
	$CI->load->model('quiz_model');
	$class_name = $CI->quiz_model->get_class_name_by_id($val['class_id']);
	$section_name = $CI->quiz_model->get_class_section_name_by_id($val['class_section_id']);
	$group_name = $CI->quiz_model->get_class_group_name_by_id($val['class_group_id']);
	$subject_name = $CI->quiz_model->get_subject_name_by_id($val['subject_id']);
	$chapter_name = $CI->quiz_model->get_chapter_name_by_id($val['chapter_id']);
	$lesson_name = $CI->quiz_model->get_lesson_name_by_id($val['lession_id']);	

		  
		  
?>
            <tr>
              <td><?php echo $val['quid'];?></td>
              <td><?php echo substr(strip_tags($val['quiz_name']),0,50);?></td>
              <td><?=$class_name['class_name']?></td>
              <td><?=$section_name['section_name']?></td>
              <td><?=$group_name['group_name']?></td>
              <td><?=$subject_name['category_name']?></td>
              <!--  <td><?=$chapter_name['chapter_name']?></td>
   <td><?=$lesson_name['lession_name']?></td>-->
              <td><?php echo $val['noq'];?></td>
              <td><a href="<?php echo site_url('quiz/quiz_detail/'.$val['quid']);?>" class="btn btn-success"  ><?php echo $this->lang->line('attempt');?> </a>
                <?php 
if($logged_in['su']=='1' || $logged_in['su']=='2'){
	?>
                <a href="<?php echo site_url('quiz/edit_quiz/'.$val['quid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a> <a href="javascript:remove_entry('quiz/remove_quiz/<?php echo $val['quid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
                <?php 
}

if(!empty($val['full_question_pattern'])){ 
?>
                &nbsp; <a href="<?php echo site_url('exam/question_preview/'.$val['quid']);?>" title="Preview Question paper" target="_blank"> <img src="<?php echo base_url('images/preview.png');?>" alt="" width="30"></a> &nbsp; <a href="<?php echo site_url('exam/download_question/'.$val['quid']);?>" title="Question paper download" target="_blank"> <img src="<?php echo base_url('images/down.png');?>"></a>
                <?php }?>
                &nbsp; <a href="<?php echo site_url('exam/build_paper/'.$val['quid']);?>" title="Make paper to download"> <img src="<?php echo base_url('images/plus.png');?>"></a></td>
            </tr>
            <?php 
}
?>
          </table>
        </div>
      </div>
      <?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>
      <a href="<?php echo site_url('quiz/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a> &nbsp;&nbsp;
      <?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>
      <a href="<?php echo site_url('quiz/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>
     
    </div>
  </div>
</div>
