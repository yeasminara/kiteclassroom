<?php 
foreach($student_list as $student){
	
	//$CI = &get_instance();
	//$CI->load->model('attendance_model');
	
	
	$get_student_attendance = get_student_attendance($student['uid'], $student['gid'],$academic_year,$class_id,$class_section_id,$class_group_id,$attandance_date);
	print_r($get_student_attendance);
	
?>
<tr>
        <td style="position: relative"><input type="checkbox" name="selected_std[<?=$student['uid']?>]" value="<?=$student['uid']?>" class="selected_std">
        	<div class="state icheckbox_square-red hover" style="display:none;     top: 11px;"></div>
            
            <input type="hidden" name="attandence_id" id="attandence_id" value="<?=isset($get_student_attendance['id']) ? $get_student_attendance['id']:''?>" />
        </td>
        <td><?=$student['roll_no']?></td>
        <td><?=$student['first_name'].' '.$student['last_name']?></td>
        <td><?=$student['section_name']?></td>
        <td><input type="radio" value="Present" name="attendance_type[<?=$student['uid']?>]" id="attendance_type" class="attendance_type" <?php if($get_student_attendance['attendance_type'] and $get_student_attendance['attendance_type']=='Present') {?> checked="checked"<?php }?> /> Present &nbsp; | &nbsp;
        <input type="radio" value="Absent" name="attendance_type[<?=$student['uid']?>]" id="attendance_type" class="attendance_type" <?php if($get_student_attendance['attendance_type'] and $get_student_attendance['attendance_type']=='Absent') {?> checked="checked"<?php }?> /> Absent &nbsp; | &nbsp;
        <input type="radio" value="Late" name="attendance_type[<?=$student['uid']?>]" id="attendance_type" class="attendance_type" <?php if($get_student_attendance['attendance_type'] and $get_student_attendance['attendance_type']=='Late') {?> checked="checked"<?php }?> /> Late &nbsp; | &nbsp;
        <input type="radio" value="Leave" name="attendance_type[<?=$student['uid']?>]" id="attendance_type" class="attendance_type" <?php if($get_student_attendance['attendance_type'] and $get_student_attendance['attendance_type']=='Leave') {?> checked="checked"<?php }?> /> Leave </td>
        </tr>
<?php }?>