<html lang="en">
  <head>
  <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
	<title> </title>
	<!-- bootstrap css -->
	<link href="<?php echo base_url('bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
	
	<!-- custom css -->
	<link href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
	
	<script>
	
	var base_url="<?php echo base_url();?>";

	</script>
	
	<!-- jquery -->
	<script src="<?php echo base_url('js/jquery.js');?>"></script>
	
	<!-- custom javascript -->
	  	<script src="<?php echo base_url('js/basic.js');?>"></script>
		
	<!-- bootstrap js -->
    <script src="<?php echo base_url('bootstrap/js/bootstrap.min.js');?>"></script>
	
	
	
	
 </head>
  <body style="background: #eee">

	<?php 
			if($this->session->userdata('logged_in')){
				if($this->uri->segment(2)!='attempt'){
				$logged_in=$this->session->userdata('logged_in');
	?>
    <header>

    </header>
  	
	    <nav class="navbar navbar-default" style="background-color: #056839;margin-bottom: 0px;">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="<?=base_url()?>">Admin Panel</a>-->
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <?php 
			  
			        $CI =& get_instance();
			  	    $CI->load->helper('site_helper');
					$user_role = get_user_role_name();
					//print_r($user_role);
					$menu_lists = get_user_menu_group();
					
					//print_r($menu_lists);
					foreach($menu_lists as $menu){
						
						$sub_menus = get_menu_by_module($menu['module']);
						
						//echo $this->db->last_query();
						//echo 'count($sub_menus)'.count($sub_menus);
						if(count($sub_menus)>1){ 
						
						$menus_split = explode(" ", $menu['module']);
						if(isset($menus_split['1'])){
							  $menu_module = $menus_split['0'].'_'.$menus_split['1'];
						}else{
							
							 $menu_module =  $menus_split['0'];
						}
						
						//echo 'kkkk : '.$menu_module.', uri'.$this->uri->segment(1);
						?>
                        
                        <li class="dropdown <?php if($this->uri->segment(1)==$menu_module){ echo 'active'; } ?>"  >
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style=""><?=ucfirst($menu['module'])?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <!--<li><a href="<?php echo site_url('pages/add');?>">New Menu</a></li>
                              <li><a href="<?php echo site_url('pages');?>">Menu List</a></li>
                              -->
                              <?php foreach($sub_menus as $sub_menu) {
                                         if(strpos($sub_menu['page_group_url'], 'index')){
                                             $url = substr($sub_menu['page_group_url'],0 ,-6);
                                         }else{
                                             $url = $sub_menu['page_group_url'];
                                         }
                                        
                                        ?>
                                      <li><a class="" href="<?=base_url().$sub_menu['page_group_url']?>"><?=$sub_menu['page_group_name']?></a></li> 
                                      <?php }?>   
                                      
                            </ul>
                          </li>
              
                        <?php
						} else{ 
					        if(strpos($menu['page_group_url'], 'index')){
								 $url1 = substr($menu['page_group_url'],0 ,-6);
							 }else{
								 $url1 = $menu['page_group_url'];
							 }
							 ?>
                             <li <?php if($this->uri->segment(1)==$menu['module']){ echo "class='active'"; } ?> > <a href="<?=base_url().$menu['page_group_url']?>" class=""> <?=ucfirst($menu['module'])?></a> </li>
                          
                             <?
						}
                  
					
					}
					
				if($user_role['role_type'] == 'administrator' || $user_role['role_type'] == 'superadmin'){ ?>
                <li class="dropdown <?php if($this->uri->segment(1)=='pages'){ echo "active"; } ?>"  >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo site_url('pages/add');?>">New Menu</a></li>
                  <li><a href="<?php echo site_url('pages');?>">Menu List</a></li>
                  
                </ul>
              </li>
                <?
					
				}
			?>
     	
			 
			  <?php  
				?>
             <li>
             
             <a href="<?php echo site_url('login/logout');?>"><?php echo $this->lang->line('logout');?></a>
             </li>

			  
            </ul>
             
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

	<?php 
			}
			}
	?>
	
