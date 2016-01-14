<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../inc/globals.inc.php');
require('../lang/'.$SYS_LANG.'/admin-index.lang.php');							// lang text for current page
require('../lang/'.$SYS_LANG.'/class-misc-errors.class.lang.php');	// lang text for errors
require('../lang/'.$SYS_LANG.'/shared.lang.php');
// classes
require('../class/misc/errors.class.php');
require('../class/misc/utils.class.php');
require('../class/misc/utilsInstallCheck.class.php');
require('../class/misc/utilsSystem.class.php');


//-------------------------------------------------------------------------------------------------
//	Globals
//-------------------------------------------------------------------------------------------------
$hError				= new Errors();
$hUtils 			= new Utils();
$hUtilsSystem = new UtilsSystem();
$hInstChk			= new UtilInstallCheck($hError);


//-------------------------------------------------------------------------------------------------
//	Init
//-------------------------------------------------------------------------------------------------
$hUtils->initVars($_POST, array('act'));
$hUtils->initVars($_GET, array('errCode'));


//-------------------------------------------------------------------------------------------------
//	Error Code
//-------------------------------------------------------------------------------------------------
if($_GET['errCode'])
	$hError->add($_GET['errCode']);


//-------------------------------------------------------------------------------------------------
//	Form
//-------------------------------------------------------------------------------------------------
if($_POST['act'] == 'login')
{
	// check login and pwd
	if(!$hUtilsSystem->isValidLogin($_POST['login'], $_POST['pwd']))
		$hError->add(10);
	
	// nothing wrong, do login and redirect
	if($hError->isEmpty())
	{
		// login, cookies
		$hUtilsSystem->login(
			crypt(md5($_POST['login']), md5($_POST['login'])),
			crypt(md5($_POST['pwd']),		md5($_POST['pwd']))
		);
		
		// redirect
		header('Location: albums/index.php');
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo TXT_HTML_TITLE; ?></title>	
	<link rel="stylesheet" style="text/css" href="../css/shared.css" />
	<link rel="stylesheet" style="text/css" href="index.css" />
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:919px;
	top:11px;
	width:72px;
	height:28px;
	z-index:1;
}
-->
</style>
</head>
<body>
<div id="apDiv1">
  <p>
    <?php
echo '<div align="center" class="menuHelp">';
echo '<a href="'.$SYS_URL.'/admin/help/help.html" target="_blank" title="Ajuda">';
echo '<img src="../../help.jpg" border="0" /><br />';
echo '<span>Ajuda</span>';
echo '</a>';
echo '</div>';
?>
</p>
</div>
<div align="center"><img src="../header.jpg" border="0" />

</div>

<div class="wrapper">

<div class="content">
        
		<div class="boxAcess">
        
		<form method="post" action="index.php">
        	
			<div class="row">
				<div class="col1"><?php echo TXT_LOGIN; ?>: <input type="text" name="login" maxlength="50" /></div>
			</div>			
			
			<div class="row">
				<div class="col1"><?php echo TXT_PWD; ?>: <input type="password" name="pwd" maxlength="50" /></div>
			</div>			
			
			<div class="row">			
				<div class="col1"><input type="submit" value="<?php echo TXT_SUBMIT; ?>" /></div>
			</div>
			
			<div class="lineBreak">&nbsp;</div>


			
<?php
			// help
echo '<div align="center" class="menuHelp">';
echo '<a href="'.$SYS_URL.'/admin/help/help.html" target="_blank" title="Ajuda">';
echo '<img src="../../help.jpg" border="0" /><br />';
echo '<span>Ajuda</span>';
echo '</a>';
echo '</div>';
//-------------------------------------------------------------------------------------------------
//	Display Errors
//-------------------------------------------------------------------------------------------------
if(!$hError->isEmpty())
{
	//echo '<div class="linebreak">&nbsp;</div>';
	echo '<div class="Error">';	
	echo $hError->display();
	echo '</div>';
}
?>
			
			<input type="hidden" name="act" value="login" />
		</form>
		
		</div>

		<div class="boxText">
			<span>Bem-Vindo ao Gerenciamento<br />de Imagens</span>
		</div>

		<div class="boxLogo">
			<div><img src="../logo1.png" width="163" height="198" alt="logo" /></div>
		</div>
		<div class="lineBreak">&nbsp;</div>

</div>
</div>

<!-- footer -->
<?php require('inc/footer.inc.php'); ?>
	
</body>
</html>
