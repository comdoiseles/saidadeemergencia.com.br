<?php
//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------
// This class manage image files to create thumbs.
// PHP5 only
//-------------------------------------------------------------------------------------------------
class ImageSystem
{
	//-----------------------------------------------------------------------------------------------
	// Members
	//-----------------------------------------------------------------------------------------------
	private $bForceCopy; 			// if set to 0 the thumb will only be created if it's size is not 
														// larger than $imgDstSize
	
	// source image
	private $imgSrcFile;
	private $imgSrcFolder;
	private $imgSrcSize;			// array 0 => width, 1 => height
	
	// destiny image
	private $imgDstFile; 			// .jpg extension
	private $imgDstFolder;
	private $imgDstSize;			// array 0 => width, 1 => height
	
	
	//-----------------------------------------------------------------------------------------------
	// Constructor
	//-----------------------------------------------------------------------------------------------
	//	int $forceCopy
	//	return void
	//-----------------------------------------------------------------------------------------------
	public function __constructor($forceCopy = 0)
	{
		$this->bForceCopy = $forceCopy;
		
		// source
		$this->imgSrcFile 	= '';
		$this->imgSrcFolder = '';
		$this->imgSrcSize 	= array();
		
		// destiny
		$this->imgDstFile 	= '';
		$this->imgDstFolder = '';
		$this->imgDstSize 	= array();
	}
	
	
	//-------------------------------------------------------------------------------------------------
	// Build image with max. width and height
	//-------------------------------------------------------------------------------------------------
	//		return void
	//-------------------------------------------------------------------------------------------------
	public function buildImageXY()
	{
		// image source is smaller than destiny image
		if(!$this->bForceCopy)
			if($this->imgSrcSize[0] < $this->imgDstSize[0] && $this->imgSrcSize[1] < $this->imgDstSize[1])
			{
				$this->imgDstSize = $this->imgSrcSize;
				$this->buildImage();
				return;
			}
				
		// calculate proportions
		// first calculate y proportional
		$percentage = $this->imgDstSize[0] / $this->imgSrcSize[0];
		$newY				= (int)($percentage * $this->imgSrcSize[1]);
		
		// check if height is in the boundary
		if($newY <= $this->imgDstSize[1])
		{
			$this->imgDstSize[1] = $newY;
			$this->buildImage();
			return;
		}
		
		// calculate X in the boundary and build image
		$percentage 					= $this->imgDstSize[1] / $this->imgSrcSize[1];
		$this->imgDstSize[0]	= (int)($percentage * $this->imgSrcSize[0]);
		$this->buildImage();
	}
	
	
	//-------------------------------------------------------------------------------------------------
	// Build image with max. width
	//-------------------------------------------------------------------------------------------------
	//		return void
	//-------------------------------------------------------------------------------------------------
	public function buildImageX()
	{
		// check for force copy value and X value
		if(!$this->bForceCopy && $this->imgSrcSize[0] < $this->imgDstSize[0])
		{
			$this->imgDstSize = $this->imgSrcSize;
		}
		// calculate proportional Y size
		else
		{
			$percentage = $this->imgDstSize[0] / $this->imgSrcSize[0];
			$this->imgDstSize[1] = (int)($percentage * $this->imgSrcSize[1]);
		}
		
		$this->buildImage();
	}
	
	
	//-------------------------------------------------------------------------------------------------
	// Build image with both fixed and y
	//-------------------------------------------------------------------------------------------------
	//		return void
	//-------------------------------------------------------------------------------------------------
	// PHP5 Note. Function should be declared as public
	//-------------------------------------------------------------------------------------------------
	public function buildImageXYFixed()
	{
		$this->buildImage();
	}
	
	
	//-------------------------------------------------------------------------------------------------
	// check if $filename is a valid image extension
	//-------------------------------------------------------------------------------------------------
	//		string $file
	//		return bool
	//-------------------------------------------------------------------------------------------------
	public function checkFileExt($file)
	{
		// check file extension
		$ext = end(explode(".", $file));
		$ext = strtolower($ext);
		if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') { return false; }
		
		return true;
	}
	
	
	//-------------------------------------------------------------------------------------------------
	// set force copy bool value
	//-------------------------------------------------------------------------------------------------
	//		string $forceCopy
	//		return void
	//-------------------------------------------------------------------------------------------------
	public function setForceCopy($forceCopy)
	{
		$this->bForceCopy = $forceCopy;
	}
	
	
	//-------------------------------------------------------------------------------------------------
	// Set the source image
	//-------------------------------------------------------------------------------------------------
	//		string $file
	//		string $folder
	//		return bool
	//-------------------------------------------------------------------------------------------------
	public function setImgSrc($file, $folder)
	{
		// check for file existance
		if(!$file) { return false; }
		if(!is_file($folder.$file)) { return false; }
		
		if(!$this->checkFileExt($file)) { return false; }
		
		// fill members
		$this->imgSrcFile 	= $file;
		$this->imgSrcFolder = $folder;
		$this->imgSrcSize 	= getimagesize($folder.$file);
		
		return true;
	}
	
	
	//-------------------------------------------------------------------------------------------------
	// Set the destiny image
	//-------------------------------------------------------------------------------------------------
	//		string $file
	//		string $folder
	//		array $size
	//		return bool
	//-------------------------------------------------------------------------------------------------
	public function setImgDst($file, $folder, $size)
	{		
		// check destiny filename
		if(!$file) { return false; }
		
		// check image extension
		$ext = end(explode(".", $file));
		$ext = strtolower($ext);
		if($ext != 'jpg') { return false; }
		
		// check size array
		if(count($size) < 2) { return false; }
		
		// fill members
		$this->imgDstFile 	= $file;
		$this->imgDstFolder = $folder;
		$this->imgDstSize 	= $size;
		
		return true;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	// get unique filename on folder
	//-----------------------------------------------------------------------------------------------
	//		string $file
	//		string $folder
	//		return string
	//-----------------------------------------------------------------------------------------------
	public function getUniqueFilename($file, $folder)
	{
		
		// vars
		$buffer = '';
		$ext		= '';
		$file 	= strtolower($file);
		
		// replace blank spaces
		$file = str_replace(" ", "_", $file);
		
		// check if it's unique
		if(!is_file($folder.$file)) { return $file; }
		
		// separete filename and extension
		$buffer = substr($file, 0, strrpos($file, '.'));
		$ext		= substr($file, strrpos($file, '.'));
		
		// add a index before the extension if necessary
		$index = 1;
		while(is_file($folder.$buffer.$index.$ext))
		{
			++$index;
		}
		
		return $buffer.$index.$ext;
	}
		
		
	//-----------------------------------------------------------------------------------------------
	// get unique filename .jpg on folder
	//-----------------------------------------------------------------------------------------------
	//		string $file
	//		string $folder
	//		return string
	//-----------------------------------------------------------------------------------------------
	public function getUniqueFilenameJPG($file, $folder)
	{
		// vars
		$buffer = '';
		$ext		= '';
		$file 	= strtolower($file);
		
		// replace blank spaces
		$file = str_replace(" ", "_", $file);
		
		// delete extentsion
		$buffer = substr($file, 0, strrpos($file, '.'));
		
		// check if it's unique
		if(!is_file($folder.$buffer.'.jpg')) { return $buffer.'.jpg'; }
		
		// add a index before the extension if necessary
		$index = 1;
		while(is_file($folder.$buffer.$index.'.jpg'))
		{
			++$index;
		}
		
		return $buffer.$index.'.jpg';
	}
	
	
	//-----------------------------------------------------------------------------------------------
	// build image based on source and destiny arrays
	//-----------------------------------------------------------------------------------------------
	//		return void
	//-----------------------------------------------------------------------------------------------
	private function buildImage()
	{
		// thumb file name
		$imgExt = end(explode(".", $this->imgSrcFile));
			
		// check image type
		if($imgExt == 'jpg' || $imgExt == 'jpeg')	{ $imgTmp = imagecreatefromjpeg($this->imgSrcFolder.$this->imgSrcFile); }
		if($imgExt == 'png') 						{ $imgTmp = imagecreatefrompng ($this->imgSrcFolder.$this->imgSrcFile); }
		if($imgExt == 'gif')						{ $imgTmp = imagecreatefromgif ($this->imgSrcFolder.$this->imgSrcFile); }
	
		// create empty resized image
		$imgNew = imagecreatetruecolor($this->imgDstSize[0], $this->imgDstSize[1]);
			
		// copy image destroy temp image
		imagecopyresampled($imgNew, $imgTmp, 0, 0, 0, 0,
						   $this->imgDstSize[0], $this->imgDstSize[1],
						   $this->imgSrcSize[0], $this->imgSrcSize[1]);
		imagedestroy($imgTmp);
			
		// create new file
		imagejpeg($imgNew, $this->imgDstFolder.$this->imgDstFile);
	}	
}

?>