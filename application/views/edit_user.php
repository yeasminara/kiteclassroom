
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
		url: "<?=base_url().'user/load_subject_only'?>",
		success: function(result){
			$("#subject_div_id").html(result);
		}
		
	});
}
</script> 
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
      <li><a class="" href="<?=base_url().$sub_menu['page_group_url']?>">
        <?=$sub_menu['page_group_name']?>
        </a></li>
      <?php }?>
    </ul>
  </div>-->
  <div class="col-md-12">
    <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >
        <h3><?php echo $title;?></h3>
        <div class="row">
          <form method="post" action="<?php echo site_url('user/update_user/'.$uid);?>" enctype="multipart/form-data">
            <div class="col-md-8"> <br>
              <div class="login-panel panel panel-default">
                <div class="panel-body">
                  <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		
		$logged_in=$this->session->userdata('logged_in');
	$su=$logged_in['su'];
		?>
                  <div class="form-group"> <?php echo $this->lang->line('group_name');?>: <?php echo $result['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $result['price'];?>) </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label>
                    <input type="text" id="inputEmail" name="email" value="<?php echo $result['email'];?>" class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
                    <input type="password" id="inputPassword" name="password"   value=""  class="form-control" placeholder="<?php echo $this->lang->line('password');?>"   >
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('first_name');?></label>
                    <input type="text"  name="first_name"  class="form-control"  value="<?php echo $result['first_name'];?>"  placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('last_name');?></label>
                    <input type="text"   name="last_name"  class="form-control"  value="<?php echo $result['last_name'];?>"  placeholder="<?php echo $this->lang->line('last_name');?>"   autofocus>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('contact_no');?></label>
                    <input type="text" name="contact_no"  class="form-control"  value="<?php echo $result['contact_no'];?>"  placeholder="<?php echo $this->lang->line('contact_no');?>"   autofocus>
                  </div>
                  <?php 
			
			$results = $this->db->where('status','1')->where('id',$result['su'])->get('savsoft_roles')->row_array();
			
			/* if user type administrator or super admin no need to add group/school name*/
			if($results['role_type'] =='administrator' || $results['role_type']=='superadmin'){}else{
			?>
                  <div class="form-group">
                    <label   ><?php echo $this->lang->line('select_group');?></label>
                    <select class="form-control" name="gid"  onChange="getexpiry();" id="gid">
                      <?php 
					foreach($group_list as $key => $val){
						?>
                      <option value="<?php echo $val['gid'];?>" <?php if($result['gid']==$val['gid']){ echo 'selected';}?> ><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>)</option>
                      <?php 
					}
					?>
                    </select>
                  </div>
                  <?php }?>
                  <div class="form-group">
                    <label for="inputEmail" ><?php echo $this->lang->line('subscription_expired');?></label>
                   
                    <input type="text" name="subscription_expired"  id="subscription_expired" class="form-control" value="<?php if($result['subscription_expired']!='0'){ echo date('Y-m-d',$result['subscription_expired']); }else{ echo '0';} ?>" placeholder="<?php echo $this->lang->line('subscription_expired');?>"  autofocus>
                  </div>
                  <div class="form-group">
                    <label   ><?php echo $this->lang->line('account_type');?></label>
                    <select class="form-control" name="su">
                      <?php 
					
					foreach($user_list as $users){ ?>
                      <option value="<?=$users['role_type']?>" id="<?=$users['role_type']?>" <?php if($result['su']==$users['id']){ echo 'selected';}?>>
                      <?=$users['title']?>
                      </option>
                      <?php
					}
					?>
                      
                      <!-- <?php if($user_type == 2) {?>
                     <option value="0" <?php if($result['su']==0){ echo 'selected';}?>   id="user_id"><?php echo $this->lang->line('user');?></option>
                     <option value="2" <?php if($result['su']==2){ echo 'selected';}?> id="school_admin_id">School Administrator</option>>
                     <option value="3" id="school_teacher_id" <?php if($result['su']==3){ echo 'selected';}?>>School Teacher</option>
                      <?php } else {?>
						<option value="0" <?php if($result['su']==0){ echo 'selected';}?>   id="user_id"><?php echo $this->lang->line('user');?></option>
						<option value="1" <?php if($result['su']==1){ echo 'selected';}?> id="administrator" ><?php echo $this->lang->line('administrator');?></option>
                         <option value="2" <?php if($result['su']==2){ echo 'selected';}?> id="school_admin_id">School Administrator</option>
                         <option value="3" id="school_teacher_id" <?php if($result['su']==3){ echo 'selected';}?>>School Teacher</option>
                  <?php }?>-->
                    </select>
                  </div>
                  <?php 
		   
		   
		   
		 
		  
		   
		   if($user_type_role['role_type']=='school_admin'){
			   
			   ?>
                  <div id="school_details">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Logo</label>
                        <div style="clear: both"></div>
                        <input type="file" name="school_logo" id="school_logo" value="" style="float: left" />
                        <input type="hidden" name="old_school_logo" id="old_school_logo" value="<?=$school_info['school_logo']?>" style="float: left" />
                        <?php if(isset($school_info['school_logo'])){ ?>
                        <img src="<?php echo base_url().'images/'.$school_info['school_logo'];?>" class="img" width="50" style="float: left;" />
                        <?php } ?>
                      </div>
                      <div class="form-group" style="clear:both">
                        <label>School Address</label>
                        <textarea name="school_address" id="school_address"><?=$school_info['school_address']?>
</textarea>
                      </div>
                    </div>
                  </div>
                  <?php } elseif($user_type_role['role_type']=='user'){?>
                  <div id="user_details">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Academic Year</label>
                        <select id="year" name="year" class="form-control">
                          <option value="">Select</option>
                          <?php 
							$firstYear = (int)date('Y')-20;
							$lastYear = (int)date('Y')+5;
							for($i=$firstYear;$i<=$lastYear;$i++)
							{ ?>
                          <option value="<?=$i?>" <?php if($student_info['academic_year'] == '$i') {?> selected="selected"<?php }?>>
                          <?=$i?>
                          </option>
                          <?php 
							}
							?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Class</label>
                        <select id="class_id" name="class_id" class="form-control">
                          <option value="">Select</option>
                          <?php foreach($class_list as $classes) {?>
                          <option value="<?=$classes['id']?>" <?php if($classes['id']==$student_info['class_id']){ echo 'selected="selected"';}?>>
                          <?=$classes['class_name']?>
                          </option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Class Section</label>
                        <select id="class_section_id" name="class_section_id" class="form-control">
                          <option value="">Select</option>
                          <?php foreach($class_section_list as $class_section) {?>
                          <option value="<?=$class_section['id']?>"  <?php if($class_section['id']==$student_info['class_section_id']){ echo 'selected="selected"';}?>>
                          <?=$class_section['section_name']?>
                          </option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Roll</label>
                        <input type="text" value="<?=$student_info['roll_no']?>" name="roll_no" id="roll_no"  class="form-control" />
                      </div>
                      <div class="form-group">
                        <label>Class Group</label>
                        <select id="class_group" name="class_group" class="form-control">
                          <option value="N/A">Select</option>
                          <option value="N/A" <?php if($student_info['class_group']=='N/A'){ echo 'selected="selected"';}?>>N/A</option>
                          <option value="Science" <?php if($student_info['class_group']=="Science"){ echo 'selected="selected"';}?>>Science</option>
                          <option value="Humanities" <?php if($student_info['class_group']=="Humanities"){ echo 'selected="selected"';}?>>Humanities</option>
                          <option value="Business Studies" <?php if($student_info['class_group']=="Business Studies"){ echo 'selected="selected"';}?>>Business Studies</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <?php } elseif($user_type_role['role_type']=='school_teacher'){?>
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
							   
							   $this->db->where('subject_id',$result['cid']);
							   $query1=$this->db->get('teacher_taken_subject');
							   $res = $query1->row_array();
							   ?>
                        <input type="checkbox" name="subject_id[<?=$classes['id']?>]" value="<?=$result['cid']?>" <?php if(isset($res['subject_id']) && $res['subject_id'] == $result['cid']){?> checked="checked" <?php }?>>
                        &nbsp;
                        <?=$result['category_name']?>
                        &nbsp; &nbsp;
                        <? }?>
                      </div>
                    </div>
                    <?php }?>
                  </div>
                  <?php } elseif($user_type_role['role_type']=='administrator' || $user_type_role['role_type']=='superadmin'){
		  
		  ?>
                  <div id="school_details" <?php if($results['role_type']=='school_admin') {}else{?>style=" display: none" <?php }?>>
                    <div class="form-group">
                      <div class="form-group">
                        <label>Logo</label>
                        <div style="clear: both"></div>
                        <input type="file" name="school_logo" id="school_logo" value="" style="float: left" />
                        <input type="hidden" name="old_school_logo" id="old_school_logo" value="<?=$school_info['school_logo']?>" style="float: left" />
                        <?php if(isset($school_info['school_logo'])){ ?>
                        <img src="<?php echo base_url().'images/'.$school_info['school_logo'];?>" class="img" width="50" style="float: left;" />
                        <?php } ?>
                      </div>
                      <div class="form-group" style="clear:both">
                        <label>School Address</label>
                        <textarea name="school_address" id="school_address"><?=$school_info['school_address']?>
</textarea>
                      </div>
                    </div>
                  </div>
                  <div id="user_details" <?php if($results['role_type']=='user') {}else{?>style=" display: none" <?php }?>>
                    <div class="form-group">
                      <div class="form-group">
                        <label>Academic Year</label>
                        <select id="year" name="year" class="form-control">
                          <option value="">Select</option>
                          <?php 
							$firstYear = (int)date('Y')-20;
							$lastYear = (int)date('Y')+5;
							for($i=$firstYear;$i<=$lastYear;$i++)
							{ ?>
                          <option value="<?=$i?>" <?php if($student_info['academic_year'] == $i) {?> selected="selected"<?php }?>>
                          <?=$i?>
                          </option>
                          <?php 
							}
							?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Class</label>
                        <select id="class_id" name="class_id" class="form-control">
                          <option value="">Select</option>
                          <?php foreach($class_list as $classes) {?>
                          <option value="<?=$classes['id']?>" <?php if($classes['id']==$student_info['class_id']){ echo 'selected="selected"';}?>>
                          <?=$classes['class_name']?>
                          </option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Class Section</label>
                        <select id="class_section_id" name="class_section_id" class="form-control">
                          <option value="">Select</option>
                          <?php foreach($class_section_list as $class_section) {?>
                          <option value="<?=$class_section['id']?>"  <?php if($class_section['id']==$student_info['class_section_id']){ echo 'selected="selected"';}?>>
                          <?=$class_section['section_name']?>
                          </option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Roll</label>
                        <input type="text" value="<?=$student_info['roll_no']?>" name="roll_no" id="roll_no"  class="form-control" />
                      </div>
                      <div class="form-group">
                        <label>Class Group</label>
                        <select id="class_group" name="class_group" class="form-control">
                          <option value="N/A">Select</option>
                          <?php foreach($class_group_list as $class_group){?>
                          <option value="<?=$class_group['group_name']?>" <?php if($student_info['class_group']==$class_group['group_name']){ echo 'selected="selected"';}?>>
                          <?=$class_group['group_name']?>
                          </option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="form-group ">
                        <label for="curl" class="col-lg-3 control-label text-left"  style="padding-left: 0px; height: 0px; width: 116px;">Upload Image </label>
                        <div class="col-sm-5">
                          <input type="file" name="image" id="image" />
                          &nbsp; &nbsp;
                          <?php if(!empty($student_info['profile_picture']))?>
                          <img src="<?=base_url().'images/student/'.$student_info['profile_picture']?>" align="" alt="" width="40" /> </div>
                      </div>
                    </div>
                  </div>
                  <div id="teacher_details"  <?php if($results['role_type']=='school_teacher') {}else{?>style=" display: none" <?php }?>>
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
							   
							   $this->db->where('subject_id',$result['cid']);
							    $this->db->where('user_id',$uid);
							   $query1=$this->db->get('teacher_taken_subject');
							   //echo $this->db->last_query();
							   $res = $query1->row_array();
							   ?>
                        <input type="checkbox" name="subject_id[<?=$classes['id']?>]" value="<?=$result['cid']?>" <?php if(isset($res['subject_id']) && $res['subject_id'] == $result['cid']){?> checked="checked" <?php }?>>
                        &nbsp;
                        <?=$result['category_name']?>
                        &nbsp; &nbsp;
                        <? }?>
                      </div>
                    </div>
                    <?php }?>
                  </div>
                  <div id="parent_details"   <?php if($results['role_type']=='parents') {}else{?>style=" display: none" <?php }?>>
                    <div class="form-group" style="clear:both;">
                      <fieldset>
                        <legend>Parent Information</legend>
                        <div class="form-group" style="clear:both;  overflow: hidden;">
                          <label for="curl" class="col-lg-3 control-label text-left">Relation With Student </label>
                          <div class="col-sm-5">
                            <input type="text" name="relation_with_student" id="relation_with_student" class="form-control" value="<?=$parent_info['relation_with_student']?>" />
                          </div>
                        </div>
                        <div class="form-group" style="clear:both;  overflow: hidden;">
                          <label for="curl" class="col-lg-3 control-label text-left">Contcat Number1</label>
                          <div class="col-sm-5">
                            <input type="text" name="contact_number1" id="contact_number1" class="form-control" value="<?=$parent_info['contact_number1']?>" />
                          </div>
                        </div>
                        <div class="form-group" style="clear:both;  overflow: hidden;">
                          <label for="curl" class="col-lg-3 control-label text-left">Contcat Number2</label>
                          <div class="col-sm-5">
                            <input type="text" name="contact_number2" id="contact_number2" class="form-control" value="<?=$parent_info['contact_number2']?>" />
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
                  <?php }?>
                  <div style="clear:both"></div>
                  <input type="hidden" name="url" value="<?=$this->uri->uri_string()?>" />
                  <button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="row">
          <div class="col-md-8">
            <h3><?php echo $this->lang->line('payment_history');?></h3>
            <table class="table table-bordered">
              <tr>
                <th><?php echo $this->lang->line('payment_gateway');?></th>
                <th><?php echo $this->lang->line('paid_date');?> </th>
                <th><?php echo $this->lang->line('amount');?></th>
                <th><?php echo $this->lang->line('transaction_id');?> </th>
                <th><?php echo $this->lang->line('status');?> </th>
              </tr>
              <?php 
if(count($payment_history)==0){
	?>
              <tr>
                <td colspan="5"><?php echo $this->lang->line('no_record_found');?></td>
              </tr>
              <?php
}
foreach($payment_history as $key => $val){
?>
              <tr>
                <td><?php echo $val['payment_gateway'];?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['paid_date']);?></td>
                <td><?php echo $val['amount'];?></td>
                <td><?php echo $val['transaction_id'];?></td>
                <td><?php echo $val['payment_status'];?></td>
              </tr>
              <?php 
}
?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
