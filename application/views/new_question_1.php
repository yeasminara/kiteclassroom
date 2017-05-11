
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
	$sub_menus = get_menu_by_module($menu_module);
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
    <form method="post" action="<?php echo site_url('qbank/new_question_1/'.$nop);?>">
      <div class="col-md-12"> <br>
        <div class="login-panel panel panel-default">
          <div class="panel-body">
            <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>
            <div class="form-group"> <?php echo $this->lang->line('multiple_choice_single_answer');?> </div>
           
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
              <label   ><?php echo $this->lang->line('select_category');?></label>
              <div  id="subject_div_id">
                <?php 
					$CI = &get_instance();
			$CI->load->model('qbank_model');
		    $subject_lists = $CI->qbank_model->get_subject_by_class_id($class_list[0]['id']);
		  
				?>
              <!--  <select name="subject_id" id="subject_id" onchange="load_chapter()" required class="form-control" >
                  <option value="">Select</option>
                  <?php foreach($subject_lists as $subject){?>
                  <option value="<?=$subject['cid']?>"  >
                  <?=$subject['category_name']?>
                  </option>
                  <?php }?>
                </select>-->
               Select Class
              </div>
            </div>
            <!--<div class="form-group">
              <label   ><?php echo $this->lang->line('select_category');?></label>
              <div  id="subject_div_id">
                <select class="form-control" name="cid">
                  <?php 
					foreach($category_list as $key => $val){
						?>
                  <option value="<?php echo $val['cid'];?>"><?php echo $val['category_name'];?></option>
                  <?php 
					}
					?>
                </select>
              </div>
            </div>-->
            <div class="form-group">
              <label   >Select Chapter</label>
              <div  id="chapter_div_id">
              <?php 
			  $CI = &get_instance();
			$CI->load->model('qbank_model');
		    $chapters = $CI->qbank_model->get_chapter_by_subject_id($class_list[0]['id'],$subject_lists[0]['cid']);
			  ?>
          <!--     <select name="chapter_id" id="chapter_id" class="form-control" onchange="load_lesson()"><option value="">Select</option>
		<?php foreach($chapters as $chapter_load){?>
        	<option value="<?=$chapter_load['id']?>" ><?=$chapter_load['chapter_name']?></option>
		 <?php }?>
		</select>-->
        Select Subject
              </div>
            </div>
            
            
             <div class="form-group">
              <label   >Select Lesson</label>
              <div  id="lesson_div_id">
            
              </div>
            </div>
            
            <div class="form-group">
              <label   ><?php echo $this->lang->line('select_level');?></label>
              <select class="form-control" name="lid">
                <?php 
					foreach($level_list as $key => $val){
						?>
                <option value="<?php echo $val['lid'];?>"><?php echo $val['level_name'];?></option>
                <?php 
					}
					?>
              </select>
                 
            </div>
           
            
            <div class="form-group">
              <label for="inputEmail"  ><?php echo $this->lang->line('question');?></label>
              <textarea  name="question"  class="form-control"   ></textarea>
            </div>
            <div class="form-group">
              <label for="inputEmail"  ><?php echo $this->lang->line('description');?></label>
              <textarea  name="description"  class="form-control"></textarea>
            </div>
            <?php 
		for($i=1; $i<=$nop; $i++){
			?>
            <div class="form-group">
              <label for="inputEmail"  ><?php echo $this->lang->line('options');?> <?php echo $i;?>)</label>
              <br>
              <input type="radio" name="score" value="<?php echo $i-1;?>" <?php if($i==1){ echo 'checked'; } ?> >
              Select Correct Option <br>
              <textarea  name="option[]"  class="form-control"   ></textarea>
            </div>
            <?php 
		}
		?>
            <button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
