<?php

namespace Bcic\Outlook\Email\Sys;

class EmailReader
{
	// imap server connection
	public $conn;

	// inbox storage and inbox message count
	private $inbox;
	private $msg_cnt;

	// email login credentials
	private $mailBoxes = [];
	private $server = '';
	private $user   = '';
	private $pass   = '';
	private $port   = 143; // adjust according to server settings
	private $mailType = '';

	// connect to the server and get the inbox emails
	function __construct( $server_host , $user_host , $pass_host , $port_host , $mailType )
	{		
		$this->defaultParams( $server_host , $user_host , $pass_host , $port_host , $mailType );		
	}

	/*	
		@params : server , user , pass and port	
		return : [
			success : only connection resource,
			error : error
		] 
		
	*/
	private function defaultParams( $server_host , $user_host , $pass_host , $port_host , $mailType )
	{
		$this->server 		= $server_host;
		$this->user 		= $user_host;
		$this->pass 		= $pass_host;
		$this->port 		= $port_host;
		$this->mailType 	= $mailType;
		
		$this->connect();		
	}
	
	// close the server connection
	function close() {
		$this->inbox = array();
		$this->msg_cnt = 0;

		imap_close($this->conn);
	}

	// open the server connection
	// the imap_open function parameters will need to be changed for the particular server
	// these are laid out to connect to a Dreamhost IMAP server
	function connect() {
		
		$this->conn = imap_open(
			'{'.$this->server.'/notls}'.$this->mailType, 
			$this->user, 
			$this->pass
		);		
	}

	// move the message to a new folder
	function move($msg_index, $folder='INBOX.Processed') {
		// move on server
		imap_mail_move($this->conn, $msg_index, $folder);
		imap_expunge($this->conn);

		// re-read the inbox
		$this->inbox();
	}

	// get a specific message (1 = first email, 2 = second email, etc.)
	function get($msg_index=NULL) {
		if (count($this->inbox) <= 0) {
			return array();
		}
		elseif ( ! is_null($msg_index) && isset($this->inbox[$msg_index])) {
			return $this->inbox[$msg_index];
		}

		return $this->inbox[0];
	}

	// read the inbox
	function inbox() {
		$this->msg_cnt = imap_num_msg($this->conn);

		$in = array();
		for($i = 1; $i <= $this->msg_cnt; $i++) {
			$in[] = array(
				'index'     => $i,
				'header'    => imap_headerinfo($this->conn, $i),
				'body'      => imap_body($this->conn, $i),
				'structure' => imap_fetchstructure($this->conn, $i)
			);
		}
		
		$this->inbox = $in;
		
	return $this->inbox;	
	}
	
	//get mail box
	public function getMailBoxes()
	{
		$list = imap_list($this->conn, "{".$this->server."}", "*");
		if (is_array($list)) {
			foreach ($list as $val) {
				$this->mailBoxes[] = imap_utf7_decode($val);				
			}
		} else {
			$this->mailBoxes[0] = "imap_list failed: " . imap_last_error() . "n";
		}
	return $this->mailBoxes;
	}
	
	//get mail according to criteria flags
	
    #ALL - return all messages matching the rest of the criteria
    #ANSWERED - match messages with the \\ANSWERED flag set
    #BCC "string" - match messages with "string" in the Bcc: field
    #BEFORE "date" - match messages with Date: before "date"
    #BODY "string" - match messages with "string" in the body of the message
    #CC "string" - match messages with "string" in the Cc: field
    #DELETED - match deleted messages
    #FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
    #FROM "string" - match messages with "string" in the From: field
    #KEYWORD "string" - match messages with "string" as a keyword
    #NEW - match new messages
    #OLD - match old messages
    #ON "date" - match messages with Date: matching "date"
    #RECENT - match messages with the \\RECENT flag set
    #SEEN - match messages that have been read (the \\SEEN flag is set)
    #SINCE "date" - match messages with Date: after "date"
    #SUBJECT "string" - match messages with "string" in the Subject:
    #TEXT "string" - match messages with text "string"
    #TO "string" - match messages with "string" in the To:
    #UNANSWERED - match messages that have not been answered
    #UNDELETED - match messages that are not deleted
    #UNFLAGGED - match messages that are not flagged
    #UNKEYWORD "string" - match messages that do not have the keyword "string"
    #UNSEEN - match messages which have not been read yet
	

}
?>