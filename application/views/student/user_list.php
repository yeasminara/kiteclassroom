
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
  <div class="col-md-12">
    <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" >
        <h3><?php echo $title;?></h3>
        <div class="row">
          <div class="col-lg-6">
            <form method="post" action="<?php echo site_url('student/index/');?>">
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
        <!-- /.row -->
        
        <div class="row" >
          <div class="col-md-12"> <br>
            <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>
            <table class="table table-bordered">
              <tr>
                <th><?php echo $this->lang->line('email');?>/Username</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Roll</th>
                <th>School Name</th>
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
                <td><?php echo $val['email'];?></td>
                <td><?php echo $val['first_name'];?> <?php echo $val['last_name'];?></td>
                <td><?
				
//if($val['title'] == 'Student'){
	$this->db->where('user_id',$val['uid']);
	$this->db->where('status','1');
	$this->db->where('is_current_year','1');
	$this->db->order_by('id','DESC');
	$this->db->select('savsoft_student_profile.*');
	$this->db->select('(select class_name FROM savsoft_class where id=savsoft_student_profile.class_id ) as class_name');
	//echo $this->db->last_query();
	$res_class_info = $this->db->get('savsoft_student_profile')->row_array();
	echo $res_class_info['class_name'];
//}
?></td>
<td><?=$res_class_info['roll_no']?></td>
                <td><?php echo $val['group_name'];

?></td>
                <td nowrap="nowrap"><a href="<?php echo site_url('student/edit_user/'.$val['uid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
                  <?php if($user_role_id == 1 && $val['su']!=1) {?>
                  <a  href="<?php echo base_url().'pages/permission/'.$val['uid'];?>"><img src="<?php echo base_url('images/setting.png');?>"></a>
                  <?php }?>
                  <a href="javascript:remove_entry('student/remove_user/<?php echo $val['uid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a></td>
              </tr>
              <?php 
}
?>
            </table>
          </div>
        </div>
        <?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>
        <a href="<?php echo site_url('student/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a> &nbsp;&nbsp;
        <?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>
        <a href="<?php echo site_url('student/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a> </div>
    </div>
  </div>
</div>
