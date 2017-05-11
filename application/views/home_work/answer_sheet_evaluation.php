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
  
  <!-- Add jQuery library -->
<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?=base_url()?>source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>source/jquery.fancybox.css?v=2.1.5" media="screen" />

  <script>
$( document ).ready(function() {
    $( "#datepicker" ).datepicker({
	      changeMonth: true,
      changeYear: true,
	   dateFormat: 'yy-mm-dd' 
	});
	
	$("#single_1").fancybox({
          helpers: {
              title : {
                  type : 'float'
              }
          }
      });
  } );
  </script>
  <style>
  .control-label{
	  font-weight: normal !important;
  }
  </style>
<div class="container">
<div class=" login-panel panel panel-default">
        <section class="wrapper panel-body">
          <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'home_work'?>">Home Work</a></li>
                <li><i class="fa fa-square-o"></i>Student Name : <?=$home_work['first_student_name'].' '.$home_work['last_student_name']?></li>
              </ol>
          <div class="content-box-large">
           
            <div class="panel-body">
              <div class="form ">
              
                <form class="form-validate form-horizontal" id="feedback_form" method="post" action="<?=base_url().$this->uri->uri_string()?>" enctype="multipart/form-data">
                
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                
                	<tr>
                    	<td nowrap="nowrap">Class </td><td> : </td>
                        <td colspan="2"><?=$home_work['class_name']?></td>
                        
                    </tr>
                    
                    <tr>
                    	<td nowrap="nowrap" >Subject </td><td> : </td>
                        <td colspan="2"><?=$home_work['category_name']?></td>
                    </tr>
                    <tr>
                    	<td nowrap="nowrap">Teacher Name </td><td> : </td>
                        <td colspan="2"><?=$home_work['first_teacher_name'].' '.$home_work['last_teacher_name']?></td>
                    </tr>
                    
                    <tr>
                    	<td nowrap="nowrap">Home Work Name </td><td> : </td>
                        <td colspan="2"><?php echo isset($home_work['home_work_title']) ? $home_work['home_work_title'] :'';?></td>
                    </tr>
                    
                    <tr>
                    	<td nowrap="nowrap"> Last Submission Date</td><td> : </td>
                        <td colspan="2"><?php echo isset($home_work['submission_time'])? $home_work['submission_time']:''?> <?php echo isset($home_work['submission_date']) ? $home_work['submission_date'] :'';?></td>
                    </tr>
                    
                    <tr>
                    	<td nowrap="nowrap">Specific Instruction</td><td> : </td>
                        <td colspan="2"><?php echo isset($home_work['specefic_instruction']) ? $home_work['specefic_instruction'] :'';?></td>
                    </tr>
                    
                     <tr>
                    	<td>Materials</td><td> : </td>
                        <td colspan="2"><?php echo isset($home_work['materials']) ? $home_work['materials'] :'';?></td>
                    </tr>
                    
                     <tr>
                    	<td nowrap="nowrap">Home Work </td><td> : </td>
                        <td colspan="2"><?php echo isset($home_work['home_work_content']) ? $home_work['home_work_content'] :'';?></td>
                    </tr>
                    
                   
                    <tr>
                    	<td>Answer Box</td><td> : </td>
                    	<td><?php if($home_work['is_complete'] == '1') { echo $home_work['answer'];} else {}?></td>
                        <td rowspan="2" width="47%">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                            	<tr><td> Portion/Segment</td><td><input type="text" name="segment" id="segment" value="<?=isset($home_work['segment'])? $home_work['segment']:''?>" class="form-control" /></td></tr>
                                <tr><td> Total Num </td><td><?=$home_work['total_marks']?></td></tr>
                                <tr><td> Num Achived</td><td><input type="text" name="mark_achived" id="mark_achived" value="<?=isset($home_work['mark_achived'])? $home_work['mark_achived']:''?>" class="form-control"/></td></tr>
                                <tr><td> Weak Point</td><td><input type="text" name="weak_point" id="weak_point" value="<?=isset($home_work['weak_point'])? $home_work['weak_point']:''?>" class="form-control"/></td></tr>
                                <tr><td> Strong Point</td><td><input type="text" name="strong_point" id="strong_point" value="<?=isset($home_work['strong_point'])? $home_work['strong_point']:''?>" class="form-control"/></td></tr>
                                <tr><td> Action to be taken</td><td><input type="text" name="action_to_take" id="action_to_take" value="<?=isset($home_work['action_to_take'])? $home_work['action_to_take']:''?>" class="form-control" /></td></tr>
                                <tr><td colspan="2" align="right">
                                <div class="form-actions">
                  <?php if($home_work['is_complete'] == '1') {?>
                  <input type="submit" class="btn btn-success" name="submit" value="Evaluate"/>
                  <a href="<?php echo base_url().'home_work/permission/'.$home_work['home_work_id']; ?>" class="btn btn-default">Back</a> 
                  <?php } else{?>
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
                   <a href="<?php echo base_url().'home_work/permission/'.$home_work['home_work_id']; ?>" class="btn btn-default">Cancel</a> 
                   <?php }?>
                   </div>
                                </td></tr>
                            </table> 
                        </td>
                    </tr>
                    
                    <tr>
                    	<td valign="top">Picture</td><td> : </td>
                    	<td valign="middle"> 
                        &nbsp;
                 <?php if(isset($home_work['image']) && $home_work['is_complete'] == '1') { ?> 
                 
                 <a id="single_1" href="<?=base_url().'images/content/'.$home_work['image']?>" title="<?=$home_work['home_work_title']?>">
	<img src="<?=base_url().'images/content/'.$home_work['image']?>" alt="" width="40" />
</a>
 <? } else { }?></td>
                    </tr>
                    <tr>
                    	<td> File</td><td> : </td>
                    	<td colspan="2">
                <?php 
				 $fileExtension = pathinfo($home_work['file']);
				 if($fileExtension['extension']=='pdf'){
				?>
                 <object width="100%" height="200" data="<?=base_url().'images/content/'.$home_work['file']?>">
</object>
<?php } else{ 
$fileName = base_url().'images/content/'.$home_work['file'];
echo '<a href="'.$fileName.'">Download File</a>';}?>
<!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?=base_url().'images/content/'.$home_work['file']?>' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>-->
                 </td>
                    </tr>
                    
                </table>
            
     
                  
                  
                  
                  
                </form>
              </div>
            </div>
          </div>
        </section>
</div>
</div>