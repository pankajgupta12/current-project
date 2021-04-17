<?php

/*ini_set('memory_limit', '512M');
ini_set('max_execution_time', 140000000);
ini_set('max_input_time', 12000);*/

error_reporting(0);

include($_SERVER['DOCUMENT_ROOT'].'/admin/class/component.php');
include($_SERVER['DOCUMENT_ROOT'].'/admin/class/VoipCall.php');
include($_SERVER['DOCUMENT_ROOT'].'/admin/class/ParseCSV.php');

//for upload voip 3cx file and import data
if( (isset( $_POST['file_upload'] ) && $_POST['file_upload'] == 'Upload' ) )
{
	
	$fileCheck = false;
	$voip = new VoipCall();

	$voip->_component_ = $voip->rtnObject();

	$voip->_folder_access_ = '/admin/images/3cx_call_record/';

	$voip->_allowed_ = array( 'csv' );

	$voip->set_file_array( $_FILES );
	
	$importName = $voip->upload( $voip );
	
	//org_file_name 
	$voip->_org_file_name_ = $_FILES['voip_data']['name'];
	
    $Protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://" ;
    
    $siteUrl = 	$Protocol.$_SERVER['SERVER_NAME'];
          
	//$fileData = array_map('str_getcsv', file($siteUrl . $voip->_folder_access_ . $importName));

	$excelFile = $_SERVER['DOCUMENT_ROOT'] . $voip->_folder_access_ . $importName; 
	 
	//send csv data to class function and invoke through by reference
	if( $fileCheck == false )
	{
		unset($_SESSION['dup_count']);  
		$voip->saveRecordOfCall( $excelFile , $voip , $fileData , $importName , $siteUrl . $voip->_folder_access_ );	
	}
	else 
	{
		$_SESSION['dup_count'] = '<span style="color:red;">Please change date column type to general text into your csv file!</span>';
		$fileCheck == true;
	}
	//unset($voip);
	
	
	
	//unset file from server after import
	//@unlink($_SERVER['DOCUMENT_ROOT'] . $voip->_folder_access_ . $importName);
	
	$_SESSION['import_approved'] = 1;
	$_SESSION['import_approved_inner'] = 1;
	$_SESSION['import_name'] = $importName;
	$importName = '';
	
}

function validate_alphanumeric_underscore($str) 
{
    return preg_match('/^[a-zA-Z0-9_]+$/',$str);
}

?>
<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<div class="body_container">
                
              
            <div class="nav_form_main">
				<input type="hidden" name="task" value="dispatch_report">
				<ul class="dispatch_top_ul dispatch_top_ul2_import dispatch5">
				    <li>
						<label>Admin</label>
					
				         <span><?php echo create_dd("admin","c3cx_users","3cx_user_name","3cx_user_name","","onchange=\"send_data(this.value,'96','quote_view');\"",$_SESSION['call']);?></span> 
				    </li>

					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if($_SESSION['call']['from_date'] != '') { echo $_SESSION['call']['from_date']; } ?>" onchange="javascript:send_data(this.value,97,'quote_view');">
					</li>
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="from_date" id="to_date" value="<?php if($_SESSION['call']['to_date'] != '') { echo $_SESSION['call']['to_date']; } ?>" onchange="javascript:send_data(this.value,98,'quote_view');">
					</li>
                    <li>
						<label>Job ID/Quote ID</label>
                        <input name="name" type="text" id="job_quote" size="45" value="<?php if($_SESSION['call']['quote_job_id'] != '') { echo $_SESSION['call']['quote_job_id']; } ?>" onKeyup="javascript:send_data(this.value,99,'quote_view');">
					</li>	
					<li>
						 <input type="reset" onclick="javascript:reset_callreport('reset',100,'quote_view');" name="reset" value="Reset" />
					</li>	
					
					<li>
						<form method="post" enctype="multipart/form-data" >
						   <label>Import</label>
							 <input type="file" name="voip_data" id="fileupload" />
							 <input type="submit" class="job_submit" Onclick="return filevalidate();" name="file_upload" value="Upload" style="margin-top:  -35px;margin-right: 38px;"/>
                         </form>					
					</li>
				</ul>
				   
				<!--<ul class="dispatch_top_ul dispatch_top_ul2_import dispatch5">
				    <li>
						<label>Imports</label>
				         <span><?php //echo create_dd("imports_name","c3cx_imports","id","org_file_name","","",'');?></span> 
				    </li>
					<li>
					<input type="submit" class="job_submit" onClick="return deleteimportfiles();" name="deleteimport" value="delete">
					</li>
				</ul>-->
			</div>
	
	<div>
		<?php
			if( isset($_SESSION['dup_count']) && $_SESSION['dup_count'] != ''  ) 
			{
				echo $_SESSION['dup_count'];
				echo "<br/>";
				unset($_SESSION['dup_count']);
			}
			
			if( isset($_SESSION['cor_count']) && $_SESSION['cor_count'] != ''  ) 
			{
				echo $_SESSION['cor_count'];
				echo "<br/>";
				unset($_SESSION['cor_count']);
			}
			
		?>
	</div>
	<div id="quote_view">
		<?php
			include( $_SERVER['DOCUMENT_ROOT'].'/admin/xjax/view_import.php' );
		?>
	</div>
	<script>
			function filevalidate(){
				var inp = document.getElementById('fileupload');
				if(inp.files.length === 0){
				alert("Please select file");
				inp.focus();
				return false;
				}
			}
	</script>
</div>	
