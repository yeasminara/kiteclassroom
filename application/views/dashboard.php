<!--
<div class="container" style=" background: #E7E7E8; padding-left: 0px; padding-top: 0px;padding-bottom: 0px;">
  <div class="col-md-3" style="background: #fff; padding-top: 15px; min-height: 479px;">
    <?php
	$logged_in=$this->session->userdata('logged_in');
	
	$user_id = $logged_in['uid'];
	$user_type = $logged_in['gid'];
	//print_r($logged_in);
	$this->db->where('user_id',$user_id);
	$schoolInfo = $this->db->get('savsoft_school_profile')->row_array();
	
	//echo $this->db->last_query();
	?>
    <p> <img src="<?=base_url().'images/'.$schoolInfo['school_logo']?>" alt=""  style="float: left; width: 80px;"/>Welcome :
      <?=$logged_in['first_name'].' '.$logged_in['last_name']?>
      <br/>
      <?=$logged_in['group_name']?>
    </p>
  </div>
  <div class="col-md-9" style=" padding-top: 15px;">
    <div class="row"> 
      
      
      <div class="col-md-3"> <a href="<?php echo site_url('qbank');?>">
        <div class="panel panel-info" style="background: url(images/icon/images/question_bank.png); 
height: 212px;
background-repeat: no-repeat;
background-size: cover;">
          <p></p>
        </div>
        </a> </div>
     
     <div class="col-md-3"> <a href="<?php echo site_url('class_content/content_list');?>">
        <div class="panel panel-info" style="background: url(images/icon/images/contents.png); 
height: 212px;
background-repeat: no-repeat;
background-size: cover;">
          <p></p>
        </div>
        </a> </div>
        <div class="col-md-3"> <a href="<?php echo site_url('class_content');?>">
        <div class="panel panel-info" style="background: url(images/icon/images/class_room.png); 
height: 212px;
background-repeat: no-repeat;
background-size: cover;">
          <p></p>
        </div>
        </a> </div>
        <div class="col-md-3"> <a href="<?php echo site_url('quiz');?>">
        <div class="panel panel-info" style="background: url(images/icon/images/online_exam.png); 
height: 212px;
background-repeat: no-repeat;
background-size: cover;">
          <p></p>
        </div>
        </a> </div>
      <div class="row"></div>
      
    </div>
    <div class="row">
    <div class="col-md-3"> <a href="<?php echo site_url('result');?>">
        <div class="panel panel-info" style="background: url(images/icon/images/results.png); 
height: 212px;
background-repeat: no-repeat;
background-size: cover;">
          <p></p>
        </div>
        </a> </div>
        <div class="col-md-3"> <a href="<?php echo site_url('home_work');?>">
        <div class="panel panel-info" style="background: url(images/icon/images/home_work.png); 
height: 212px;
background-repeat: no-repeat;
background-size: cover;">
          <p></p>
        </div>
        </a> </div>
        <div class="col-md-3"> <a href="<?php echo site_url('class_content');?>">
        <div class="panel panel-info" style="background: url(images/icon/images/teacher_corner.png); 
height: 212px;
background-repeat: no-repeat;
background-size: cover;">
          <p></p>
        </div>
        </a> </div>
    <div class="row"></div>
    </div>
  </div>
</div>
-->

 <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Present</span>
              <div class="count">200</div>
              <span class="count_bottom"><i class="green">4% </i> From last month</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Absent</span>
              <div class="count">123</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From April Month</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total CT </span>
              <div class="count green">25</div>
              <span class="count_bottom"><i class="green">
			   20</i> Complete </span>
			  <span class="count_bottom"><i class="red">
			   2</i> Absent </span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Performance</span>
              <div class="count">Good</div>
              <span class="count_bottom"><i class="red"> </i> Not good last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Final Exam</span>
              <div class="count">3</div>
              <span class="count_bottom"><i class="green"> 2 Are done</i> 1 is left</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Dues</span>
              <div class="count">No dues</div>
              <span class="count_bottom"><i class="green">Compelete from last month</i></span>
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Network Activities <small>Graph title sub-title</small></h3>
                  </div>
                  <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div id="chart_plot_01" class="demo-placeholder"></div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                  <div class="x_title">
                    <h2>Progress </h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                      <p> Excellent</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Good</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                      <p>Bad</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Not Bad</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

              <div class="row">
          


            <div class="col-md-12 col-sm-8 col-xs-12">



           
              <div class="row">


                <!-- Start to do list -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Home Work List <small>For Tommorrow</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="">
                        <ul class="to_do">
                          <li>
                            <p>
                              <i class="fa fa-cogs"></i> Bangla 1st paper home  </p>
                          </li>
                          <li>
                            <p>
                               <i class="fa fa-cogs"></i> Bangla 1st paper home</p>
                          </li>
                          <li>
                            <p>
                               <i class="fa fa-cogs"></i>  Bangla 1st paper home</p>
                          </li>
                          <li>
                            <p>
                               <i class="fa fa-cogs"></i> Bangla 1st paper home</p>
                          </li>
                          <li>
                            <p>
                               <i class="fa fa-cogs"></i>  Bangla 1st paper home</p>
                          </li>
                          <li>
                            <p>
                              <i class="fa fa-cogs"></i> Bangla 1st paper home</p>
                          </li>
                          <li>
                            <p>
                              <i class="fa fa-cogs"></i>  Bangla 1st paper home</p>
                          </li>
                          <li>
                            <p>
                              <i class="fa fa-cogs"></i>  Bangla 1st paper home</p>
                          </li>
                          <li>
                            <p> <i class="fa fa-cogs"></i> Bangla 1st paper home</p>
                          </li>
						  <li>
                           <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">View Previous Home Work</a>
                </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End to do list -->
                
                <!-- start of weather widget -->
                <div class="col-md-6">
                   <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Teachers List</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <li>
                      <img src="dist/img/user1-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Alexander Pierce</a>
                      <span class="users-list-date">Today</span>
                    </li>
                    <li onmouseover="teacher_comment()">
                      <img src="dist/img/user8-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Norman</a>
                      <span class="users-list-date">Yesterday</span>
                    </li>
                    <li>
                      <img src="dist/img/user7-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Jane</a>
                      <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user6-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">John</a>
                      <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user2-160x160.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Alexander</a>
                      <span class="users-list-date">13 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user5-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Sarah</a>
                      <span class="users-list-date">14 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user4-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Nora</a>
                      <span class="users-list-date">15 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user3-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Nadia</a>
                      <span class="users-list-date">15 Jan</span>
                    </li>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">View All Users</a>
                </div>
                <!-- /.box-footer -->
              </div>
          
                </div>
                <!-- end of weather widget -->
              </div>
            </div>
          </div>
      