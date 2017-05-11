<div class="container">
<div class="row">
  
  <div class="col-md-6 col-md-offset-3" >
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-9"> <i class="fa fa-users fa-5x"></i>Teacher: <?=$teacherInfo['first_name'].' '.$teacherInfo['last_name']?>&nbsp; &nbsp; Subject :  <?=$subjectInfo['category_name']?>  </div>
          <div class="col-xs-3 text-right">
            <div>Message Box</div>
          </div>
        </div>
      </div>
      <style>
	  hr{
		      border-top: 2px solid #d6e9c6;
	  }
	  </style>
      <div class="panel-footer">  
      <p>Message Body</p>
      <?php if($messageInfo['message']){
		  echo $messageInfo['message'];
		  echo '<hr/>';
		   } else{?>     	
          <form name="frmMessage" id="frmMessage" method="post" action="<?=$this->uri->uri_string()?>" enctype="multipart/form-data"> 
           <textarea name="main_message" id="main_message"></textarea>
           <input type="hidden" name="teacher_id" value="<?=$teacherInfo['uid']?>" />
           <input type="hidden" name="student_id" value="<?=$student['student_id']?>" />
           <input type="hidden" name="subject_id" value="<?=$subjectInfo['cid']?>" />
        <br/>
        <input type="submit" name="send" value="Send" class="btn btn-success" style="float:right" />
        </form>
        <?php }?>
        <?php foreach($messageReplyInfo as $messageReply){?>
        	<p style="margin-bottom:0"> <?=$messageReply['message']?></p>
            <p style="text-align:right"><?=$messageReply['first_name'].' '.$messageReply['last_name']?></p>
            <hr/>
        <?php }?>
        <div class="clearfix"></div>
        <?php if($messageInfo['message']){?>
        <form name="frmReply" id="frmReply" method="post" action="<?=$this->uri->uri_string()?>" enctype="multipart/form-data"> 
        <textarea name="replay_message" id="replay_message"></textarea>
        <br/>
        <input type="hidden" name="message_id" id="message" value="<?=$messageInfo['id']?>" />
        <input type="submit" name="reply" value="Reply" class="btn btn-success" style="float:right" />
        </form>
        <?php }?>
        <div class="clearfix"></div>
      </div>
      </div>
  </div>
 <div class="clearfix"></div>
 
  
  <div class="row"></div>
 
</div>
</div>
