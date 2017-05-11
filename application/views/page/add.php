<script>
function change_module(){
	var val = $('#module1').val();
	$('#module').val(val);
}
</script>
   <div class="col-md-12">
   <div class="login-panel panel panel-default"  id="lists">
		<div class="panel-body" > 
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header"><i class="fa fa fa-bars"></i> Pages</h3>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                <li><i class="fa fa-bars"></i> <a href="<?php echo base_url().'pages'?>">Pages</a></li>
                <li><i class="fa fa-square-o"></i> Add/Edit page</li>
              </ol>
            </div>
          </div>
          <div class="content-box-large">
            <div class="panel-heading">
              <div class="panel-title">Add New Page</div>
            </div>
            <div class="panel-body">
              <div class="form ">
                <form class="form-validate form-horizontal" id="feedback_form" method="post" action="<?php echo base_url(); ?>pages/<?php echo $this->uri->segment(2) == 'edit' ? 'edit/' . $results['id'] : 'add'; ?>">
                  <div class="form-group ">
                    <label for="cname" class="control-label col-lg-2">Page Name (English) <span class="required">*</span></label>
                    <div class="col-lg-4">
                      <input class="form-control" id="page_group_name" name="page_group_name" type="text" required value="<?php echo isset($results['page_group_name']) ? $results['page_group_name'] :'';?>" />
                    </div>
                  </div>
                  <div class="form-group ">
                    <label for="cname" class="control-label col-lg-2">Page Name (Bangla) <span class="required">*</span></label>
                    <div class="col-lg-4">
                      <input class="form-control" id="page_group_name_bn" name="page_group_name_bn" type="text" required value="<?php echo isset($results['page_group_name_bn']) ? $results['page_group_name_bn'] :'';?>" />
                    </div>
                  </div>
                  <div class="form-group ">
                    <label for="module" class="control-label col-lg-2">Page Group <span class="required">*</span></label>
                    <div class="col-lg-4">
               
               <select id="module1" class="form-control " onchange="change_module()" style="float: left; width: 200px;">
               <option value="">Select</option>
               
               <?php 
			   $this->db->group_by('module');
			   $this->db->where('status','1');
			   $query = $this->db->get('savsoft_page_group');
			   if($query->num_rows()>0){
				   foreach($query->result_array() as $module){ ?>
                   <option value="<?=$module['module']?>"><?=$module['module']?></option>
                   <?php
				   }
				 }
			   ?>
               <?php ?>
               </select>
                      <input class="form-control " id="module" type="text" name="module" value="<?php echo isset($results['module']) ? $results['module'] :'';?>" required  style="float: right; width: 111px;" />
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
                        <select name="page_type" id="page_type" required class="form-control">
                            <option value="">Select</option>
                            <option value="list" <?php if(isset($results['page_type']) && $results['page_type']=='list') {?> selected="selected"<?php }?>>List</option>
                            <option value="add" <?php if(isset($results['page_type']) && $results['page_type']=='add') {?> selected="selected"<?php }?>>Add</option>
                            <option value="edit" <?php if(isset($results['page_type']) && $results['page_type']=='edit') {?> selected="selected"<?php }?>>Edit</option>
                            <option value="delete" <?php if(isset($results['page_type']) && $results['page_type']=='delete') {?> selected="selected"<?php }?>>Delete</option>
                            <option value="others" <?php if(isset($results['page_type']) && $results['page_type']=='others') {?> selected="selected"<?php }?>>Others</option>
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
       
</div>
</div>
</div>