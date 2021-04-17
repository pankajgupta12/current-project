<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>	
<script type="text/javascript">
window.onload = function () {
		var chart1 = new CanvasJS.Chart("chartContainer1",
	{
		title:{
			text: "Quote According to Location"
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
			dataPoints: [
			  <?php  
			    
			    $sql1 =   mysql_query("SELECT id, name,abv FROM `sites`");
                while($sites = mysql_fetch_assoc($sql1)) {
				 $totalquote =  quoteBySite($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $sites['id'] , 1);
				 
			
			  ?>
				{ y: <?php echo $totalquote['totalquote']; ?>, indexLabel: "<?php echo $sites['abv']; ?> (<?php  echo $totalquote['totalquote']; ?>/<?php echo $totalquote['totalbooking']; ?>)" },
			   <?php  } ?>
			]
		}
		]
	});
	
	var chart2 = new CanvasJS.Chart("chartContainer2", {
	//exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Sales Team"
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
		dataPoints: [
		    <?php  
    			 $adminsql =   mysql_query("SELECT id, name FROM `admin` where is_call_allow = 1 AND status = 1 ORDER by id asc");
                while($admindata = mysql_fetch_assoc($adminsql)) {
				 $adminquote =  quoteBySite($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $admindata['id'] , 2);  
				 
			  ?>
			   { y: <?php echo $adminquote['totalquote'] ?>, name: "<?php echo $admindata['name'] ?>" },
			  <?php } 
			  $adminquote1 =  quoteBySite($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , 0 , 2);  
			  ?>
			  { y: <?php echo $adminquote1['totalquote'] ?>, name: "No Follow up" },
		
		]
			 
	}]
});

var chart3 = new CanvasJS.Chart("chartContainer3", {
	title: {
		text: "Monthly Quote and Booked"
	},
	axisX: {
		//valueFormatString: "MMM YYYY"
		valueFormatString: "MMMM YYYY"
	},
	axisY2: {
		//title: "Median List Price",
		//prefix: "$",
		//suffix: "K"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		verticalAlign: "top",
		horizontalAlign: "center",
		dockInsidePlotArea: true,
		itemclick: toogleDataSeries
	},
	data: [{
		type:"line",
		axisYType: "secondary",
		name: "Quote",
		showInLegend: true,
		markerSize: 0,
		yValueFormatString: "#,###",
		dataPoints: [	
		
		  <?php  
		   $month = date('m'); 
		   //$month = 12; 
		  for($i=1; $i<= $month; $i++) {
                $totalqu = getmonthlyQuote($i , 0);
		  ?>
		    { x: new Date(<?php echo date('Y'); ?>, <?php echo $i; ?> , ' '), y: <?php echo $totalqu; ?> },
		  <?php   }  ?>
		]
	},
	{
		type: "line",
		axisYType: "secondary",
		name: "Booked",
		showInLegend: true,
		markerSize: 0,
		yValueFormatString: "#,###",
		dataPoints: [
			 <?php  
			  $jmonth = date('m'); 
			//  $jmonth = 12; 
			 for($j=1; $j<= $jmonth; $j++) { 
			   $totalbooked = getmonthlyQuote($j , 1);
			 ?>
		      { x: new Date(<?php echo date('Y'); ?>, <?php echo $j; ?> , ' '), y: <?php echo $totalbooked; ?> },
		    <?php  }   ?>
		
		]
	}]
});

 /* var chart4 = new CanvasJS.Chart("chartContainer4", {            
      title:{
        text: "Monthly job Type Amount/Staff Amt/BCIC Profit"              
      },

      data: [  //array of dataSeries     
      { //dataSeries - first quarter
       type: "column",
       name: "Total Job Amount",
	    showInLegend: true,
       dataPoints: [
	<?php   
          $jobsql =   mysql_query("SELECT id, name FROM `job_type`  ORDER by id asc");
                while($jobdata = mysql_fetch_assoc($jobsql)) {
				$getdata = gettotalAmountData($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $jobdata['id']);
     ?>	
       { label: "<?php echo $jobdata['name']; ?>", y: <?php echo $getdata['totalamt'] ?> },
				<?php  }   ?>
       ]
     },
     { //dataSeries - second quarter

      type: "column",
      name: "Total Staff Amount",     
      showInLegend: true,	  
      dataPoints: [
	  <?php   
	  //
       $jobsql =   mysql_query("SELECT id, name FROM `job_type`  ORDER by id asc");
                while($jobdata = mysql_fetch_assoc($jobsql)) {
				$getdata = gettotalAmountData($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $jobdata['id']);
     ?>	
      { label: "<?php echo $jobdata['name']; ?>", y: <?php echo $getdata['staffamt'] ?> },
				<?php  }  ?>
      ]
    },
        { //dataSeries - second quarter

      type: "column",
      name: "Total Profit Amount",   
       showInLegend: true,	  
      dataPoints: [
	   <?php   
	    $jobsql =   mysql_query("SELECT id, name FROM `job_type`  ORDER by id asc");
                while($jobdata = mysql_fetch_assoc($jobsql)) {
				$getdata = gettotalAmountData($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $jobdata['id']);
     ?>	
       { label: "<?php echo $jobdata['name']; ?>", y: <?php echo $getdata['profitamt'] ?> },
				<?php  }  ?>
      ]
    }
    ]
  });
   */
 var chart5 = new CanvasJS.Chart("chartContainer5", {
	animationEnabled: true,
	title: {
		text: "Job Status Details"
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "##",
		indexLabel: "{label} {y}",
		dataPoints: [
		 <?php  
		  $sql = mysql_query("SELECT *  FROM `system_dd` WHERE `type` = 26");
		  while($statusdata = mysql_fetch_assoc($sql)) {
			  
			$totalcount =  getjobStatusData($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'] , $statusdata['id']);
           
		 ?>
			{y: <?php echo $totalcount; ?>, label: "<?php echo $statusdata['name']; ?>"},
		  <?php  } ?>
		]
	}]
});
	
	var chart6 = new CanvasJS.Chart("chartContainer6", {            
      title:{
        text: "Current Month <?php echo date('M Y');?> Daily Quote/Booking"              
      },

      data: [  //array of dataSeries     
      
         { //dataSeries - second quarter
    
          type: "column",
          name: "Quote", 
          showInLegend: true,               
          dataPoints: [
          <?php   
           $GetQuoteData1 = GetQuoteData__1();
          for($i1=1; $i1<= date('t'); $i1++) { 
              
                $days1 = $i1.' '.date('M');
               
               if($GetQuoteData1[$i1] > 0) {
                   $Totalquote = $GetQuoteData1[$i1];
               }else{
                   $Totalquote = 0;
               }
               
              ?>  
              { label: "<?php echo $days1; ?>", y: <?php  echo $Totalquote; ?> },
          <?php  } ?>
          ]
        },
        { //dataSeries - second quarter
    
          type: "column",
          name: "Booking", 
          showInLegend: true,               
          dataPoints: [
          <?php 
          
          $getBookingQ_1 = GetBookingQuoteData__1();
          
         // print_r($getBookingQ_1);
          
          
          for($i1=1; $i1<= date('t'); $i1++) {
              $days2 = $i1.' '.date('M');
               
                  if($getBookingQ_1[$i1] > 0) {
                   $counttotal = $getBookingQ_1[$i1];
                  }else{
                      $counttotal = 0;
                  }
              ?>  
              { label: "<?php echo $days2; ?>", y: <?php  echo $counttotal; ?> },
          <?php  } ?>
          ]
        }
    ],
 /** Set axisY properties here*/
    axisY:{
      prefix: "",
      suffix: ""
    }    
  });
  
  /* var chart7 = new CanvasJS.Chart("chartContainer7", {
  theme: "light1", // "light1", "light2", "dark1"
  animationEnabled: true,
  exportEnabled: true,
  title: {
    text: "Current Month Quote By Status"
  },
  axisX: {
    margin: 10,
    labelPlacement: "inside",
    tickPlacement: "inside"
  },
  axisY2: {
   // title: "Views (in billion)",
    titleFontSize: 20,
    includeZero: true,
    suffix: ""
  },
  data: [{
    type: "bar",
    axisYType: "secondary",
    yValueFormatString: "",
    indexLabel: "{y}",
    dataPoints: [
	 <?php  
	  $getStatusdata = quoteStatusInfoData(); 
          foreach($getStatusdata as $key=>$value1) {
	 ?>
      { label: "<?php echo $value1['stepname']; ?>", y: <?php echo $value1['totalquote']; ?> },
		  <?php  } ?>
    ]
  }]
});
 */

var chart7 = new CanvasJS.Chart("chartContainer7", {
	animationEnabled: true,
	
	title:{
		 text: "Current Month Quote By Status"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		//title: "Number of Companies"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#014D65",
		dataPoints: [
		 <?php  
	  $getStatusdata = quoteStatusInfoData(); 
          foreach($getStatusdata as $key=>$value1) {
	 ?>
			{ y: <?php echo $value1['totalquote']; ?>, label: "<?php echo $value1['stepname']; ?>" },
			 <?php  } ?>	
		]
	}]
});

  
 var chart8 = new CanvasJS.Chart("chartContainer8", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "yearly/Monthly Quote/Booked Info"
	},
	axisY: {
		title: "Total Quote/Booked",
		valueFormatString: "#0",
		includeZero: true,
		//suffix: "K",
		//prefix: "£"
	},
	legend: {
		cursor: "pointer",
		itemclick: toogleDataSeries
	},
	toolTip: {
		shared: true
    },
	data: [{
		type: "area",
		name: "Quote",
		markerSize: 5,
		showInLegend: true,
		//xValueFormatString: "MMMM",
		//yValueFormatString: "£#0K",
		dataPoints: [
		    <?php $quoteinf = allgetQUoteInfo(); 
		    foreach($quoteinf as $key=>$valquote) {
		    ?> 
			{ x: new Date(<?php echo $valquote['yearnumber'] ?>, <?php echo ($valquote['monthnumber'] - 1) ?>), y: <?php echo $valquote['quoteid'] ?> },
	    	<?php  } ?>	
		]
	}, {
		type: "area",
		name: "Booked",
		markerSize: 5,
		showInLegend: true,
		//yValueFormatString: "£#0K",
		dataPoints: [
		    <?php //$quoteinf = allgetQUoteInfo(); 
		       foreach($quoteinf as $key=>$valquote) {
		    ?> 
		    	{ x: new Date(<?php echo $valquote['yearnumber'] ?>, <?php echo ($valquote['monthnumber'] -1) ?>), y: <?php echo $valquote['totalbooked'] ?> },
	    	<?php  } ?>	
		]
	}]
});
  
 //chart.render();
	
	
	chart1.render();
	chart2.render();
	chart3.render();
	//chart4.render();
	chart5.render();
	chart6.render();
	chart7.render();
	chart8.render();
	
	
	function toogleDataSeries(e){
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

}
}


	function get_dahboard(){
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
		
	}
</script>