<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------

class Albums
{
	
	//-----------------------------------------------------------------------------------------------
	//	Members
	//-----------------------------------------------------------------------------------------------
	private $dom;
	private $path;
	
	
	//-----------------------------------------------------------------------------------------------
	//	Constructor
	//-----------------------------------------------------------------------------------------------
	//	string $pathToFile
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function __construct($path)
	{
		$this->path = $path;
		
		$this->dom = new DOMDocument();
		$this->dom->load($path.'albums.xml');
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Add Album
	//-----------------------------------------------------------------------------------------------
	//	string	$sAlbum
	//	return 	void
	//-----------------------------------------------------------------------------------------------
	public function addAlbum($sAlbum)
	{
		$photoalbum = $this->dom->getElementsByTagName('photoalbum')->item(0);

		// create album node
		$album 	= $this->dom->createElement('album');
		$album->setAttribute('albumname', $sAlbum);

		// create images node
		$imgs		= $this->dom->createElement('images');
		$album->appendChild($imgs);

		$photoalbum->appendChild($album);

		$this->dom->save($this->path.'albums.xml');
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Edit Albums
	//-----------------------------------------------------------------------------------------------
	//	int			$albumId	
	//	return 	void
	//-----------------------------------------------------------------------------------------------
	public function delAlbum($albumId)
	{
		$album	= $this->dom->getElementsByTagName('album')->item($albumId);		
		$imgs		= $album->getElementsByTagName('images')->item(0);
		$img 		= $imgs->getElementsByTagName('image');
		
		$cImgs	= $img->length - 1;
		for($i = $cImgs; $i >= 0; $i--)
		{
			// delete file
			$file = $img->item($i)->getAttribute('imagename');			
			$this->delImgFiles($file);
		}
		
		// delete album
		$photoalbum = $this->dom->getElementsByTagName('photoalbum')->item(0);
		$photoalbum->removeChild($album);
		
		$this->dom->save($this->path.'albums.xml');
		
	}
	
	//-----------------------------------------------------------------------------------------------
	//	Edit Albums
	//-----------------------------------------------------------------------------------------------
	//	int			$albumId
	//	string	$sAlbum
	//	return 	void
	//-----------------------------------------------------------------------------------------------
	public function editAlbum($albumId, $sAlbum)
	{
		// retrieve album		
		$album	= $this->dom->getElementsByTagName('album')->item($albumId);
		
		// update attribute		
		$album->setAttribute('albumname', $sAlbum);
		
		$this->dom->save($this->path.'albums.xml');
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Album
	//-----------------------------------------------------------------------------------------------
	//	int			$index
	//	return 	array
	//-----------------------------------------------------------------------------------------------
	public function getAlbum($index)
	{
		$album = '';
		
		// retrieve albums
		$nodeAlbum 	= $this->dom->getElementsByTagName('album')->item($index);
		$album = $nodeAlbum->getAttribute('albumname');		
		
		return $album;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	//	Get Albums
	//-----------------------------------------------------------------------------------------------
	//	return array
	//-----------------------------------------------------------------------------------------------
	public function getAlbums()
	{
		$aAlbums 	= array();		
		$id				= 0;
		
		// retrieve albums
		$albums 	= $this->dom->getElementsByTagName('album');
		
		foreach($albums as $nodeAlbum)
		{
			$images = $nodeAlbum->getElementsByTagName('image');
			
			$aAlbums[] = array(
				'id'		=> $id++,
				'sName' => $nodeAlbum->getAttribute('albumname'),
				'cImg' 	=> $images->length				
			);
		}
		
		return $aAlbums;
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