
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



<!--<footer style=" background: #056839; min-height: 100px; height: auto; padding: 2rem 0; color: #fff">
<div class="container">
<div class="col-md-4 padding_left_none">
    <div class="row">
        <div class="col-md-2"> <img src="<?=base_url()?>images/location.png" alt="Location" width="40" style="width: 40px"> </div>
        <div class="col-md-9 padding_left_none">
          <p>Address<br/>
            4/8 Humayun Road, Block-B, Mohammadpur, Dhaka - 1207, Bangladesh </p>
        </div>
      </div>
    </div>
   <div class="col-md-4">
    <div class="row">
        <div class="col-md-2"> <img src="<?=base_url()?>images/phone.png" alt="Location" width="40" style="width: 40px"> </div>
        <div class="col-md-9 padding_left_none">
          <p>Phone<br/>
            +8809606016227 <br/>
            <br/>
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-4 padding_right_none">
    <div class="row">
        <div class="col-md-2"> <img src="<?=base_url()?>images/globe.png" alt="Location" width="40" style="width: 40px"> </div>
        <div class="col-md-9 padding_left_none">
          <p>E-mail<br/>
            info@kite.com.bd </p>
        </div>
      </div>
    </div>
</div>
<div class="container">
<p class="text_right" style="text-align: right"><a href="" title="Find us on facebook"><img src="<?=base_url()?>images/facebook.png" alt="Facebbok" width="45" /></a>
        <a href="" title="Find us on facebook"><img src="<?=base_url()?>images/google_plus.png" alt="Facebbok" width="45" /></a>
        <a href="" title="Find us on facebook"><img src="<?=base_url()?>images/skype.png" alt="Facebbok" width="45" /></a>
        <a href="" title="Find us on facebook"><img src="<?=base_url()?>images/youtube.png" alt="Facebbok" width="45" /></a></p>
</div>
<div class="container" style="text-align:center;">
Powered by <a href="http://kite.com.bd">Kite Bangladesh</a>
</div>
</footer>-->

</body>
</html>
