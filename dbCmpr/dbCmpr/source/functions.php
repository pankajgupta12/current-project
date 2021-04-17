<?php

function checkIfPost()
{
	if( isset( $_POST ) ):
	
		$dbLink = new Compare\Db\App\DbCompare();
		$dbLink->setConnector( DB_host , DB_user , DB_pass , DB_name );
		
		//set credentials to retreive into class_alias
		if( isset( $_POST['user_name'] ) )
		$dbLink->setLoginUser( mysql_real_escape_string( $_POST['user_name'] ) );
	
		if( isset( $_POST['user_pass'] ) )
		$dbLink->setLoginPass( mysql_real_escape_string( $_POST['user_pass'] ) );
		
		//check credentials
		if( isset( $_POST['user_name']) && isset( $_POST['user_pass']) ) :
			
			ob_start();
			$rtnData = $dbLink->chkCredentials();
			
			$decodedData = json_decode($rtnData);
			
			if( $decodedData->data->message == 'success' )
			{
				$_SESSION['details'] = $rtnData;
				header( 'location:dbcompare/index.php' );
				exit;
			}
			else
			{
				return $rtnData;
			}
			 
		else :
			$data['message'] = 'error';
			$data['type'] = 'Details are not found, Please try with correct details!';
			return json_encode( array( 'data' => $data ) );
		endif;	
		
	endif;
}	

?>