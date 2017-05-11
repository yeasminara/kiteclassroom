
<script>
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
  <h3><?php echo $title;?> <a class="btn btn-default" href="<?=base_url().'qbank/insert_chapter'?>">Add New</a></h3>
  <div class="row">
    <div class="col-md-12"> 
    
    
    <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >
      
      
      <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>
      <div id="message"></div>
      
     
      <table class="table table-bordered">
      <tr><td colspan="5">
      <form action="<?=base_url().'qbank/chapter_list'?>" method="post">
        <table>
        	<tr><td><div class="form-group">
              <label>Select Class</label>
              <select name="class_id" id="class_id" required onchange="load_subject()" class="form-control" >
                <option value="">Select</option>
                <?php foreach($class_list as $class) {?>
                <option value="<?=$class['id']?>" <?php if($this->input->post('class_id') && $this->input->post('class_id')==$class['id']){ echo 'selected="selected"';}?> >
                <?=$class['class_name']?>
                </option>
                <?php }?>
              </select>
            </div> &nbsp; &nbsp; </td>
            <td> <div class="form-group">
              <label   ><?php echo $this->lang->line('select_category');?></label>
              <div  id="subject_div_id">
                <?php 
					$CI = &get_instance();
					$CI->load->model('qbank_model');
		    		$subject_lists = $CI->qbank_model->get_subject_by_class_id($this->input->post('class_id'));
		  
				?>
                <select name="subject_id" id="subject_id" required class="form-control" >
                  <option value="">Select</option>
                  <?php foreach($subject_lists as $subject){?>
                  <option value="<?=$subject['cid']?>" <?php if($this->input->post('subject_id') && $this->input->post('subject_id')==$subject['cid']){ echo 'selected="selected"';}?>>
                  <?=$subject['category_name']?>
                  </option>
                  <?php }?>
                </select>
              </div>
            </div> &nbsp; &nbsp; </td>
            <td><input type="submit" name="submit" value="Search" class="btn btn-default"/></td>
            </tr>
       </table>
     </form>
      </td></tr>
        <tr>
          <th>Class</th>
          <th>Subject</th>
          <th>Chapter</th>
          <th>Lesson</th>
          <th>Classification</th>
          <th><?php echo $this->lang->line('action');?> </th>
        </tr>
        <?php 
if(count($category_list)==0){
	?>
        <tr>
          <td colspan="5"><?php echo $this->lang->line('no_record_found');?></td>
        </tr>
        <?php
}

foreach($category_list as $key => $val){
?>
        <tr>
          <td><?=$val['class_name']?></td>
          <td><?=$val['category_name']?></td>
          <td><?=$val['chapter_name']?></td>
          <td><?=$val['lession_name']?></td>
          <td><?=$val['classification']?></td>
          <td nowrap="nowrap">
          <a href="<?=base_url()?>qbank/update_chapter/<?php echo $val['id'];?>"><img src="<?php echo base_url('images/edit.png');?>"></a> &nbsp; |&nbsp;
          <a href="javascript:remove_entry('qbank/remove_chapter/<?php echo $val['id'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a></td>
        </tr>
        <?php 
}
?>
      </table>
    </div>
    </div>
    </div>
  </div>
</div>
