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
  .control-label{
	  font-weight: normal !important;
  }
  </style>
<div class="container">
	<div class="login-panel panel panel-default">
        <section class="wrapper panel-body">
          <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'home_work'?>">Home Work</a></li>
                <li><i class="fa fa-square-o"></i>Home Work : <?=$home_work['home_work_title']?></li>
              </ol>
          <div class="content-box-large">
           
            <div class="panel-body">
              <div class="form ">
              
                <form class="form-validate form-horizontal" id="feedback_form" method="post" action="<?=base_url().$this->uri->uri_string()?>" enctype="multipart/form-data">
                
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                	<tr>
                    	<td>Class </td><td> : </td>
                        <td><?=$home_work['class_name']?></td>
                    </tr>
                    
                    <tr>
                    	<td>Subject </td><td> : </td>
                        <td><?=$home_work['category_name']?></td>
                    </tr>
                     <tr>
                    	<td>Total Exam Marks </td><td> : </td>
                        <td><?=$home_work['total_marks']?></td>
                    </tr>
                    <tr>
                    	<td>Teacher Name </td><td> : </td>
                        <td><?=$home_work['first_teacher_name'].' '.$home_work['last_teacher_name']?></td>
                    </tr>
                    
                    <tr>
                    	<td>Home Work Name </td><td> : </td>
                        <td><?php echo isset($home_work['home_work_title']) ? $home_work['home_work_title'] :'';?></td>
                    </tr>
                    
                    <tr>
                    	<td> Last Submission Date</td><td> : </td>
                        <td><?php echo isset($home_work['submission_time'])? $home_work['submission_time']:''?> <?php echo isset($home_work['submission_date']) ? $home_work['submission_date'] :'';?></td>
                    </tr>
                    
                    <tr>
                    	<td>Specific Instruction</td><td> : </td>
                        <td><?php echo isset($home_work['specefic_instruction']) ? $home_work['specefic_instruction'] :'';?></td>
                    </tr>
                    
                     <tr>
                    	<td>Home Work Content</td><td> : </td>
                        <td><?php echo isset($home_work['home_work_content']) ? $home_work['home_work_content'] :'';?></td>
                    </tr>
                    
                    <tr>
                    	<td>Materials</td><td> : </td>
                        <td><?php echo isset($home_work['materials']) ? $home_work['materials'] :'';?></td>
                    </tr>
                    <tr>
                    	<td>Answer Box</td><td> : </td>
                    	<td><?php if($home_work['is_complete'] == '1') { echo $home_work['answer'];} else {?><textarea name="home_work_content" id="home_work_content"><?php echo isset($home_work['answer']) ? $home_work['answer'] :'';?></textarea><?php }?></td>
                    </tr>
                    
                    <tr>
                    	<td valign="top">Add picture</td><td> : </td>
                    	<td> 
                 <?php if(isset($home_work['image']) && $home_work['is_complete'] == '1') { ?> <img src="<?=base_url().'images/content/'.$home_work['image']?>" alt="" width="30" /> <? } else {?> <input type="file" name="image" id="image" /><?php }?></td>
                    </tr>
                    <tr>
                    	<td>Add File</td><td> : </td>
                    	<td>
                 <?php if($home_work['is_complete'] == '1') {  
				 $fileExtension = pathinfo($home_work['file']);
				// echo 'file extensyion'.$fileExtension['extension'];
				 
				 if($fileExtension['extension']=='pdf'){
				 ?>
                 
                  <object width="100%" height="200" data="<?=base_url().'images/content/'.$home_work['file']?>">
</object>
<?php } else{ 
$fileName = base_url().'images/content/'.$home_work['file'];
echo '<a href="'.$fileName.'">Download File</a>';}?>

<!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?=base_url().'images/content/'.$home_work['file']?>' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>-->

                  <? } else{?> <input type="file" name="content_file" id="content_file" /> (Please upload pdf, doc file)<?php }?></td>
                    </tr>
                    <?php if($home_work['is_evaluate'] == '1') {?>
                    <tr><th colspan="3">Teacher Evaluation</th></tr>
                    <tr><td>Portion/Segment</td><td>:</td><td><?php echo isset($home_work['segment']) ? $home_work['segment'] :'';?></td></tr>
                    
                    <tr><td>Number Achived</td><td>:</td><td><?php echo isset($home_work['mark_achived']) ? $home_work['mark_achived'] :'';?></td></tr>
                    <tr><td>Weak Point</td><td>:</td><td><?php echo isset($home_work['weak_point']) ? $home_work['weak_point'] :'';?></td></tr>
                    <tr><td>Strong Point</td><td>:</td><td><?php echo isset($home_work['strong_point']) ? $home_work['strong_point'] :'';?></td></tr>
                    <tr><td>Action to be taken</td><td>:</td><td><?php echo isset($home_work['action_to_take']) ? $home_work['action_to_take'] :'';?></td></tr>
                    <?php }?>
                </table>
            
     
                  
                  
                  
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                     <!-- <button class="btn btn-primary" type="submit">Save</button>
                      <button class="btn btn-default" type="button">Cancel</button>-->
            
                  <div class="form-actions">
                  <?php if($home_work['is_complete'] == '1') {?>
                  <a href="<?php echo base_url(); ?>home_work" class="btn btn-default">Back</a> 
                  <?php } else{?>
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
                   <a href="<?php echo base_url(); ?>home_work" class="btn btn-default">Cancel</a> 
                   <?php }?>
                   </div>
                  
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
</div>
</div>