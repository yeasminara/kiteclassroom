<script>
function load_subject(){
	var class_id =$('#class_id').val();
	$("#subject_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id,
		url: "<?=base_url().'loading/load_subject_for_class_content'?>",
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( document ).ready(function() {
    $( "#datepicker" ).datepicker({
	      changeMonth: true,
      changeYear: true,
	   dateFormat: 'yy-mm-dd' 
	});
  } );
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
  <div class="col-md-12"  id="lists">
    <div class="login-panel panel panel-default">
      <div class="panel-body">
        <h3><?php echo $title;?></h3>
        <div class="row">
          <form class="form-validate form-horizontal" id="feedback_form" method="post" action="<?php echo base_url(); ?>class_content/<?php echo $this->uri->segment(2) == 'edit' ? 'edit/' . $results['id'] : 'add'; ?>" enctype="multipart/form-data">
            <div class="col-md-12">
              <div>
                <div>
                  <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label text-right">Select Class</label>
                    <div class="col-sm-5">
                      <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control col-lg-9" >
                        <option value="">Select</option>
                        <?php foreach($class_list as $class) {?>
                        <option value="<?=$class['id']?>" <?php if(isset($results['class_id']) && $results['class_id'] ==$class['id']) {?> selected="selected" <?php }?>>
                        <?=$class['class_name']?>
                        </option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label text-right">Select Class Section</label>
                    <div class="col-sm-5">
                      <select name="class_section_id" id="class_section_id"   class="form-control" >
                        <option value="">Select</option>
                        <?php foreach($class_section_list as $classSection) {?>
                        <option value="<?=$classSection['id']?>" <?php if(isset($results['class_section_id']) && $results['class_section_id'] ==$classSection['id']) {?> selected="selected" <?php }?>>
                        <?=$classSection['section_name']?>
                        </option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label text-right">Select Class Group</label>
                    <div class="col-sm-5">
                      <select name="class_group_id" id="class_group_id"   class="form-control" >
                        <option value="">Select</option>
                        <?php foreach($class_group_list as $classGroup) {?>
                        <option value="<?=$classGroup['id']?>" <?php if(isset($results['class_group_id']) && $results['class_group_id'] ==$classGroup['id']) {?> selected="selected" <?php }?>>
                        <?=$classGroup['group_name']?>
                        </option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label   class="col-sm-2 control-label text-right" ><?php echo $this->lang->line('select_category');?></label>
                    <div  id="subject_div_id" class="col-sm-5">
                      <?php 
				if(isset($results['class_id'])){
					$this->db->where('class_id',$results['class_id']);
					$subject_list = $this->db->get('savsoft_category'); ?>
                      <select name="subject_id" id="subject_id"   class="form-control" >
                        <?php foreach($subject_list->result_array() as $subjects){ ?>
                        <option value="<?=$subjects['cid']?>" <?php if($results['subject_id'] == $subjects['cid']) {?> selected="selected"<?php }?>>
                        <?=$subjects['category_name']?>
                        </option>
                        	;
					
                        <?php }?>
                      </select>
                      <?php
				}else{
				?>
                      <select name="subject_id" id="subject_id"   class="form-control " >
                        <option value="">Select</option>
                      </select>
                      <?php }?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label text-right"><?php echo 'Content Title';?></label>
                    <div class="col-sm-5">
                      <input type="text"  name="title"  class="form-control" placeholder=" Content title" value="<?php echo isset($results['title'])? $results['title']:''?>" required autofocus>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label text-right"  ><?php echo $this->lang->line('description');?></label>
                    <div class="col-sm-5">
                      <textarea   name="description"  class="form-control tinymce_textarea" ><?php echo isset($results['description'])? $results['description']:''?></textarea>
                    </div>
                  </div>
                  <div class="form-group ">
                    <label for="curl" class="col-sm-2 control-label text-right"> Lesson Plan </label>
                    <div class="col-sm-5">
                      <input type="file" name="lesson_plan" id="lesson_plan" />
                      (Please upload pdf, doc file)<br/>
                      <strong>
                      <?php if(isset($results['lesson_plan'])) { echo $results['lesson_plan']; }?>
                      </strong></div>
                  </div>
                  <div class="form-group ">
                    <label for="curl" class="col-sm-2 control-label text-right"> Audio Link </label>
                    <div class="col-sm-5">
                      <input type="text" name="audio_file" id="audio_file"  class="form-control" />
                      (Please upload pdf, doc file)<br/>
                      <strong>
                      <?php if(isset($results['audio_file'])) { echo $results['audio_file']; }?>
                      </strong></div>
                  </div>
                  <div class="form-group ">
                    <label for="curl" class="col-sm-2 control-label text-right"> Video Link </label>
                    <div class="col-sm-5">
                      <input type="text" name="vedio_link" id="vedio_link" class="form-control" />
                      (Please upload pdf, doc file)<br/>
                      <strong>
                      <?php if(isset($results['vedio_link'])) { echo $results['vedio_link']; }?>
                      </strong></div>
                  </div>
                  <div class="form-group ">
                    <label for="curl" class="col-sm-2 control-label text-right">Image </label>
                    <div class="col-sm-5">
                      <input type="file" name="image" id="image" />
                      <br/>
                      <strong>
                      <?php if(isset($results['image'])) { ?>
                      <img src="<?=base_url().'images/content/'.$results['image']?>" alt="" width="30" />
                      <? }?>
                      </strong></div>
                  </div>
                  
                  <!-- <div class="form-group ">
            <label for="curl" class="col-sm-2 control-label text-right"> Other Content File </label>
            <div class="col-sm-5">
         		<input type="file" name="content_file" id="content_file" /> (Please upload pdf, doc file)<br/>
                <strong> <?php if(isset($results['file'])) { echo $results['file']; }?></strong></div>
          </div>
          -->
                  
                  <div class="form-group ">
                    <label for="curl" class="col-sm-2 control-label text-right"> Other Content File </label>
                    <div class="col-sm-5">
                      <input type="file" name="content_file" id="content_file" />
                      (Please upload pdf, doc file)<br/>
                      <strong>
                      <?php if(isset($results['file'])) { echo $results['file']; }?>
                      </strong></div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail"  class="col-sm-2 control-label text-right" >Class <?php echo 'Date';?></label>
                    <div class="col-sm-5">
                      <input type="text" name="start_date"  value="<?php echo isset($results['class_time_date'])? $results['class_time_date']:''?>" class="form-control" placeholder="Start Date"   required id="datepicker">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail"   class="col-sm-2 control-label text-right"><?php echo $this->lang->line('duration');?></label>
                    <div class="col-sm-5">
                      <input type="text" name="duration" value="<?php echo isset($results['duration'])? $results['duration']:''?>" class="form-control" placeholder="<?php echo $this->lang->line('duration');?>"  required  >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail"   class="col-sm-2 control-label text-right">Display Status</label>
                    <div class="col-sm-5">
                      <select id="is_display" name="is_display" class="form-control">
                        <option value="0">Public</option>
                        <option value="1">Private</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <?php if ($this->uri->segment(2) == 'edit'): ?>
                      <div class="form-actions">
                        <input type="hidden" value="<?php
                if (isset($results['id'])) {
                    echo $results['id'];
                }
                ?>" name="edit_id"/>
                        <input type="submit" class="btn btn-primary" name="update" value="Update"/>
                        <a href="<?php echo base_url(); ?>class_content" class="btn btn-default">Cancel</a> </div>
                      <?php else: ?>
                      <div class="form-actions">
                        <input type="submit" class="btn btn-primary" name="add" value="Submit"/>
                        <a href="<?php echo base_url(); ?>class_content" class="btn btn-default">Cancel</a> </div>
                      <?php endif; ?>
                    </div>
                  </div>
                  
                  <!--	<button class="btn btn-success" type="submit"><?php echo $this->lang->line('next');?></button>--> 
                  
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>