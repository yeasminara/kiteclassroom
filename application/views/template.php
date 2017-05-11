<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$logged_in=$this->session->userdata('logged_in');

$user_name = $this->db->where('uid',$logged_in['uid'])->get('savsoft_users')->row_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kite Classroom | </title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url()?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->

    <link rel="stylesheet" href="<?=base_url()?>css/AdminLTE.min.css">
    <!-- iCheck -->

	
	<script>
	
	var base_url="<?php echo base_url();?>";

	</script>
	
	<!-- jquery -->
	<script src="<?php echo base_url('js/jquery.js');?>"></script>
	
	<!-- custom javascript -->
	  	<script src="<?php echo base_url('js/basic.js');?>"></script>
    <!-- bootstrap-progressbar -->

    <!-- Custom Theme Style -->
    <link href="<?=base_url()?>css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">

 <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa" style="background: #fff;"><img src="<?=base_url().'images/KITE-LOGO.png'?>" alt="" style="width: 30px; height: auto"></i> <span>Kite Classroom</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?=base_url()?>images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span> Welcome</span>
                <h2><?=$user_name['first_name'].' '.$user_name['last_name']?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
     <?php if($this->session->userdata('logged_in')){
				if($this->uri->segment(2)!='attempt'){
				$logged_in=$this->session->userdata('logged_in');
				?>

      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                
                 <?php
	 $CI =& get_instance();
			  	    $CI->load->helper('site_helper');
					$user_role = get_user_role_name();
					//print_r($user_role);
					$menu_lists = get_user_menu_group();
	?>
    
                 <!--<ul class="nav side-menu">
               
                
                
                
                 <li><a><i class="fa fa-home"></i> Home </a>
                   
                  </li>
                  <li><a><i class="fa fa-edit"></i> Result</a>
                  
                  </li>
                  <li><a><i class="fa fa-desktop"></i> Attendance </a>
                   
                  </li>
                  <li><a><i class="fa fa-table"></i>  Fees</a>
                    
                  </li>
                
                </ul>-->
                
                
                <ul class="nav side-menu">
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
                           <ul class="nav child_menu">
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
                <ul class="nav child_menu">
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
              </div>
            

            </div>
			      <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
            <?php }
	 }
			?>
          </div>
        </div>
 <div class="top_nav">
<div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
			 
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?=base_url()?>images/img.jpg" alt=""><?=$user_name['first_name'].' '.$user_name['last_name']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="<?php echo site_url('login/logout');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
				

                <li role="presentation" class="dropdown">
				
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="badge bg-red">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?=base_url()?>images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=base_url()?>images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=base_url()?>images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=base_url()?>images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
         
			  </ul>
            </nav>
          </div>
</div>
            <!-- /sidebar menu -->

      

        <!-- top navigation -->
           <!-- page content -->
        <div class="right_col" role="main">
          <?php echo isset($middle) ? $middle:'' ;?>
           </div>
        <!-- /page content -->

        <!-- footer content -->
        
        
<?php 
if($this->config->item('tinymce')){
					if($this->uri->segment(2)!='attempt'){
					if($this->uri->segment(2)!='view_result'){

					if($this->uri->segment(2)!='config'){
					if($this->uri->segment(2)!='css'){

	
	?>
	<script type="text/javascript" src="<?php echo base_url();?>editor/tiny_mce.js"></script>
	<script type="text/javascript">
 <?php 
 if($this->uri->segment(2)=='edit_quiz' || $this->uri->segment(2)=='add_new' ){
?>
			tinyMCE.init({
	
    mode : "textareas",
	editor_selector : "tinymce_textarea",
	theme : "advanced",
		relative_urls:"false",
	 plugins: "jbimages",
	  
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
 
	
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "jbimages,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		
		
	});

<?php 
 }else{
?>

			tinyMCE.init({
	
    mode : "textareas",
		theme : "advanced",
		relative_urls:"false",
	 plugins: "jbimages",
	  
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
 
	
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "jbimages,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		
		
	});
	
<?php 
 }
 ?>
 
</script>

	
	<?php 
						}
					}
			}
		}
	}
?>

         <footer>
          <div class="pull-right">
           <a href="https://kite.com"> Powered By Kite Bangladesh Ltd </a>
          </div>
          <div class="clearfix"></div>
        </footer>
		  <script src="<?=base_url()?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?=base_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
 <!-- Chart.js -->
    <script src="<?=base_url()?>vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
 
    <!-- bootstrap-progressbar -->
    <script src="<?=base_url()?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
   
    <script src="<?=base_url()?>vendors/Flot/jquery.flot.js"></script>
    <script src="<?=base_url()?>vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?=base_url()?>vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?=base_url()?>vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?=base_url()?>vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    
    <script src="<?=base_url()?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    
    <!-- DateJS -->
    <script src="<?=base_url()?>vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
  
    <!-- bootstrap-daterangepicker -->
   
    <script src="<?=base_url()?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?=base_url()?>build/js/custom.min.js"></script>
        <!-- /footer content -->
      </div>
    </div>
	
  </div>
  </div>  
    
</body>
</html>






