<?php
// Default Params
$from_date = "";
$to_date = "";

function checkCaseCount($case_id, $user_id, $from_date, $to_date){
	switch ($case_id) {
		case '1': $cnt = noChecklist($user_id, $from_date, $to_date); break;
		case '2': $cnt = contactingCx($user_id, $from_date, $to_date); break;
		case '3': $cnt = cxComplaints($user_id, $from_date, $to_date); break;
		case '4': $cnt = dealCxDirect($user_id, $from_date, $to_date); break;
		case '5': $cnt = deniedJobs($user_id, $from_date, $to_date); break;
		case '6': $cnt = failRecleans($user_id, $from_date, $to_date); break;
		case '7': $cnt = plbas($user_id, $from_date, $to_date); break;
		case '8': $cnt = reCleans($user_id, $from_date, $to_date); break;
		case '9': $cnt = startStop($user_id, $from_date, $to_date); break;
		case '10': $cnt = unAvailability($user_id, $from_date, $to_date); break;
		case '11': $cnt = sickDay($user_id, $from_date, $to_date); break;
		case '12': $cnt = notWorking($user_id, $from_date, $to_date); break;
		default: $cnt = "-";  break;
	}
	return $cnt;
}

function countJob($type, $user_id, $from_date, $to_date){

	// $type = 1 (Offered) | 2 (Denied) | 3 (Accepted)
	if( $from_date != "" AND $to_date != "" )
	{
		
		if($type == 2) 
		{
			// Check Denied Jobs of Franchise
			$q2 = mysql_query("SELECT id  FROM `staff_jobs_status` WHERE `status` IN (0,2) AND date(created_at) >= '".$from_date."' AND date(created_at) <= '".$to_date."' AND staff_id = '".$user_id."' ");
		}
		elseif($type == 1)
		{
			// Check Offered Jobs of Franchise
			$q2 = mysql_query("SELECT DISTINCT(job_id) as jobid  FROM `staff_jobs_status` WHERE date(created_at) >= '".$from_date."' AND date(created_at) <= '".$to_date."' AND `staff_id` = ".$user_id." AND `status` = 5");
		}
		elseif($type == 3)
		{
			// Check Accepted Jobs of Franchise
			$q2 = mysql_query("SELECT DISTINCT(job_id) as jobid  FROM `staff_jobs_status` WHERE date(created_at) >= '".$from_date."' AND date(created_at) <= '".$to_date."' AND `staff_id` = ".$user_id." AND `status` IN (1,4) ");
		}
		elseif($type == 4)
		{
			// Check Reclean Jobs of Franchise
			$q2 = mysql_query("SELECT DISTINCT(job_id) as jobid  FROM `staff_jobs_status` WHERE date(created_at) >= '".$from_date."' AND date(created_at) <= '".$to_date."' AND `staff_id` = ".$user_id." AND `status` IN (3) ");
		}
	} 
	else 
	{
		if($type == 2) 
		{
			// Check Denied Jobs of Franchise
			$q2 = mysql_query("SELECT id  FROM `staff_jobs_status` WHERE `status` IN (0,2) AND staff_id = '".$user_id."' ");
		}
		elseif($type == 1)
		{
			// Check Offered Jobs of Franchise
			$q2 = mysql_query("SELECT DISTINCT(job_id) as jobid  FROM `staff_jobs_status` WHERE `staff_id` = ".$user_id." AND `status` = 5");
		}
		elseif($type == 3)
		{
			// Check Accepted Jobs of Franchise
			$q2 = mysql_query("SELECT DISTINCT(job_id) as jobid  FROM `staff_jobs_status` WHERE `staff_id` = ".$user_id." AND `status` IN (1,4) ");
		}
		elseif($type == 4)
		{
			// Check ReClean Jobs of Franchise
			$q2 = mysql_query("SELECT DISTINCT(job_id) as jobid  FROM `staff_jobs_status` WHERE `staff_id` = ".$user_id." AND `status` IN (3) ");
		}
	}

	$cnt2 = mysql_num_rows($q2);

	return $cnt2;
}

function noChecklist($user_id, $from_date, $to_date){
	return true;
}

function contactingCx($user_id, $from_date, $to_date){
	return true;
}

function cxComplaints($user_id, $from_date, $to_date){
	return true;
}

function dealCxDirect($user_id, $from_date, $to_date){
	return true;
}
function deniedJobs($user_id, $from_date, $to_date){
	return true;
}

function failRecleans($user_id, $from_date, $to_date){
	$q1 = mysql_query("SELECT id FROM `job_reclean` WHERE staff_id = ".$user_id." and reclean_date>='".$from_date."' AND reclean_date <='".$to_date."'  and status != 2 AND reclean_work = 2 group by job_id");
	$rs =   mysql_num_rows($q1);
	return $rs;
}

function plbas($user_id, $from_date, $to_date){
	return true;
}

function reCleans($user_id, $from_date, $to_date){
	$q1 = mysql_query("SELECT id FROM `job_reclean` WHERE staff_id = ".$user_id." and reclean_date>='".$from_date."' AND reclean_date <='".$to_date."'  and status != 2 group by job_id");
	$rs = mysql_num_rows($q1);
	return $rs;
}

function startStop($user_id, $from_date, $to_date){
	return true;
}
function unAvailability($user_id, $from_date, $to_date){
	return true;
}
function sickDay($user_id, $from_date, $to_date){
	return true;
}
function notWorking($user_id, $from_date, $to_date){
	return true;
}


// function countAssignJob(){
// 	$q1 = mysql_query("SELECT DISTINCT(job_id) as jobid  FROM `staff_jobs_status` WHERE `staff_id` = 99 AND `status` = 5")
// }

if(isset($_POST))
{
	if($_POST['from_date']!="" && $_POST['to_date']!="")
	{
		// Collect the posted search query
		$from_date = strtolower(mysql_real_escape_string($_POST['from_date']));
		$to_date = strtolower(mysql_real_escape_string($_POST['to_date']));
		$task = strtolower(mysql_real_escape_string($_POST['task']));

		$from_date = date("Y-m-d", strtotime($from_date) );
		$to_date = date("Y-m-d", strtotime($to_date) );

		$q = "task=".$task."&from_date=".$from_date."&to_date=".$to_date;

		// If validation has passed, redirect to the URL rewritten search page
		if ($q != '') {
		   header( 'Location: '.$site_name . "/admin/index.php?" . $q );
		}
	}
}


// Get Franchise List
$q1 = mysql_query("SELECT id, name  FROM `staff` WHERE `status` = 1 AND `better_franchisee` = 2");

$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

?>
<div class="container franchise_case">
	<div class="row">
		<div class="col-md-12">
			<h2>Franchise Case Report (<?php echo $from_date . " to " . $to_date ?>) </h2>
			
			<div class="datepicker">
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<label for="from">From</label>
				<input type="text" id="from" name="from_date" value="<?php if($from_date!=""){ echo $from_date; } ?>" autocomplete="off" >
				<label for="to">to</label>
				<input type="text" id="to" name="to_date" value="<?php if($to_date!=""){ echo $to_date; } ?>" autocomplete="off" >
				<input type="hidden" name="task" value="franc_case_report">
				<input type="submit" name="submit" value="Submit">
				</form>
			</div>

			
			<table class="table table-striped outer-table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Franchise Name</th>
						<th>Case Type</th>
					</tr>
				</thead>

				<tbody>
				<?php
					if (mysql_num_rows($q1)>0)
					{ 
						while ($row1 = mysql_fetch_assoc($q1)) 
						{
							$offered = countJob(1, $row1['id'],$from_date,$to_date);
							$declined = countJob(2, $row1['id'],$from_date,$to_date);
							$accepted = countJob(3, $row1['id'],$from_date,$to_date);
							$reclean = countJob(4, $row1['id'],$from_date,$to_date);
							$perc = ($declined/$offered)*100;

							?>
						<tr>
							<td><?php echo $row1['id']; ?></td>
							<td><?php echo $row1['name']; ?></td>
							<td>
								<table class="inner_table">
									<tr>
										<th>Offered</th>
										<th>Accepted</th>
										<th>ReClean</th>
										<th>Denied</th>
										<th>Denied %</th>
									</tr>
									<tr>
										<td><?php echo $offered; ?></td>
										<td><?php echo $accepted; ?></td>
										<td><?php echo $reclean; ?></td>
										<td><?php echo $declined; ?></td>
										<td class="<?php if($perc  > 50){ echo 'bgred'; } else { echo ''; } ?>"> <?php echo round($perc)."%"; ?></td>
									</tr>
								</table>
								<br>
								<table class="inner_table">
									<tr>
										<th>SNo</th>
										<th>Type</th>
										<th>Count</th>
										<th>%</th>
										<th>Step 1</th>
										<th>Step 2</th>
										<th>Step 3</th>
										<th>Step 4</th>
									</tr>
									<?php 
										$p=1;
										$q3 = mysql_query("SELECT * FROM franc_case_type WHERE status = 1 ");
										if( mysql_num_rows($q3) > 0 )
										{
											while($row3 = mysql_fetch_assoc($q3))
											{
												$q4 = mysql_query("SELECT * FROM franc_case_step WHERE case_id = '".$row3['id']."' ");

												echo "<tr>";
												echo "<td>".$p."</td>";
												echo "<td>". $row3['case_title'] ."</td>";
												echo "<td>". checkCaseCount($row3['id'], $row1['id'], $from_date, $to_date) ."</td>";
												echo "<td></td>";
												if( mysql_num_rows($q4) > 0 )
												{
													$i4=1;
													while ($row4 = mysql_fetch_assoc($q4)) 
													{
														echo "<td>". $row4['step_heading'] ."</td>";
														$i4++;
													}
												}

												for($i = $i4; $i <= 4; $i++) 
												{
													echo "<td> - </td>";
												}
												echo "</tr>";
												$p++;
											}
										}
									?>
								</table>
								

							<?php //echo checkRecleanCount($user_id = $row1['id'], $from_date = "2019-10-01", $to_date = "2019-11-31");  ?></td>
						
						</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>

		</div>
	</div>
</div>


<style type="text/css">
	.franchise_case .inner_table{ width: 95%;  }
	.franchise_case .inner_table th, .franchise_case .inner_table td{ border: 1px solid #ccc; padding: 2px 5px;  }
	.franchise_case h2 { float: left;}
	.franchise_case .datepicker {float: right;}
	.franchise_case table td{  }
	.franchise_case td.bgred{background-color: #f70f0f;color: #fff;}
</style>
  <script>
  $( function() {
    var dateFormat = "mm-dd-yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>