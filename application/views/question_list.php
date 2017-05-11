 <div class="container">
     <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >
  <script>
function load_subject(){
	var class_id =$('#class_id').val();
	$("#subject_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id,
		url: "<?=base_url().'loading/load_subject'?>",
		success: function(result){
			$("#subject_div_id").html(result);
		}
		
	});
}
function load_chapter(){
	var class_id =$('#class_id').val();
	var subject_id =$('#subject_id').val();
	$("#chapter_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id+'&subject_id='+subject_id,
		url: "<?=base_url().'loading/load_chapter_for_question_1'?>",
		success: function(result){
			$("#chapter_div_id").html(result);
		}
		
	});
}

function load_lesson(){
	var class_id =$('#class_id').val();
	var subject_id =$('#subject_id').val();
	var chapter_id =$('#chapter_id').val();
	$("#lesson_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id+'&subject_id='+subject_id+'&chapter_id='+chapter_id,
		url: "<?=base_url().'loading/load_lession_for_question_1'?>",
		success: function(result){
			$("#lesson_div_id").html(result);
		}
		
	});
}

function load_subject1(){
	var class_id =$('#class_id1').val();
	$("#subject_div_id1").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id,
		url: "<?=base_url().'loading/load_subject1'?>",
		success: function(result){
			$("#subject_div_id1").html(result);
		}
		
	});
}

function load_chapter1(){
	var class_id =$('#class_id1').val();
	var subject_id =$('#subject_id1').val();
	$("#chapter_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id+'&subject_id='+subject_id,
		url: "<?=base_url().'loading/load_chapter1'?>",
		success: function(result){
			$("#chapter_div_id1").html(result);
		}
		
	});
}

function load_lesson1(){
	var class_id =$('#class_id1').val();
	var subject_id =$('#subject_id1').val();
	var chapter_id =$('#chapter_id1').val();
	$("#lesson_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id+'&subject_id='+subject_id+'&chapter_id='+chapter_id,
		url: "<?=base_url().'loading/load_lesson1'?>",
		success: function(result){
			$("#lession_div_id1").html(result);
		}
		
	});
}

</script>
 <?php
$abc=array(
'0'=>'ক',
'1'=>'খ',
'2'=>'গ',
'3'=>'ঘ',
'4'=>'ঙ',
'6'=>'চ',
'7'=>'ছ',
'8'=>'জ',
'9'=>'ঝ',
'10'=>'ঞ',
'11'=>'য'
);
?>  
 <h3><?php echo $title;?></h3>
    <div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('qbank/index/');?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
	 
	  
    </div><!-- /input-group -->
	 </form>
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->


  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
						<div class="form-group">	 
					<form method="post" action="<?php echo site_url('qbank/pre_question_list/'.$limit.'/'.$cid.'/'.$lid);?>">
               
               <table>
               	<tr><td>
                <select name="class_id" id="class_id" onchange="load_subject()"  class="form-control">
                <option value="">Select Class</option>
               
                <?php 
				
				foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>"  <?php if(isset($class_id) && $class_id==$class['id']){ echo 'selected="selected"';} ?>>
                <?=$class['class_name']?>
                </option>
                <?php }?>
              </select></td>
               <td  id="subject_div_id">
					<select   name="subject_id" id="subject_id" class="form-control" onchange="load_chapter()">
					<option value="0"><?php echo $this->lang->line('all_category');?></option>
                     <?php 
				if(isset($class_id)){ 
					$CI = &get_instance();
					$CI->load->model('qbank_model');
					$category_list = $CI->qbank_model->get_subject_by_class_id($class_id);
				}
				?>
                
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>" <?php if($val['cid']==$cid){ echo 'selected';} ?> ><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					</select>
			 	</td>
                <td  id="chapter_div_id">
                  <?php if(isset($chapter_id)){
			$CI = &get_instance();
			$CI->load->model('qbank_model');
		    $chapters = $CI->qbank_model->get_chapter_by_subject_id($class_id,$cid);
			
			?>
         <select name="chapter_id" id="chapter_id" class="form-control" onchange="load_lesson()"><option value="">Select</option>
		<?php foreach($chapters as $chapter_load){?>
        	<option value="<?=$chapter_load['id']?>" <?php if(isset($chapter_id) && $chapter_id==$chapter_load['id']){ echo 'selected="selected"';} ?> ><?=$chapter_load['chapter_name']?></option>
		 <?php }?>
		</select>
        
            <? 
			 } else{ }?>
                </td>
                <td  id="lesson_div_id">
                
                <?php if(isset($lession_id)){
			$CI = &get_instance();
			$CI->load->model('qbank_model');
		    $lessions = $CI->qbank_model->get_lesson_by_chapter_id($class_id,$cid, $chapter_id);
			
			?>
         <select name="lession_id" id="lession_id" class="form-control" ><option value="">Select</option>
		<?php foreach($lessions as $lesson_load){?>
        	<option value="<?=$lesson_load['id']?>" <?php if(isset($lession_id) && $lession_id==$lesson_load['id']){ echo 'selected="selected"';} ?> ><?=$lesson_load['lession_name']?></option>
		 <?php }?>
		</select>
        
            <? 
			 } else{ }?>
                </td>
                
                
                <td><select  name="lid" class="form-control">
				<option value="0"><?php echo $this->lang->line('all_level');?></option>
					<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>"  <?php if($val['lid']==$lid){ echo 'selected';} ?> ><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select></td>
                    <td> <button class="btn btn-default" type="submit"><?php echo $this->lang->line('filter');?></button></td>
              </tr>
               </table>     
               
              
              
                
					
					 </form>
			</div>
	
<table class="table table-bordered">
<tr>
 <th>#</th>
 <th><?php echo $this->lang->line('question');?></th>
<th><?php echo $this->lang->line('question_type');?></th>
<th>Class</th>
<th><?php echo $this->lang->line('category_name');?> / <?php echo $this->lang->line('level_name');?></th>
 
<th><?php echo $this->lang->line('percent_corrected');?></th>
<th><?php echo $this->lang->line('action');?> </th>
</tr>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($result as $key => $val){
?>
<tr>
 <td>  <a href="javascript:show_question_stat('<?php echo $val['qid'];?>');">+</a>  <?php echo $val['qid'];?></td>
 <td><?php /*echo substr(strip_tags($val['question']),0,40);*/  echo $val['question'];
 
				$CI = &get_instance();
				$CI->load->model('Quiz_model');
				$res_option = $CI->Quiz_model->get_options($val['qid']);
				$k=0;
				foreach($res_option as $ok => $option){
 ?>
 
 	<p style="padding: 0 0 0 9px; margin: 0">
                                <?php echo $abc[$k++];?>) <?php echo $option['q_option'];?>
                                
                                </p>
                            <?php }?>
 <span style="display:none;" id="stat-<?php echo $val['qid'];?>">
  
 
 <table class="table table-bordered">
<tr><td><?php echo $this->lang->line('no_times_corrected');?></td><td><?php echo $val['no_time_corrected'];?></td></tr>
<tr><td><?php echo $this->lang->line('no_times_incorrected');?></td><td><?php echo $val['no_time_incorrected'];?></td></tr>
<tr><td><?php echo $this->lang->line('no_times_unattempted');?></td><td><?php echo $val['no_time_unattempted'];?></td></tr>

</table>


 

 </span>
 
 
 
 </td>
<td><?php echo $val['question_type'];?></td>
<td><?php echo $val['class_name'];?></td>
<td><?php echo $val['category_name'];?> / <span style="font-size:12px;"><?php echo $val['level_name'];?></span></td>
 
<td><?php if($val['no_time_served']!='0'){ $perc=($val['no_time_corrected']/$val['no_time_served'])*100; 
?>

<div style="background:#eeeeee;width:100%;height:10px;"> <div style="background:#449d44;width:<?php echo intval($perc);?>%;height:10px;"></div></div>
<span style="font-size:10px;"><?php echo intval($perc);?>%</span>

<?php
}else{ echo $this->lang->line('not_used');} ?></td>

<td>
<?php 
$qn=1;
if($val['question_type']==$this->lang->line('multiple_choice_single_answer')){
	$qn=1;
}
if($val['question_type']==$this->lang->line('multiple_choice_multiple_answer')){
	$qn=2;
}
if($val['question_type']==$this->lang->line('match_the_column')){
	$qn=3;
}
if($val['question_type']==$this->lang->line('short_answer')){
	$qn=4;
}
if($val['question_type']==$this->lang->line('long_answer')){
	$qn=5;
}


?>
<a href="<?php echo site_url('qbank/edit_question_'.$qn.'/'.$val['qid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<a href="javascript:remove_entry('qbank/remove_question/<?php echo $val['qid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>

</td>
</tr>

<?php 
}
?>
</table>
</div>

</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('qbank/index/'.$back.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('qbank/index/'.$next.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>







<br><br><br><br>
<div class="login-panel panel panel-default">
		<div class="panel-body"> 

<?php echo form_open('qbank/import',array('enctype'=>'multipart/form-data')); ?>
 <h4><?php echo $this->lang->line('import_question');?></h4> 
 
 <select name="class_id1" id="class_id1" onchange="load_subject1()">
                <option value="">Select Class</option>
               
                <?php 
				
				foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>"  <?php if(isset($class_id) && $class_id==$class['id']){ echo 'selected="selected"';} ?>>
                <?=$class['class_name']?>
                </option>
                <?php }?>
              </select>
              <span id="subject_div_id1"></span>
              <span id="chapter_div_id1"></span>
              <span id="lession_div_id1"></span>
              
 <!--<select name="cid"   >
 <option value="0"><?php echo $this->lang->line('select_category');?></option>
<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>" <?php if($val['cid']==$cid){ echo 'selected';} ?> ><?php echo $val['category_name'];?></option>
						<?php 
					}
					?></select>-->
 <select name="did"  >
 <option value="0"><?php echo $this->lang->line('select_level');?></option>
<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>"  <?php if($val['lid']==$lid){ echo 'selected';} ?> ><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select> 

<?php echo $this->lang->line('upload_excel');?>
	<input type="hidden" name="size" value="3500000">
	<input type="file" name="xlsfile" style="width:150px;float:left;margin-left:10px;">
	<div style="clear:both;"></div>
	<input type="submit" value="Import" style="margin-top:5px;" class="btn btn-default">
	
<a href="<?php echo base_url();?>sample/sample.xls" target="new">Click here</a> <?php echo $this->lang->line('upload_excel_info');?> 
</form>

</div>
</div>


</div>
</div>
</div>

<br><br><br><br>