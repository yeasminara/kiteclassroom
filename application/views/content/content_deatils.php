 <div class="container">

  <script>
 $(function() {
  var height = $('#lists').height();
 
 $("#sub_menu").css("min-height",height+"px");
});
 </script>
  <div class="col-md-3 panel login-panel" style="background: #fff; padding-top: 15px;" id="sub_menu">
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
  </div>
  <div class="col-md-9"  id="lists">
    <div class="login-panel panel panel-default">
      <div class="panel-body">
      
  <script>
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
      <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa fa-bars"></i> <?php echo $title;?></h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                    <li><i class="fa fa-bars"></i><a href="<?php echo base_url().'class_content'?>">Class Content</a></li>
                    <li><i class="fa fa-square-o"></i>Details : <?php /*echo substr(strip_tags($result['question']),0,40);*/  echo $result['title'];?></li>
                    <li style="float: right">
                    <?php
 $logged_in=$this->session->userdata('logged_in');

	if($result['user_id'] == $logged_in['uid']){ ?>
        <a href="<?php echo site_url('class_content/edit/'.$result['id']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
    <a href="javascript:delete_c('<?php echo $result['id'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
    <?php
	}
 ?>
                    </li>
                </ol>
            </div>
        </div>
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

 <th><?php echo 'Content title'?></th>
 
<th>Class</th>
 <th>Subject</th>
 <th>Teacher Name </th>
<th><?php echo 'Date';?></th>

</tr>

<tr>

 <td><?php /*echo substr(strip_tags($result['question']),0,40);*/  echo $result['title'];?></td>
<td><?php echo $result['class_name'];?></td>
<td><?php echo $result['category_name'];?></td>
<td><?php echo $result['first_name'].' '.$result['last_name'];?></td>
 <td><?php echo date('d-m-Y',strtotime($result['class_time_date']));?></td>
 
 </tr>


</table>
<table class="table table-bordered">
	<tr>
    	<td>Class Duration</td>
        <td><?php echo $result['duration'];?></td>
    </tr>
    <tr>
    	<td>Description</td>
         <td><?php echo $result['description'];?></td>
    </tr>
     <tr>
    	<td>Content File</td>
         <td>
         <?php if(!empty($result['file'])) {?>
         <object width="100%" height="200" data="<?=base_url().'images/content/'.$result['file']?>">
</object> <?php }?>
         </td>
    </tr>
    <tr>
    	<td>Image</td>
         <td><img src="<?=base_url().'images/content/'.$result['image']?>" alt="" width="30" /></td>
    </tr>
    <tr>
    	<td>Audio Link</td>
         <td><?php echo $result['audio_file'];?></td>
    </tr>
    <tr>
    	<td>Video Link</td>
         <td><?php echo $result['vedio_link'];?></td>
    </tr>
</table>

</div>

</div>

</div>
</div>
</div>



</div>
