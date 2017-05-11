
  
 <div class="container">
 <script>
$( document ).ready(function() {

	
    $( '#school_admin' ).click(function() {
 		$('#school_details').show();
		$('#user_details').hide();
		$('#teacher_details').hide();
		$('#parent_details').hide();
	});
	$( '#user' ).click(function() {
 		$('#school_details').hide();
		$('#user_details').show();
		$('#teacher_details').hide();
		$('#parent_details').hide();
	});
	
	$( '#administrator' ).click(function() {
 		$('#user_details').hide();
		$('#school_details').hide();
		$('#teacher_details').hide();
		$('#parent_details').hide();
	});
	 $( '#school_teacher' ).click(function() {
 		$('#school_details').hide();
		$('#user_details').hide();
		$('#parent_details').hide();
		$('#teacher_details').show();
	});
	$( '#parents' ).click(function() {
 		$('#school_details').hide();
		$('#user_details').hide();
		$('#teacher_details').hide();
		$('#parent_details').show();
	});
	
});

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
function check_student(){
	
	var class_id =$('#class_id1').val();
	var year = $('#year1').val();
	var class_section_id = $('#class_section_id1').val();
	var roll_no = $('#roll_no1').val();
	var class_group = $('#class_group1').val();
	var gid = $('#gid').val();
	$("#student_name").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id+'&year='+year+'&class_section_id='+class_section_id+'&roll_no='+roll_no+'&class_group='+class_group+'&gid='+gid,
		url: "<?=base_url().'loading/check_student'?>",
		success: function(result){
			
			$("#student_name").html(result);
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
 <form method="post" action="<?php echo site_url('user/insert_user/');?>" enctype="multipart/form-data" autocomplete="off">
  	<div class="login-panel panel panel-default">
		<div class="panel-body"> 
        
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
        
          <div class="form-group">
          <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label>
          <input type="text" value="" id="inputEmail" name="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address').'/Username';?>" required autofocus>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
          <input type="password" value="" id="inputPassword" name="password"  class="form-control" placeholder="<?php echo $this->lang->line('password');?>" required >
        </div>
        <div class="form-group">
          <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('first_name');?></label>
          <input type="text"  name="first_name"  class="form-control" placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('last_name');?></label>
          <input type="text"   name="last_name"  class="form-control" placeholder="<?php echo $this->lang->line('last_name');?>"   autofocus>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('contact_no');?></label>
          <input type="text" name="contact_no"  class="form-control" placeholder="<?php echo $this->lang->line('contact_no');?>"   autofocus>
        </div>
        <div class="form-group">
          <label>Select School</label>
          <?php if(count($group_list)==1){ ?>
          <select class="form-control" name="gid" id="gid"  onchange="check_student()">
            <option value="0">None</option>
            <?php foreach($group_list as $key => $val){?>
              <option value="<?php echo $val['gid'];?>"><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>)</option>
            <?php }?>
            
            </select>
            <?php } else {?>
            <select class="form-control" name="gid" id="gid" onChange="getexpiry();check_student();">
            <option value="0">None</option>
            <?php foreach($group_list as $key => $val){?>
              <option value="<?php echo $val['gid'];?>"><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>)</option>
            <?php }?>
            </select>
            <?php 
					 }
					
						?>
          
           
        </div>
        <div class="form-group">
          <label for="inputEmail"  ><?php echo $this->lang->line('subscription_expired');?></label>
          <?php if(count($group_list)==1){?>
          <input type="text" name="subscription_expired" class="form-control" placeholder="<?php echo $this->lang->line('subscription_expired');?>" value="<?=date('Y-m-d',(time()+($group_list[0]['valid_for_days']*24*60*60)))?>"    autofocus id="datepicker">
          <?php } else{?>
          <input type="text" name="subscription_expired"  id="datepicker" class="form-control" placeholder="<?php echo $this->lang->line('subscription_expired');?>"    autofocus>
          <?php }?>
        </div>
        <div class="form-group">
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
            <!-- <?php if($user_type == 2) {?>
                    	<option value="">Select</option>
                    	<option value="0" id="user_id"><?php echo $this->lang->line('user');?></option>
                    	<option value="2" id="school_admin_id">School Administrator</option>
                        <option value="3" id="school_teacher_id">School Teacher</option>
                    <?php } else {?>
                        <option value="">Select</option>
						<option value="0" id="user_id"><?php echo $this->lang->line('user');?></option>
						<option value="1" id="administrator"><?php echo $this->lang->line('administrator');?></option>
                        <option value="2" id="school_admin_id">School Administrator</option>
                         <option value="3" id="school_teacher_id">School Teacher</option>
                        <?php }?>-->
          </select>
        </div>
        <div id="teacher_details"  style="display: none">
          <?php foreach($class_list as $classes) {
				
					 $this->db->where('class_id',$classes['id']);
					 $query=$this->db->get('savsoft_category');
					//echo $this->db->last_query();
		//return $query->result_array();
					 ?>
          <div class="form-group">
            <div class="form-group">
              <label>Class :
                <?=$classes['class_name']?>
              </label>
              <br/>
              <label>Subjects : </label>
              <?php foreach( $query->result_array() as $result) {
							   ?>
              <input type="checkbox" name="subject_id[<?=$classes['id']?>]" value="<?=$result['cid']?>">
              &nbsp;
              <?=$result['category_name']?>
              &nbsp; &nbsp;
              <? }?>
            </div>
          </div>
          <?php }?>
        </div>
        
         <?php if(count($group_list)==1){ ?>
				<div id="user_details">
			<? }else{ ?>
			<div id="user_details"  style="display: none">
		<?php 	}
			?>
            
            	<div class="form-group">
                
                	<div class="form-group">	 
						<label>Academic Year</label>
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
                    
                	<div class="form-group">	 
						<label>Class</label>
                        <select id="class_id" name="class_id" class="form-control">
                        	<option value="">Select</option>
                        	<?php foreach($class_list as $classes) {?>
                            <option value="<?=$classes['id']?>"><?=$classes['class_name']?></option>
                            <?php }?>
                        </select> 
                    </div>
                    <div class="form-group">	 
						<label>Class Section</label>
                        <select id="class_section_id" name="class_section_id" class="form-control">
                        	<option value="">Select</option>
                        	<?php foreach($class_section_list as $class_section) {?>
                            <option value="<?=$class_section['id']?>"><?=$class_section['section_name']?></option>
                            <?php }?>
                        </select> 
                    </div>
                    
                    <div class="form-group">	 
						<label>Roll</label> 
                        <input type="text" value="" name="roll_no" id="roll_no"  class="form-control" />
                    </div>
                    <div class="form-group">	 
						<label>Class Group</label>
                        <select id="class_group" name="class_group" class="form-control">
                        	<option value="N/A">Select</option>
                            <?php foreach($class_group_list as $class_group){?>
                            <option value="<?=$class_group['group_name']?>"><?=$class_group['group_name']?></option>
                            <?php }?>
                        	
                        </select> 
                    </div>
                    
                    
                    <div class="form-group ">
            <label for="curl" class="col-lg-3 control-label text-left"  style="padding-left: 0px; height: 0px; width: 116px;">Upload Image </label>
            <div class="col-sm-5">
         		<input type="file" name="image" id="image" /> <br/>
                </div>
          </div>
          <div style="clear: both"></div>
                </div>
            </div>
        
        
            <div id="school_details" style="display: none">
            	<div class="form-group">
                	
                     <div class="form-group">	 
						<label>Logo</label> 
                        <input type="file" name="school_logo" id="school_logo" />
                    </div>
                    <div class="form-group">	 
						<label>School Address</label> 
                        <textarea name="school_address" id="school_address"></textarea>
                    </div>
                    
                </div>
            </div>
	
    
      
            
            <div id="parent_details"  style="display: none">
            	<div class="form-group" style="clear:both;">
                	<fieldset>
                    	<legend>Check Student</legend>
                        <div class="form-group" style=" overflow: hidden">	 
						<label class="col-sm-3  control-label text-right">Academic Year</label>
                        <div class="col-sm-5">
                        <select id="year1" name="year" class="form-control" onchange="check_student()">
                        	<option value="">Select</option>
                        	<?php 
							$firstYear = (int)date('Y')-20;
							$lastYear = (int)date('Y')+5;
							for($i=$firstYear;$i<=$lastYear;$i++)
							{ ?>
								<option value="<?=$i?>" <? if($i==date('Y')){ echo 'selected="selected"';}?> ><?=$i?></option>';
							<? }
							?>
                        </select> 
                        </div>
                    </div>
                    
                        <div class="form-group" style="clear:both;  overflow: hidden;">	 
                            <label  class="col-sm-3  control-label text-right">Class</label>
                            <div class="col-sm-5">
                            <select id="class_id1" name="class_id" class="form-control" onchange="check_student()" >
                                <option value="">Select</option>
                                <?php foreach($class_list as $classes) {?>
                                <option value="<?=$classes['id']?>"><?=$classes['class_name']?></option>
                                <?php }?>
                            </select> 
                            </div>
                        </div>
                        <div class="form-group" style="clear:both;  overflow: hidden;">	 
                            <label  class="col-sm-3  control-label text-right">Class Section</label>
                            <div class="col-sm-5">
                            <select id="class_section_id1" name="class_section_id" class="form-control" onchange="check_student()" >
                                <option value="">Select</option>
                                <?php foreach($class_section_list as $class_section) {?>
                                <option value="<?=$class_section['id']?>"><?=$class_section['section_name']?></option>
                                <?php }?>
                            </select> 
                            </div>
                        </div>
                        
                        <div class="form-group" style="clear:both;  overflow: hidden;">	 
                            <label  class="col-sm-3  control-label text-right">Roll</label>
                            <div class="col-sm-5"> 
                            <input type="text" value="" name="roll_no" id="roll_no1"  class="form-control" onchange="check_student()" />
                            </div>
                        </div>
                        <div class="form-group" style="clear:both;  overflow: hidden;">	 
                            <label  class="col-sm-3  control-label text-right">Class Group</label>
                            <div class="col-sm-5">
                            <select id="class_group1" name="class_group" class="form-control" onchange="check_student()">
                                <option value="N/A">Select</option>
                                <?php foreach($class_group_list as $class_group){?>
                                <option value="<?=$class_group['group_name']?>"><?=$class_group['group_name']?></option>
                                <?php }?>
                                
                            </select> 
                            </div>
                        </div>
                          <div class="form-group" style="clear:both;  overflow: hidden;">
                            <label  class="col-sm-3  control-label text-right">Student Name</label>
                            <div class="col-sm-5" id="student_name"></div>
                          </div>
                    </fieldset>
                	
              <fieldset>
                    	<legend>Parent Information</legend>
                        <div class="form-group" style="clear:both;  overflow: hidden;">
                            <label for="curl" class="col-lg-3 control-label text-left">Confirm Your Children </label>
                            <div class="col-sm-5">
                            	<input type="checkbox" name="conform" value="1"   />   
                            </div>
                         </div>
                         <div class="form-group" style="clear:both;  overflow: hidden;">
                            <label for="curl" class="col-lg-3 control-label text-left">Relation With Student </label>
                            <div class="col-sm-5">
                                <input type="text" name="relation_with_student" id="relation_with_student" class="form-control" value="" />
                            </div>
                          </div>
                          <div class="form-group" style="clear:both;  overflow: hidden;">
                            <label for="curl" class="col-lg-3 control-label text-left">SMS Number </label>
                            <div class="col-sm-5">
                                <input type="text" name="contact_number1" id="contact_number1" class="form-control" value="" />
                                </div>
                          </div>
                          <div class="form-group" style="clear:both;  overflow: hidden;">
                            <label for="curl" class="col-lg-3 control-label text-left">Another Number</label>
                            <div class="col-sm-5">
                                 <input type="text" name="contact_number2" id="contact_number2" class="form-control" value="" />
                                </div>
                          </div>
                       <!--   
                         
                        <div class="form-group" style="clear:both;  overflow: hidden;">
                            <label for="curl" class="col-lg-3 control-label text-left">Upload Image </label>
                            <div class="col-sm-5">
                                <input type="file" name="parent_image" id="image" /> <br/>
                                </div>
                          </div>-->
               </fieldset>      
                    
                    
          <div style="clear: both"></div>
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