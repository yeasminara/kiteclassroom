
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
        <h3><?php echo $title;?></h3>
        <div class="row">
          <form method="post" action="<?php echo site_url('user/update_user/'.$uid);?>">
            <div class="col-md-8"> <br>
              <div class="login-panel panel panel-default">
                <div class="panel-body">
                  <?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>
                  <div class="form-group"> <?php echo $this->lang->line('group_name');?>: <?php echo $result['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $result['price'];?>) </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label>
                    <input type="email" id="inputEmail" name="email" value="<?php echo $result['email'];?>" readonly=readonly class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
                    <input type="password" id="inputPassword" name="password"   value=""  class="form-control" placeholder="<?php echo $this->lang->line('password');?>"   >
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('first_name');?></label>
                    <input type="text"  name="first_name"  class="form-control"  value="<?php echo $result['first_name'];?>"  placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('last_name');?></label>
                    <input type="text"   name="last_name"  class="form-control"  value="<?php echo $result['last_name'];?>"  placeholder="<?php echo $this->lang->line('last_name');?>"   autofocus>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="sr-only"><?php echo $this->lang->line('contact_no');?></label>
                    <input type="text" name="contact_no"  class="form-control"  value="<?php echo $result['contact_no'];?>"  placeholder="<?php echo $this->lang->line('contact_no');?>"   autofocus>
                  </div>
                  <button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="row">
          <div class="col-md-8">
            <h3><?php echo $this->lang->line('payment_history');?></h3>
            <table class="table table-bordered">
              <tr>
                <th><?php echo $this->lang->line('payment_gateway');?></th>
                <th><?php echo $this->lang->line('paid_date');?> </th>
                <th><?php echo $this->lang->line('amount');?></th>
                <th><?php echo $this->lang->line('transaction_id');?> </th>
                <th><?php echo $this->lang->line('status');?> </th>
              </tr>
              <?php 
if(count($payment_history)==0){
	?>
              <tr>
                <td colspan="5"><?php echo $this->lang->line('no_record_found');?></td>
              </tr>
              <?php
}
foreach($payment_history as $key => $val){
?>
              <tr>
                <td><?php echo $val['payment_gateway'];?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['paid_date']);?></td>
                <td><?php echo $val['amount'];?></td>
                <td><?php echo $val['transaction_id'];?></td>
                <td><?php echo $val['payment_status'];?></td>
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
</div>
