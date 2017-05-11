<script>
    function delete_c(id){
	 var r=confirm("Do you want to delete?");
	   if (r==true)
		  {
			
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>media/delete/',
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
		  <li><a class="" href="<?=base_url().$sub_menu['page_group_url']?>"><?=$sub_menu['page_group_name']?></a></li> 
		  <?php }?>  
    </ul>
    </div>-->
    
   <div class="col-md-12">
   <div class="login-panel panel panel-default"  id="lists">
		<div class="panel-body" > 

      <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header" style="margin-top: 0px;"><i class="fa fa fa-bars"></i> Media</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                    <!--<li><i class="fa fa-bars"></i>Pages</li>-->
                     <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'media'?>">All Media</a></li>
                </ol>
            </div>
        </div>
   <div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">All Menu List &nbsp; &nbsp;
                     &nbsp; <a class="btn btn-primary" href="<?php echo base_url().'media/add'?>" style="color: #fff"><i class="icon_plus_alt2"></i> Add New Media</a></div>
				</div>
  				<div class="panel-body">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
                            	
								<th>Image</th>
								<th>URL</th>
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
                        
								<td><img src="<?=$result['url']?>" alt="" width="50" /></td>
                                <td><?=$result['url']?></td>
                         
                                <td><?php if($result['status']==1){ echo 'Active';} else{ echo 'Inactive';}?></td>
								<td class="right"> <div class="btn-group">
                                      <a class="btn btn-success" href="<?php echo base_url().'media/edit/'.$result['id'];?>"><i class="icon_pencil-edit_alt"></i> Edit</a>
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
</div>