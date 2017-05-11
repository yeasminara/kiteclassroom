 <div class="container">
  <script>
 $(function() {
  var height = $('#lists').height();
 
 $("#sub_menu").css("min-height",height+"px");
});
 </script>
  <!--<div class="col-md-3 panel login-panel" style="background: #fff; padding-top: 15px;" id="sub_menu">
    <?php 
	
	$CI =& get_instance();
	$CI->load->helper('site_helper');
	$urimenu = $this->uri->segment(1);
	$menus_split = explode("_", $urimenu);
	if(isset($menus_split['1'])){
		  $menu_module = $menus_split['0'].' '.$menus_split['1'];
	}else{
		
		 $menu_module =  $menus_split['0'];
	}
	$sub_menus = get_menu_by_module($menu_module);
	//print_r($sub_menus);
	
	//$menus_split = explode(" ", $menu['module']);
	
						
	?>
    <ul>
      <?php foreach($sub_menus as $sub_menu) {
			 if(strpos($sub_menu['page_group_url'], 'index')){
				 $url = substr($sub_menu['page_group_url'],0 ,-6);
			 }else{
				 $url = $sub_menu['page_group_url'];
			 }
			
			?>
      <li><a class="" href="<?=base_url().$sub_menu['page_group_url']?>">
        <?=$sub_menu['page_group_name']?>
        </a></li>
      <?php }?>
    </ul>
  </div>-->
  
    <div class="col-md-9">
    <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >
   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('qbank/pre_new_question/');?>">
	
<div class="col-md-12">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		
		
		
				<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_question_type');?></label> 
					<select class="form-control" name="question_type" onChange="hidenop(this.value);">
						<option value="1"><?php echo $this->lang->line('multiple_choice_single_answer');?></option>
						<option value="2"><?php echo $this->lang->line('multiple_choice_multiple_answer');?></option>
						<option value="3"><?php echo $this->lang->line('match_the_column');?></option>
						<option value="4"><?php echo $this->lang->line('short_answer');?></option>
						<option value="5"><?php echo $this->lang->line('long_answer');?></option>
					
					</select>
			</div>

			<div class="form-group" id="nop" >	 
					<label for="inputEmail"  ><?php echo $this->lang->line('nop');?></label> 
					<input type="text"   name="nop"  class="form-control" value="4"   >
			</div>

<div class="form-group">
<?php 
$this->db->order_by('qid', 'DESC');
$query = $this->db->get('savsoft_qbank');
$res = $query->row_array();
if(isset($res['question_code'])){
	$code = $res['question_code']+1;
}else{
	$code = '10001';
}
//echo $code;
?>
              <label>Question Code (Last Entry Code: <?=$res['question_code']?>. Please enter <?=$code?>, if it is new question.  )</label>
              <input type="text" value="" name="question_code" id="question_code" class="form-control"  />
            </div>
 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('next');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 
</div></div></div>


</div>