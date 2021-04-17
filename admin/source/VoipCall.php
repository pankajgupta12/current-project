<?php
//error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/admin/source/functions/config.php');

class VoipCall
{
	
	//default db
	public $db;
	
	public $valid;
	
	public $_file_;
	
	public $_component_;
	
	public $_folder_access_;
	
	public $_org_file_name_;
	
	public $_allowed_;
	
	public static $_import;
	
	public static $_data;
	
	public static $_calls;
	
	public static $_call_details;
	
	public static $_import_name;
	
	public function __construct() 
	{
		
		//$this->db=new Mysqlidb(HOST, USER, PASSWORD, DB);
		//$this->valid=new Validation(); 
		
    }
	
	/*	
		@params : $_FILE and Destination (folder name)
		return result
	*/
	public function upload( &$grabOject = null )
	{	
		return $grabOject->_component_->uploadFile( $grabOject->get_file_array() , $grabOject->_folder_access_ , null , null , $grabOject->_allowed_ );
	}
	
	/*
	
		@params, csv data
		Save data into 3 tables
	
	*/
	public function saveRecordOfCall( $importName = null , &$grabOject = null , $csvRenderData = null )
	{
		
		/* echo "<pre>";
		print_r($csvRenderData);
		exit; */
		
		if(strlen('7/12/2017  8:34:00') == 10){
        $date = explode('-',$date);
        $M= $date[0];
        $D = $date[1];
        $Y = $date[2];
       //this $date = $Y.'-'.$m.'-'.$d;
       //or this =>
       $date = date('Y-m-d H:i:s', mktime($h, $m, $s, $M, $D, $Y));
    }else{
         $date = date('Y-m-d H:i:s', strtotime($date));
    }

    echo $date; exit;
		
		/* echo self::checkAndRepNumAgain('Payal(102)');
		echo "<br />";
		echo self::checkAndRepNumAgain('(61407307240)'); exit; */
		
		self::filterCsvDataByRow( $importName , $grabOject , $csvRenderData );
		
	}
	
	/*
		@params : $_file_
	*/
	public function set_file_array( $_file_ )
	{
		$this->_file_ = $_file_;	
	}
	
	/*
		@params : $_file_
	*/
	public function get_file_array()
	{
		return $this->_file_;	
	}
	
	/*
		return object
	*/
	public function rtnObject()
	{
		return new Component;
	}
	
	/*
	
		@params, csv_unrender_data
		return and save it on the basis of few conditions to rectify
	
	*/
	private static function filterCsvDataByRow( $importName = null , &$grabOject = null , $csv = null )
	{
		
		//echo number_format(1.2378147769392E+14,0,'','');
		
		//echo "<br />";
		
		//echo number_format( '6.14E+10', 0, '' , ''); exit;
		
		//connection open
		$db = self::sqlConn();
		
		/*
		
			condition 1 :: check date and verify
			condition 2 :: If blank then check next column to verify if its blank too then leave it
			condition 3 :: If column does not relate with date just false and check next column if its blank ?
		
		*/
		
		/*
		
			Area code	Region	State or territory	Capital city
			02	Central East	New South Wales, Australian Capital Territory	Sydney, Canberra
			03	South East	Victoria, Tasmania	Melbourne, Hobart
			04	Mobile telephones	Australia-wide	 
			07	North East	Queensland	Brisbane
			08	Central and West	Western Australia, South Australia, Northern Territory	Perth, Adelaide, Darwin
		
		*/
		
		//main loop for getting values
		$dateInner = '';
		$dupBool = false;
		$importId = 0;
		$phoneId = 0;
		$callId = 0;
		$dateInc = 0;
		$getReferenceFromTableByPhone = false;
		$globalMobileData = '';
		
		$getReferenceFromTableByPhoneForTo = false;
		$globalMobileDataForTo = '';
		
		$refFromQuoteId = '';
		$refFromJobId = '';
		$refStaffId = '';
		$refAdminId = '';
		
		$refFromQuoteIdTo = '';
		$refFromJobIdTo= '';
		
		$dateVal = '';
		$mobile = '';
		$outerToType = '';
		
		$customDate = '';
		
		//duplicate
		$dupCount = 0;
		
		//correct records
		$corRecord = 0;
		$checkStatus = false;
		
		//flags
		$tmpFlagFrom = false;		
		$tmpFlagFromOnce = false;			
		$importOnce = false;			
			
		$getcxref = false;	
		$checkStatuscx = 1;	
			
		$k = 0;foreach( $csv as $csvKey => $csvindex )
		{
			
			$chkDateFormat = explode( " " , $csvindex[0] );
			
			//if date format found
			if( self::checkCsvDate( $chkDateFormat[0] , $csvindex ) )
			{	
				
				//echo '************* ' . $csvindex[0] . '----' .  number_format( $csvindex[1], 0, '' , '') . ' ****************';
				//echo '<br />';
				
				if( self::checkDuplicacy( $csvindex[0] , $csvindex[1] , $db ) == false )
				{
					
					//check and phone number code replace 
					//$csvindex[1] = '(61417240591)';
					//$csvindex[1] = '-61417240591';
					//$csvindex[1] = '61417240591';
					
					$csvindex[1] = self::checkAndRepNum( $csvindex[1] );										
					$csvindex[1] = self::checkAndRepNumAgain( $csvindex[1] );				
					$csvindex[1] = self::checkAndRepNumwithOtherFormat( $csvindex[1] );	
					 
					//echo '----------';					
					//echo "<br />";
					
					//if date found then place the data first time
					//save data into 3 tables very first time 
					$dupBool = false;
					$parentId = '';
					$tmpFlagFromOnce = false;
					
					//echo '************* ' . $csvindex[0] . '----' . $csvindex[1] . ' ****************';
					//echo '<br />';
					
					//default
					$dateInner = $csvindex[0];
					$chkDateFormat = explode( " " , $csvindex[0] );
					$dateVal = $csvindex[0];
					$mobile = $csvindex[1];	
					$fileInsertDate = date( 'Y-m-d h:i:s' );
					
					//dateformat scene
					$customDate = date( 'Y-m-d h:i:s' , strtotime($csvindex[0]));
					
					//save first data into imports table
					self::$_import = new stdClass;					
					self::$_import->datetime 			= $fileInsertDate;
					self::$_import->filename 			= $importName;
					self::$_import->org_file_name  	= $grabOject->_org_file_name_;
					
					
					
					
					//call saveCallerDetail and return insert id
					if( $importOnce == false )
					//self::saveCallerDetail( 'c3cx_imports_activity' , self::$_import , 5 , $db );
					$importId = self::saveCallerDetail( 'c3cx_imports' , self::$_import , 4 , $db );
					
					
					if( $importId > 0 )
					$importOnce = true;
					
					//save first data into phone table
					self::$_data = new stdClass;
					self::$_data->phone_number = $mobile;
					self::$_data->date_time = $dateVal;
					self::$_data->import_name = $importName;
					self::$_data->import_id = $importId;
					/* echo "<pre>";
					print_r(self::$_data); */
					//call saveCallerDetail and return insert id
					$phoneId = self::saveCallerDetail( 'c3cx_phone' , self::$_data , 0 , $db );
					
					//save data into phone table
					$date1 = $chkDateFormat[0];
					$dateTime = $chkDateFormat[1];
					$destination  = $csvindex[3];
					
					$outerToType = $csvindex[3];
					
					$ivrOption  = $csvindex[9];
					$duration  = $csvindex[7];
					$callEndBy  = $csvindex[9];
					
					//query setup for who called
					$quoteNew = self::getCallerDetail( 'quote_new' , str_replace(" " , "" , $mobile) , 0 , $db);
					$adminNew = self::getCallerDetail( 'staff' , str_replace(" " , "" , $mobile) , 1 , $db);
					$cxNew = self::getCallerDetail( 'c3cx_users' , str_replace(" " , "" , $mobile) , 2 , $db);
				
					//get phone number and name who called
					if( !empty($quoteNew) ){ 
						$getReferenceFromTableByPhone = true;  
						$globalMobileData = $quoteNew;
						$checkStatuscx = 1;
					}
					
					if( !empty($adminNew) ){ 
						$getReferenceFromTableByPhone = true; $globalMobileData = $adminNew; 
						$refStaffId = $globalMobileData['id'];	
						$checkStatuscx = 1;
					}
					
					if( !empty($cxNew) ){
						//$getReferenceFromTableByPhone = true; 
						$getcxref = true;
						$globalMobileData = $cxNew;
						$refAdminId = $globalMobileData['id'];	
						$checkStatuscx = 2;
					}
					
					//who called
					 
					if(isset($checkStatuscx) && $checkStatuscx == 1) {
					   $fromType = ( $getReferenceFromTableByPhone == false ) ? $mobile : $globalMobileData['name'];
					   $fromNumber = ( $getReferenceFromTableByPhone == false ) ? $mobile : $globalMobileData['phone'];
					}elseif(isset($checkStatuscx) && $checkStatuscx == 2) {
						$fromType = ( $getcxref == false ) ? $mobile : $globalMobileData['name'];
					    $fromNumber = ( $getcxref == false ) ? $mobile : $globalMobileData['phone'];
					}
					 
					//set
					if( $getReferenceFromTableByPhone == true )
					{
						$tmpFlagFromOnce = true;
					}
					
					//query setup for whom received
					$quoteNewForTo = self::getCallerDetail( 'quote_new' , str_replace(" " , "" , $outerToType) , 0 , $db);
					$adminNewForTo = self::getCallerDetail( 'staff' , str_replace(" " , "" , $outerToType) , 1 , $db);
					$cxNewForTo = self::getCallerDetail( 'c3cx_users' , str_replace(" " , "" , $outerToType) , 2 , $db);
					
					//get phone number and name who called
					if( !empty($quoteNewForTo) ){
						
						$getReferenceFromTableByPhoneForTo = true; 
						$globalMobileDataForTo = $quoteNewForTo;
						$checkStatuscx = 1;
					}
					
					if( !empty($adminNewForTo) ){
						
						$getReferenceFromTableByPhoneForTo = true; $globalMobileDataForTo = $adminNewForTo;
						$refStaffId = $globalMobileDataForTo['id'];
						$checkStatuscx = 1;
					}
					
					if( !empty($cxNewForTo) ){
						//$getReferenceFromTableByPhoneForTo = true; 
						$globalMobileDataForTo = $cxNewForTo;
						$refAdminId = $globalMobileDataForTo['id'];
						$checkStatuscx = 2;
						$getcxref = true;
					}
					
					//for whom
				if(isset($checkStatuscx) && $checkStatuscx == 1) {	
					$toType = ( $getReferenceFromTableByPhoneForTo == false ) ? $outerToType : $globalMobileDataForTo['name'];
					$toNumber = ( $getReferenceFromTableByPhoneForTo == false ) ? $outerToType : $globalMobileDataForTo['phone']; 
				}elseif(isset($checkStatuscx) && $checkStatuscx == 2) {	
					$toType = ( $getcxref == false ) ? $outerToType : $globalMobileDataForTo['name'];
					$toNumber = ( $getcxref == false ) ? $outerToType : $globalMobileDataForTo['phone']; 
				}
				
					if(!empty($quoteNew)) { $from = '(Client)';}else if(!empty($adminNew)) { $from = '(Staff)'; }else if(!empty($cxNew)) { $from = '(Admin)'; }else { $from = ''; }
					
					if(!empty($quoteNewForTo)) { $to = '(Client)';}else if(!empty($adminNewForTo)) { $to = '(Staff)'; }else if(!empty($cxNewForTo)) { $to = '(Admin)'; }else { $to = ''; }
					
					// Add Quote Note & job note
					// For Form type
					$heading = $fromType . $from . ' called to '.$toType . $to;
					$durationText = ($duration !== '') ? '('.$duration.')' : '';
					
					if( !empty($quoteNew) ){
						
						if( $globalMobileData['status'] == 0 ){
								
								$refFromQuoteId = $globalMobileData['id'];									
								add_quote_notes($globalMobileData['id'],$heading,'3CX Call'.$durationText , $customDate,$fromType , 9,$importId);
								
							} else { 
								
								$refFromQuoteId = $globalMobileData['id'];
								$refFromJobId = $globalMobileData['booking_id']; 
								add_job_notes($globalMobileData['booking_id'],$heading,'3CX Call'.$durationText, $customDate,$fromType , 9,$importId);
							}
					}
					
					// For To type
					if( !empty($quoteNewForTo) ){	
						if( $globalMobileDataForTo['status'] == 0 ){
								
								$refFromQuoteId = $globalMobileDataForTo['id'];
								add_quote_notes($globalMobileDataForTo['id'],$heading,'3CX Call'.$durationText,  $customDate,$fromType , 9,$importId);
								
							} else { 
								
								$refFromQuoteId = $globalMobileDataForTo['id'];
								$refFromJobId = $globalMobileDataForTo['booking_id']; 
								add_job_notes($globalMobileDataForTo['booking_id'],$heading,'3CX Call'.$durationText, $customDate,$fromType , 9,$importId);
								
							} 
					} 
					
					$staffId = $refStaffId;
					$adminId = $refAdminId;
					$quoteId = $refFromQuoteId;
					$jobId = $refFromJobId;
					$comments = $callEndBy;
					
					$date1 = date( 'Y-m-d' , strtotime($date1));
					
					//save data into c3cx_calls table
					//call saveCallerDetail and return insert id
					self::$_calls = new stdClass;
					self::$_calls->import_name 		= $importName;
					self::$_calls->import_id        = $importId;
					self::$_calls->phone_id 		= $phoneId;
					self::$_calls->call_time 		= $dateTime;
					self::$_calls->call_date 		= $date1;
					self::$_calls->from_type 		= $fromType;
					self::$_calls->from_number 		= $fromNumber;
					self::$_calls->to_type 			= $toType;
					self::$_calls->to_number 		= $toNumber;
					self::$_calls->ivr_option 		= $ivrOption;
					self::$_calls->duration 		= $duration;
					self::$_calls->terminated_by 	= $callEndBy;
					self::$_calls->staff_id 		= $refStaffId;
					self::$_calls->admin_id 		= $refAdminId;
					self::$_calls->quote_id 		= $refFromQuoteId;
					self::$_calls->job_id 			= $refFromJobId;
					
		
					//didnt find the detail behind the number (0) 
					//didnt find the detail behind the number (0) 
					/* if($checkStatus == true)
					{	
						if( ($getReferenceFromTableByPhoneForTo == true) || ($getReferenceFromTableByPhone == true) )
						{
							self::$_calls->approved_status 	= 1;
						}
						else
						{
							self::$_calls->approved_status 	= 0;
							
						}
					} */
					
					if( ($getReferenceFromTableByPhoneForTo == true) || ($getReferenceFromTableByPhone == true) )
						{
							self::$_calls->approved_status 	= 1;
							$tmpFlagFrom = true;
						}
						else
						{
							self::$_calls->approved_status 	= 0;
							
						}
					
				    /* if( ($getReferenceFromTableByPhoneForTo == true) || ($getReferenceFromTableByPhone == true) )
					{
						
						$tmpFlagFrom = true;
					} */
					
					self::$_calls->approved_by 		= 0;
					self::$_calls->comments 		= '';
					$callId = self::saveCallerDetail( 'c3cx_calls' , self::$_calls , 1 , $db );					
					
					//empty state
					$refStaffId = ''; 
					$refAdminId = '';
					$refFromQuoteId = '';
					$refFromJobId = '';
					
					$refFromQuoteIdTo = '';
					$refFromJobIdTo= '';
					
					$fromType = '';
					$fromNumber = '';
					$toType = '';
					$toNumber = '';
					$outerToType = '';
					
					//flags set
					$getReferenceFromTableByPhoneForTo = false;
					$getReferenceFromTableByPhone = false;
					$getcxref = false;
					$checkStatuscx = 1;
					
					//calls insert id					
					$status = $csvindex[4];
					$ringing = $csvindex[5];
					$talking = $csvindex[6];
					$totals = $csvindex[7];
					$cost = $csvindex[8];
					$reasons = $callEndBy;
					
					$date1 = date( 'Y-m-d' , strtotime($date1));	
					
					//save data into call_details table
					//call saveCallerDetail and return insert id
					self::$_call_details = new stdClass;
					self::$_call_details->import_name 		= $importName;
					self::$_call_details->phone_id 			= $phoneId;
					self::$_call_details->import_id        = $importId;
					self::$_call_details->calls_id 			= $callId;
					self::$_call_details->date				= $date1;
					self::$_call_details->time				= $dateTime;
					self::$_call_details->caller_id 		= $dateTime;
					self::$_call_details->destination 		= $destination;
					self::$_call_details->status 			= $status;
					self::$_call_details->ringing 			= $ringing;
					self::$_call_details->talking 			= $talking;
					self::$_call_details->totals 			= $totals;
					self::$_call_details->cost 				= $cost;
					self::$_call_details->reasons 			= $reasons;					
					self::saveCallerDetail( 'c3cx_calls_details' , self::$_call_details , 2 , $db );
					
					//check who received the call and re-ensure
					
					
					//correct record inserted
					$corRecord++;
										
				}
				else
				{
					
					//record duplicate record too
					$dupBool = true;
					
					//echo '****** DUPLICATE FOUND ********';
					//echo '<br />';
					//echo '<br />';
					$dupCount++;
					
				}
				
			}
			else // else check child rows related to the call				
			{
				
				//check 3 conditions
				// first blank				
				if( $csvindex[0] == '' )
				{
					
					//check next column once
					if( isset( $csvindex[1] ) && $csvindex[1] !== '' )
					{
				
						//save data for rest records into call_detail table
						if( $dupBool == true )
						{
							
							//duplicate
							//echo '****** DUPLxxxxICATE under multiple rows ********';
							//echo '<br />';
							//echo '<br />';
							
							$dupCount++;
							
						}
						else
						{
							
							//inserted
							//echo '************* ' . $csvindex[0] . '----' . $csvindex[1] . ' ****************';
							//echo '<br />';
							
							//save data into phone table							
							$destination  = $csvindex[3];
							$ivrOption  = $csvindex[9];
							$duration  = $csvindex[7];
							$callEndBy  = $csvindex[9];
							
							//calls insert id							
							$status = $csvindex[4];
							$ringing = $csvindex[5];
							$talking = $csvindex[6];
							$totals = $csvindex[7];
							$cost = $csvindex[8];
							$reasons = $callEndBy;				
															
							//save data into call_details table
							self::$_call_details = new stdClass;
							self::$_call_details->import_name 		= $importName;
							self::$_call_details->phone_id 			= $phoneId;
							self::$_call_details->import_id        = $importId;
							self::$_call_details->calls_id 			= $callId;
							self::$_call_details->date				= $date1;
							self::$_call_details->time				= $dateTime;
							self::$_call_details->caller_id 		= $dateTime;
							self::$_call_details->destination 		= $destination;
							self::$_call_details->status 			= $status;
							self::$_call_details->ringing 			= $ringing;
							self::$_call_details->talking 			= $talking;
							self::$_call_details->totals 			= $totals;
							self::$_call_details->cost 				= $cost;
							self::$_call_details->reasons 			= $reasons;					
							self::saveCallerDetail( 'c3cx_calls_details' , self::$_call_details , 2 , $db );
							
							//check once before grab next fresh record
							//we do check at first level
							//Step1. Check if transfer the call to specific IVR than 
							//update to c3cx_calls ivr option
							//self::$_calls
							
							if( self::checkIvrOption(  'c3cx_ivr_options' , self::$_call_details , $destination ) )
							{	
								//update when found ivr into table
								self::updateIvrOption( 'c3cx_calls' , self::$_call_details , $destination ); 
							}
							
							//update total timming too
							if( self::$_call_details->totals !== "" )
							{								
								//update the duration into c3cx_calls
								self::updateIvrCallDuration( 'c3cx_calls' , self::$_call_details->totals , self::$_call_details ); 
								//update when found Call end into table
							    self::updateCallend( 'c3cx_calls' , self::$_call_details->calls_id , self::$_call_details );
							}
							
							
							
							//check receiver
							//step1. c3cx_users
							//step2. quote_new
							//step3. staff
							$quoteNew = self::getCallerDetail( 'quote_new' , self::$_call_details->destination , 0 , $db);
							$adminNew = self::getCallerDetail( 'staff' , self::$_call_details->destination , 1 , $db);
							$cxNew = self::getCallerDetail( 'c3cx_users' , str_replace(" " , "" , self::$_call_details->destination) , 2 , $db);
							
							$tmpFlag = false;
							
							
							//client
							if( !empty($quoteNew) )
							{ 
								$globalMobileData = $quoteNew;
								$tmpFlag = true;
								if( $tmpFlagFromOnce == true )
								{
									self::updateToCallInfo( 'c3cx_calls' , $globalMobileData , self::$_call_details , 0 , 1 , 0 );
									
									self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , self::$_call_details->calls_id , 0 );
								}
								else
								{
									self::updateToCallInfo( 'c3cx_calls' , $globalMobileData , self::$_call_details , 0 , 0 , 0 );
									
									self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , self::$_call_details->calls_id , 0 );
								}
									
							}
							
							//staff
							if( !empty($adminNew) )
							{ 
								$globalMobileData = $adminNew; 
								
								
								
								$tmpFlag = true;
								if( $tmpFlagFromOnce == true )
								{
									self::updateToCallInfo( 'c3cx_calls' , $globalMobileData , self::$_call_details , 0 , 1 , 1 );
									
									self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , self::$_call_details->calls_id , 1 );
								}
								else
								{
									self::updateToCallInfo( 'c3cx_calls' , $globalMobileData , self::$_call_details , 0 , 0 , 1 );
									
									self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , self::$_call_details->calls_id , 1 );
								}
							}
							
							//team admin
							if( !empty($cxNew) )
							{								
								$globalMobileData = $cxNew;	

								$tmpFlag = true;
								if( $tmpFlagFromOnce == true )
								{
									self::updateToCallInfo( 'c3cx_calls' , $globalMobileData , self::$_call_details , 0 , 1 );
									
									self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , self::$_call_details->calls_id , 2 );
								}
								else
								{
									self::updateToCallInfo( 'c3cx_calls' , $globalMobileData , self::$_call_details , 0 , 0 );
									
									self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , self::$_call_details->calls_id , 2 );
									
								}
							}
							
							//correct record inserted
							$corRecord++;
								
						}
						
					}
					else
					{
						
						//echo ' >>>> Column does not exists <<<< ' ;
						//echo "<br />";
						//echo "<br />";
						
					}
					
				}
				else // means something other text instead of date and blank
				{
					
					//record data
					//error found
					
					//echo ' >>>> Column does not supported <<<< ' ;
					//echo "<br />";
					//echo "<br />";
					
				}			
				
			}
			
		}	
		
		$_SESSION['dup_count'] = $dupCount;		
		$_SESSION['cor_count'] = $corRecord;
		
		self::sqlClose( $db );
	
	}
	
	/*
	
		@params :: need compile string
		@mather :: check into array and verify
		@return :: true false 
	
	*/
	private static function checkIndexString( $compileIndexString = null )
	{
		
		$matcher = array(
		
			'Call Time',
			'3CX Ltd.'
			
		);
		
		if( in_array( $compileIndexString , $matcher ) )
		{
			return 2;
		}
		else
		{
			return 0;
		}
		
	}
	
	/*
	
		@params :: check once we got a string
		@return :: bool
	
	*/
	private static function checkString( $compileString )
	{
		
		$matcher = array(
		
			'Call Time'
			
		);
				
		if( in_array( $compileString , $matcher ) )
		{
			return 1;
		}
		else
		{
			return 0;
		}
		
		
	}
	
	/*
	
		@params :: date
		@return :: bool
	
	*/
	private static function checkCsvDate($date = null , $csvindex = null)
	{
		
		$thedatestring = $date; 
		$iTimestamp = strtotime($thedatestring);
		if ($iTimestamp >= 0 && false !== $iTimestamp)
		{
			// Its good.
			return 1;
		}
		else
		{
			return 0;
		}
		
	}
	
	/*
	 * 
	 * @params :: full date_time , complete phone number
	 * return :: boolean
	 * 
	 */ 
	private static function checkDuplicacy( $dateTime = null , $phoneNumber = null , $db = null )
	{
		
		//check and phone number code replace 
		$phoneNumber = self::checkAndRepNum( $phoneNumber );
		$phoneNumber = self::checkAndRepNumAgain( $phoneNumber );
		$phoneNumber = self::checkAndRepNumwithOtherFormat( $phoneNumber );
		$db = self::sqlConn();
		
		/* echo "select 
						* 
					from 
						c3cx_phone 
					WHERE 
						phone_number like '%$phoneNumber%' 
						AND 
						date_time = '{$dateTime}'" ;
						
		echo "<br />"; */
        
		$query = mysql_query( 
					"select 
						* 
					from 
						c3cx_phone 
					WHERE 
						phone_number like '%$phoneNumber%' 
						AND 
						date_time = '{$dateTime}'" 
		) or die($db->error);
		
		$detail = mysql_fetch_assoc( $query );
		
		if( !empty( $detail ) )
		{
			self::sqlClose( $db );
			return true;
		}
		else
		{
			self::sqlClose( $db );
			return false;
		}
		
	}
	
	/*
	 * 
	 * @params :: phone number
	 * return :: return replace with 61* to 0 when with or without anything?
	 * 
	 */ 
	private static function checkAndRepNumwithOtherFormat( $phoneNumber = null )
	{
		
		$code = array(
		
			'612',
			'613',
			'614',
			'617',
			'618'
		
		);
		
		$codeRep = array(
		
			'02',
			'03',
			'04',
			'07',
			'08'
		
		);

		$k = 0; while( $k <= count( $code )-1 )
		{
			
			$phoneNumber = str_replace( $code[$k], $codeRep[$k], $phoneNumber );
				
		$k++;	
		} 
		
	return $phoneNumber;	
	}
	
	/*
	 * 
	 * @params :: phone number
	 * return :: return replace with -61* to 0?
	 * 
	 */ 
	private static function checkAndRepNum( $phoneNumber = null )
	{
		
		$code = array(
		
			'-612',
			'-613',
			'-614',
			'-617',
			'-618'
		
		);
		
		$codeRep = array(
		
			'02',
			'03',
			'04',
			'07',
			'08'
		
		);

		$k = 0; while( $k <= count( $code )-1 )
		{
			
			$phoneNumber = str_replace( $code[$k], $codeRep[$k], $phoneNumber );
				
		$k++;	
		} 
		
	return $phoneNumber;	
	}
	
	/*
	 * 
	 * @params :: phone number
	 * return :: return replace with (61* to 0?
	 * 
	 */ 
	private static function checkAndRepNumAgain( $phoneNumber = null )
	{
		
		$code = array(
		
			'(612',
			'(613',
			'(614',
			'(617',
			'(618'
		
		);
		
		$codeRep = array(
		
			'02',
			'03',
			'04',
			'07',
			'08'
		
		);

		$k = 0; while( $k <= count( $code )-1 )
		{
			
			if(strstr($phoneNumber, $code[$k]) == true)
			{
				 $phoneNumber = str_replace( ")", "", $phoneNumber );				
				//echo "<br />";
			}
			 $phoneNumber = str_replace( $code[$k], $codeRep[$k], $phoneNumber );
			//echo "<br />";
				
		$k++;	
		} 
		
	return $phoneNumber;	
	}
	
	/*
	 * 
	 * @params :: null
	 * return sqlConn Object
	 * 
	 */ 
	private static function sqlConn()
	{
		
		$gaSql['user']     = DB_user;
        $gaSql['password'] = DB_pass;
        $gaSql['db']       = DB_name;
        $gaSql['server']   = DB_HOST;
        $gaSql['port']     = 3306; // 3306 is the default MySQL port

        $input =& $_GET;
        //$input =& $_REQUEST;
        $gaSql['charset']  = 'utf8';
        $db = mysql_connect('localhost', 'mysql_user', 'mysql_password');
		mysql_select_db($db,DB_name); 
	
	return $db;
	}
	
	/*
	 * 
	 * @params :: null
	 * return sqlConn Object
	 * 
	 */ 
	private static function sqlClose( &$db = null )
	{
		
		if( mysql_close($db) )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	/*
	 * 
	 * @params :: phone-number
	 * return :: full data
	 * 
	 */ 
	private static function getCallerDetail( $tableName = null , $phoneNumber = null , $type = null , $db = null )
	{
		
		//for quote_new
		if( $type == 0 )
		{
			$str = "SELECT 
					phone, name , booking_id, id, status
				FROM {$tableName}	
					WHERE 1=1
				AND
					phone like '%{$phoneNumber}%'
				ORDER BY id desc 
				LIMIT 1	
				";
			
		}
		else if( $type == 1 ) //for cleaner
		{
			$str = "SELECT 
					mobile as phone , name , id
				FROM {$tableName}	
					WHERE 1=1
				AND
					mobile like '%{$phoneNumber}%'
				ORDER BY id desc 
				LIMIT 1		
				";
			
		} else if( $type == 2 ) //admin
		{
			$str = "SELECT 
					 3cx_extension_number as phone , 3cx_user_name as name , id
				FROM {$tableName}	
					WHERE 1=1
				AND
					3cx_extension_number like '%{$phoneNumber}%'
				ORDER BY id desc 
				LIMIT 1		
				";
				
		}else{}
		
		$db = self::sqlConn();
        
		$query = mysql_query(
		
			$str
			
		) 
		
		or 
		
		die(
		
			mysql_error()
		);
		
		$detail = mysql_fetch_assoc( $query );
		
	return  $detail;
	}
	
	/*
	 * 
	 * @params :: phone-number
	 * return :: full data
	 * 
	 */ 
	private static function saveCallerDetail( $tableName = null , $data = null , $type = null , $db = null )
	{
		
		//for 3cx_phone
		if( $type == 0 )
		{
			
			$str = "INSERT INTO {$tableName} SET 
					phone_number = '{$data->phone_number}',
					date_time = '{$data->date_time}',
					import_name = '{$data->import_name}',
					import_id = '{$data->import_id}'
				";
			mysql_query(
				$str
			);			
		
			return mysql_insert_id();
		}
		else if( $type == 1 ) //for c3cx_calls 
		{		
			
			mysql_query(
				"INSERT INTO {$tableName} SET 
					import_name = '{$data->import_name}',
					import_id = '{$data->import_id}',
					phone_id = '{$data->phone_id}',
					call_time = '{$data->call_time}',
					call_date = '{$data->call_date}',
					from_type = '{$data->from_type}',
					from_number = '{$data->from_number}',
					to_type = '{$data->to_type}',
					to_number = '{$data->to_number}',
					ivr_option = '{$data->ivr_option}',
					duration = '{$data->duration}',
					terminated_by = '{$data->terminated_by}',
					staff_id = '{$data->staff_id}',
					admin_id = '{$data->admin_id}',
					quote_id = '{$data->quote_id}',
					job_id = '{$data->job_id}',
					approved_status = {$data->approved_status},
					approved_by = '0',
					comments = '{$data->comments}'
					
				"
			);
					
			return mysql_insert_id();		
			
		} else if( $type == 2 ) //c3cx_calls_details
		{
			
			mysql_query(
				"INSERT INTO {$tableName} SET
					import_name = '{$data->import_name}',
					import_id = '{$data->import_id}',
					phone_id = '{$data->phone_id}',
					calls_id = '{$data->calls_id}',
					date = '{$data->date}',
					time = '{$data->time}',
					caller_id = '{$data->caller_id}',
					destination = '{$data->destination}',
					status = '{$data->status}',
					ringing = '{$data->ringing}',
					talking = '{$data->talking}',
					totals = '{$data->totals}',
					cost = '{$data->cost}', 
					reasons = '{$data->reasons}'
					
				"
			);
			
			return mysql_insert_id();
				
		}//for 3cx_phone
		else if( $type == 4 )
		{
		    $str = "INSERT INTO c3cx_imports_activity SET 					
					datetime = '{$data->datetime}',
					filename = '{$data->filename}',
					org_file_name  = '{$data->org_file_name}',
					admin_id  = '{$_SESSION['admin']}'
				";
				
			mysql_query(
				$str
			);	
			
			$str = "INSERT INTO {$tableName} SET 					
					datetime = '{$data->datetime}',
					filename = '{$data->filename}',
					org_file_name  = '{$data->org_file_name}',
					admin_id  = '{$_SESSION['admin']}'
				";
				
			mysql_query(
				$str
			);	
			
		
			return mysql_insert_id();
		}else{}
		
	}
	
	/*
	 * 
	 * @params :: calls data
	 * return :: full data
	 * 
	 */ 
	private static function checkIvrOption( $tableName = null , $data = null , $destination = null )
	{
		
		$destination = str_replace( " " , "" , $destination );
		$str = "SELECT 
					COUNT(id) as IVR
				FROM {$tableName}	
					WHERE 1=1
				AND
					ivr_tiny_name LIKE '%{$destination}%'
				ORDER BY id desc 
				LIMIT 1		
		";
		
		$ivrCount = mysql_fetch_assoc(mysql_query($str));
		
	return $ivrCount['IVR'];	
	}
	
	/*
	 * 
	 * @params :: calls data
	 * return :: full data
	 * 
	 */ 
	private static function updateIvrOption( $tableName = null , $data = null , $destination = null )
	{
		
		//c3cx_calls ivr option will update
		$str = "UPDATE {$tableName}	
					SET 
				c3cx_calls.ivr_option = '{$destination}'			
				WHERE 
					c3cx_calls.id = {$data->calls_id}
						
		";
		//echo "<br />";
		$query = mysql_query($str);
		
	return mysql_affected_rows($query);	
	}
	
	/*
	 * 
	 * @params :: calls data
	 * return :: full data
	 * 
	 */ 
	private static function updateIvrCallDuration( $tableName = null , $duration = null , $data = null )
	{
		
		//c3cx_calls ivr option will update
		$str = "UPDATE {$tableName}	
					SET 
				c3cx_calls.duration = '{$duration}'			
				WHERE 
					c3cx_calls.id = {$data->calls_id}						
		";
		$query = mysql_query($str);
		
	return mysql_affected_rows($query);	
	}
	private static function updateCallend( $tableName = null , $callId = null , $data = null )
	{
		
		//c3cx_calls ivr option will update
		$str = "UPDATE {$tableName}	
					SET 
				c3cx_calls.terminated_by = '{$data->reasons}'			
				WHERE 
					c3cx_calls.id = {$data->calls_id}						
		";
		$query = mysql_query($str);
		
	return mysql_affected_rows($query);	
	}
	
	/*
	 * 
	 * @params :: calls data
	 * return :: full data
	 * 
	 */ 
	private static function updateToCallInfo( $tableName = null , $toData = null , $data = null , $type = null , $approvedStatus = null )
	{
		
		if( $type == 0 )	
		{
			
			//update teh detail into c3cx_calls table
			$phone = $toData['phone'];
			$name = $toData['name'];
			
			//c3cx_calls ivr option will update
			$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.to_number = '{$phone}',
					c3cx_calls.to_type = '{$name}',
					c3cx_calls.approved_status = '{$approvedStatus}' 
					WHERE 
						c3cx_calls.id = {$data->calls_id}						
			";
		}
		else if( $type == 1 )
		{
			
			//c3cx_calls ivr option will update			
			$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.to_type = '{$data->destination}',
					c3cx_calls.to_type = '{$data->destination}',
					c3cx_calls.approved_status  = '{$approvedStatus}'
					WHERE 
						c3cx_calls.id = {$data->calls_id}						
			";
			
		}
		
		$query = mysql_query($str);
		
	return mysql_affected_rows($query);	
	}
	
	/*
	 * 
	 * @params :: calls data
	 * return :: full data
	 * 
	 */ 
	private static function updateToCallInfoAgain( $tableName = null , $toData = null , $calls_id = null , $type = null )
	{
	
		// TO client 
		if( $type == 0 )	
		{
			$quote_id = $toData['id'];
			
			if( isset( $toData['booking_id']) && $toData['booking_id'] > 0 )
			{
				$booking_id = $toData['booking_id'];
				
				$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.quote_id = '{$quote_id}',
					c3cx_calls.job_id = '{$booking_id}'										
					WHERE 
						c3cx_calls.id = {$calls_id}						
				";
				
			}
			else
			{
				
				$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.quote_id = '{$quote_id}'					
					WHERE 
						c3cx_calls.id = {$calls_id}						
				";
				
			}
						
		}
		else if( $type == 1 )  // TO staff 
		{
			
			$staff_id = $toData['id'];		
			
			$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.staff_id = '{$staff_id}'					
					WHERE 
						c3cx_calls.id = {$calls_id}						
			";
			
		}
		else if( $type == 2 )  // TO Admin Team 
		{
			
			$admin_id = $toData['id'];
			$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.admin_id = '{$admin_id}'
					WHERE 
						c3cx_calls.id = {$calls_id}						
			";
			
		}
		
		$query = mysql_query($str);
		
	return mysql_affected_rows($query);	
	}
	
	/*
	
		@params : unidentified phone number
		returns null
		@work : update staff | admin | client 
		table : c3cx_calls over id
	
	
	*/
	public function recheckListOfUnidentifyNum( $rowData )
	{
		 
		$fromNum = trim($rowData['from_number']);
		$toNum = trim($rowData['to_number']);
		
		//from who called
		if(is_numeric($fromNum)) {
		    
    		$quoteFrom = self::getCallerDetail( 'quote_new' , str_replace(" " , "" , $fromNum) , 0 , $db);
    		$adminFrom = self::getCallerDetail( 'staff' , str_replace(" " , "" , $fromNum) , 1 , $db);
    		$cxFrom = self::getCallerDetail( 'c3cx_users' , str_replace(" " , "" , $fromNum) , 2 , $db);
    		
    		self::updateFromNum( $quoteFrom , $adminFrom , $cxFrom , $rowData['id'] );
    		
		}
		//who received the call
		if(is_numeric($toNum)) {
		    
    		$quoteTo = self::getCallerDetail( 'quote_new' , str_replace(" " , "" , $toNum) , 0 , $db);
    		$adminTo = self::getCallerDetail( 'staff' , str_replace(" " , "" , $toNum) , 1 , $db);
    		$cxTo = self::getCallerDetail( 'c3cx_users' , str_replace(" " , "" , $toNum) , 2 , $db);
    		
			self::updateToNum( $quoteTo , $adminTo , $cxTo , $rowData['id'] );
    		
		}
		
	}
	 
	/*
	
	    @params : FROM => admin , staff , client
	    return null
	    update thoise details according to conditions
	
	*/
	private static function updateFromNum( $quoteNew , $adminNew , $cxNew , $calls_id )
	{
	
	    //get phone number and name who called
		if( !empty($quoteNew) ){ 
			$globalMobileData = $quoteNew;
			
			if( $globalMobileData['status'] == 0 ){
							
				$refFromQuoteId = $globalMobileData['id'];
				//add_quote_notes($globalMobileData['id'],'3CX call','Quote received by call.' , );
				
			} else { 
				
				$refFromQuoteId = $globalMobileData['id'];
				$refFromJobId = $globalMobileData['booking_id']; 
				//add_job_notes($globalMobileData['booking_id'],'3CX call','Job received by call' , $customDate);
				
			}
			
			self::recheckStatusUpdate( 'c3cx_calls' , $calls_id , 1 );
			
			self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , $calls_id , 0 );
		}
		
		if( !empty($adminNew) ){ 
			$globalMobileData = $adminNew; 
			$refStaffId = $globalMobileData['id'];	
			
			self::recheckStatusUpdate( 'c3cx_calls' , $calls_id , 1 );
			
			self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , $calls_id , 1 );
		}
		
		if( !empty($cxNew) ){
			$globalMobileData = $cxNew;
			$refAdminId = $globalMobileData['id'];		
			
			self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , $calls_id , 2 );
		}
		
		//who called
		$fromType = ( empty( $globalMobileData ) ) ? $mobile : $globalMobileData['name'];
		$fromNumber = ( empty(  $globalMobileData ) ) ? $mobile : $globalMobileData['phone'];
		
	    self::updateToCallFromName( 'c3cx_calls', $fromType  , $fromNumber, $calls_id );
	}
	
	/*
	
	    @params : TO => admin , staff , client
	    return null
	    update thoise details according to conditions
	
	
	*/
	private static function updateToNum( $quoteNew , $adminNew , $cxNew , $calls_id )
	{
	
	
		/* print_r($quoteNew);
		print_r($adminNew); */
		
	    //get phone number and name who called
		if( !empty($quoteNew) ){ 
			$globalMobileData = $quoteNew;
			
			if( $globalMobileData['status'] == 0 ){
							
				$refFromQuoteId = $globalMobileData['id'];
				//add_quote_notes($globalMobileData['id'],'3CX call','Quote received by call.' , $customDate);
				
			} else { 
				
				$refFromQuoteId = $globalMobileData['id'];
				$refFromJobId = $globalMobileData['booking_id']; 
				//add_job_notes($globalMobileData['booking_id'],'3CX call','Job received by call' , $customDate);
				
			}
			
			self::recheckStatusUpdate( 'c3cx_calls' , $calls_id , 1 );
			
			//update name
			self::recheckStatusUpdateByName( 'c3cx_calls' , $calls_id , $globalMobileData , 1 );
			
			self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , $calls_id , 0 );
			
		}
		
		if( !empty($adminNew) ){ 
			$globalMobileData = $adminNew; 
			$refStaffId = $globalMobileData['id'];		
			self::recheckStatusUpdate( 'c3cx_calls' , $calls_id , 1 );
			
			//update name
			self::recheckStatusUpdateByName( 'c3cx_calls' , $calls_id , $globalMobileData , 1 );
			
			//update name
			self::recheckStatusUpdateByName( 'c3cx_calls' , $calls_id , $globalMobileData , 1 );
			
			self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , $calls_id , 1 );
		}
		
		if( !empty($cxNew) ){
			$globalMobileData = $cxNew;
			$refAdminId = $globalMobileData['id'];	
			
			self::updateToCallInfoAgain( 'c3cx_calls' , $globalMobileData , $calls_id , 2 );
		}
		//for whom
		$toType = ( empty($globalMobileDataForTo) ) ? $outerToType : $globalMobileData['name'];
		$toNumber = ( empty($globalMobileDataForTo) ) ? $outerToType : $globalMobileData['phone'];
		
		self::updateToCallToName( 'c3cx_calls'  , $toType , $toNumber  , $calls_id );
		
	}
	
	/*
	 * 
	 * @params :: calls data phone and name
	 * return :: null
	 * 
	 */ 
	private static function updateToCallFromName( $tableName = null , $fromType = null , $fromNumber = null , $calls_id = null )
	{
	
		if( $fromType != '' && $fromNumber != '' )  // TO Admin Team 
		{
			
			$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.from_type = '{$fromType}'
					WHERE 
						c3cx_calls.id = {$calls_id}						
			";
			
		}
		
		$query = mysql_query($str);
		
	return mysql_affected_rows($query);	
	}
	
	/*
	 * 
	 * @params :: calls data phone and name
	 * return :: null
	 * 
	 */ 
	private static function updateToCallToName( $tableName = null , $toType = null , $toNumber = null , $calls_id = null )
	{
	
		if( $toType != '' && $toNumber != '' )  // TO Admin Team 
		{
			
			$str = "UPDATE {$tableName}	
						SET 
					c3cx_calls.to_type = '{$toType}'
					WHERE 
						c3cx_calls.id = {$calls_id}						
			";
			
		}
		
		$query = mysql_query($str);
		
	return mysql_affected_rows($query);	
	}
	
	/*
	 * 
	 * @params :: calls data
	 * return :: full data
	 * 
	 */ 
	private static function recheckStatusUpdate( $tableName = null , $calls_id = null , $status = null )
	{
	
		$str1 = "UPDATE {$tableName}	
						SET 
					c3cx_calls.approved_status = 1
					WHERE 
						c3cx_calls.id = {$calls_id}						
			";
		$query = mysql_query($str1);
		
	return mysql_affected_rows($query);	
	}
	
	/*
	 * 
	 * @params :: calls data
	 * return :: full data
	 * 
	 */ 
	private static function recheckStatusUpdateByName( $tableName = null , $calls_id = null , $data = null , $status = null )
	{
	
		$toName = $data['name'];
		$str1 = "UPDATE {$tableName}	
						SET 
					c3cx_calls.to_type = '{$toName}'
					WHERE 
						c3cx_calls.id = {$calls_id}						
			";
		$query = mysql_query($str1);
		
	return mysql_affected_rows($query);	
	}
	
}

?>