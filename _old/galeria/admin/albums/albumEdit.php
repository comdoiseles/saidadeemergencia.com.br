<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../lang/'.$SYS_LANG.'/admin-albums-albumEdit.lang.php');		// lang text for current page
require('../../lang/'.$SYS_LANG.'/admin-inc-menu.inc.lang.php');				// lang text for menu
require('../../lang/'.$SYS_LANG.'/class-misc-errors.class.lang.php');		// lang text for errors
require('../../lang/'.$SYS_LANG.'/shared.lang.php');
// classes
require('../../class/albums/albums.class.php');
require('../../class/misc/errors.class.php');
require('../../class/misc/utils.class.php');
require('../../class/misc/utilsSystem.class.php');


//-------------------------------------------------------------------------------------------------
//	Globals
//-------------------------------------------------------------------------------------------------
$hUtilsSystem = new UtilsSystem();
$hUtils				= new Utils();
$hError				= new Errors();
$hAlbums			= new Albums('../../');


//-------------------------------------------------------------------------------------------------
//	Init
//-------------------------------------------------------------------------------------------------
$hUtils->initVars($_GET, array('albumId'));
$hUtils->initVars($_POST, array('act'));

$albumId 	= (int)$_REQUEST['albumId'];
$sAlbum		= htmlspecialchars($hAlbums->getAlbum($albumId));

//-------------------------------------------------------------------------------------------------
//	Check Session
//-------------------------------------------------------------------------------------------------
if(!$hUtilsSystem->isLogged())
{
	echo $hError->getMsg(100);
	exit;
}


//-------------------------------------------------------------------------------------------------
//	Edit Form
//-------------------------------------------------------------------------------------------------
if($_POST['act'] == 'edit')
{
	// check errors
	if(!$_POST['sAlbum'])
		$hError->add(30);

	// edit album name
	if($hError->isEmpty())
	{
		$hAlbums->editAlbum($albumId, $_POST['sAlbum']);
		
		// redirect
		header('Location: index.php?albumId='.$albumId);
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo TXT_HTML_TITLE; ?></title>
	<script type="text/javascript" src="../../inc/utils.inc.js"></script>
	<script type="text/javascript" src="index.js"></script>
	<link rel="stylesheet" style="text/css" href="../../css/shared.css" />	
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

<div style="padding-left:10px;">

<?php
//-------------------------------------------------------------------------------------------------
//	Errors
//-------------------------------------------------------------------------------------------------
if(!$hError->isEmpty())
	$hError->display();
?>
	
	<form method="post" action="albumEdit.php">
		<input type="text" name="sAlbum" value="<?php echo $sAlbum; ?>" maxlength="20" />
		
		<input type="submit" value="<?php echo TXT_BUTTON_SUBMIT; ?>" />
		
		<input type="hidden" name="act" value="edit" />
		<input type="hidden" name="albumId" value="<?php echo $albumId ?>" />
	</form>
</div>
<!--  close div with no class -->

</div>
<!-- close main -->

</div>
<!-- close content -->

</div>
<!-- close wrapper -->

<!-- footer -->
<?php require('../inc/footer.inc.php'); ?>

</body>
</html>
