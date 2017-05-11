
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
  <div class="col-md-12"  id="lists">
    <div class="login-panel panel panel-default">
      <div class="panel-body">
<?php 
$logged_in=$this->session->userdata('logged_in');
?>
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

    function delete_c(id){
	 var r=confirm("Do you want to delete?");
	   if (r==true)
		  {
			
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>class_content/delete/',
                data:'&deleteId='+id,
                success: function(data){
                            alert("Row deleted");
							location.reload();
                    
                    }

                })
					
			 
		  }
		else
		  {
			 //return false;
		  }
 }
</script>
   

    <div class="row">
 
  <!--<div class="col-lg-6">
    <form method="post" action="<?php echo site_url('qbank/index/');?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
	 
	  
    </div>
	 </form>
  </div>-->
</div>


  <div class="row">
 
<div class="col-md-12">

	 <h3><?php echo $title;?>  <a class="btn btn-default" href="<?=base_url().'class_content/add_content'?>">Add Smart Classroom Content</a></h3> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	


<div class="form-group">	 
					<form method="post" action="<?php echo site_url('class_content/content_list/'.$limit.'/'.$cid.'/'.$lid);?>">
               
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
                
                
            
                    <td> <button class="btn btn-default" type="submit"><?php echo $this->lang->line('filter');?></button></td>
              </tr>
               </table>     
               
              
              
                
					
					 </form>
			</div>

<table class="table table-bordered">
<tr>
 <th>#</th>
 <th><?php echo 'Content title'?></th>
<th>Class</th>
 <th>Subject</th>
 <th>Chapter</th>
 <th>Lesson</th>
 <th>Created BY </th>
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
$i=1;

if($limit>0){
	$i=$i+$limit;	
}else{
	$i=1;
}


//echo '$i'.$i;
foreach($result as $key => $val){


?>
<tr>
 <td> <?=$i++?></td>
 <td><?php /*echo substr(strip_tags($val['question']),0,40);*/  echo $val['title'];?></td>
<td nowrap="nowrap"><?php echo $val['class_name'];?></td>
<td nowrap="nowrap"><?php echo $val['category_name'];?></td>
<td><?php echo $val['chapter_name'];?></td>
<td><?php echo $val['lesson_name'];?></td>
<td><?php echo $val['first_name'].' '.$val['last_name'];?></td>
 <td nowrap="nowrap"> 
 <a href="<?php echo site_url('loading/view_content/'.$val['id']);?>" title="View"><img src="<?php echo base_url('images/view.png');?>" alt="Details" width="20"></a>
 <?php
    $result_role = $this->db->where('status','1')->where('id',$logged_in['su'])->get('savsoft_roles')->row_array(); 
	$this->db->where('user_id',$logged_in['uid']);
	$this->db->where('id',$val['id']);
	
	$query=$this->db->get('savsoft_smart_class_content');
	if($result_role['role_type']=='administrator' || $result_role['role_type']=='superadmin'){
		$content_found=1;
	}else{
		$content_found = $query->num_rows();
	}
	if($content_found>0){ ?>
    
        <a href="<?php echo site_url('class_content/edit_content/'.$val['id']);?>" title="Edit"><img src="<?php echo base_url('images/edit.png');?>"  alt="Edit"></a>
    <a href="javascript:delete_c('<?php echo $val['id'];?>');" title="Delete"><img src="<?php echo base_url('images/cross.png');?>" alt="Delete"></a>
    <?php
	}
 ?>



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

<a href="<?php echo site_url('class_content/content_list/'.$back.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('class_content/content_list/'.$next.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>



</div>
</div>
</div>


</div>

