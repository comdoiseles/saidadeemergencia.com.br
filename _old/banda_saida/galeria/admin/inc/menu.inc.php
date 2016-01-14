<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------

// main menu
echo '<div class="menuRow">';

// albums
echo '<div class="menuCol">';
echo '<a href="'.$SYS_URL.'/admin/albums/index.php" title="'.TXT_LINK_ALBUM_TITLE.'">';
echo TXT_LINK_ALBUM;
echo '</a>';
echo '</div>';

// preview
echo '<div class="menuCol">';
echo '<a href="'.$SYS_URL.'/index.php" target="_blank" title="'.TXT_LINK_PREVIEW_TITLE.'">';
echo TXT_LINK_PREVIEW;
echo '</a>';
echo '</div>';

// setup
echo '<div class="menuCol">';
echo '<a href="'.$SYS_URL.'/admin/main/setup.php" title="'.TXT_LINK_SETUP_TITLE.'">';
echo TXT_LINK_SETUP;
echo '</a>';
echo '</div>';

// logout
echo '<div class="menuCol">';
echo '<a href="'.$SYS_URL.'/admin/main/logout.php" title="'.TXT_LINK_LOGOUT_TITLE.'">';
echo TXT_LINK_LOGOUT;
echo '</a>';
echo '</div>';

// help
echo '<div align="center" class="menuHelp">';
echo '<a href="'.$SYS_URL.'/admin/help/help.html" target="_blank" title="Ajuda">';
echo '<img src="../../help.jpg" border="0" /><br />';
echo '<span>Ajuda</span>';
echo '</a>';
echo '</div>';

// line break
echo '<div class="lineBreak">&nbsp;</div>';

echo '</div>';


?>
