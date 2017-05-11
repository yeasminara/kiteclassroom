

<link href="<?php echo base_url('bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
 <script src="http://tinymce.cachefly.net/4.1/tinymce.min.js"></script>
 <script src="<?php echo base_url('js/jquery.js');?>"></script>
 <script src="<?=base_url()?>js/doc/vendor/FileSaver.js"></script>
  <script src="<?=base_url()?>js/doc/html-docx.js"></script>
<script>

 
 $('#convert').click(function(){
		var donload = 1;
		var examID = $('#examID').val();
		$.ajax({
                type:'POST',
                url:'<?php echo base_url();?>exam/download_complete/',
                data:'&donload='+donload+'&examID='+examID,
                success: function(data){
							location.reload();
                    
                    }

                })
	})
	
</script>
 <div class="container">
  <div class="row">
    <section class="wrapper">
      <div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title"><?=$title?> </div>
				</div>
  				<div class="panel-body">
              <div class="page-orientation">
                <span>Page orientation:</span>
                <label><input type="radio" name="orientation" value="portrait" checked>Portrait</label>
                <label><input type="radio" name="orientation" value="landscape">Landscape</label>
              </div>
              <input type="hidden" name="examID" id="examID" value="<?=$resultExam['quid']?>" />
  				<button id="convert" class="btn btn-success">Download Question</button>
  				<div id="download-area"></div>
                <br/>
                
<style>
.mce-item-table, .mce-item-table td, .mce-item-table th, .mce-item-table caption{
	border: 1px dashed #fff !important;
}
.mce-item-table td{
	border: none !important;
	
}
</style>
                <textarea class="form-control" name="full_question_pattern" id="content" style="height:600px">
                <?=$resultExam['full_question_pattern']?>
                </textarea>
			
               
  				</div>
  			</div>
            


  <script>
    tinymce.init({
      selector: '#content',
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen fullpage",
        "insertdatetime media table contextmenu paste"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | " +
        "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | " +
        "link image"
    });
    document.getElementById('convert').addEventListener('click', function(e) {
      e.preventDefault();
      convertImagesToBase64()
      // for demo purposes only we are using below workaround with getDoc() and manual
      // HTML string preparation instead of simple calling the .getContent(). Becasue
      // .getContent() returns HTML string of the original document and not a modified
      // one whereas getDoc() returns realtime document - exactly what we need.
      var contentDocument = tinymce.get('content').getDoc();
      var content = '<!DOCTYPE html>' + contentDocument.documentElement.outerHTML;
      var orientation = document.querySelector('.page-orientation input:checked').value;
      var converted = htmlDocx.asBlob(content, {orientation: orientation});

      saveAs(converted, 'question.doc');

      var link = document.createElement('a');
      link.href = URL.createObjectURL(converted);
      link.download = 'question.doc';
      link.appendChild(
        document.createTextNode('Click here if your download has not started automatically'));
      var downloadArea = document.getElementById('download-area');
      downloadArea.innerHTML = '';
      downloadArea.appendChild(link);
    });

    function convertImagesToBase64 () {
      contentDocument = tinymce.get('content').getDoc();
      var regularImages = contentDocument.querySelectorAll("img");
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext('2d');
      [].forEach.call(regularImages, function (imgElement) {
        // preparing canvas for drawing
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        canvas.width = imgElement.width;
        canvas.height = imgElement.height;

        ctx.drawImage(imgElement, 0, 0);
        // by default toDataURL() produces png image, but you can also export to jpeg
        // checkout function's documentation for more details
        var dataURL = canvas.toDataURL();
        imgElement.setAttribute('src', dataURL);
      })
      canvas.remove();
    }
  </script>
</section>
</div>