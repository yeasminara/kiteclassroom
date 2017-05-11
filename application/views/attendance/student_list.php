<!--<script src="<?=base_url()?>assets/js/jquery-1.8.3.min.js"></script>-->

<link rel="stylesheet" href="<?=base_url()?>ui/jquery-ui.css">
<script src="<?=base_url()?>ui/jquery-1.12.4.js"></script>
<script src="<?=base_url()?>ui/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function($) {
 
   $('#check_all').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.selected_std').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.selected_std').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
	
		$('#form1').submit(function(){
	
		if($('.selected_std:checked').length == 0){
			alert('Please Select checkbox');
			$('.icheckbox_square-red').show();
			return false;
		}
		/*else{
			$('.icheckbox_square-red').hide();
		        return true;
		}*/
		if($('.attendance_type:checked').length == 0){
			alert('Please Select attendance type');
			return false;
		}
		
	});
	
	
    $( "#datepicker" ).datepicker({
	      changeMonth: true,
      changeYear: true,
	   dateFormat: 'yy-mm-dd' 
	});
  
	
});
function search_student(){
	var data = $('#form1').serialize();
	$.ajax({
		type: "POST",
		data : data,
		url: "<?=base_url().'student_attendance/search_student'?>",
		success: function(result){
			$("#load_student").html(result);
		}
		
	});
	
}
</script>



<style>
.icheckbox_square-red, .iradio_square-red {
    border: 1px solid red;
    cursor: pointer;
    display: inline-block;
    height: 15px;
    left: 6px;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 6px;
    vertical-align: middle;
    width: 15px;
    z-index:-11;
}

.check_all_class, .selected_std{
 z-index:1;
}
.icheckbox_square-red.hover {
    background-position: -24px 0;
}
</style>


   
 <div class="login-panel panel panel-default">
      <div class="panel-body">
      <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                   <li> <i class="fa fa-bars"></i><span><?=isset($title) ? $title:''?></span></li>
                </ol>
            </div>
        </div>
   <div class="content-box-large">
    <form id="form1" name="form1" action="<?=base_url().'student_attendance/add'?>" method="post" enctype="multipart/form-data">
  				<div class="panel-body">
                	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                    <tr>
                    <?php 
					$logged_in=$this->session->userdata('logged_in');
					if($logged_in['role_type']=='administrator' || $logged_in['role_type']=='superadmin'){?>
                    <th><select name="gid" id="gid" class="form-control" onchange="search_student()">
                      <option value="">Select School</option>
                      <?php 
				
				
				foreach($school_list as $school) {?>
                      <option value="<?=$school['gid']?>" <?php if($this->input->post('gid') && $this->input->post('gid')==$school['gid']){ echo 'selected="selected"';}?> >
                      <?=$school['group_name']?>
                      </option>
                      <?php }?>
                    </select></th>
                    <?php }?>
                    <th> <select id="academic_year" name="academic_year" class="form-control" onchange="search_student()">
                        	<option value="">Academic year</option>
                        	<?php 
							$firstYear = (int)date('Y')-20;
							$lastYear = (int)date('Y')+5;
							$current_year = date('Y');
							for($i=$firstYear;$i<=$lastYear;$i++)
							{
								if($current_year==$i){
									$sel = 'selected="selected"';
								}else{
									$sel = '';
								}
								echo '<option value='.$i.' '.$sel.'>'.$i.'</option>';
							}
							?>
                        </select> </th>
                    <th><select name="class_id" id="class_id" required class="form-control" onchange="search_student()">
                      <option value="">Select class</option>
                      <?php 
				
				
				foreach($class_list as $class) {?>
                      <option value="<?=$class['id']?>" <?php if($this->input->post('class_id') && $this->input->post('class_id')==$class['id']){ echo 'selected="selected"';}?> >
                      <?=$class['class_name']?>
                      </option>
                      <?php }?>
                    </select></th>
                   <th><select name="class_section_id" id="class_section_id" required class="form-control" onchange="search_student()">
                      <option value="">Select section</option>
                      <?php 
				
				
				foreach($class_section_list as $class_section) {?>
                      <option value="<?=$class_section['id']?>" <?php if($this->input->post('class_section_id') && $this->input->post('class_section_id')==$class_section['id']){ echo 'selected="selected"';}?> >
                      <?=$class_section['section_name']?>
                      </option>
                      <?php }?>
                    </select></th>
                    
                    <th><select name="class_group_id" id="class_group_id" required class="form-control" onchange="search_student()">
                      <option value="">Select Group</option>
                      <?php 
				
				
				foreach($class_group_list as $class_group) {?>
                      <option value="<?=$class_group['id']?>" <?php if($this->input->post('class_group_id') && $this->input->post('class_group_id')==$class_group['id']){ echo 'selected="selected"';}?> >
                      <?=$class_group['group_name']?>
                      </option>
                      <?php }?>
                    </select></th>
                    <th>
                      <input type="text" name="attandance_date"  value="<?php echo isset($results['attandance_date'])? $results['attandance_date']:''?>" class="form-control" placeholder="Attendance Date"   required id="datepicker" onchange="search_student()">
                    </th>
                    </tr>
                    </table>
                </div>
  				<div class="panel-body col-lg-10">
               <div class="message"><? 
			   if($this->session->flashdata('message')){
				   echo $this->session->flashdata('message');
			   }
			   ?></div>
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="position: relative; z-index: 0">
						<thead>
							<tr>
                                 <th style="position: relative; width: 20px">
		  
		  <div class="state icheckbox_square-red hover" style="display:none; border-width: 2px; left: 9px;
    top: 21px;"></div>
                                <input type="checkbox" name="check_all" id="check_all" class="form-control">
                                </th>
								<th  style="width:30px">Roll</th>
							    <th>Name</th>
                                <th style="width:70px">Section</th>
                                <th style="width: 333px">Action</th>
							</tr>
						</thead>
						
                        <tbody id="load_student"> 
                        	<?php 
							
							//echo 'attandance_date'.$this->input->post('attandance_date');
foreach($student_list as $student){
	
?>
<tr>
        <td style="position: relative"><input type="checkbox" name="selected_std[<?=$student['uid']?>]" value="<?=$student['uid']?>" class="selected_std">
        	<div class="state icheckbox_square-red hover" style="display:none;     top: 11px;"></div>
        </td>
        <td><?=$student['roll_no']?></td>
        <td><?=$student['first_name'].' '.$student['last_name']?></td>
        <td><?=$student['section_name']?></td>
        <td>
        <input type="radio" value="Present" name="attendance_type[<?=$student['uid']?>]" id="attendance_type" class="attendance_type" /> Present &nbsp; | &nbsp;
        <input type="radio" value="Absent" name="attendance_type[<?=$student['uid']?>]" id="attendance_type"  class="attendance_type"/> Absent &nbsp; | &nbsp;
        <input type="radio" value="Late" name="attendance_type[<?=$student['uid']?>]" id="attendance_type" class="attendance_type" /> Late &nbsp; | &nbsp;
        <input type="radio" value="Leave" name="attendance_type[<?=$student['uid']?>]" id="attendance_type"  class="attendance_type"/> Leave 
        </td>
        </tr>
<?php }?>
                       
                        </tbody>
                         <tr>
                        	<td colspan="5" style="text-align: right"><input type="submit" name="save" id="save" value="Save" class="btn btn-default" /></td>
                        </tr>
					</table>
  			
                </div>
                	</form>
  			</div>

</div>
</div>
