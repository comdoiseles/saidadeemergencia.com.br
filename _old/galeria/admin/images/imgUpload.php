<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../lang/'.$SYS_LANG.'/admin-images-imgUpload.lang.php');		// lang text for current page
require('../../lang/'.$SYS_LANG.'/admin-inc-menu.inc.lang.php');				// lang text for menu
require('../../lang/'.$SYS_LANG.'/class-misc-errors.class.lang.php');		// lang text for errors
require('../../lang/'.$SYS_LANG.'/shared.lang.php');
// classes
require('../../class/images/images.class.php');
require('../../class/images/imageSystem.class.php');
require('../../class/misc/errors.class.php');
require('../../class/misc/utils.class.php');
require('../../class/misc/utilsSystem.class.php');


//-------------------------------------------------------------------------------------------------
//	Globals
//-------------------------------------------------------------------------------------------------
$hUtils				= new Utils();
$hUtilsSystem = new UtilsSystem();
$hImg					= new Images('../../');
$hError				= new Errors();
$albumId			= '';


//-------------------------------------------------------------------------------------------------
//	Init
//-------------------------------------------------------------------------------------------------
$hUtils->initVars($_REQUEST, array('albumId'));
$hUtils->initVars($_POST, array('act', 'sCaption'));
$hUtils->initVars($_FILES, array('fImg'), 1);

// additional init
if(!$_FILES['fImg'])
	$_FILES['fImg']['size'] = 0;

$albumId = $_REQUEST['albumId'];
	
//-------------------------------------------------------------------------------------------------
//	Check Session
//-------------------------------------------------------------------------------------------------
if(!$hUtilsSystem->isLogged())
{
	echo $hError->getMsg(100);
	exit;
}


//-------------------------------------------------------------------------------------------------
//	Add
//-------------------------------------------------------------------------------------------------
if($_POST['act'] == 'add')
{
	$imgSys	= new ImageSystem(0);
	
	$_FILES['fImg']['name'] = utf8_decode($_FILES['fImg']['name']);
	
	// check size
	if(!$_FILES['fImg']['size'])
		$hError->add(20);
	
	// check file extension
	else	
	  if(!$imgSys->checkFileExt($_FILES['fImg']['name']))
			$hError->add(21);
	
	if($hError->isEmpty())
	{
		// Member vars
		$fileSrc		= '';
		$folderSrc	= '../../temp/';
		
		$fileDst1		= '';
		$folderDst1	= '../../largeimages/';
		
		$fileDst2 	= '';
		$folderDst2	= '../../thumbs/';
		
		// manage image file
		// source file
		$fileSrc = $imgSys->getUniqueFilename($_FILES['fImg']['name'], $folderSrc);		
		move_uploaded_file($_FILES['fImg']['tmp_name'], $folderSrc.$fileSrc);
		if(!$imgSys->setImgSrc($fileSrc, $folderSrc))
		{
			echo $hError->getMsg(22);
			echo $fileSrc;
			exit;
		}
			
		// destiny file 1
		$fileDst1 = $imgSys->getUniqueFilenameJPG('1.jpg', $folderDst1);
		$size = array(576, 432);
		if(!$imgSys->setImgDst($fileDst1, $folderDst1, $size))
		{
			echo $hError->getMsg(23);
			echo $fileDst1;
			exit;
		}
			
		// build Image
		$imgSys->buildImageXY();
		
		// destiny file2 - same filename as file1		
		$fileDst2 = $fileDst1;
		$size = array(39, 29);
		if(!$imgSys->setImgDst($fileDst2, $folderDst2, $size))
		{
			echo $hError->getMsg(24);
			echo $fileDst2;
			exit;
		}
			
		// Build Image
		$imgSys->buildImageXY();
		
		// Delete source
		unlink($folderSrc.$fileSrc);
		
		// add image info
		$hImg->add($albumId, $fileDst1, $_POST['sCaption']);
		
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
	<link rel="stylesheet" style="text/css" href="../../css/shared.css" />
	<link rel="stylesheet" style="text/css" href="imgUpload.css" />
	<script type="text/javascript" src="../../inc/utils.inc.js"></script>	
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
//	Display Errors
//-------------------------------------------------------------------------------------------------
if(!$hError->isEmpty())
{
	echo '<div class="Error">';
	echo $hError->display();
	echo '</div>';
}
?>

	<form method="post" action="imgUpload.php" enctype="multipart/form-data">
		
		<div class="row">
			<div class="col1"><?php echo TXT_FIELD_IMAGE; ?></div>
			<div class="col2"><input type="file" name="fImg" />
				<br />
				<br />
				<cite>
					Tamanho recomendado - máximo de 5 mb.<br />
					Tamanho permitido - máximo de 10 mb.
				</cite>
			</div>
		</div>
		<div class="lineBreak">&nbsp;</div>
		
		<div class="row">
			<div class="col1"><?php echo TXT_FIELD_CAPTION; ?></div>
			<div class="col2"><input type="text" name="sCaption" /></div>
		</div>
		<div class="lineBreak">&nbsp;</div>
		
		<div class="row">
			<div class="col1">&nbsp;</div>
			<div class="col2"><input type="submit" value="<?php echo TXT_SUBMIT; ?>" /></div>
		</div>
		<div class="lineBreak">&nbsp;</div>	
		
		<input type="hidden" name="albumId" value="<?php echo $albumId; ?>" />
		<input type="hidden" name="act" value="add" />
	</form>
</div>

</div>

</div>
</div>

<!-- footer -->
<?php require('../inc/footer.inc.php'); ?>

</body>
</html>
