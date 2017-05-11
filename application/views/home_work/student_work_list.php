<script>
    function delete_c(id){
	 var r=confirm("Do you want to delete?");
	   if (r==true)
		  {
			
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>pages/delete/',
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
 function load_subject(){
	var class_id =$('#class_id').val();
	$("#subject_div_id").html('<p>Loading...</p>');
	$.ajax({
		type: "POST",
		data : '&class_id='+class_id,
		url: "<?=base_url().'loading/load_subject_only'?>",
		success: function(result){
			$("#subject_div_id").html(result);
		}
		
	});
}
</script>
 <div class="container">

   
 
  



<div class="row">

<div class=" login-panel panel panel-default">
        <section class="wrapper panel-body">
      <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa fa-bars"></i> Pages</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                    <!--<li><i class="fa fa-bars"></i>Pages</li>-->
                    <li><i class="fa fa-square-o"></i>Home Work</li>
                </ol>
            </div>
        </div>
   <div class="content-box-large">
  				<div class="panel-heading">
					
  				<div class="panel-body">
                <div class="row">
 
  <div class="col-lg-8">
    <form method="post" action="<?php echo site_url('home_work/index/');?>">
    
    <div class="input-group" style="float: left; width: 200px;">

              <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" >
                <option value="">Select class</option>
                <?php 
				
				
				foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>" <?php if($this->input->post('class_id') && $this->input->post('class_id')==$class['id']){ echo 'selected="selected"';}?> > 
                <?=$class['class_name']?>
                </option>
                <?php }?>
              </select>
            </div>
     
     <div class="input-group" style="float: left; width: 200px;">
              <div  id="subject_div_id">
                <?php 
					$CI = &get_instance();
					$CI->load->model('qbank_model');
		    		$subject_lists = $CI->qbank_model->get_subject_by_class_id($this->input->post('class_id'));
		  
				?>
                <select name="subject_id" id="subject_id" required class="form-control" >
                  <option value="">Select Subject</option>
                  <?php foreach($subject_lists as $subject){?>
                  <option value="<?=$subject['cid']?>" <?php if($this->input->post('subject_id') && $this->input->post('subject_id')==$subject['cid']){ echo 'selected="selected"';}?>>
                  <?=$subject['category_name']?>
                  </option>
                  <?php }?>
                </select>
              </div>
            </div>       
	<div class="input-group">
    
    
    
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
	 
	  
    </div><!-- /input-group -->
	 </form>
  </div><!-- /.col-lg-6 -->
</div>


  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
                            	<th>SI</th>
								<th>Title</th>
							    <th>Class</th>
								<th>Subject</th>
                                <th>Submission Date</th>
                                <th>Status</th>
							</tr>
						</thead>
						<tbody>
                  
				<?php 
				$i=1;
					if(count($result)==0){
						?>
					<tr>
					 <td colspan="6"><?php echo $this->lang->line('no_record_found');?></td>
					</tr>	
						
						
						<?php
					}foreach($result as $key => $val){
					?>
					<tr>
                        <td><?=$i++?></td>    	
                        <td><a href="<?=base_url().'home_work/answer/'.$val['home_work_id'].'/'.$val['id']?>"><?=$val['home_work_title']?></a></td>
                        <td><?=$val['class_name']?></td>
                        <td><?=$val['category_name']?></td>
                        <td><?=date('d-m-Y', strtotime($val['home_work_title']))?></td>
                        <td><?php if($val['is_complete']=='0') {?><span style="color: blue">New</span><?php } else{ echo '<span style="color: green">Complete</span>'; }?></td>
                    </tr>
					<?php }?>
					
							
							
						</tbody>
					</table>
  				</div>
  			</div>
</div>

</section>
</div>
</div>
</div>
