
<div class="container">
  <div class="login-panel panel panel-default">
    <div class="panel-body">
      <link rel='stylesheet' type='text/css' href='<?=base_url()?>fullcalendar/fullcalendar.css' />
      <link rel='stylesheet' type='text/css' href='<?=base_url()?>fullcalendar/fullcalendar.print.css' media='print' />
      <!--<script type='text/javascript' src='../jquery/jquery-1.8.1.min.js'></script>--> 
      <script type='text/javascript' src='<?=base_url()?>fullcalendar/jquery-ui-1.8.23.custom.min.js'></script> 
      <script type='text/javascript' src='<?=base_url()?>fullcalendar/fullcalendar.min.js'></script> 
      <script type='text/javascript'>


$(document).ready(function() {
	
		$('#calendar').fullCalendar({
		header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
			
			events: "<?=base_url()?>loading/json_events",
			
			eventDrop: function(event, delta) {
				alert(event.title + ' was moved ' + delta + ' days\n' +
					'(should probably update your database)');
			},
			
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			}
			
		});
		
	});
	
</script>
      <style type='text/css'>


	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
      <div id='calendar'></div>
    </div>
  </div>
</div>
