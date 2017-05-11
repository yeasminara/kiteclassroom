
  
 <div class="container">
 <script>




</script>
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
  </script> -->
      <h3><?php echo $title;?></h3>
	<!--<div class="col-md-3 panel login-panel" style="background: #fff; padding-top: 15px; min-height: 529px;">
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
 <form method="post" class="form-horizontal form-label-left" action="<?php echo site_url('student/insert_user/');?>" enctype="multipart/form-data" autocomplete="off">
  	<div class="login-panel panel panel-default">
		<div class="panel-body"> 
        
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
        
          <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email-name">Username <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" value="" id="inputEmail" name="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address').'/Username';?>" required autofocus>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="password" value="" id="inputPassword" name="password"  class="form-control" placeholder="<?php echo $this->lang->line('password');?>" required >
          </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                        </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text"  name="first_name"  class="form-control" placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text"   name="last_name"  class="form-control" placeholder="<?php echo $this->lang->line('last_name');?>"   autofocus>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Contact Number <span class="required">*</span>
                        </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" name="contact_no"  class="form-control" placeholder="<?php echo $this->lang->line('contact_no');?>"   autofocus>
          </div>
        </div>
        
         <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Father's Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text"   name="father_name"  class="form-control" placeholder="Father's Name"   autofocus>
          </div>
        </div>
         <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mother's Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text"   name="mother_name"  class="form-control" placeholder="Mother's Name"   autofocus>
          </div>
        </div>
        
         <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Guardian's Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text"   name="guardian_name"  class="form-control" placeholder="Guardian's Name"   autofocus>
          </div>
          </div>
              <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gender <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
          	<select name="gender" id="gender" class="form-control">
            	<option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
          </div>
        </div>
        <?php if($user_role == 'administrator'){ ?>
			<div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Select School</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
          <?php if(count($group_list)==1){ ?>
          <select class="form-control" name="gid" id="gid">
            <option value="0">None</option>
            <?php foreach($group_list as $key => $val){?>
              <option value="<?php echo $val['gid'];?>"><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>)</option>
            <?php }?>
            
            </select>
            <?php } else {?>
            <select class="form-control" name="gid" id="gid" >
            <option value="0">None</option>
            <?php foreach($group_list as $key => $val){?>
              <option value="<?php echo $val['gid'];?>"><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>)</option>
            <?php }?>
            </select>
            <?php 
					 }
					
						?>
          
           </div>
        </div>
		<? } else{?>
        <input type="hidden" name="" id="" value="<?=$group_list[0]['gid']?>" />
        <?php }
		//print_r($group_list);
		?>
        
        
        <!--<div class="form-group">
          <label for="inputEmail"  ><?php echo $this->lang->line('subscription_expired');?></label>
          <?php if(count($group_list)==1){?>
          <input type="text" name="subscription_expired" class="form-control" placeholder="<?php echo $this->lang->line('subscription_expired');?>" value="<?=date('Y-m-d',(time()+($group_list[0]['valid_for_days']*24*60*60)))?>"    autofocus id="datepicker">
          <?php } else{?>
          <input type="text" name="subscription_expired"  id="datepicker" class="form-control" placeholder="<?php echo $this->lang->line('subscription_expired');?>"    autofocus>
          <?php }?>
        </div>-->
        <!--<div class="form-group">
          <label   ><?php echo $this->lang->line('account_type');?></label>
          <select class="form-control" name="su" required>
            <option value="">Select</option>
            <?php 
					
					foreach($user_list as $users){ ?>
            <option value="<?=$users['role_type']?>" id="<?=$users['role_type']?>">
            <?=$users['title']?>
            </option>
            <?php
					}
					?>
          
          </select>
        </div>-->
        
        
     
            
    
                
                	<div class="form-group">	 
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Academic Year</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="year" name="year" class="form-control">
                        	<option value="">Select</option>
                        	<?php 
							$firstYear = (int)date('Y')-20;
							$lastYear = (int)date('Y')+5;
							for($i=$firstYear;$i<=$lastYear;$i++)
							{
								echo '<option value='.$i.'>'.$i.'</option>';
							}
							?>
                        </select>
                        </div> 
                    </div>
                    
                	<div class="form-group">	 
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Class</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="class_id" name="class_id" class="form-control">
                        	<option value="">Select</option>
                        	<?php foreach($class_list as $classes) {?>
                            <option value="<?=$classes['id']?>"><?=$classes['class_name']?></option>
                            <?php }?>
                        </select> 
                        </div>
                    </div>
                    <div class="form-group">	 
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Class Section</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="class_section_id" name="class_section_id" class="form-control">
                        	<option value="">Select</option>
                        	<?php foreach($class_section_list as $class_section) {?>
                            <option value="<?=$class_section['id']?>"><?=$class_section['section_name']?></option>
                            <?php }?>
                        </select> 
                        </div>
                    </div>
                    
                    <div class="form-group">	 
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Roll</label>
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <input type="text" value="" name="roll_no" id="roll_no"  class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">	 
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Class Group</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="class_group" name="class_group" class="form-control">
                        	<option value="N/A">Select</option>
                            <?php foreach($class_group_list as $class_group){?>
                            <option value="<?=$class_group['group_name']?>"><?=$class_group['group_name']?></option>
                            <?php }?>
                        	
                        </select> 
                        </div>
                    </div>
                    
                    
                    <div class="form-group ">
            <label for="curl" class="control-label col-md-3 col-sm-3 col-xs-12" >Upload Image </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
         		<input type="file" name="image" id="image"  /> 
                </div>
          </div>
         
        
            
	
    
      
            
            
            
       
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
       </div>
     
    
     
     </div>
 </form>
 </div>
 </div>
   

<script>
getexpiry();
</script>