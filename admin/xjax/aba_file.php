<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	echo "<pre>"; print_r($getAllDetails);
	//error_reporting(0);
	//ini_set('display_errors', 0);
	
	//https://github.com/anam-hossain/aba
	/*	Code 	Transaction Description
		13 		Externally initiated debit items
		50 		Externally initiated credit items with the exception of those bearing Transaction Codes
		51 		Australian Government Security Interest
		52 		Family Allowance
		53 		Pay
		54 		Pension
		55 		Allotment
		56 		Dividend
		57 		Debenture/Note Interest
	*/

	/*
	  
		Field 				Description
		Bank name 			Bank name must be 3 characters long and Capitalised. For example: CBA
		BSB 				The valid BSB format is XXX-XXX.
		Account number 		Account number must be up to 9 digits.
		User name 			(Descriptive record) 	User or preferred name must be letters only and up to 26 characters long.
		Account name 		(Detail record) 	Account name must be BECS characters only and up to 32 characters long.
		User number 		User number which is allocated by APCA must be up to 6 digits long. The Commonwealth bank default is 301500.
		Description 		(Descriptive record) 	Description must be up to 12 characters long and letters only.
		Reference 			(Detail record) 	The reference must be BECS characters only and up to 18 characters long. For example: Payroll number.
		Remitter 			The remitter must be letters only and up to 16 characters long.

	*/
			
	use Anam\Aba\Aba;
	
	include( $_SERVER["DOCUMENT_ROOT"].'/aba-master/src/AbaServiceProvider.php' );
	include( $_SERVER["DOCUMENT_ROOT"].'/aba-master/src/Aba.php' );
	
	include( $_SERVER["DOCUMENT_ROOT"].'/aba-master/src/Validation/Validator.php' );
	include( $_SERVER["DOCUMENT_ROOT"].'/aba-master/src/Facades/Aba.php' );

	$aba = new Aba();
	
	// Descriptive record or file header
	// The header information is included at the top of every ABA file
	// and is used to describe your bank details.
	$aba->addFileDetails([
		'bank_name' => 'ANZ', // bank name
		'user_name' => 'BCIC', // Account name
		'bsb' => '014-527', // bsb with hyphen
		'account_number' => '295683522', // account number
		'remitter' => 'BCIC', // Remitter
		'user_number' => '301500', // User Number (as allocated by APCA). The Commonwealth bank default is 301500
		'description' => 'Creditors', // description
		'process_date'  => date('DDMMYY'); // DDMMYY - Date to be processed 
	]);
	
	
	
	
	/* $transactions = [
		[
			'bsb' => '014-527', // bsb with hyphen
			'account_number' => '370222073',
			'account_name'  => 'Business2sell Pty Ltd',
			'reference' => 'Payroll number',
			'transaction_code'  => '53',
			'amount' => '1.25'
		],
		[
			'bsb' => '014-527', // bsb with hyphen
			'account_number' => '456638934',
			'account_name'  => 'Savings',
			'reference' => 'Payroll number',
			'transaction_code'  => '53',
			'amount' => '2.25'  
		]
	]; */
	
	$transactions = $getAllDetails;

	foreach ($transactions as $transaction)
	{
		$transaction['bsb'] = str_replace(" ", "", $transaction['bsb']);
		$transaction['account_number'] = str_replace(" ", "", $transaction['account_number']);
		$transaction['account_name'] = substr($transaction['account_name'], 0,32);
		
		$fstNum = substr($transaction['bsb'], 0,3);
		$transaction['bsb'] = $fstNum .'-'. substr($transaction['bsb'], 3,strlen($transaction['bsb']));
		
		$aba->addTransaction($transaction);
	}

	$getStringContent = $aba->generate();
	
	file_put_contents( $_SERVER["DOCUMENT_ROOT"] . '/admin/images/aba/TeamPayment.aba' , $getStringContent );
	
	//$aba->download("Multiple-transactions-By-BcicGroup");
	
?>
