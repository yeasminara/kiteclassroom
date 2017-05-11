<script>
    function delete_c(id){
	 var r=confirm("Do you want to delete?");
	   if (r==true)
		  {
			
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>pages/delete/',
                data:'&deleteId='+id,
                success: function(data){
                            alert("Row deleted");
							location.reload();
                    
                    }

                })
					
			 
		  }
		else
		  {
			 //return false;
		  }
 }
 
</script>
  <div class="col-md-12">
   <div class="login-panel panel panel-default"  id="lists">
		<div class="panel-body" > 
      <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa fa-bars"></i> Pages</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                    <!--<li><i class="fa fa-bars"></i>Pages</li>-->
                    <li><i class="fa fa-square-o"></i><a href="<?php echo base_url().'pages'?>">Pages</a></li>
                </ol>
            </div>
        </div>
   <div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">All Menu List &nbsp; &nbsp;
                     &nbsp; <a class="btn btn-primary" href="<?php echo base_url().'pages/add'?>" style="color: #fff"><i class="icon_plus_alt2"></i> Add New Page</a></div>
				</div>
  				<div class="panel-body">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
                            	
								<th>Page Title</th>
							    <th>Module</th>
								<th>URL</th>
                                <th>Create Date</th>
                                <th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						if($count>0){
						foreach($results as $result){
						//$group_name = get_menu_group_name($result['menu_group_id']);	
						?>
                        <tr class="<?php if($count%2 == 0){ echo 'even';}else{ echo 'odd';}?> gradeX">
                        
								<td><?=$result['page_group_name']?></td>
                                <td><?=$result['module']?></td>
                                <td><?=$result['page_group_url']?></td>
                                <td><?=date('d-m-Y',strtotime($result['create_date']))?></td>
                                <td><?php if($result['status']==1){ echo 'Active';} else{ echo 'Inactive';}?></td>
								<td class="right"> <div class="btn-group">
                                      <a class="btn btn-success" href="<?php echo base_url().'pages/edit/'.$result['id'];?>"><i class="icon_pencil-edit_alt"></i> Edit</a>
                                      <a class="btn btn-danger" href="javascript:delete_c(<?php echo $result['id'];?>)"><i class="icon_close_alt2"></i> Delete</a>
                                  </div></td>
							</tr>
                        <?php
						}
						}
						?>
							
					
							
							
						</tbody>
					</table>
  				</div>
  			</div>

</div>
</div>
</div>