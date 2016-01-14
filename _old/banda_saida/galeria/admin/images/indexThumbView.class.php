<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------

class IndexThumbView
{
	//-----------------------------------------------------------------------------------------------
	//	Members
	//-----------------------------------------------------------------------------------------------
	private $aImg;							// array	['id']
															//				['albumId']
															//				['sFilename']
															//				['sCaption']
	
	// pseudo consts
	private $TXT_BUTTON_DEL;
	private $TXT_LINK_EDIT;
	private $TXT_LINK_ADD;
	private $TXT_JS_PROMPT;
	

	//-----------------------------------------------------------------------------------------------
	//	Constructor
	//-----------------------------------------------------------------------------------------------
	//	array		$aImg
	//	return	void
	//-----------------------------------------------------------------------------------------------
	public function __construct($aImg)
	{
		$this->aImg = $aImg;
		
		// peseudo consts
		$this->TXT_BUTTON_DEL 			= $GLOBALS['TXT_BUTTON_DEL'];
		$this->TXT_LINK_EDIT				= $GLOBALS['TXT_LINK_EDIT'];
		$this->TXT_LINK_ADD					= $GLOBALS['TXT_LINK_ADD'];
		$this->TXT_JS_PROMPT				= $GLOBALS['TXT_JS_PROMPT'];
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Print Col
	//-----------------------------------------------------------------------------------------------
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function printCol()
	{
		echo '<div class="col">';
		
		// image
		echo $this->getImg();
		echo '<br /><br />';
		
		// caption
		echo $this->getCaption();		
		
		// delete
		echo $this->getDel();
		
		echo '</div>'."\n";
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Caption
	//-----------------------------------------------------------------------------------------------
	//	return string
	//-----------------------------------------------------------------------------------------------
	private function getCaption()
	{
		$buffer = '';
		
		if(!$this->aImg['sFilename'])
			return $buffer;
		
		// button
		$link = $this->getCaptionButton();
		
		// caption		
		$buffer .= '<textarea class="TextareaDisable" disabled="disabled">';
		$buffer .= stripslashes($this->aImg['sCaption']);
		$buffer .= '</textarea>';
		$buffer .= '<br /><br />';
			
		$buffer .= $link;			
		return $buffer;		
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Caption Edit||Add Button
	//-----------------------------------------------------------------------------------------------
	//	return string
	//-----------------------------------------------------------------------------------------------
	private function getCaptionButton()
	{		
		
		$link = '<input type="button" onclick="editCaption(';
		$link .= $this->aImg['albumId'].', '.$this->aImg['id'].');" value="%s"/>';
		
		if($this->aImg['sCaption'])
		{
			$link = sprintf(
				$link,				
				$this->TXT_LINK_EDIT
			);
		}
		else
		{
			$link = sprintf(
				$link,				
				$this->TXT_LINK_ADD
			);
		}
		
		return $link;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Del
	//-----------------------------------------------------------------------------------------------
	//	return string
	//-----------------------------------------------------------------------------------------------
	private function getDel()
	{
		if(!$this->aImg['sFilename'])
			return '';
		
		echo '<input type="button" value="'.$this->TXT_BUTTON_DEL.'" ';
		echo 'onclick="delImg('.$this->aImg['albumId'].','.$this->aImg['id'].', \''.$this->TXT_JS_PROMPT.'\');" ';
		echo '/>';
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Img
	//-----------------------------------------------------------------------------------------------
	//	return string
	//-----------------------------------------------------------------------------------------------
	private function getImg()
	{
		$buffer = '&nbsp;';
		
		if(!$this->aImg['sFilename'])
			return $buffer;
		
		$buffer  = '<img src="../../thumbs/'.$this->aImg['sFilename'].'" />';		
		
		return $buffer;
	}
}
?>