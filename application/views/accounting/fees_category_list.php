
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
		
		 <form method="post" action="<?php echo site_url('accounting/add_fees/');?>">
	
<table class="table table-bordered">
<tr>
 <th>Category name</th>
<th><?php echo $this->lang->line('action');?> </th>
</tr>
<?php 
if(count($fees_category_list)==0){
	?>
<tr>
 <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}

foreach($fees_category_list as $key => $val){
?>
<tr>
 <td><input type="text"   class="form-control"  value="<?php echo $val['category_name'];?>" onBlur="update_fees_category(this.value,'<?php echo $val['id'];?>');" ></td>
<td>
<a href="javascript:remove_entry('accounting/delete_fees/<?php echo $val['id'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>

</td>
</tr>

<?php 
}
?>
<tr>
 <td>
 
 <input type="text"   class="form-control"   name="category_name" value="" placeholder="Category name"  required ></td>
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