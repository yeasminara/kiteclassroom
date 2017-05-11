<div class="container">
<div class="row">
<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
  <div class="col-md-6">
    <div class="panel panel-info">
      <div class="panel-heading">
      
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div>Subject with Teacher List </div>
          </div>
        </div>
      </div>
       <style>
	  .round{
		  background: green;
		  color: #fff;
		  -webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px;
padding: 5px 10px;
	  }
	  </style>
      <div class="panel-footer">  
      	<table width="100%" cellpadding="0" cellspacing="0" class="table table-border">
        	<tr><th>Subject</th><th>Teacher</th></tr>
            <?php foreach($subjectList as $subject){?>
            <tr><td><?=$subject['category_name']?></td><td>
            <?php 
			$teacherList = get_teacher_by_subject($subject['cid']);
			foreach($teacherList as $teacher){ 
				 $this->db->where('replied_user_id',$teacher['uid']);
				 $this->db->where('is_view','0');
				 $query = $this->db->get('savsoft_message_reply');
				 $countReplyMessage = $query->num_rows();
		 
			?>
             <a href="<?=base_url().'parents/message/'.$teacher['uid'].'/'.$student['student_id'].'/'.$subject['cid']?>"><span class="pull-left"><?=$teacher['first_name'].' '.$teacher['last_name']?></span>
             <?php if($countReplyMessage>0){ ?>
            <span class="pull-right"><i class=" round"><?=$countReplyMessage?></i></span><?php }?>
            </a>
            <?
			
			
			}?>
            </td></tr>
            <?php 
			
			}?>
        </table>
        <div class="clearfix"></div>
      </div>
      </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div>Student Informaion</div>
          </div>
        </div>
      </div>
      <div class="panel-footer">  
      	<table width="100%" cellpadding="0" cellspacing="0" class="table table-border">
        	<tr><td>Student Name</td><td><?=$student['first_name'].' '.$student['last_name']?></td></tr>
            <tr><td>Class Name</td><td><?=$student['class_name']?></td></tr>
            <tr><td>Section Name</td><td><?=$student['section_name']?></td></tr>
            <tr><td>Group Name</td><td><?=$student['group_name']?></td></tr>
            <tr><td>Roll</td><td><? if(strlen($student['roll_no'])==1){echo '0'.$student['roll_no'];
			}else{ echo $student['roll_no'];}?></td></tr>
        </table>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
 
 
  
  <div class="row"></div>
  <hr>
  <br>
</div>
</div>
