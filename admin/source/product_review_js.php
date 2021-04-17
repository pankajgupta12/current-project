<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>	
<script type="text/javascript">
window.onload = function () {
	var chart1 = new CanvasJS.Chart("chartContainer1",
	{
		title:{
			text: "Last Week Review According to Location"
		},
		legend: {
			maxWidth: 350,
			itemWidth: 200
		},
		data: [
		{
			type: "pie",
			//showInLegend: true,
			legendText: "{indexLabel}",
			dataPoints: 
			[
			  <?php   $sql1 =   mysql_query("SELECT id, name FROM `sites`");
               while($sites = mysql_fetch_assoc($sql1)) {
				 //$totalquote =  quoteBySite($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $sites['id'] , 1);
				$getreview =  WeeklyviewData($sites['id']);
			  ?>
			
				  { y: "<?php echo $getreview['count']; ?>", indexLabel: "<?php echo $sites['name']; ?>(<?php echo $getreview['count']; ?>)" },
				
			   <?php  } ?>
			]
		}
		]
	});
	
	var chart2 = new CanvasJS.Chart("chartContainer2", {
	//exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Product Review"
	},
	legend:{
		//cursor: "pointer",
		//itemclick: explodePie
	},
	data: [{
		type: "pie",
		//showInLegend: true,
		//toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} - {y}",
		dataPoints: 
		[
			  <?php   $sql1 =   mysql_query("SELECT id, name FROM `sites`");
               while($sites = mysql_fetch_assoc($sql1)) {
				 //$totalquote =  quoteBySite($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $sites['id'] , 1);
				$getreview =  WeeklyviewData($sites['id']);
			  ?>
			
				  { y: "<?php echo $getreview['count']; ?>", indexLabel: "<?php echo $sites['name']; ?>(<?php echo $getreview['count']; ?>)" },
				
			   <?php  } ?>
		]
			 
	}]
});

	
	chart1.render();
	chart2.render();
	
	/* function toogleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else{
		e.dataSeries.visible = true;
	}
	 chart.render();
   }
	
	function explodePie (e) {
	if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
	} else {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
	}
	e.chart.render();

    } */
}


	/* function get_dahboard(){
		var from_date = $('#from_date').val();
		var to_data =  $('#to_data').val();
		
		$.ajax({
			url: "xjax/dashbaord_ajax.php",
			type: "POST",
			data:'from_date='+from_date+'&to_data='+to_data,
			success: function(data){
			 //$('#getpage').html(data);
			  location.reload(); // then reload the page.(3)
			}
		  });
		
	} */
</script>