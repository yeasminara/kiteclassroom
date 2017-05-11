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
   
 <h3><?php echo $title;?></h3>
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

			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	

	
<table class="table table-bordered">
<tr>
 <th>#</th>
 <th><?php echo 'Content title'?></th>
<th>Class</th>
 <th>Subject</th>
 <th>User Name</th>
<th><?php echo 'Date';?></th>
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
foreach($result as $key => $val){
?>
<tr>
 <td> <?=$i++?></td>
 <td><?php /*echo substr(strip_tags($val['question']),0,40);*/  echo $val['title'];?></td>
<td><?php echo $val['class_name'];?></td>
<td><?php echo $val['category_name'];?></td>
<td><?php echo $val['first_name'].' '.$val['last_name'];?></td>
 <td><?php echo date('d-m-Y',strtotime($val['class_time_date']));?></td>


<td>

<?php 
if($logged_in['su']=='1' || $logged_in['su']=='2' || $logged_in['su']=='3'){
	 $this->db->where('user_id',$logged_in['uid']);
	$this->db->where('id',$val['id']);
	$query=$this->db->get('savsoft_content');
	$content_found = $query->num_rows();
	if($content_found>0){
	?>
			
<a href="<?php echo site_url('class_content/update_permission/'.$val['scpid']);?>" class="btn btn-default">Send Permission</a>


<?php 
	}
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

<a href="<?php echo site_url('class_content/index/'.$back.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('class_content/index/'.$next.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>


</div>
</div>
</div>

</div>

