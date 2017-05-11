<div class="container">
<div class="row">
  <div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php echo $num_users;?></div>
            <div><?php echo $this->lang->line('no_registered_user');?> </div>
          </div>
        </div>
      </div>
      <a href="<?php echo site_url('user');?>">
      <div class="panel-footer"> <span class="pull-left"><?php echo $this->lang->line('users');?> <?php echo $this->lang->line('list');?></span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php echo $num_quiz;?></div>
            <div><?php echo $this->lang->line('no_registered_quiz');?> </div>
          </div>
        </div>
      </div>
      <a href="<?php echo site_url('quiz');?>">
      <div class="panel-footer"> <span class="pull-left"><?php echo $this->lang->line('quiz');?> <?php echo $this->lang->line('list');?></span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-question-circle fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php echo $num_qbank;?></div>
            <div><?php echo $this->lang->line('no_questions_qbank');?></div>
          </div>
        </div>
      </div>
      <a href="<?php echo site_url('qbank');?>">
      <div class="panel-footer"><?php echo $this->lang->line('question');?> <?php echo $this->lang->line('list');?></span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
  <div class="row"></div>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php /*echo $num_users;*/?></div>
            <div>Home Work </div>
          </div>
        </div>
      </div>
      
      <div class="panel-footer"> 
      <?php foreach($home_work_list as $homeWork){?>
      <a href="<?php echo site_url('home_work');?>">
      <span class="pull-left"><?=$homeWork['home_work_title']?></span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
      </a>
        <div class="clearfix"></div>
        <?php }?>
      </div>
       </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php /*echo $num_quiz;*/?></div>
            <div>Parent Notification</div>
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
       <?php foreach($teacher_message as $message){
		 
		 $this->db->where('message_id',$message['id']);
		 $this->db->where('replied_user_id',$message['parent_id']);
		 $this->db->where('is_view','0');
		 $query = $this->db->get('savsoft_message_reply');
		 $countReplyMessage = $query->num_rows();
		 
		 if($message['is_view']==0 && $countReplyMessage>0){
			 $newMessage = 1+$countReplyMessage;
		 }elseif($message['is_view']==1 &&$countReplyMessage>0){
			 $newMessage = $countReplyMessage;
		 }elseif($message['is_view']==0){
			 $newMessage = 1;
		 }else{
		 }
		  
		?>
      <a href="<?php echo site_url('teacher/message/'.$message['id']);?>">
      <span class="pull-left"><?=$message['first_name'].' '.$message['last_name']?>(<?=$message['subject_name']?>)</span> <span class="pull-right"><i class="<?php if($newMessage>0){ ?> round<?php }?>"><?=$newMessage?></i></span>
      </a>
        <div class="clearfix"></div>
        <?php }?>
      </div>
      </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-question-circle fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php /*echo $num_qbank;*/?></div>
            <div><?php /*echo $this->lang->line('no_questions_qbank');*/?></div>
          </div>
        </div>
      </div>
      <div class="panel-footer">
        <div class="clearfix"></div>
      </div>
   </div>
  </div>
  <div class="row"></div>
</div>
</div>