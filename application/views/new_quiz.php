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
     <form method="post" action="<?php echo site_url('quiz/insert_quiz/');?>">
	
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
              <label>Select Class</label>
              <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" >
                <option value="">Select</option>
                <?php foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>" >
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
                <option value="<?=$classSection['id']?>" >
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
                <option value="<?=$classGroup['id']?>" >
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
		    $subject_lists = $CI->qbank_model->get_subject_by_class_id($class_list[0]['id']);
		  
				?>
                <select name="subject_id" id="subject_id"   class="form-control" >
                  <option value="">Select</option>
                 
                </select>
               
              </div>
            </div>
         <!--    <div class="form-group">
              <label   >Select Chapter</label>
              <div  id="chapter_div_id">
              <?php 
			  $CI = &get_instance();
			$CI->load->model('qbank_model');
		    $chapters = $CI->qbank_model->get_chapter_by_subject_id($class_list[0]['id'],$subject_lists[0]['cid']);
			  ?>
               <select name="chapter_id" id="chapter_id" class="form-control"><option value="">Select</option>
	
		</select>
              </div>
            </div>
            
            
             <div class="form-group">
              <label   >Select Lesson</label>
              <div  id="lesson_div_id">
            		<select name="lession_id" id="lession_id" class="form-control"><option value="">Select</option>
	
		</select>
              </div>
            </div>-->
            
		
		 			<div class="form-group">	 
					<label><?php echo 'Quiz Name';?></label> 
					<input type="text"  name="quiz_name"  class="form-control" placeholder="<?php echo $this->lang->line('quiz_name');?>"  required autofocus>
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea   name="description"  class="form-control tinymce_textarea" >
                    
                    </textarea>
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('start_date');?></label> 
					<input type="text" name="start_date"  value="<?php echo date('Y-m-d H:i:s',time());?>" class="form-control" placeholder="<?php echo $this->lang->line('start_date');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('end_date');?></label> 
					<input type="text" name="end_date"  value="<?php echo date('Y-m-d H:i:s',(time()+(60*60*24*365)));?>" class="form-control" placeholder="<?php echo $this->lang->line('end_date');?>"   required >
			</div>
            <div class="form-group">	 
					<label for="inputEmail"  >Exam Total marks</label> 
					<input type="text" name="exam_total_marks"  value="100" class="form-control" placeholder="Exam Total marks(Ex: 50,100)"  required  >
			</div>
            
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('duration');?></label> 
					<input type="text" name="duration"  value="10" class="form-control" placeholder="<?php echo $this->lang->line('duration');?>"  required  >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('maximum_attempts');?></label> 
					<input type="text" name="maximum_attempts"  value="10" class="form-control" placeholder="<?php echo $this->lang->line('maximum_attempts');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('pass_percentage');?></label> 
					<input type="text" name="pass_percentage" value="50" class="form-control" placeholder="<?php echo $this->lang->line('pass_percentage');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('correct_score');?></label> 
					<input type="text" name="correct_score"  value="1" class="form-control" placeholder="<?php echo $this->lang->line('correct_score');?>"   required >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('incorrect_score');?></label> 
					<input type="text" name="incorrect_score"  value="0" class="form-control" placeholder="<?php echo $this->lang->line('incorrect_score');?>"  required  >
			</div>
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('ip_address');?></label> 
					<input type="text" name="ip_address"  value="" class="form-control" placeholder="<?php echo $this->lang->line('ip_address');?>"    >
			</div>
				<div class="form-group">	 
					<label for="inputEmail" ><?php echo $this->lang->line('view_answer');?></label> <br>
					<input type="radio" name="view_answer"    value="1" checked > <?php echo $this->lang->line('yes');?>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="view_answer"    value="0"  > <?php echo $this->lang->line('no');?>
			</div>
			<?php 
			if($this->config->item('webcam')==true){
				?>
				<div class="form-group">	 
					<label for="inputEmail" ><?php echo $this->lang->line('capture_photo');?></label> <br>
					<input type="radio" name="camera_req"    value="1"  > <?php echo $this->lang->line('yes');?>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="camera_req"    value="0"  checked > <?php echo $this->lang->line('no');?>
			</div>
			<?php 
			}else{
				?>
				<input type="hidden" name="camera_req" value="0">
				
				<?php 
			}
			?>
				<div class="form-group">	 
					
					 <?php 
					 
					 if($group_type == 2){?> <input type="hidden" name="gids[]" value="<?php echo $group_id;?>" ><?php }else{ ?>
                     
                     <label   ><?php echo $this->lang->line('select_group');?></label> <br>
                     <?php 
						
                        foreach($group_list as $key => $val){
						?>
						
						 <input type="checkbox" name="gids[]" value="<?php echo $val['gid'];?>" <?php if($key==0){ echo 'checked'; } ?> > <?php echo $val['group_name'];?> &nbsp;&nbsp;&nbsp;
						<?php 
					}
					 
					 }
					
					 
					?>
					 
			</div>

				<div class="form-group">	 
					<label for="inputEmail" ><?php echo $this->lang->line('question_selection');?></label> <br>
					<input type="radio" name="question_selection"    value="1"  > <?php echo $this->lang->line('automatically');?><br>
					<input type="radio" name="question_selection"    value="0"  checked > <?php echo $this->lang->line('manually');?>
			</div>
				<div class="form-group">	 
					<label for="inputEmail" ><?php echo $this->lang->line('generate_certificate');?></label> <br>
					<input type="radio" name="gen_certificate"    value="1"  > <?php echo $this->lang->line('yes');?><br>
					<input type="radio" name="gen_certificate"    value="0"  checked > <?php echo $this->lang->line('no');?>
			</div>
			 
				<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('certificate_text');?></label> 
					<textarea   name="certificate_text"  class="form-control" ></textarea><br>
					<?php echo $this->lang->line('tags_use');?> <?php echo htmlentities("<br>  <center></center>  <b></b>  <h1></h1>  <h2></h2>   <h3></h3>    <font></font>");?><br>
					{email}, {first_name}, {last_name}, {quiz_name}, {percentage_obtained}, {score_obtained}, {result}, {generated_date}, {result_id}, {qr_code}
			</div>

 
	<button class="btn btn-success" type="submit"><?php echo $this->lang->line('next');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 
</div>
</div>
</div>


</div>