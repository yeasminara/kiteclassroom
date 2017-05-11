


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
        
        <h3 class="page-header" style="margin-top:0"><i class="fa fa fa-bars"></i> Media</h3>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'media'?>">All Media</a></li>
                <li><i class="fa fa-square-o"></i>Add/Edit media</li>
              </ol>
              
     
	<div class="row">
        <section class="wrapper">
         
          <div class="content-box-large">
            <div class="panel-heading">
            </div>
             <section class="panel">
            <div class="panel-body" style="border: solid 1px #eee">
           
              <div class="form ">
                <form class="form-validate form-horizontal" id="feedback_form" method="post" action="<?php echo base_url(); ?>media/<?php echo $this->uri->segment(2) == 'edit' ? 'edit/' . $results['id'] : 'add'; ?>" enctype="multipart/form-data">
                
                <div class="form-group">
                                      <label class="col-sm-2 control-label">Upload Image</label>
                                      <div class="col-sm-10">
                                          <input type="file" name="content_file" id="content_file" /> <br/>
                                          <?php if(isset($results['media_file'])) { ?><img src="<?=$results['url']?>" alt="" width="50" /> <? }?>
                                      </div>
                                  </div>
                                    
                
           
               
                  
                  
                  
                  <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-2">Status </label>
                    <div class="col-lg-1">
                      <input class="form-control" id="status" name="status" type="checkbox" value="1" <?php if(isset($results['status']) && $results['status'] == 1){?> checked="checked" <?php } else{}?> />
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                     <!-- <button class="btn btn-primary" type="submit">Save</button>
                      <button class="btn btn-default" type="button">Cancel</button>-->
                      
                           <?php if ($this->uri->segment(2) == 'edit'): ?>
                  <div class="form-actions">
                    <input type="hidden" value="<?php
                        if (isset($results['id'])) {
                            echo $results['id'];
                        }
                        ?>" name="edit_id"/>
                    <input type="submit" class="btn btn-primary" name="update" value="Update"/>
                    <a href="<?php echo base_url(); ?>media" class="btn btn-default">Cancel</a> 
                   </div>
                  <?php else: ?>
                  <div class="form-actions">
                    <input type="submit" class="btn btn-primary" name="add" value="Submit"/>
                   <a href="<?php echo base_url(); ?>media" class="btn btn-default">Cancel</a> </div>
                  <?php endif; ?>
                  
                    </div>
                  </div>
                </form>
              </div>
             </div>
             </section>
            
          </div>
        </section>
</div>
</div>
</div>
</div>
