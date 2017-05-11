 <div class="container">

   
 
 
 



<div class="col-md-4">
</div>
<div class="col-md-4">

	<div class="login-panel panel panel-default">
		<div class="panel-body"> 

		


		<?php 
		if($this->session->flashdata('message')){
			?>
			<div class="alert alert-danger">
			<?php echo $this->session->flashdata('message');?>
			</div>
		<?php	
		}
		?>				  
			

		</div>
	</div>

</div>
<div class="col-md-4">


</div>



</div>