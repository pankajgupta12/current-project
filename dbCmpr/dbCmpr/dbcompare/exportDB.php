<?php

require_once('config.php');
require_once('DbDiff.php');

//echo "<pre>";
//print_r($dbs_config);




$downloadObj = new DbDiff();

$dbName = $_POST['name_setter'] . '.sql';
  //$databasename = $_POST['name_setter'];
//$dbName = 'test.sql';
$data = '';
 
//check full data once
if( !empty( $_POST['tableval'] ) ||  !empty($_POST['alterVal']) ) :

	if( !empty( $_POST['tableval'] ) ) : 
	
		//table structure
		foreach ($_POST['tableval'] as $tbl)
		{
			if( file_exists( "inc/".$tbl.".inc" ) ) :	
				$data .= file_get_contents("inc/".$tbl.".inc");
				
				//check user is check for data import tableDataVal
				if( !empty( $_POST['tableDataVal'] ) ) :
				
					foreach ($_POST['tableDataVal'] as $tblDataName)
					{
						if( $tbl === base64_decode($tblDataName) )	:
						
							//data import check into file
							if( file_exists( "inc/" . base64_decode($tblDataName) . "_import.inc" ) ) :	
							
								$data .= file_get_contents("inc/".base64_decode($tblDataName)."_import.inc");
							
							endif;
							
						endif;	
					}
				
				endif;		
				
			endif;	
		}

		$files = glob('inc/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}
	endif;
	
	if( !empty( $_POST['alterVal'] ) ) : 
	
		foreach( $_POST['alterVal'] as $key => $query ) :
			
			$altQuery = explode( "##", base64_decode($query) );			
			$setQuery = $altQuery[0];
			$type = $altQuery[1];
			
			$downloadObj->createAlterSheetForExport( $setQuery , $type );
				
		endforeach;
		
		//get all content from alter sheet to appen in downald sql file
		$data .= file_get_contents( "modify/alter.inc");
		
		//remove file
		$files = glob('modify/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}
		
	endif;
	
	//empty first time
	$downloadObj->putContentPublically( "inc/{$dbName}", "" );

	//add default comments
	$downloadObj->putContentPublically( "inc/{$dbName}", "-- phpMyAdmin SQL Dump"  . PHP_EOL ,FILE_APPEND);

	//add default comments
	$downloadObj->putContentPublically( "inc/{$dbName}", "-- HOST"  . PHP_EOL ,FILE_APPEND);

	//add default comments
	//$dateTimeGeneration = date_format(date(), 'g:ia \o\n l jS F Y');
	$downloadObj->putContentPublically( "inc/{$dbName}", "-- Generation Time: {date()}"  . PHP_EOL ,FILE_APPEND);

	//add default comments
	//file_put_contents( "inc/{$dbName}", " SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' "  . PHP_EOL ,FILE_APPEND);

	$downloadObj->putContentPublically( "inc/{$dbName}", " SET SQL_MODE = ''; "  . PHP_EOL ,FILE_APPEND);

	//add default comments
	//file_put_contents( "inc/{$dbName}", " SET time_zone = '+00:00' "  . PHP_EOL ,FILE_APPEND);

	$downloadObj->putContentPublically( "inc/{$dbName}", "--"  . PHP_EOL ,FILE_APPEND);
	$downloadObj->putContentPublically( "inc/{$dbName}", "--"  . PHP_EOL ,FILE_APPEND);
	$downloadObj->putContentPublically( "inc/{$dbName}", "-- --STRUCTURE SQL"  . PHP_EOL ,FILE_APPEND);
	$downloadObj->putContentPublically( "inc/{$dbName}", "{$data}"  . PHP_EOL,FILE_APPEND );
	$downloadObj->putContentPublically( "inc/{$dbName}", "--"  . PHP_EOL ,FILE_APPEND);
	$downloadObj->putContentPublically( "inc/{$dbName}", "--"  . PHP_EOL ,FILE_APPEND);
	$downloadObj->putContentPublically( "inc/{$dbName}", "--"  . PHP_EOL ,FILE_APPEND);
	
	if( file_exists('inc/'.$dbName))
	{	
		$downloadObj->download( $dbName );		
		unset($downloadObj);
	}
	else
	{
		echo "error";
	}

endif;
?>