<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------

class Images
{
	
	//-----------------------------------------------------------------------------------------------
	//	Members
	//-----------------------------------------------------------------------------------------------
	private $path;											// relative path to script root
	private $dom;												// handle DOM for albums.xmml
	private $aImgs;											// array images																			
																			// values =>	['id']
																			//						['albumId']
																			//						['sFilename']
																			//					 	['sCaption']
	
	
	//-----------------------------------------------------------------------------------------------
	//	Constructor
	//-----------------------------------------------------------------------------------------------
	//	string $path										
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function __construct($path)
	{
		$this->path = $path;
		
		$this->dom	= new DOMDocument();
		$this->dom->load($this->path.'albums.xml');
		
		// default
		$this->aImgs = array();
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Add
	//-----------------------------------------------------------------------------------------------
	//	int			$albumId
	//	string	$sFile
	//	string	$sCaption
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function add($albumId, $sFile, $sCaption)
	{
		$nodeImg = $this->dom->createElement('image');
		$nodeImg->setAttribute('imagename', utf8_encode($sFile));
		$nodeImg->setAttribute('infotext', $sCaption);
		
		// get album/images
		$nodeImgs =
			$this->dom->getElementsByTagName('album')->item($albumId)->getElementsByTagName('images')->item(0);
			
		// append image
		$nodeImgs->appendChild($nodeImg);
		
		// rebuild xml
		$this->dom->save($this->path.'albums.xml');		
	}
	
	
	
	//-----------------------------------------------------------------------------------------------
	//	Delete Img
	//-----------------------------------------------------------------------------------------------
	//	int			$albumId
	//	int			$imgId	 
	//	return 	void
	//-----------------------------------------------------------------------------------------------
	public function delImg($albumId, $imgId)
	{
		// retrieve image info
		$album 	= $this->dom->documentElement;
		$imgs		= $album->getElementsByTagName('album')->item($albumId)->getElementsByTagName('images')->item(0);
		$img		= $imgs->getElementsByTagName('image')->item($imgId);
		
		// delete file
		$this->delImgFiles($img->getAttribute('imagename'));
		
		// delete from xml tree
		$imgs->removeChild($img);
		
		$this->dom->save($this->path.'albums.xml');
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Edit Img Caption
	//-----------------------------------------------------------------------------------------------
	//	int			$albumId
	//	int			$imgId
	//	string	$sCaption
	//	return 	void
	//-----------------------------------------------------------------------------------------------
	public function editImgCaption($albumId, $imgId, $sCaption)
	{
		// retrieve image info
		$album 	= $this->dom->documentElement;
		$imgs		= $album->getElementsByTagName('album')->item($albumId)->getElementsByTagName('images')->item(0);
		$img		= $imgs->getElementsByTagName('image')->item($imgId);
		
		// delete from xml tree
		$img->setAttribute('infotext', $sCaption);
		
		$this->dom->save($this->path.'albums.xml');		
	}
	
	//-----------------------------------------------------------------------------------------------
	//	Get Img Array
	//-----------------------------------------------------------------------------------------------
	//	return array
	//-----------------------------------------------------------------------------------------------
	public function get()
	{
		return $this->aImgs;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Img Array
	//-----------------------------------------------------------------------------------------------
	//	int			$index
	//	return 	array
	//-----------------------------------------------------------------------------------------------
	public function getAlbumName($index)
	{
		$album = $this->dom->getElementsByTagName('album')->item($index);		
		return $album->getAttribute('albumname');
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Caption
	//-----------------------------------------------------------------------------------------------
	//	int			$albumId
	//	int			$imgId
	//	return 	array
	//-----------------------------------------------------------------------------------------------
	public function getCaption($albumId, $imgId)
	{
		$nodeAlbum  = $this->dom->getElementsByTagName('album')->item($albumId);
		$nodeImg		= $nodeAlbum->getElementsByTagName('image')->item($imgId);
		return $nodeImg->getAttribute('infotext');
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Set Album
	//-----------------------------------------------------------------------------------------------
	//	int			$albumId
	//	return 	void
	//-----------------------------------------------------------------------------------------------
	public function setAlbum($albumId)
	{
		$albums 		= $this->dom->getElementsByTagName('album');
		$nodeAlbum 	= $albums->item($albumId);
		$imgs				= $nodeAlbum->getElementsByTagName('image');
		
		$i = 0;
		
		foreach($imgs as $node)
		{
			$this->aImgs[] = array(
				'id'				=> $i,
				'albumId'		=> $albumId,
				'sFilename' => $node->getAttribute('imagename'),
				'sCaption'	=> $node->getAttribute('infotext')
			);
			
			++$i;
		}
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Round
	//-----------------------------------------------------------------------------------------------
	//	int	$multiple
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function round($multiple)
	{
		if((count($this->aImgs) % $multiple) == 0)
			return;
		
		while(((count($this->aImgs) % $multiple) != 0))
			$this->aImgs[] = array('sFilename' => '', 'sCaption' => '');
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Delete Img Files
	//-----------------------------------------------------------------------------------------------
	//	string $filename
	//	return void
	//-----------------------------------------------------------------------------------------------
	private function delImgFiles($filename)
	{
		// image
		$imgLarge = $this->path.'largeimages/'.$filename; 
		if(is_file($imgLarge))
			unlink($imgLarge);
			
		// thumb
		$imgThumb = $this->path.'thumbs/'.$filename;
		if(is_file($imgThumb))
			unlink($imgThumb);
	}
	
}
?>