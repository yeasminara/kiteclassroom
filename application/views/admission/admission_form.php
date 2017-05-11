<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>School Admission</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link href="<?=base_url()?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
    <![endif]-->
	<script src="<?php echo base_url('js/jquery.js');?>"></script>
	<script src="<?=base_url()?>vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?=base_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?=base_url()?>ui/jquery-ui.css">
	<!--  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
	<script src="<?=base_url()?>ui/jquery-ui.js"></script>
	<script>
	$(document).ready(function () {
		
		$( "#datepicker" ).datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true,
			//yearRange: '1980:'+(new Date).getFullYear() 
		});	 
		$( "#father_name" ).keyup(function() {
			var fatherName = $( "#father_name" ).val();
			  $( "#gurdian_name" ).val(fatherName);
		});
	}); 
	</script>
	</head>
	<body class="">
    <div class="wrapper" style="overflow: hidden;"> 
      
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container">
          <div class="row" style="background-color:gray">
            <div class="col-md-2"><img src="<?=base_url()?>images/<?=$school_other_information['school_logo']?>" style="width:100%; height: auto" alt=""></div>
            <div class="col-md-10 pull-left" style="color:white">
              <h4>
                <?=$school_name['group_name']?>
              </h4>
              <p>
                <?=$school_other_information['school_address']?>
              </p>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Main content -->
      <section class="content">
        <div class="container"> 
          <!-- left column -->
          <div class="col-md-12" style="padding-top: 10px;">
            <form id="demo-form2" data-parsley-validate class="">
              <!-- general form elements -->
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td width="50%" valign="top"><div class="panel panel-success">
                      <div class="panel-heading">
                      <h3 class="panel-title">Personal Information</h3>
                    </div>
                      <div class="panel-body">
                      <div class="form-group">
                          <label for="academic_year">Academic Year * :</label>
                          <select id="academic_year" name="academic_year" class="form-control" required="required">
                          <?php $date = date('Y')-5;
							$next_year = date('Y')+1;
							
							for($i=$date; $i<=$next_year; $i++){
							?>
                          <option value="<?=$i?>">
                            <?=$i?>
                            </option>
                          <?php }?>
                        </select>
                        </div>
                      <div class="form-group">
                          <label for="class_id"> Admission Class * :</label>
                          <select id="class_id" name="class_id" class="form-control" required="required">
                          <option value="">Select Class</option>
                          <?php foreach($class_information as $class){?>
                          <option value="<?=$class['id']?>">
                            <?=$class['class_name']?>
                            </option>
                          <?php }?>
                        </select>
                        </div>
                      <div class="form-group">
                          <label for="class_group_id">Class Group * :</label>
                          <select id="class_group_id" name="class_group_id" class="form-control">
                          <?php foreach($class_group_information as $class_group){?>
                          <option value="<?=$class_group['id']?>">
                            <?=$class_group['group_name']?>
                            </option>
                          <?php }?>
                        </select>
                        </div>
                      <div class="form-group">
                          <label for="father_name">Student's Name * :</label>
                          <input type="email" class="form-control" id="student_name" name="student_name"
                                   placeholder="Student's Name" required="required"/>
                        </div>
                      <div class="form-group">
                          <label for="father_name">Father's Name * :</label>
                          <input type="email" class="form-control" id="father_name" name="father_name"
                                   placeholder="Father's Name" required="required" />
                        </div>
                      <!--<div class="form-group">
                            <label for="father_nid">Father's NID :</label>
                            <input type="email" class="form-control" id="father_nid" placeholder="Father's NID" name="father_nid">
                        </div>-->
                      <div class="form-group">
                          <label for="mother_name">Mother's Name * :</label>
                          <input type="email" class="form-control" id="mother_name"
                                   placeholder="Mother's Name" name="mother_name" required="required" />
                        </div>
                      <!-- <div class="form-group">
                            <label for="mother_nid">Mother's NID :</label>
                            <input type="email" class="form-control" id="mother_nid" placeholder="Mother's NID" name="mother_nid">
                        </div>-->
                      <div class="form-group">
                          <label>Date of Birth:</label>
                          <div class="input-group date">
                          <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                          <input type="text" class="form-control pull-right" id="datepicker" name="birth_date">
                        </div>
                          <!-- /.input group --> 
                        </div>
                      <!--<div class="form-group">
                            <label for="exampleInputEmail1">Birth Certificate Number * :</label>
                            <input type="email" class="form-control" id="birth_certificate"
                                   placeholder="Birth Certificate Number" name="birth_certificate">
                        </div>-->
                      <div class="form-group">
                          <label for="gender">Gender * :</label>
                          <div class="checkbox">
                          <label>
                              <input type="radio" name="gender">
                              Male</label>
                          <label>
                              <input type="radio" name="gender">
                              Female</label>
                        </div>
                        </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Religion :</label>
                          <select name="religion" id="religion" class="form-control">
                          <option value="">Select</option>
                          <option value="Islam">Islam</option>
                          <option value="Hindu">Hindu</option>
                          <option value="Christianism">Christianism</option>
                          <option value="Buddhism">Buddhism</option>
                          <option value="Others">Others</option>
                        </select>
                        </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">SMS Mobile No. * :</label>
                          <input type="email" class="form-control" id="gurdian_mobile"
                                   placeholder="Mobile No" name="mobile_no" required="required"/>
                        </div>
                    </div>
                    </div></td>
                  <td valign="top" width="50%"><div class="panel panel-success">
                      <div class="panel-heading">
                      <h3 class="panel-title">Guardian's Information</h3>
                    </div>
                      <div class="panel-body">
                      <div class="form-group">
                          <label for="gurdian_name"> Guardian's Name * :</label>
                          <input type="email" class="form-control" id="gurdian_name"
                                   placeholder="Enter email" name="gurdian_name" />
                        </div>
                      <div class="form-group">
                          <label for="gurdian_occupation">Guardian's Occupation * :</label>
                          <input type="password" class="form-control" id="gurdian_occupation"
                                   placeholder="Guardian's Occupation" name="gurdian_occupation">
                        </div>
                      <!--<div class="form-group">
                            <label for="guardian_occupation_level">Guardian's Occupation Level * :</label>
                            <select name="guardian_occupation_level" id="guardian_occupation_level"
                                    class="form-control">
                                <option value="">Select</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gurdian_income">Guardian's Monthly Income :</label>
                            <input type="email" class="form-control" id="gurdian_income"
                                   placeholder="Guardian's Monthly Income" name="gurdian_income">
                        </div>-->
                      
                      <div class="form-group">
                          <label for="email">Email :</label>
                          <input type="email" class="form-control" id="gudian_email" placeholder="Email" name="email">
                        </div>
                    </div>
                    </div>
                    <div class="panel panel-success">
                      <div class="panel-heading">
                        <h3 class="panel-title">Special Information</h3>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="tribal">Tribal Status :</label>
                          <label>
                            <input type="checkbox" name="tribal">
                            Yes</label>
                          <label>
                            <input type="checkbox" name="tribal">
                            No</label>
                          <p class="bg-info">
                            <label for="exampleInputEmail1">If Yes then fillup the form :</label>
                            <input type="email" class="form-control" id="tribal_status" name="tribal_status">
                          </p>
                        </div>
                        <div class="form-group">
                          <label for="disability">Disability Status :</label>
                          <label>
                            <input type="checkbox" name="disability">
                            Yes</label>
                          <label>
                            <input type="checkbox" name="disability">
                            No</label>
                          <p class="bg-info">
                            <label for="disability_status">If Yes then fillup the form :</label>
                            <input type="email" class="form-control" id="disability_status" name="disability_status">
                          </p>
                        </div>
                        <div class="form-group">
                          <label for="other">Others :</label>
                          <label>
                            <input type="checkbox" name="other">
                            Freedom Fighter's Grandson/Children</label>
                          <label>
                            <input type="checkbox" name="other">
                            Player</label>
                          <label>
                            <input type="checkbox">
                            Others</label>
                          <p class="bg-info">
                            <label for="others_status">If Yes then fillup the form :</label>
                            <input type="email" class="form-control" id="others_status" name="others_status">
                          </p>
                        </div>
                      </div>
                    </div>
                    
                    
                    
                    </td>
                </tr>
              </table>
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">Previous Academic Information</h3>
                </div>
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Roll</th>
                      <th>Thana/Registration No</th>
                      <th>Post/Board</th>
                      <th>GPA</th>
                      <th>Passing Year</th>
                    </tr>
                    <tr>
                      <td><input type="email" class="form-control" id="psc_roll"
                                           placeholder="PSC Roll" name="psc_roll"></td>
                      <td><input type="email" class="form-control" id="psc_thana"
                                           placeholder="PSC Thana" name="psc_thana"></td>
                      <td><input type="email" class="form-control" id="psc_post"
                                           placeholder="PSC Post" name="psc_post"></td>
                      <td><input type="email" class="form-control" id="psc_gpa"
                                           placeholder="PSC GPA" name="psc_gpa"></td>
                      <td><select class="form-control" name="psc_year">
                          <option>1991</option>
                          <option>1992</option>
                          <option>1993</option>
                          <option>1994</option>
                          <option>1995</option>
                          <option>1996</option>
                          <option>1997</option>
                          <option>1998</option>
                          <option>1999</option>
                          <option>2000</option>
                          <option>2001</option>
                          <option>2002</option>
                          <option>2003</option>
                          <option>2004</option>
                          <option>2005</option>
                          <option>2006</option>
                          <option>2007</option>
                          <option>2008</option>
                          <option>2009</option>
                          <option>2010</option>
                          <option>2011</option>
                          <option>2012</option>
                          <option>2013</option>
                          <option>2014</option>
                          <option>2015</option>
                          <option>2016</option>
                          <option>2017</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td><input type="email" class="form-control" id="jsc_roll"
                                           placeholder="JSC Roll"></td>
                      <td><input type="email" class="form-control" id="jsc_thana"
                                           placeholder="JSC Thana"></td>
                      <td><input type="email" class="form-control" id="jsc_post"
                                           placeholder="JSC Post"></td>
                      <td><input type="email" class="form-control" id="jsc_gpa"
                                           placeholder="JSC GPA"></td>
                      <td><select class="form-control">
                          <option>1991</option>
                          <option>1992</option>
                          <option>1993</option>
                          <option>1994</option>
                          <option>1995</option>
                          <option>1996</option>
                          <option>1997</option>
                          <option>1998</option>
                          <option>1999</option>
                          <option>2000</option>
                          <option>2001</option>
                          <option>2002</option>
                          <option>2003</option>
                          <option>2004</option>
                          <option>2005</option>
                          <option>2006</option>
                          <option>2007</option>
                          <option>2008</option>
                          <option>2009</option>
                          <option>2010</option>
                          <option>2011</option>
                          <option>2012</option>
                          <option>2013</option>
                          <option>2014</option>
                          <option>2015</option>
                          <option>2016</option>
                          <option>2017</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td><input type="email" class="form-control" id="ssc_roll"
                                           placeholder="SSC Roll" name="jsc_roll"></td>
                      <td><input type="email" class="form-control" id="ssc_thana"
                                           placeholder="SSC Thana" name="jsc_thana"></td>
                      <td><input type="email" class="form-control" id="ssc_post"
                                           placeholder="SSC Post" name="jsc_post"></td>
                      <td><input type="email" class="form-control" id="ssc_gpa"
                                           placeholder="SSC GPA" name="jsc_gpa"></td>
                      <td><select class="form-control" name="jsc_year">
                          <option>1991</option>
                          <option>1992</option>
                          <option>1993</option>
                          <option>1994</option>
                          <option>1995</option>
                          <option>1996</option>
                          <option>1997</option>
                          <option>1998</option>
                          <option>1999</option>
                          <option>2000</option>
                          <option>2001</option>
                          <option>2002</option>
                          <option>2003</option>
                          <option>2004</option>
                          <option>2005</option>
                          <option>2006</option>
                          <option>2007</option>
                          <option>2008</option>
                          <option>2009</option>
                          <option>2010</option>
                          <option>2011</option>
                          <option>2012</option>
                          <option>2013</option>
                          <option>2014</option>
                          <option>2015</option>
                          <option>2016</option>
                          <option>2017</option>
                        </select></td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">Present Address</h3>
                </div>
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <td><label for="present_house">House No *:</label>
                        <input type="email" class="form-control" id="present_house"
                                           placeholder="House No" name="present_house" required="required"/></td>
                      <td><label for="present_road">Road No *:</label>
                        <input type="email" class="form-control" id="present_road"
                                           placeholder="Road No " name="present_road" required="required"/></td>
                      <td><label for="present_area">Area Name/Village *:</label>
                        <input type="email" class="form-control" id="present_area"
                                           placeholder="Area Name/Village" name="present_area" required="required"/></td>
                    </tr>
                    <tr>
                      <td><label for="present_post">Post Office :</label>
                        <input type="email" class="form-control" id="present_post"
                                           placeholder="Post Office"></td>
                      <td><label for="present_code">Post Code :</label>
                        <input type="email" class="form-control" id="exampleInputEmail1"
                                           placeholder="Post Code" name="present_code"></td>
                      <td><label for="present_uposila">Thana/Upazilla :</label>
                        <input type="email" class="form-control" id="present_uposila"
                                           placeholder="Thana/Upazilla" name="present_uposila"></td>
                    </tr>
                    <tr>
                      <td><label for="present_ward">Ward :</label>
                        <input type="email" class="form-control" id="present_ward"
                                           placeholder="Ward"></td>
                      <td><label for="present_district">District :</label>
                        <input type="email" class="form-control" id="present_district"
                                           placeholder="District" name="present_district"></td>
                      <td><label for="present_catch_area">Catchment Area :</label>
                        <input type="email" class="form-control" id="present_catch_area"
                                           placeholder="Catchment Area" name="present_catch_area"></td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">Parmanent Address</h3>
                </div>
                <div class="panel-body">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="same_address" value="1">
                      Same as Present Address </label>
                  </div>
                  <table class="table">
                    <tr>
                      <td><label for="parmanent_house">House No *:</label>
                        <input type="email" class="form-control" id="parmanent_house"
                                           placeholder="House No" name="parmanent_house"></td>
                      <td><label for="parmanent_road">Road No *:</label>
                        <input type="email" class="form-control" id="parmanent_road"
                                           placeholder="Road No" name="parmanent_road"></td>
                      <td><label for="parmanent_email">Area Name/Village *:</label>
                        <input type="email" class="form-control" id="parmanent_email"
                                           placeholder="Area Name/Village" name="parmanent_email"></td>
                    </tr>
                    <tr>
                      <td><label for="parmanent_post">Post Office :</label>
                        <input type="email" class="form-control" id="exampleInputEmail1"
                                           placeholder="Post Office" name="parmanent_post"></td>
                      <td><label for="parmanent_code">Post Code :</label>
                        <input type="email" class="form-control" id="exampleInputEmail1"
                                           placeholder="Post Code" name="parmanent_code"></td>
                      <td><label for="parmanent_uposila">Thana/Upazilla :</label>
                        <input type="email" class="form-control" id="parmanent_uposila"
                                           placeholder="Thana/Upazilla" name="parmanent_uposila"></td>
                    </tr>
                    <tr>
                      <td><label for="parmanent_ward">Ward :</label>
                        <input type="email" class="form-control" id="parmanent_ward"
                                           placeholder="Ward" name="parmanent_ward"></td>
                      <td><label for="parmanent_district">District :</label>
                        <input type="email" class="form-control" id="parmanent_district"
                                           placeholder="District" name="parmanent_district"></td>
                      <td><label for="parmanent_catchement">Catchment Area :</label>
                        <input type="email" class="form-control" id="parmanent_catchement"
                                           placeholder="Catchment Area" name="parmanent_catchement"></td>
                    </tr>
                  </table>
                </div>
              </div>
              
              <div class="panel panel-success">
                      <div class="panel-heading">
                        <h3 class="panel-title">Student Profile Picture</h3>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="Image">Upload Image :</label>
                          <input type="file" class="" id="student_image" name="student_image" required>
                        </div>
                    </div>
                    </div>
              <p class="bg-info pull-right">
                <button type="submit" class="btn btn-primary">Submit</button>
              </p>
            </form>
          </div>
        </div>
      </section>
    </div>
</body>
</html>
