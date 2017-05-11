                
<style>
.mceItemTable, .mceItemTable td, .mceItemTable th, .mceItemTable caption, .mceItemVisualAid{
	border: 1px dashed #fff !important;
}
.mce-item-table td{
	border: none !important;
	
}
table td{
	border: none !important;
}

</style>
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
 <div class="container">
  <div class="row">
    <section class="wrapper">
      <div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title"><?=$title?> </div>
				</div>
  				<div class="panel-body">
                <style>
				td{
					border: none !important;}
					
					.newspaper {
    -webkit-column-count: 3; /* Chrome, Safari, Opera */
    -moz-column-count: 3; /* Firefox */
    column-count: 3;
}
				</style>
                <form action="<?=base_url().'exam/submit/'.$resultExam['quid'];?>" name="frmEXam" id="frmEXam" method="post">
                <?php if(!empty($resultExam['full_question_pattern'])){ ?>
                <textarea class="form-control" name="full_question_pattern" id="content" style="height:600px">
                <?=$resultExam['full_question_pattern']?>
                </textarea>
				<? } else{?>
  					<textarea class="form-control" name="full_question_pattern" id="content" style="height:600px">
                    	<table width="100%" cellpadding="0" cellspacing="2" border="0" style="border: none" >
                        	<tr><td align="center" valign="middle" colspan="3" style="border: none"><?=$schoolInfo['group_name']?> <?=$resultExam['quiz_name']?></td></tr>
                            <tr><td align="left" width="20%" style="border: none">Total : 2 hours</td><td align="center" valign="middle" style="border: none"><?=$subjectList['category_name']?></td><td align="right" width="20%" style="border: none">Total Marks : <?=$resultExam['exam_total_marks']?></td></tr>
                            <tr><td align="center" valign="middle" colspan="3" style="border: none">[N.B.- The Figures in the right margin indicate full marks]</td></tr>
                        </table>
                        <p>&nbsp;</p>
                        <table width="100%" cellpadding="0" cellspacing="2" border="0" style="border: none">
                        <?php 
						$i=1;
						
						if($subjectList['category_name'] == 'English 1st Paper' || $subjectList['category_name'] == 'English 2nd Paper' ){ 
                        
                        
                        foreach($resultQuestion as $allQuestion){ ?>
                       		<tr><td align="left" width="3%" valign="top" style="border: none">
							<?php 
							 $bn_digits=array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
echo $output = str_replace(range(0, 9),$bn_digits, $i); 
$i++;
							?>
							</td><td align="left" style="border: none"><?=$allQuestion['question_type']?></td><td align="right" width="3%" style="border: none">0.5X6=3</td></tr>
                        	<tr><td style=" padding-bottom: 5px; border: none">&nbsp;</td><td colspan="2"  style=" padding-bottom: 5px; border: none">
							
							<?=$allQuestion['question']?>
                            
                            </td></tr>
						<?php }?>
                        
                        
                        <?
						} else{
						foreach($resultQuestion as $allQuestion){ ?>
                       		<tr><td align="left" width="3%" valign="top"  style=" padding-bottom: 5px; border: none">
							
                            <?php 
							//echo $allQuestion['question_type'];
							
							 $bn_digits=array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
echo $output = str_replace(range(0, 9),$bn_digits, $i); 
$i++;
							?>
							</td>
                            <?php  if($allQuestion['question_type']==$this->lang->line('short_answer') || $allQuestion['question_type']==$this->lang->line('long_answer')){ ?>
                            <td align="left"  style=" padding-bottom: 5px; border: none"><?=$allQuestion['question']?></td>
                            <?php }else{ ?>
                            <td align="left"  style=" padding-bottom: 5px; border: none">
                            
                                <div class="newspaper">
                                  <?=$allQuestion['question']?>
							<?php 
							$CI = &get_instance();
							$CI->load->model('Quiz_model');
							$res_option = $CI->Quiz_model->get_options($allQuestion['qid']);
							$k=0;
							foreach($res_option as $ok => $option){
							?>
                            	<p style="padding: 0 0 0 9px; margin: 0">
                                <?php echo $abc[$k++];?>) <?php echo $option['q_option'];?>
                                
                                </p>
                            <?php }?>
                                </div>
                          
							</td>
                            <?php }?>
                            </tr>
                        	
						<?php }
						
						}?>
                        
                        </table>
                    </textarea>
                    <?php }?>
                    <br/>
                    <input type="submit" name="submit" value="Generate Exam Paper" class="btn btn-success" />
                    </form>
  				</div>
  			</div>
            


  
</section>
</div>