<script type="text/javascript" src="<?=base_url()?>js/angular.min.js"></script>
 <style>
@media print {
   
   .navbar{
   display:none;
   }
   #footer{
   display:none;
   } 
   .printbtn{
	  display:none; 
   }
   #social_share{
	   display:none;
   }
   #page_break2{
	   
   page-break-after: always;
	}
	

}
 td{
		font-size:14px;
		padding:4px;
	}
	
	
</style>
<script>
function sumCategoryMarks(){
		//var maxField = <?php //echo $totalGlobalCourses;?>; //Input fields increment limitation
		var sum = 0;
		var sum1 = 0;
		var maxField=5;

		$(".question").each(function(){
        	sum += +$(this).val();
        });
	 //$(".total").val(sum);	
	 $('#examFullMarks').val(sum);
	}
	
	 function checkMarksInput(questionID, categoryID, maxMarks){
	  var insertedMark = $('#knowledge_'+questionID+categoryID).val();
	  if(maxMarks < insertedMark) {
		  var str = "Exit Out of Exam Marks";
          alert(str);
		  $('#knowledge_'+questionID+categoryID).val('');
		  return;
	  }   
	 
	 }
	 
</script>
 <div class="container">
<?php 
$logged_in=$this->session->userdata('logged_in');
$result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array();
?>
   
 <h3><?php echo $title;?></h3>
   
 
<a href="javascript:print();" class="btn btn-success printbtn"><?php echo $this->lang->line('print');?></a>

<?php
if($result['gen_certificate']=='1'){
?>
<a href="<?php echo site_url('result/generate_certificate/'.$result['rid']);?>" class="btn btn-warning printbtn"><?php echo $this->lang->line('download_certificate');?></a>
	
<?php
}
?>
  <div class="row">
     
<div class="col-md-12">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
		 
<table class="table table-bordered">
<?php 
if($result['camera_req']=='1'){
	?>
<tr><td colspan='2'> <?php if($result['photo']!=''){ ?> <img src ="<?php echo base_url('photo/'.$result['photo']);?>" id="photograph" ><?php } ?></td></tr>
	
	<?php 
}
?>
<tr><td><?php echo $this->lang->line('first_name');?></td><td><?php echo $result['first_name'];?></td></tr>
<tr><td><?php echo $this->lang->line('last_name');?></td><td><?php echo $result['last_name'];?></td></tr>
<tr><td><?php echo $this->lang->line('email');?></td><td><?php echo $result['email'];?></td></tr>
<tr><td><?php echo $this->lang->line('quiz_name');?></td><td><?php echo $result['quiz_name'];?></td></tr>
<tr><td><?php echo $this->lang->line('attempt_time');?></td><td><?php echo date('Y-m-d H:i:s',$result['start_time']);?></td></tr>
<tr><td><?php echo $this->lang->line('time_spent');?></td><td><?php echo intval($result['total_time']/60);?></td></tr>
<tr><td><?php echo 'Exam Total Marks ';?></td><td><?php echo $result['exam_total_marks'];?></td></tr>
<tr><td><?php echo $this->lang->line('score_obtained');?></td><td><?php echo $result['score_obtained'];?></td></tr>
<tr><td><?php echo $this->lang->line('percentage_obtained');?></td><td><?php if(!empty($result['score_obtained'])) {echo $result['percentage_obtained'].'%.'; }?></td></tr>

<tr><td><?php echo $this->lang->line('status');?></td><td><?php echo $result['result_status'];?></td></tr>

</table>
  
 
		</div>
</div>
<br>


<?php
 
 
  
if($this->config->item('google_chart') == true ){ 
?>


<!-- google chart starts -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $value;?>);

        var options = {
          title: '<?php echo $this->lang->line('top_10_result');?> <?php echo $result['quiz_name'];?>',
          hAxis: {title: '<?php echo $this->lang->line('quiz');?>(<?php echo $this->lang->line('user');?>)', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
		 <div id="chart_div" style="width: 800px; height: 500px;"></div>
<!-- google chart ends -->


<!-- google chart starts -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $qtime;?>);

        var options = {
          title: '<?php echo $this->lang->line('time_spent_on_ind');?>'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
	  
	  
	  
    </script>
		 <div id="chart_div2" style="width:800px; height: 500px;"></div>
<!-- google chart ends -->




 

<?php 
}

$ind_score=explode(',',$result['score_individual']); 


		 //print_r($logged_in);
		 
		 
// view answer
if($result['view_answer']=='1' || $result_role['role_type']!='user'){
	
?>

<div class="login-panel panel panel-default">
		<div class="panel-body"> 
<h3><?php echo $this->lang->line('answer_sheet');?></h3>

<form action="<?=base_url().'result/assign_score/'.$result['rid']?>" method="post" >

        <table width="100%" cellpadding="0" cellspacing="0" class="table table-bordered" >
             	<thead>
                	<tr>
                    	<th>
                        Questions</th>
                        <th>Written Answer</th>
                        <th>Marks Distribution</th>
                        <th>Obtained marks</th>
                    </tr>
             </thead>
             
             <tbody>
            
             
<?php 
$abc=array(
'0'=>'A',
'1'=>'B',
'2'=>'C',
'3'=>'D',
'4'=>'E',
'6'=>'F',
'7'=>'G',
'8'=>'H',
'9'=>'I',
'10'=>'J',
'11'=>'K'
);
foreach($questions as $qk => $question){
	
?>

<tr id="q<?php echo $qk;?>" class="" style="<?php if($ind_score[$qk]=='1'){ ?>background-color:#e3f8da;<?php }else if($ind_score[$qk]=='2'){ ?>background-color:#ffe1cb;<?php }else if($ind_score[$qk]=='3'){ ?>background-color:#fdfbcf;<?php }else{ ?>background-color:#ffffff;<?php } ?>">
    <td width="50%">
    <input type="hidden" name="question_id[<?php echo $question['qid'];?>]" id="question_id" value="<?php echo $question['qid'];?>" />
    
		 <?php echo '<b>'.$this->lang->line('question');?> <?php echo $qk+1;?>)</b><br>
		 <?php echo $question['question'];?>

		 <?php if($question['description']!='') {
			 echo '<hr>';
			echo '<b>'.$this->lang->line('description').'</b><br>';
			echo $question['description'];
		 }
		 ?> 
		 </td>
    <td><div style="padding:10px;" >
		 <?php
		 
		
		 // multiple single choice
		 if($question['question_type']==$this->lang->line('multiple_choice_single_answer')){
			 
			 			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="1">
			 <?php
			$i=0;
			$correct_options=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					if($option['score'] >= 0.1){
						$correct_options[]=$option['q_option'];
					}
			?>
			 
		<div class="op"><?php echo $abc[$i];?>) <input type="radio" name="answer[<?php echo $qk;?>][]"  id="answer_value<?php echo $qk.'-'.$i;?>" value="<?php echo $option['oid'];?>"   <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?>  > <?php echo $option['q_option'];?> </div>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			echo "<br>".$this->lang->line('correct_options').': '.implode(', ',$correct_options);
		 }
			
// multiple_choice_multiple_answer	

		 if($question['question_type']==$this->lang->line('multiple_choice_multiple_answer')){
			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="2">
			 <?php
			$i=0;
			$correct_options=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
						if($option['score'] >= 0.1){
						$correct_options[]=$option['q_option'];
					}
			?>
			 
		<div class="op"><?php echo $abc[$i];?>) <input type="checkbox" name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk.'-'.$i;?>"   value="<?php echo $option['oid'];?>"  <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?> > <?php echo $option['q_option'];?> </div>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			echo "<br>".$this->lang->line('correct_options').': '.implode(', ',$correct_options);
		 }
			 
	// short answer	

		 if($question['question_type']==$this->lang->line('short_answer')){
			 			 $save_ans="";
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans=$saved_answer['q_option'];
				 }
			 }
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="3"   >
			 
			 <?php

			 
			
			 ?>
			 
		<div class="op"> 
		<?php echo $this->lang->line('your_answer');?> 
		<input type="text" name="answer[<?php echo $qk;?>][]" value="<?php echo $save_ans;?>" id="answer_value<?php echo $qk;?>"   >  
		</div>
			 
			 
			 <?php 
			 			 foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					 echo "<br>".$this->lang->line('correct_answer').': '.$option['q_option'];
			 }
			 }
			 
		 }
		 
		 
		 	// long answer	

		 if($question['question_type']==$this->lang->line('long_answer')){
			 $save_ans="";
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans=$saved_answer['q_option'];
				 }
			 }
			 ?>
             
			 <input type="hidden"  name="question_type[]" id="q_type<?php echo $qk;?>" value="4">
			 <?php
			 ?>
			 
		<div class="op"> 
		<?php echo $this->lang->line('answer');?> <br>
		<?php echo $this->lang->line('word_counts');?>  <?php echo str_word_count($save_ans);?>
		<textarea name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk;?>" style="width:100%;height:100%;" onKeyup="count_char(this.value,'char_count<?php echo $qk;?>');" readonly="readonly"><?php echo $save_ans;?></textarea>
		</div>
		
			 
			 <?php 
			 
			 
		 }
			 
		
		
		
		
		
		
		// matching	

		 if($question['question_type']==$this->lang->line('match_the_column')){
			 			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					// $exp_match=explode('__',$saved_answer['q_option_match']);
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 
			 ?>
			 <input type="hidden" name="question_type[]" id="q_type<?php echo $qk;?>" value="5">
			 <?php
			$i=0;
			$match_1=array();
			$match_2=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					$match_1[]=$option['q_option'];
					$match_2[]=$option['q_option_match'];
			?>
			 
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			?>
			<div class="op">
						<table>
						<tr><td></td><td><?php echo $this->lang->line('your_answer');?></td><td><?php echo $this->lang->line('correct_answer');?></td></tr>
						<?php 
			 
			foreach($match_1 as $mk1 =>$mval){
						?>
						<tr><td>
						<?php echo $abc[$mk1];?>)  <?php echo $mval;?> 
						</td>
						<td>
						
							<select name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk.'-'.$mk1;?>"  >
							<option value="0"><?php echo $this->lang->line('select');?></option>
							<?php 
							foreach($match_2 as $mk2 =>$mval2){
								?>
								<option value="<?php echo $mval.'___'.$mval2;?>"  <?php $m1=$mval.'___'.$mval2; if(in_array($m1,$save_ans)){ echo 'selected'; } ?> ><?php echo $mval2;?></option>
								<?php 
							}
							?>
							</select>

						</td>
						
						<td>
						<?php 
							echo $match_2[$mk1];
							?>
						</td>
						
						</tr>
				
						
						<?php 
			}
			
			
			?>
			</table>
			 </div>
			<?php
			
		 }
			
		 ?>

		</div>
        
        </td>
        
        <?php 
	if($question['question_type']==$this->lang->line('multiple_choice_single_answer') || $question['question_type']==$this->lang->line('multiple_choice_multiple_answer')  || $question['question_type']==$this->lang->line('multiple_choice_multiple_answer')){ ?>
		
		<td><?=$result['correct_score']?></td>
        <td><? if($ind_score[$qk] ==1){ echo 1;} else{ echo 0;}?></td>
	<? } else{
		
		
			if($ind_score[$qk]=='3' && $result_role['role_type']!='user'){
	?>
    <td>	<?php 
		
			
		?>
		<!--<div id="assign_score<?php echo $qk;?>">
		<?php echo $this->lang->line('evaluate');?>	
		<a href="javascript:assign_score('<?php echo $result['rid'];?>','<?php echo $qk;?>','1');"  class="btn btn-success" ><?php echo $this->lang->line('correct');?></a>	
		<a href="javascript:assign_score('<?php echo $result['rid'];?>','<?php echo $qk;?>','2');"  class="btn btn-danger" ><?php echo $this->lang->line('incorrect');?></a>	
		</div>-->
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr><td>Knowledge </td><td> 1</td></tr>
            <tr><td>Comprehensive </td><td> 2</td></tr>
            <tr><td>Application </td><td> 3</td></tr>
            <tr><td>Higher Order Thinking </td><td> 4</td></tr>
        </table>
        
			</td>
    <td>
  
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr><td>Knowledge </td><td> <input type="text" value="" name="knowledge[<?php echo $question['qid'];?>]" id="knowledge_<?php echo $question['qid'];?>1" style="width: 34px;"  onKeyUp="sumCategoryMarks(); checkMarksInput(<?php echo $question['qid'];?>,1,1);" class="question"/></td></tr>
            <tr><td>Comprehensive </td><td> <input type="text" value="" name="comprehensive[<?php echo $question['qid'];?>]" id="knowledge_<?php echo $question['qid'];?>2" style="width: 34px;" onKeyUp="sumCategoryMarks();checkMarksInput(<?php echo $question['qid'];?>,2,2);"  class="question"/></td></tr>
            <tr><td>Application </td><td> <input type="text" value="" name="application[<?php echo $question['qid'];?>]" id="knowledge_<?php echo $question['qid'];?>3" style="width: 34px;" onKeyUp="sumCategoryMarks();checkMarksInput(<?php echo $question['qid'];?>,3,3);"  class="question"/></td></tr>
            <tr><td>Higher Order Thinking </td><td> <input type="text" value="" name="higher_order[<?php echo $question['qid'];?>]" id="knowledge_<?php echo $question['qid'];?>4" style="width: 34px;" onKeyUp="sumCategoryMarks();checkMarksInput(<?php echo $question['qid'];?>,4,4);"  class="question"/></td></tr>
        </table>
        </td>
       
   <?php 
			} else{ 
			
			//print_r($result);
			$questionId = $question['qid'];
			$resultID = $result['rid'];
			$userID = $result['uid'];
			$quizID = $result['quid'];
			$where = "result_id = $resultID and quiz_id = $quizID and question_id = $questionId";
			
			$result_details = $this->db->where($where)->get('savsoft_result_deatils')->row_array();
			//echo $this->db->last_query();
			?>
           <td>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered">
        	<tr><td>Knowledge </td><td> 1</td></tr>
            <tr><td>Comprehensive </td><td> 2</td></tr>
            <tr><td>Application </td><td> 3</td></tr>
            <tr><td>Higher Order Thinking </td><td> 4</td></tr>
        </table>
        
			</td>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered">
        	<tr><td>Knowledge </td><td> <?=isset($result_details['obtain_knowledge_marks']) ? $result_details['obtain_knowledge_marks']:''?> </td></tr>
            <tr><td>Comprehensive </td><td><?=isset($result_details['obtain_comprehensive_marks']) ? $result_details['obtain_comprehensive_marks']:''?> </td></tr>
            <tr><td>Application </td><td><?=isset($result_details['obtain_application_marks']) ? $result_details['obtain_application_marks']:''?> </td></tr>
            <tr><td>Higher Order Thinking </td><td><?=isset($result_details['obtain_higher_order_thinking_marks']) ? $result_details['obtain_higher_order_thinking_marks']:''?></td></tr>
        </table></td>
            <?php
			}
		}
		?>
</tr>

 <?php if($result_role['role_type']!='user' && ($question['question_type']==$this->lang->line('long_answer') || $question['question_type']==$this->lang->line('short_answer'))){ ?>
 
<!-- <tr>
 	<td colspan="2" align="right"> Total Marks : </td>
    <td><?=$result['correct_score']?></td>
    <td></td>
 </tr>-->
 <?php
	}
	
	?>
 <?php
}
if($ind_score[$qk]=='3' && ($question['question_type']==$this->lang->line('long_answer') || $question['question_type']==$this->lang->line('short_answer'))){
?>
<tr>
<td colspan="2" align="right"> Total Obtained Marks : </td>
    <td><?=$result['exam_total_marks']?></td>
    <td><input type="text"  id="examFullMarks" name="obtained_score" value=""  style="  padding: 2px; text-align:right" class="form-control"/></td>
</tr>
<tr> <td colspan="3"><input type="submit" name="submit" value="Submit" /></td></tr>
<?php }?>
 </tbody> 
  
 </table>
</form>
</div>
</div>
<?php 
}
// view answer ends
?>





 
 
 
 
</div>
      
</div>

 



</div>

<input type="hidden" id="evaluate_warning" value="<?php echo $this->lang->line('evaluate_warning');?>">
 