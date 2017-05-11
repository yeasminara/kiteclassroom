<section class="wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header"><i class="fa fa fa-bars"></i> Pages</h3>
      <ol class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
        <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'pages'?>">Pages</a></li>
        <li><i class="fa fa-square-o"></i>Add/Edit page</li>
      </ol>
    </div>
  </div>
  <div class="content-box-large">
    <div class="panel-heading">
      <div class="panel-title">Add New Page</div>
    </div>
    <div class="panel-body">
      <div class="form ">
      
      <?php

$full_name = array(
	'name'	=> 'full_name',
	'id'	=> 'full_name',
	'value'	=> set_value('full_name'),
	'class'=> 'form-control',
);

if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
		'class'=> 'form-control',
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'=> 'form-control',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class'=> 'form-control',
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class'=> 'form-control',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 5,
);
?>


<?php echo form_open($this->uri->uri_string(), array(
    'class' => 'form-validate form-horizontal'
)); ?>

    <div class="form-group ">
        <label for="cname" class="control-label col-lg-2">Full Name <span class="required">*</span></label>
        
        <div class="col-lg-4">
           <?php echo form_input($full_name); ?>
			 </div>
			<div class="col-lg-4"><?php echo form_error($full_name['name']); ?><?php echo isset($errors[$full_name['name']])?$errors[$full_name['name']]:''; ?>
        </div>
    </div>
<?php if ($use_username) { ?>
    <div class="form-group ">
        <label for="cname" class="control-label col-lg-2">Username <span class="required">*</span></label>
        
        <div class="col-lg-4">
            <?php echo form_input($username); ?>
        </div>
        <div class="col-lg-4"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></div>
    </div>
  <?php } ?>
      <div class="form-group ">
        <label for="cname" class="control-label col-lg-2">Email <span class="required">*</span></label>
        
        <div class="col-lg-4">
          <?php echo form_input($email); ?>
			 </div>
			<div class="col-lg-4"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
        </div>
    </div>  
    
    
    <div class="form-group ">
        <label for="cname" class="control-label col-lg-2">Password <span class="required">*</span></label>
        
        <div class="col-lg-4"><?php echo form_password($password); ?></div>
		<div class="col-lg-4"><?php echo form_error($password['name']); ?></div>
    </div> 
    <div class="form-group ">
        <label for="cname" class="control-label col-lg-2">Confirm Password <span class="required">*</span></label>
        
        <div class="col-lg-4"><?php echo form_password($confirm_password); ?></div>
		<div class="col-lg-4"><?php echo form_error($confirm_password['name']); ?></div>
    </div> 
   
   
   <?php if ($this->uri->segment(2) == 'edit'): ?>
          <div class="form-actions">
            <input type="hidden" value="<?php
                if (isset($results['id'])) {
                    echo $results['id'];
                }
                ?>" name="edit_id"/>
                <?php     echo form_submit('update', 'Update',array('class'=>'btn btn-primary btn-lg btn-block','style'=>'width: 200px'));?>
            <!--<input type="submit" class="btn btn-primary" name="update" value="Update"/>-->
            <a href="<?php echo base_url(); ?>pages" class="btn btn-default">Cancel</a> 
           </div>
          <?php else: ?>
          <div class="form-actions">
           <!-- <input type="submit" class="btn btn-primary" name="add" value="Submit"/>-->
            <?php     echo form_submit('register', 'Register',array('class'=>'btn btn-primary btn-lg btn-block','style'=>'width: 200px'));?>
            
           <a href="<?php echo base_url(); ?>pages" class="btn btn-default">Cancel</a> </div>
          <?php endif; ?>
          
           

    
<?php echo form_close(); ?>

        <form class="form-validate form-horizontal" id="feedback_form" method="post" action="<?php echo base_url(); ?>page/<?php echo $this->uri->segment(2) == 'edit' ? 'edit/' . $results['id'] : 'add'; ?>">
          <div class="form-group ">
            <label for="cname" class="control-label col-lg-2">Page Name <span class="required">*</span></label>
            <div class="col-lg-4">
              <input class="form-control" id="page_group_name" name="page_group_name" type="text" required value="<?php echo isset($results['page_group_name']) ? $results['page_group_name'] :'';?>" />
            </div>
          </div>
          <div class="form-group ">
            <label for="module" class="control-label col-lg-2">Page Group <span class="required">*</span></label>
            <div class="col-lg-4">
       
              <input class="form-control " id="module" type="text" name="module" value="<?php echo isset($results['module']) ? $results['module'] :'';?>" required  />
            </div>
          </div>
          <div class="form-group ">
            <label for="curl" class="control-label col-lg-2">Url <span class="required">*</span></label>
            <div class="col-lg-4">
              <input class="form-control " id="page_group_url" type="text" value="<?php echo isset($results['page_group_url']) ? $results['page_group_url'] :'';?>" name="page_group_url" required/>
            </div>
          </div>
          <div class="form-group ">
            <label for="cname" class="control-label col-lg-2">Page Type <span class="required">*</span></label>
            <div class="col-lg-4">
            	<select name="page_type" id="page_type" required  class="form-control ">
                	<option value="">Select</option>
                    <option value="list">List</option>
                    <option value="add">Add</option>
                    <option value="edit">Edit</option>
                    <option value="delete">Delete</option>
                    <option value="others">Others</option>
                </select>
            </div>
          </div>
          <div class="form-group ">
            <label for="ccomment" class="control-label col-lg-2">Status </label>
            <div class="col-lg-1">
              <input class="form-control" id="mstatus" name="mstatus" type="checkbox" value="1" <?php if(isset($results['status']) && $results['status'] == 1){?> checked="checked" <?php } else{}?> />
            </div>
          </div>
          
          <div class="form-group ">
            <label for="ccomment" class="control-label col-lg-2">Position</label>
            <div class="col-lg-1">
              <input class="form-control" id="position" name="position" value="<?php echo isset($results['position']) ? $results['position'] :'';?>" type="number"/>
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
            <a href="<?php echo base_url(); ?>pages" class="btn btn-default">Cancel</a> 
           </div>
          <?php else: ?>
          <div class="form-actions">
            <input type="submit" class="btn btn-primary" name="add" value="Submit"/>
           <a href="<?php echo base_url(); ?>pages" class="btn btn-default">Cancel</a> </div>
          <?php endif; ?>
          
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
