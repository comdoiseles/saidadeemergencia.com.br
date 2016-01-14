<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../lang/'.$SYS_LANG.'/admin-albums-index.lang.php');			// lang text for current page
require('../../lang/'.$SYS_LANG.'/admin-inc-menu.inc.lang.php');			// lang text for menu
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
//	Check Session
//-------------------------------------------------------------------------------------------------
if(!$hUtilsSystem->isLogged())
{
	header('Location: ../index.php?errCode=11');
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="pragma" content="no-cache" />
	<title><?php echo TXT_HTML_TITLE; ?></title>
	<script type="text/javascript" src="../../inc/utils.inc.js"></script>
	<script type="text/javascript" src="index.js"></script>
	<link rel="stylesheet" style="text/css" href="../../css/shared.css" />
	<link rel="stylesheet" style="text/css" href="index.css" />
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
//	Display Albums
//-------------------------------------------------------------------------------------------------
echo '<div class="main">';

// add new album
echo '<div style="padding-left:10px;">';
echo '<a href="albumAdd.php" title="'.TXT_LINK_ADD_TITLE.'">';
echo TXT_LINK_ADD;
echo '</a>';
echo '<br /><br />';
echo '</div>';

// header
echo '<div class="rowMain">';
echo '<div class="col1">'.TXT_TITLE_ALBUMS.'</div>';
echo '<div class="col2">'.TXT_TITLE_TOTAl.'</div>';	
echo '<div class="col3">'.TXT_TITLE_VIEW.'</div>';
echo '<div class="col4">'.TXT_TITLE_RENAME.'</div>';
echo '<div class="col5">'.TXT_TITLE_DELETE.'</div>';
echo '<div class="lineBreak">&nbsp;</div>';
echo '</div>';

// get albums array
$aAlbums = $hAlbums->getAlbums();

// message for empty record
if(!count($aAlbums))
{
	echo '<div class="row">';
	echo '<div style="padding:5px 0px 5px 0px;">'.TXT_NORECFOUND.'</div>';
	echo '</div>';
}

foreach($aAlbums as $v)
{
	echo '<div class="row">';
	
	// name
	echo '<div class="col1">';
	echo htmlspecialchars($v['sName']);
	echo '</div>';
	
	// total images
	echo '<div class="col2">';
	echo $v['cImg'];
	echo '</div>';
	
	// view
	echo '<div class="col3">';	
	echo '<a href="../images/index.php?albumId='.$v['id'].'" title="'.TXT_LINK_VIEW_TITLE.'">'.TXT_LINK_VIEW.'</a>';	
	echo '</div>';
	
	// rename
	echo '<div class="col4">';
	echo '<a href="albumEdit.php?albumId='.$v['id'].'" ';	
	echo 'title="'.TXT_LINK_EDIT_TITLE.'">';
	echo TXT_LINK_EDIT;
	echo '</a>';
	echo '</div>';
	
	// exclude
	echo '<div class="col5">';
	echo '<a href="javascript:doNothing();" ';
	echo 'onclick="delAlbum('.$v['id'].', \''.TXT_JS_CONFIRM_EXLUDE.'\')" ';
	echo 'title="'.TXT_LINK_DEL_TITLE.'">';
	echo TXT_LINK_DEL;
	echo '</a>';
	echo '</div>';
	
	// break line
	echo '<div class="lineBreak">&nbsp;</div>';
	
	echo '</div>';
	
}
echo '</div>';
?>

</div>
</div>

<!--  footer -->
<?php require('../inc/footer.inc.php'); ?>

</body>
</html>
