
<script>

$(document).ready(function($) {
 
   $('#check_all').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.selected_user').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.selected_user').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
	
});

function promote_student(){
	if($('#promoted_year').val()==''){
		alert('Please select year');
		return false;
	}
	if($('#promoted_class_id').val()==''){
		alert('Please select class');
		return false;
	}
	if($('.selected_user:checked').length==0){
		alert('Please select student');
		return false;
	}
	var params = $('#serachFrm').serialize();
	$.ajax({
		type: "POST",
		data : params,
		url: "<?=base_url().'user/student_promotion_submit'?>",
		success: function(html){
			alert('Student Promoted Successfully');
		}
		
	});
	
}
</script>
  
  <div  style="padding: 10px; border: solid 1px #eee"> 
<h3>Promoted To</h3>
<?php 
$year = $this->input->post('year');
$class = $this->input->post('class_id');
$nextYear = $year+1;
$nextClass = $class+1;
?>	
<table class="table table-bordered">
<tr>

    
    <th>Academic Year</th>
    <td>
        <select id="promoted_year" name="promoted_year" class="form-control">
          
     
     <?php 
							$firstYear = (int)$year;
							$lastYear = (int)$year+5;
							for($i=$firstYear;$i<=$lastYear;$i++)
							{ ?>
                            
								<option value="<?=$i?>" <?php if($i==$nextYear) {?> selected="selected"<?php }?>><?=$i?></option>
							<?php 
							}
							?>
                            
         </select> 
    </td>
    
    <th>Class</th>
    <td>
     <select name="promoted_class_id" id="promoted_class_id" class="form-control">
     <option value="">Select Class</option>
     <?php foreach($class_list as $classes) {?>
     	<option value="<?=$classes['id']?>"  <?php if($classes['id']==$nextClass) {?> selected="selected"<?php }?>><?=$classes['class_name']?></option>
     <?php }?>
     </select>
    </td>

   
</tr>
</table>
<table class="table table-bordered">
<tr>
    <th><input type="checkbox" name="check_all" id="check_all" class="form-control" style="width: 16px;"></th>
    <th>Student Name</th>
    <th>Previous Roll</th>
    <th>New Roll</th>
    <th>New Section</th>
    <th>New Group</th>
</tr>
<?php 
foreach($student_list as $studentLists){ ?>

<tr>
	
<td><input type="checkbox" name="selected_student[<?php echo $studentLists['user_id'];?>]" value="<?php echo $studentLists['user_id'];?>" class="selected_user form-control" style="width: 16px;" /></td>
<td><?=$studentLists['first_name'].' '.$studentLists['last_name']?></td>
<td><?=$studentLists['roll_no']?></td>
<td><input type="text" name="new_roll_no[<?php echo $studentLists['user_id'];?>]" id="new_roll_no" value="" class="form-control" /></td>
 <td>
     <select name="promoted_class_section_id[<?php echo $studentLists['user_id'];?>]" id="promoted_class_section_id" class="form-control">
     <option value="">Select Section</option>
     <?php foreach($class_section_list as $sections) {?>
     	<option value="<?=$sections['id']?>"><?=$sections['section_name']?></option>
     <?php }?>
     </select>
    </td> 
     <td>
     <select name="promoted_class_group_id[<?php echo $studentLists['user_id'];?>]" id="promoted_class_group_id" class="form-control">
     <option value="N/A">Select Group</option>
     <?php foreach($class_group_list as $class_group) {?>
     	<option value="<?=$class_group['group_name']?>"><?=$class_group['group_name']?></option>
     <?php }?>
     </select>
    </td>
</tr>

<?php
}
?>
<tr><td colspan="6" align="center"><input type="button" name="search" value="Promote Student" id="" class="btn btn-primary" onclick="promote_student()" /></td></tr>
</table>
</div>

