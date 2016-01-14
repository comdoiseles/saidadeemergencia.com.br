<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../lang/'.$SYS_LANG.'/admin-images-captionEdit.lang.php');	// lang text for current page
require('../../lang/'.$SYS_LANG.'/admin-inc-menu.inc.lang.php');				// lang text for menu
require('../../lang/'.$SYS_LANG.'/class-misc-errors.class.lang.php');		// lang text for errors
require('../../lang/'.$SYS_LANG.'/shared.lang.php');
// classes
require('../../class/images/images.class.php');
require('../../class/misc/errors.class.php');
require('../../class/misc/utils.class.php');
require('../../class/misc/utilsSystem.class.php');


//-------------------------------------------------------------------------------------------------
//	Globals
//-------------------------------------------------------------------------------------------------
$hUtilsSystem = new UtilsSystem();
$hUtils				= new Utils();
$hError				= new Errors();
$hImg					= new Images('../../');


//-------------------------------------------------------------------------------------------------
//	Init
//-------------------------------------------------------------------------------------------------
$hUtils->initVars($_REQUEST, array('albumId', 'imgId'));
$hUtils->initVars($_POST, array('act', 'sCaption'));

$albumId 	= (int)$_REQUEST['albumId'];
$imgId		= (int)$_REQUEST['imgId'];
$sCaption	= htmlspecialchars($hImg->getCaption($albumId, $imgId));


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
	if(strlen($_POST['sCaption']) > 100)
		$hError->add(25);

	// edit album name
	if($hError->isEmpty())
	{
		$hImg->editImgCaption($albumId, $imgId, $_POST['sCaption']);
		
		// redirect
		header('Location: index.php?albumId='.$albumId);
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
//	Menu
//-------------------------------------------------------------------------------------------------
if(!$hError->isEmpty())
{
	$hError->display();
}
?>
        <form method="post" action="captionEdit.php">
          <textarea name="sCaption" cols="30" rows="5"><?php echo $sCaption; ?></textarea>
          <br />
          <br />
          <input type="submit" value="<?php echo TXT_BUTTON_SUBMIT; ?>" />
          <input type="hidden" name="act" value="edit" />
          <input type="hidden" name="albumId" value="<?php echo $albumId ?>" />
          <input type="hidden" name="imgId" value="<?php echo $imgId ?>" />
        </form>
      </div>
      
      
    </div>
  </div>
</div>

<!-- footer -->
<?php require('../inc/footer.inc.php') ?>

</body>
</html>
