<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
require('../../inc/globals.inc.php');
require('../../class/misc/utilsSystem.class.php');

//-------------------------------------------------------------------------------------------------
//	Globals
//-------------------------------------------------------------------------------------------------
$hUtilsSystem = new UtilsSystem();

// logout & redirect
$hUtilsSystem->logout();
header('Location: '.$SYS_URL.'/admin/');
exit;
?>