
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
  <div class="col-md-9">
    <div class="login-panel panel panel-default"  id="lists">
      <div class="panel-body" > 
        <script>
function search_student(){
	if($('#year').val()==''){
		alert('Please select year');
		return false;
	}
	if($('#class_id').val()==''){
		alert('Please select class');
		return false;
	}
	if($('#class_section_id').val()==''){
		alert('Please select class section');
		return false;
	}
	var params = $('#serachFrm').serialize();
	$.ajax({
		type: "POST",
		data : params,
		url: "<?=base_url().'user/student_promotion_list'?>",
		success: function(html){
			$('#student_list_div').html(html);
		}
		
	});
	
}
</script>
        <h3><?php echo $title;?></h3>
        <div class="row">
          <div class="col-md-12"> <br>
            <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>
            <div id="message"></div>
            <form method="post" action="" id="serachFrm" name="serachFrm">
              <table class="table table-bordered">
                <tr>
                  <th>School</th>
                  <td><select name="group_id" id="group_id" class="form-control">
                      <option value="">Select School</option>
                      <?php foreach($group_list as $groups) {?>
                      <option value="<?=$groups['gid']?>">
                      <?=$groups['group_name']?>
                      </option>
                      <?php }?>
                    </select></td>
                  <th>Academic Year</th>
                  <td><select id="year" name="year" class="form-control">
                      <option value="">Select Year</option>
                      <?php foreach($academic_year as $year) {?>
                      <option value="<?=$year['academic_year']?>">
                      <?=$year['academic_year']?>
                      </option>
                      <?php }?>
                    </select></td>
                  <th>Class</th>
                  <td><select name="class_id" id="class_id" class="form-control">
                      <option value="">Select Class</option>
                      <?php foreach($class_list as $classes) {?>
                      <option value="<?=$classes['id']?>">
                      <?=$classes['class_name']?>
                      </option>
                      <?php }?>
                    </select></td>
                </tr>
                <tr>
                  <th>Class Section</th>
                  <td><select name="class_section_id" id="class_section_id" class="form-control">
                      <option value="">Select Section</option>
                      <?php foreach($class_section_list as $sections) {?>
                      <option value="<?=$sections['id']?>">
                      <?=$sections['section_name']?>
                      </option>
                      <?php }?>
                    </select></td>
                  <th>Class Group</th>
                  <td><select name="class_group_id" id="class_group_id" class="form-control">
                      <option value="">Select Group</option>
                      <?php foreach($class_group_list as $class_group) {?>
                      <option value="<?=$class_group['group_name']?>">
                      <?=$class_group['group_name']?>
                      </option>
                      <?php }?>
                    </select></td>
                  <td colspan="2"><input type="button" name="search" value="Search" id="search" class="btn btn-success" onclick="search_student()" /></td>
                </tr>
              </table>
              <div id="student_list_div"> </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
