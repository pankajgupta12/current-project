<?php 

namespace Compare\Db\App;

interface TableSpecification
{
	
	//abstract methods

	//set table method
	public function setTable();

	//get table method
	public function getTableName();

	//set table method
	public function setTableUser();

	//set table method
	public function getUserColumnName();

	//set table method
	public function setTablePwd();

	//set table method
	public function getPwdColumnName();

}

//Db Comparision and Setter / Getter
class DbCompare implements TableSpecification
{

	public $db = '';
	
	private $host = '';
	private $user = '';
	private $pass = '';
	private $dbase = '';
	
	private $login_user = '';
	private $login_pass = '';

	//set table
	private $tbl = '';

	//set table
	private $tblUser = '';	

	//set table
	private $tblPwd = '';	
	
	//set constructor
	public function setConnector( $host = null , $user = null , $pass = null , $dbase = null )
	{
		//set all important details
		$this->setHost( $host );
		$this->setUser( $user );
		$this->setPass( $pass );
		$this->setDB( $dbase );
		
		//call connector
		//set linker
		$this->	setLinker( $this->callConnector() );	
	}
	
	//connector
	public function callConnector()
	{	
		$link = mysqli_connect($this->getHost(),$this->getUser(),$this->getPass(), $this->getDB()) or die("Could not connect");	return $link;
	}
	
	//chkLogin credentials
	public function chkCredentials()
	{
		$rtnData = '';
		$rtnData = $this->chkUserInTbl();
		if( empty($rtnData) )
		{
			$data['message'] = 'error';
			$data['type'] = 'Details are not found, Please try with correct details!';
			$data['data'] = '';
			$rtnData = json_encode( array( 'data' => $data ) );
		}
		else
		{
			$data['message'] = 'success';
			$data['type'] = 'Login Details';
			$data['data'] = $rtnData;
			$rtnData = json_encode( array( 'data' => $data ) );
		}
		
		return $rtnData;
	}
	
	//get detail and return boolean
	private function chkUserInTbl()
	{
		$strQuery = '';
		
		$strQuery .= 'SELECT ';
		$strQuery .= ' * ';
		$strQuery .= ' FROM ';
		$strQuery .= ' admin ';
		$strQuery .= ' WHERE 1 = 1';
		$strQuery .= ' AND ';
		$strQuery .= ' username = "' . mysql_real_escape_string( $this->getLoginUser() ) . '"';
		$strQuery .= ' AND ';
		$strQuery .= ' pwd = "' . mysql_real_escape_string( $this->getLoginPass() ) . '"';
		
		return (mysqli_fetch_array( mysqli_query( $this->getLinker() , $strQuery ) ));
	}
	
	//set host
	public function setHost( $host = null )
	{
		$this->host = $host;
	}
	
	//set user
	public function setUser( $user = null )
	{
		$this->user = $user;
	}
	
	//set pass
	public function setPass( $pass = null )
	{
		$this->pass = $pass;
	}
	
	//set db
	public function setDB( $dbase = null )
	{
		$this->dbase = $dbase;
	}
	
	//get host
	public function getHost( $host = null )
	{
		return $this->host;
	}
	
	//get user
	public function getUser( $user = null )
	{
		return $this->user;
	}
	
	//get pass
	public function getPass( $pass = null )
	{
		return $this->pass;
	}
	
	//get db
	public function getDB( $dbase = null )
	{
		return $this->dbase;
	}
	
	//set host
	public function setLoginUser( $loginUser = null )
	{
		$this->login_user = $loginUser;
	}
	
	//set host
	public function setLoginPass( $loginPass = null )
	{
		$this->login_pass = $loginPass;
	}
	
	//set host
	public function getLoginUser( $loginUser = null )
	{
		return $this->login_user;
	}
	
	//set host
	public function getLoginPass( $loginPass = null )
	{
		return $this->login_pass;
	}
	
	//set host
	public function setLinker( $linker = null )
	{
		$this->db = $linker;
	}
	
	//set host
	public function getLinker()
	{
		return $this->db;
	}

	//set table	
	public function setTable( $tbl = null )
	{
		$this->tbl = $tbl;
	}

	//set host
	public function getTableName()
	{
		return $this->getTable();
	}
	
	//set host
	private function getTable()
	{
		return $this->tbl;
	}

	//set table	
	public function setTableUser( $tblUser = null )
	{
		$this->tblUser = $tblUser;
	}

	//set host
	public function getUserColumnName()
	{
		return $this->getTableUser();
	}
	
	//set host
	private function getTableUser()
	{
		return $this->tblUser;
	}

	//set table	
	public function setTablePwd( $tblPwd = null )
	{
		$this->tblPwd = $tblPwd;
	}

	//set host
	public function getPwdColumnName()
	{
		return $this->getTablePwd();
	}
	
	//set host
	private function getTablePwd()
	{
		return $this->tblPwd;
	}

}
?>