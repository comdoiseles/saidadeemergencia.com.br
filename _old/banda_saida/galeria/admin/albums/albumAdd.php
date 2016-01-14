<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../lang/'.$SYS_LANG.'/admin-albums-albumAdd.lang.php');			// lang text for current page
require('../../lang/'.$SYS_LANG.'/admin-inc-menu.inc.lang.php');				// lang text for menu
require('../../lang/'.$SYS_LANG.'/class-misc-errors.class.lang.php');		// lang text for errors
require('../../lang/'.$SYS_LANG.'/shared.lang.php');
// classes
require('../../class/albums/albums.class.php');
require('../../class/misc/errors.class.php');
require('../../class/misc/utils.class.php');
require('../../class/misc/utilsSystem.class.php');


//-------------------------------------------------------------------------------------------------
//	Globals & Init
//-------------------------------------------------------------------------------------------------
$hUtilsSystem = new UtilsSystem();
$hUtils				= new Utils();
$hErr					= new Errors();
$hAlbums			= new Albums('../../');

$hUtils->initVars($_POST, array('act', 'sAlbum'));

//-------------------------------------------------------------------------------------------------
//	Check Session
//-------------------------------------------------------------------------------------------------
if(!$hUtilsSystem->isLogged())
{
	echo $hErr->getMsg(100);
	exit;
}


//-------------------------------------------------------------------------------------------------
//	Add
//-------------------------------------------------------------------------------------------------
if($_POST['act'] == 'add')
{
	
	// empty
	if(!$_POST['sAlbum'])
		$hErr->add(30);
	
	// max 8 albums
	if(count($hAlbums->getAlbums()) >= 20)
		$hErr->add(31);
	
	// add
	if($hErr->isEmpty())
	{
		$hAlbums->addAlbum($_POST['sAlbum']);
		
		// redirect
		header('Location: index.php');
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo TXT_HTML_TITLE; ?></title>
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

<div style="padding-left: 10px;">

<?php
//-------------------------------------------------------------------------------------------------
//	Errors
//-------------------------------------------------------------------------------------------------
if(!$hErr->isEmpty())
{
	echo '<div class="Error">';
	echo $hErr->display();
	echo '</div>';
}
?>

	<form method="post" action="albumAdd.php">
		<?php echo TXT_INPUT_ADD_LABEL; ?>
		<input type="text" name="sAlbum" maxlength="20" />
		<input type="submit" value="<?php echo TXT_SUBMIT; ?>" />
		<input type="hidden" name="act" value="add" />
	</form>
</div>
<!-- close div with no class name -->

</div>
<!-- close main -->

</div>
<!--  close content -->

</div>
<!--  close wrapper -->

<!--  footer -->
<?php require('../inc/footer.inc.php'); ?>

</body>
</html>
