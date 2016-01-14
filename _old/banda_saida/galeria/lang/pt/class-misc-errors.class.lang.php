<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------

// error messages
$ERROR_MSG = array
(
	// login
	10 		=> 'Usuário/Senha não conferem.',
	11		=> 'A sessão expirou.',
	
	// images
	20		=> 'Arquivo de imagem não encontrado.',
	21		=> 'Extensão do arquivo de imagem inválido.',
	22		=> 'Erro Fatal ao processar a imagem fonte!',
	23		=> 'Erro Fatal ao processar <i>largeimage</i>',
	24		=> 'Erro Fatal ao processar <i>thumbs</i>',
	25		=> 'A legenda deve ter no máximo 100 caracteres',
	
	// albums
	30		=> 'Nome do Álbum inválido',
	31		=> 'É permitido o máximo de 20 álbums',
	
	// system
	40		=> 'Senha incorreta.',
	41		=> 'É necessário fornecer uma nova senha',
	42		=> 'Confirmação de senha inválida',
	
	// installation checkup
	50		=> 'PHP inferior a versão 5',
	51		=> 'Arquivo <i>albums.xml</i> não possui permissão de escrita',
	52		=> 'Arquivo <i>config.inc.php</i> não possui permissão de escrita',
	53		=> 'Diretório <i>largeimages</i> nao possui permissão de escrita',
	54		=> 'Diretório <i>temp</i> nao possui permissão de escrita',
	55		=> 'Diretório <i>thumbs</i> nao possui permissão de escrita',
	
	100		=> '<b>ERRO FATAL.</b><br> É necessário efetuar o login para acessar essa área.',	
	1000 	=> 'Erro desconhecido.'
);
?>