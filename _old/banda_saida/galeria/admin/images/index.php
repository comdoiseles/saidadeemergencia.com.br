<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../lang/'.$SYS_LANG.'/admin-images-index.lang.php');				// lang text for current page
require('../../lang/'.$SYS_LANG.'/admin-inc-menu.inc.lang.php');				// lang text for menu
require('../../lang/'.$SYS_LANG.'/class-misc-errors.class.lang.php');		// lang text for errors
require('../../lang/'.$SYS_LANG.'/shared.lang.php');
// classes
require('../../class/images/images.class.php');
require('../../class/misc/errors.class.php');
require('../../class/misc/utils.class.php');
require('../../class/misc/utilsSystem.class.php');
// right here & right now
require('indexThumbView.class.php');


//-------------------------------------------------------------------------------------------------
//	Globals
//-------------------------------------------------------------------------------------------------
$hUtils					= new Utils();
$hUtilsSystem		= new UtilsSystem();
$hImg						= new Images('../../');
$hError					= new Errors();


//-------------------------------------------------------------------------------------------------
//	Init
//-------------------------------------------------------------------------------------------------
$hUtils->initVars($_GET, array('albumId'));
$hImg->setAlbum($_GET['albumId']);


//-------------------------------------------------------------------------------------------------
//	Check Session
//-------------------------------------------------------------------------------------------------
if(!$hUtilsSystem->isLogged())
{
	echo $hError->getMsg(100);
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="pragma" content="no-cache" />
	<title><?php echo TXT_HTML_TITLE; ?></title>
	<link rel="stylesheet" style="text/css" href="../../css/shared.css" />
	<link rel="stylesheet" style="text/css" href="index.css" />
	<script type="text/javascript" src="../../inc/utils.inc.js"></script>
	<script type="text/javascript" src="index.js"></script>
</head>
<body>
<div class="wrapper">
<div class="content">	

<?php
//-------------------------------------------------------------------------------------------------
//	Menu
//-------------------------------------------------------------------------------------------------
require('../inc/menu.inc.php');


//-------------------------------------------------------------------------------------------------
//	Display Images
//-------------------------------------------------------------------------------------------------
// members
$hImg->round(3);
$aImgs = $hImg->get();

echo "\n".'<div class="main">'."\n";

echo '<div class="rowMain">';
echo $hImg->getAlbumName($_GET['albumId']);
echo '</div>';

echo '<br />';

// upload
echo '<div align="center" style="padding-left:10px; width:120px;">';
echo '<a href="imgUpload.php?albumId='.$_GET['albumId'].'" title="'.$TXT_LINK_TITLE_ADD_IMG.'">';
echo $TXT_LINK_ADD_IMG;
echo '</a>';
echo '</div>';

echo '<br />';

// no records found
if(!count($aImgs))
{
	echo '<div style="padding-left: 18px;">';
	echo $TXT_NORECFOUND;
	echo '</div>';
}

$i = 1;
foreach($aImgs as $k => $v)
{
	$hThumb = new IndexThumbView($v);
	
	// open row
	if((($i - 1) % 3) == 0)
		echo '<div class="row">'."\n";
	
	$hThumb->printCol();
	
	// close row, break line
	if(($i % 3) == 0)
	{
		echo '<div class="lineBreak">&nbsp;</div>'."\n";
		echo '</div>'."\n";
	}
	
	++$i;
}

echo '</div>';
echo '<div class="lineBreak">&nbsp;</div>'."\n";
?>

</div>
</div>

<!-- footer -->
<?php require('../inc/footer.inc.php') ?>

</body>
</html>
