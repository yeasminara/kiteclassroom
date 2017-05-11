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
  <div class="col-md-12">
   <div class="login-panel panel panel-default"  id="lists">
		<div class="panel-body" > 
      <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa fa-bars"></i> Pages</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                    <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'user'?>">Users</a></li>
                    <li><i class="fa fa-square-o"></i><?=$users['first_name'].' '.$users['last_name']?></li>
                </ol>
            </div>
        </div>
   <div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">All Menu List</div>
				</div>
  				<div class="panel-body">
                <form action="<?=base_url().$this->uri->uri_string()?>" method="post" enctype="multipart/form-data">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
                            	<th> <input type="checkbox" name="check_all" id="check_all" class="form-control" style="width: 16px; height: 15px;"></th>
								<th>Page Title</th>
							    <th>Module</th>
								<th>URL</th>
                                <th>Create Date</th>
                                <th>Status</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						if($count>0){
						foreach($results as $result){
							$check_permission = get_menu_group_permission($result['id'],$users['uid']);	
						?>
                        <tr class="<?php if($count%2 == 0){ echo 'even';}else{ echo 'odd';}?> gradeX">
                        
                        <td><input type="checkbox" name="selected_page[]" value="<?php echo $result['id'];?>" class="selected_user form-control" <?php if($check_permission == 1 ) {?> checked="checked" <?php }?> style="width: 16px; height: 15px;"></td>
                        
                        <td><?=$result['page_group_name']?></td>
                        <td><?=$result['module']?></td>
                        <td><?=$result['page_group_url']?></td>
                        <td><?=date('d-m-Y',strtotime($result['create_date']))?></td>
                        <td><?php if($result['status']==1){ echo 'Active';} else{ echo 'Inactive';}?></td>
							
							</tr>
                        <?php
						}
						}
						?>
							
					<tr><td colspan="6" style="text-align:center" align="center">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
           <a href="<?php echo base_url().'user'; ?>" class="btn btn-default">Cancel</a>
                   </td></tr>
							
							
						</tbody>
					</table>
  				</form>
                </div>
  			</div>
</div>
</div>
</div>