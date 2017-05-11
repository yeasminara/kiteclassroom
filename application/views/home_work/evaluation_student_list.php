<!--<script src="<?=base_url()?>assets/js/jquery-1.8.3.min.js"></script>-->
<script type="text/javascript">
$(document).ready(function($) {
 
   $('#check_all').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.selected_user').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.selected_user').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
	
});
</script>
<style>
.icheckbox_square-red, .iradio_square-red {
    border: 1px solid red;
    cursor: pointer;
    display: inline-block;
    height: 15px;
    left: 7px;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 6px;
    vertical-align: middle;
    width: 15px;
    z-index:-11;
}

.check_all_class, .selected_std{
 z-index:1;
}
.icheckbox_square-red.hover {
    background-position: -24px 0;
}
</style>
 <div class="container">
<div class=" login-panel panel panel-default">
        <section class="wrapper panel-body">
             <h3 class="page-header"><i class="fa fa fa-bars"></i> Pages</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                    <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'home_work'?>">Home Work</a></li>
                    <li><i class="fa fa-bars"></i>Assign <span style="color:#000"><?=$home_work['home_work_title']?></span>  to Student</li>
                </ol>
   <div class="content-box-large">
  				
  				<div class="panel-body">
                <form action="<?=base_url().$this->uri->uri_string()?>" method="post" enctype="multipart/form-data">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
                            	<th> <input type="checkbox" name="check_all" id="check_all" class="form-control">
                                <input type="hidden" name="home_work_id" id="home_work_id" value="<?=$home_work['home_work_id']?>" class="form-control">
                                </th>
								<th>Roll</th>
							    <th>Name</th>
                                <th>Section</th>
                                <th>Create Date</th>
                                <th>Status</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						if(count($student_list)>0){
						foreach($student_list as $result){
							$CI = &get_instance();
							$CI->load->model('Homew_model');
							$check_permission = $CI->Homew_model->check_home_work_status($result['uid'],$home_work['home_work_id']);	
						?>
                        <tr class="<?php if($count%2 == 0){ echo 'even';}else{ echo 'odd';}?> gradeX">
                        
                        <td><input type="checkbox" name="selected_student[]" value="<?php echo $result['uid'];?>" class="selected_user form-control" <?php if($check_permission['is_complete']==1 && $check_permission['is_evaluate']==1 ) {?> checked="checked"  disabled="disabled"<?php }?>></td>
                        
                        <td><?=$result['roll_no']?></td>
                        <td><?=$result['first_name'].' '.$result['last_name']?></td>
                        <td><?=$result['section_name']?></td>
                        <td><?=date('d-m-Y',strtotime($result['create_date']))?></td>
                        <td><?php if($check_permission['is_complete']==1 ){ ?> 
							<a href="<?=base_url().'home_work/evaluation/'.$home_work['home_work_id'].'/'.$check_permission['id'].'/'.$result['uid'];?>" class="btn btn-default">Evaluate</a>
						<? } elseif($check_permission['is_complete']==1 && $check_permission['is_evaluate']==1){?>
                        
							<a href=""  class="btn btn-danger">DONE</a>  
							<?php }else{ echo '';}?></td>
							
							</tr>
                        <?php
						}
						}
						?>
				
							
							
						</tbody>
					</table>
  				</form>
                </div>
  			</div>
</section>
</div>