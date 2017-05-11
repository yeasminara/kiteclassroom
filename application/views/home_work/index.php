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
  <script>
 $(function() {
  var height = $('#lists').height();
 
 $("#sub_menu").css("min-height",height+"px");
});
 </script>
  <!--<div class="col-md-3 panel login-panel" style="background: #fff; padding-top: 15px;" id="sub_menu"> </div>-->
  <div class="col-md-12" id="lists">
    <div class="login-panel panel panel-default">
      <div class="wrapper panel-body">
        <div style="position: relative">
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
            <!--<li><i class="fa fa-bars"></i>Pages</li>-->
            <li><i class="fa fa-square-o"></i>Home Work</li>
          </ol>
          <div style="position: absolute; right: 9px; top: -6px;
}"> <a class="btn btn-primary" href="<?php echo base_url().'home_work/add'?>" style="color: #fff; padding-top:14px; padding-bottom: 14px;"><i class="icon_plus_alt2"></i> Add New Home Work</a></div>
        </div>
        <div class="content-box-large">
          <div class="panel-heading"> </div>
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
                    </span> </div>
                  <!-- /input-group -->
                </form>
              </div>
              <!-- /.col-lg-6 --> 
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
              <thead>
                <tr style="border: #056839 solid 1px; background: #8CC63E; color: #056839">
                  <th>Title</th>
                  <th>Class</th>
                  <th>Subject</th>
                  <th>Submission Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					if(count($result)==0){
						?>
                <tr>
                  <td colspan="6"><?php echo $this->lang->line('no_record_found');?></td>
                </tr>
                <?php
					}foreach($result as $key => $val){
					?>
                <tr>
                  <td><?=$val['home_work_title']?></td>
                  <td><?=$val['class_name']?></td>
                  <td><?=$val['category_name']?></td>
                  <td><?=date('d-m-Y', strtotime($val['home_work_title']))?></td>
                  <td></td>
                  <td><a href="<?=base_url().'home_work/permission/'.$val['home_work_id']?>" class="btn btn-primary">Assign</a><a href="<?=base_url().'home_work/evaluation_list/'.$val['home_work_id']?>" class="btn btn-info">Evaluate</a></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
