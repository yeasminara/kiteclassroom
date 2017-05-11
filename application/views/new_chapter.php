
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
		url: "<?=base_url().'loading/load_chapter'?>",
		success: function(result){
			$("#chapter_div_id").html(result);
		}
		
	});
}
</script>
<div class="container">
  <h3><a href="<?=base_url()?>qbank/chapter_list">Chapter List</a> &raquo; <?php echo $title;?> </h3>
  <div class="row">
    <div class="col-md-6"> 
    <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >
     <form method="post" action="<?php /*echo site_url('qbank/insert_chapter/');*/ ?><?=base_url().$this->uri->uri_string()?>">
       <table class="table table-bordered" width="60%">
        <tr>
          <th class="col-md-2">Class</th> <td  class="col-md-5"><select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" ><option value="">Select</option>
          <?php foreach($class_list as $class) {?>
          	<option value="<?=$class['id']?>" <?php if(isset($chapter_list['class_id']) && $chapter_list['class_id']==$class['id']){?> selected="selected" <?php }?> ><?=$class['class_name']?></option>
          <?php }?>
          </select></td></tr>
          <tr><th>Subject</th>
          <td id="subject_div_id"><?php if(isset($chapter_list['class_id'])){ 
		    $CI = &get_instance();
			$CI->load->model('qbank_model');
		    $subject_lists = $CI->qbank_model->get_subject_by_class_id($chapter_list['class_id']);
		  ?>
		 <select name="subject_id" id="subject_id" onchange="load_chapter()" required class="form-control" ><option value="">Select</option>
		<?php foreach($subject_lists as $subject){?>
        	<option value="<?=$subject['cid']?>" <?php if(isset($chapter_list['subject_id']) && $chapter_list['subject_id']==$subject['cid']){?> selected="selected" <?php }?> ><?=$subject['category_name']?></option>
		 <?php }?>
		</select>
        <?php
	
			 } else{ echo 'Select Class to load subject';}?></td></tr>
             
          <tr><th>Chapter</th><td id="chapter_div_id"><?php if(isset($chapter_list['class_id'])){
			$CI = &get_instance();
			$CI->load->model('qbank_model');
		    $chapters = $CI->qbank_model->get_chapter_by_subject_id($chapter_list['class_id'],$chapter_list['subject_id']);
			
			?>
         <select name="chapter_id" id="chapter_id" class="form-control" ><option value="">Select</option>
		<?php foreach($chapters as $chapter_load){?>
        	<option value="<?=$chapter_load['id']?>" <?php if(isset($chapter_list['chapter_name']) && $chapter_list['chapter_name']==$chapter_load['chapter_name']){?> selected="selected" <?php }?> ><?=$chapter_load['chapter_name']?></option>
		 <?php }?>
		</select>
        
            <? 
			 } else{ echo 'Select subject';}?></td></tr>
          <tr><th>Lession</th><td> <input type="text"   class="form-control"   name="lession_name" value="<?=isset($chapter_list['lession_name'])? $chapter_list['lession_name'] :''?>" placeholder="Lession name"   > </td></tr>
           <tr><th>Classification</th><td> <input type="text"   class="form-control"   name="classification" value="<?=isset($chapter_list['classification'])? $chapter_list['classification'] :''?>" placeholder="পদ্য,গদ্য"   /> </td></tr>
           <tr><th>Status</th><td align="left"> <input type="checkbox"   class=""   name="mstatus" value="1"  style="" <?php if(isset($chapter_list['status']) && $chapter_list['status']==1){?> checked="checked" <?php }?>/></td></tr>
           
         <tr><td colspan="4" align="right">  
         <?php if ($this->uri->segment(2) == 'update_chapter') {?>
         <input class="btn btn-default" type="submit" name="submit" value="Update">
         <?php } else{?>
         
         <input class="btn btn-default" type="submit" name="submit" value="<?php echo $this->lang->line('add_new');?>">
         <?php }?>
         <a href="<?=base_url()?>qbank/chapter_list" class="btn btn-danger">Go Back</a>
         </td></tr>
       </table>
     </form>
     </div>
     </div>
    </div>
  </div>
</div>
