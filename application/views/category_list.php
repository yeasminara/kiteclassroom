 <div class="container">

   
 <h3><?php echo $title;?></h3>


  <div class="row">
 
<div class="col-md-12">
<div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		<div id="message"></div>
		
		 <form method="post" action="<?php echo site_url('qbank/insert_category/');?>">
	
<table class="table table-bordered">
<tr>
 <th><?php echo $this->lang->line('category_name');?></th>
<th><?php echo $this->lang->line('action');?> </th>
</tr>
<?php 
if(count($category_list)==0){
	?>
<tr>
 <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}

foreach($category_list as $key => $val){
?>
<tr>
 <td><input type="text"   class="form-control"  value="<?php echo $val['category_name'];?>" onBlur="updatecategory(this.value,'<?php echo $val['cid'];?>');" ></td>
  <td><select id="class_id" name="class_id" class="form-control" onBlur="updatecategory1(this.value,'<?php echo $val['cid'];?>');">
 <option value="">Select</option>
 <?php foreach($class_list as $classes) {?>
 <option value="<?=$classes['id']?>" <?php if($classes['id'] == $val['class_id']) {?> selected="selected" <?php }?>><?=$classes['class_name']?></option>
 <?php }?>
 </select></td>
<td>
<a href="javascript:remove_entry('qbank/remove_category/<?php echo $val['cid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>

</td>

</tr>

<?php 
}
?>
<tr>
 <td>
 
 <input type="text"   class="form-control"   name="category_name" value="" placeholder="<?php echo $this->lang->line('category_name');?>"  required ></td>
 <td><select id="class_id" name="class_id" class="form-control">
 <option value="">Select</option>
 <?php foreach($class_list as $classes) {?>
 <option value="<?=$classes['id']?>"><?=$classes['class_name']?></option>
 <?php }?>
 </select></td>
<td>
<button class="btn btn-default" type="submit"><?php echo $this->lang->line('add_new');?></button>
 
</td>
</tr>
</table>
</form>
</div>

</div>

</div>

</div>



</div>