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
<style>
.control-label {
	font-weight: normal !important;
}
</style>
<div class="container">
   <div class="login-panel panel panel-default"  id="lists">
		<div class="panel-body" > 

        <ol class="breadcrumb">
          <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
          <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'home_work'?>">Home Work</a></li>
          <li><i class="fa fa-square-o"></i>Add/Edit Home Work</li>
        </ol>
    <div class="content-box-large">
      <div class="panel-body">
      <div class="form ">
      <form class="form-validate form-horizontal" id="feedback_form" method="post" action="<?php echo base_url(); ?>home_work/<?php echo $this->uri->segment(2) == 'edit' ? 'edit/' . $results['home_work_id'] : 'add'; ?>">
        <div class="form-group ">
          <label for="cname" class="control-label col-lg-2">Class <span class="required">*</span></label>
          <div class="col-lg-4">
            <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" >
              <option value="">Select class</option>
              <?php 
                        foreach($class_list as $class) {?>
              <option value="<?=$class['id']?>" <?php if(isset($results['class_id']) && $results['class_id']==$class['id']){ echo 'selected="selected"';}?> >
              <?=$class['class_name']?>
              </option>
              <?php }?>
            </select>
          </div>
        </div>
        <div class="form-group ">
          <label for="cname" class="control-label col-lg-2">Subject <span class="required">*</span></label>
          <div class="col-lg-4">
            <div  id="subject_div_id">
              <?php 
                            $CI = &get_instance();
                            $CI->load->model('qbank_model');
                            $subject_lists = $CI->qbank_model->get_subject_by_class_id($this->input->post('class_id'));
                  
                        ?>
              <select name="subject_id" id="subject_id" required class="form-control" >
                <option value="">Select Subject</option>
                <?php foreach($subject_lists as $subject){?>
                <option value="<?=$subject['cid']?>" <?php if(isset($results['subject_id']) && $results['subject_id']==$subject['cid']){ echo 'selected="selected"';}?>>
                <?=$subject['category_name']?>
                </option>
                <?php }?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group ">
          <label for="module" class="control-label col-lg-2"> Home Work Name <span class="required">*</span></label>
          <div class="col-lg-4">
            <input class="form-control " id="home_work_title" type="text" name="home_work_title" value="<?php echo isset($results['home_work_title']) ? $results['home_work_title'] :'';?>" required  />
          </div>
        </div>
        <div class="form-group ">
          <label for="module" class="control-label col-lg-2"> Home Work Content <span class="required">*</span></label>
          <div class="col-lg-4">
            <textarea name="home_work_content" id="home_work_content"><?php echo isset($results['home_work_content']) ? $results['home_work_content'] :'';?></textarea>
          </div>
        </div>
        <div class="form-group ">
          <label for="module" class="control-label col-lg-2"> Specific Instruction </label>
          <div class="col-lg-4">
            <input class="form-control " id="specefic_instruction" type="text" name="specefic_instruction" value="<?php echo isset($results['specefic_instruction']) ? $results['specefic_instruction'] :'';?>"   />
          </div>
        </div>
        <div class="form-group ">
          <label for="module" class="control-label col-lg-2"> Materials</label>
          <div class="col-lg-4">
            <input class="form-control " id="materials" type="text" name="materials" value="<?php echo isset($results['materials']) ? $results['materials'] :'';?>"   />
          </div>
        </div>
        <div class="form-group ">
          <label for="module" class="control-label col-lg-2"> Home Work Marks</label>
          <div class="col-lg-4">
            <input class="form-control " id="total_marks" type="text" name="total_marks" value="<?php echo isset($results['total_marks']) ? $results['total_marks'] :'';?>"   />
          </div>
        </div>
        <div class="form-group ">
          <label for="module" class="control-label col-lg-2"> Last Submission Date</label>
          <div class="col-lg-4">
            <input type="text" name="submission_date"  value="<?php echo isset($results['submission_date'])? $results['submission_date']:''?>" class="form-control" placeholder="Last Date"   required id="datepicker">
          </div>
        </div>
        <div class="form-group ">
          <label for="module" class="control-label col-lg-2"> Last Submission Time</label>
          <div class="col-lg-4">
            <input type="text" name="submission_time"  value="<?php echo isset($results['submission_time'])? $results['submission_time']:'10am'?>" class="form-control" placeholder="Last time" >
          </div>
        </div>
        <div class="form-group ">
          <label for="ccomment" class="control-label col-lg-2" style="text-align: right">Status </label>
          <div class="col-lg-1">
            <input class="form-control" id="mstatus" name="mstatus" type="checkbox" value="1" <?php if(isset($results['status']) && $results['status'] == 1){?> checked="checked" <?php } else{}?> />
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10"> 
            <!-- <button class="btn btn-primary" type="submit">Save</button>
                      <button class="btn btn-default" type="button">Cancel</button>-->
            
            <?php if ($this->uri->segment(2) == 'edit'): ?>
            <div class="form-actions">
              <input type="hidden" value="<?php
                        if (isset($results['home_work_id'])) {
                            echo $results['home_work_id'];
                        }
                        ?>" name="edit_id"/>
              <input type="submit" class="btn btn-primary" name="update" value="Update"/>
              <a href="<?php echo base_url(); ?>pages" class="btn btn-default">Cancel</a> </div>
            <?php else: ?>
            <div class="form-actions">
              <input type="submit" class="btn btn-primary" name="add" value="Submit"/>
              <a href="<?php echo base_url(); ?>home_work" class="btn btn-default">Cancel</a> </div>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
</div>
