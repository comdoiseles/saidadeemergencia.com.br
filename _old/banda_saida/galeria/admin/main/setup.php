<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../lang/'.$SYS_LANG.'/admin-main-setup.lang.php');					// lang text for current page
require('../../lang/'.$SYS_LANG.'/admin-inc-menu.inc.lang.php');				// lang text for menu
require('../../lang/'.$SYS_LANG.'/class-misc-errors.class.lang.php');		// lang text for errors
require('../../lang/'.$SYS_LANG.'/shared.lang.php');
// classes
require('../../class/misc/errors.class.php');
require('../../class/misc/utils.class.php');
require('../../class/misc/utilsSystem.class.php');


//-------------------------------------------------------------------------------------------------
//	Globals & Init
//-------------------------------------------------------------------------------------------------
$hUtilsSystem = new UtilsSystem();
$hUtils				= new Utils();
$hErr					= new Errors();

$hUtils->initVars($_POST, array('act', 'pwdCur', 'pwdNew', 'pwdNew2'));


//-------------------------------------------------------------------------------------------------
//	Check Session
//-------------------------------------------------------------------------------------------------
if(!$hUtilsSystem->isLogged())
{
	echo $hErr->getMsg(100);
	exit;
}


//-------------------------------------------------------------------------------------------------
//	Form
//-------------------------------------------------------------------------------------------------
if($_POST['act'] == 'formPwd')
{
	
	// check for errors
	// current pwd
	if($SYS_PWD != $_POST['pwdCur'])
		$hErr->add(40);
	
	// empty pwd
	if(!$_POST['pwdNew'])
		$hErr->add(41);
	
	// pwd confirmation
	if($_POST['pwdNew'] != $_POST['pwdNew2'])
		$hErr->add(42);
	
	// update pwd
	if($hErr->isEmpty())
	{
		// retrieve file
		$encPwd = $_POST['pwdNew'];
		$sFile 	= '../../inc/globals.inc.php';
		$aFile	= file($sFile);
		
		// search for pwd
		foreach($aFile as $k => $v)
		{
			// update pwd
			if(strpos($v, '$SYS_PWD') !== false)
			{
				$aFile[$k] =
					'$SYS_PWD = \''.
					$encPwd."';\n";
			}
		}
		
		// reset cookies
		$hUtilsSystem->login(
			$SYS_ADMIN,
			$encPwd);
		
		file_put_contents($sFile, $aFile);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo TXT_HTML_TITLE; ?></title>
	<link rel="stylesheet" style="text/css" href="../../css/shared.css" />
	<link rel="stylesheet" style="text/css" href="setup.css" />
</head>
<body>
<div class="wrapper">
<div class="content">
    
<?php
//-------------------------------------------------------------------------------------------------
//	Menu
//-------------------------------------------------------------------------------------------------
require('../inc/menu.inc.php');
?>
		
		<div class="main">
			<div class="Title"><?php echo TXT_PWD_TITLE; ?></div>
			<br />
			
<?php
//-------------------------------------------------------------------------------------------------
//	Display Errors || Success Message
//-------------------------------------------------------------------------------------------------
if(!$hErr->isEmpty())
{
	echo '<div class="Error">';
	echo $hErr->display();
	echo '</div>';
}

?>
			<form method="post" action="setup.php">
				
				<div class="row">
					<div class="col"><?php echo TXT_PWD_CUR; ?>:</div>
					<div class="col"><input type="password" name="pwdCur" maxlength="50" /></div>
				</div>
				<div class="lineBreak">&nbsp;</div>
				
				<div class="row">
					<div class="col"><?php echo TXT_PWD_NEW; ?>:</div>
					<div class="col"><input type="password" name="pwdNew" maxlength="50" /></div>
				</div>
				<div class="lineBreak">&nbsp;</div>
				
				<div class="row">
					<div class="col"><?php echo TXT_PWD_NEW2; ?>:</div>
					<div class="col"><input type="password" name="pwdNew2" maxlength="50" /></div>
				</div>
				<div class="lineBreak">&nbsp;</div>	
				
				<div class="row">
					<div class="col">&nbsp;</div>
					<div class="col"><input type="submit" value="<?php echo TXT_PWD_BUTTON; ?>" /></div>
				</div>
				<div class="lineBreak">&nbsp;</div>	
				
				<input type="hidden" name="act" value="formPwd" />
			</form>
			
		</div>

</div>
</div>

<!-- footer -->
<?php require('../inc/footer.inc.php'); ?>

</body>
</html>
