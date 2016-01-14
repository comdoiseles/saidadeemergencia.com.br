<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------
//	Utilities based on table gimg_system data
//-------------------------------------------------------------------------------------------------
//	Require
//	globals.inc.php
//-------------------------------------------------------------------------------------------------

class UtilsSystem
{	
	//-----------------------------------------------------------------------------------------------
	//	Members
	//-----------------------------------------------------------------------------------------------	
	private $SYS_ADMIN;				// login
	private $SYS_PWD;					// password
	
	private $sessionVar;			// session var string name
	private $system;					// system vars
	
	private $SESSION_TIME;		// session time
	
		
	//-----------------------------------------------------------------------------------------------
	//	Construct
	//-----------------------------------------------------------------------------------------------	
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		$this->SYS_ADMIN 			= $GLOBALS['SYS_ADMIN'];
		$this->SYS_PWD				= $GLOBALS['SYS_PWD'];
		
		$this->sessionVar			= 'LOGIN';
		$this->sessionPwd			= 'PWD';
		
		$this->SESSION_TIME 	= 7200;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Is Logged
	//-----------------------------------------------------------------------------------------------
	//	return bool
	//-----------------------------------------------------------------------------------------------
	public function isLogged()
	{
                //print $this->SYS_ADMIN;
                //print $_COOKIE[$this->sessionVar];
                //print crypt(md5($this->SYS_ADMIN), md5($this->SYS_ADMIN));
                //print $this->SYS_PWD;
                //print $_COOKIE[$this->sessionPwd];
                //exit;

		// check if cookie is set and with valid value
		if(!isset($_COOKIE[$this->sessionVar]) || !isset($_COOKIE[$this->sessionPwd]))
			return false;
		
		// login
		if(crypt(md5($this->SYS_ADMIN), md5($this->SYS_ADMIN)) != $_COOKIE[$this->sessionVar])
			return false;
		
		// pwd
		if(crypt(md5($this->SYS_PWD), md5($this->SYS_PWD)) != $_COOKIE[$this->sessionPwd])
			return false;
		
		// renew cookies
		$this->login(
			$_COOKIE[$this->sessionVar],
			$_COOKIE[$this->sessionPwd]
		);
		
		return true;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Is Valid Login
	//-----------------------------------------------------------------------------------------------
	//	string $login
	//	string $pwd
	//	return bool
	//-----------------------------------------------------------------------------------------------
	public function isValidLogin($login, $pwd)
	{

		if($login != $this->SYS_ADMIN)
			return false;

		
		if(crypt(md5($pwd), md5($pwd)) != crypt(md5($this->SYS_PWD), md5($this->SYS_PWD)))
			return false;
		
		return true;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Login
	//-----------------------------------------------------------------------------------------------
	//	string	$login			: encrypted
	//	string	$pwd				: encrypted
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function login($login, $pwd)
	{
		// login

		setcookie(
			$this->sessionVar,
			$login,
			time() + $this->SESSION_TIME,
			"/"
		);
		
		// pwd
		setcookie(
			$this->sessionPwd,
			$pwd,
			time() + $this->SESSION_TIME,
			"/"
		);
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Logout
	//-----------------------------------------------------------------------------------------------
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function logout()
	{
		// login
		setcookie(
			$this->sessionVar,
			'0',
			time() - $this->SESSION_TIME,
			"/"
		);
		
		// pwd
		setcookie(
			$this->sessionPwd,
			'0',
			time() - $this->SESSION_TIME,
			"/"
		);
	}
}
?>