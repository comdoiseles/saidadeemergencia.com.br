//-------------------------------------------------------------------------------------------------
// 	OSW - Gerenciador Galeria de Imagens
// 	http://www.onlinesolucoesweb.com.br
// 	2010
//-------------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------
// SETTING VARIABLES
//-------------------------------------------------------------------------------------------------
currentpage = 1;
_global.whichalbum = 1;

function scalerf(w, h)
{
	diffw = w - bigframew;
	diffh = h - bigframeh;
	
	if (diffw <= 0 && diffh <= 0)
		scaler = 1 * 100;
	else if (diffw == Math.max(diffw, diffh))
		//scale to height
		scaler = bigframew / w * 99.5;
	else if (diffh == Math.max(diffw, diffh))
		//scale to width
		scaler = bigframeh / h * 99.5;
	
	return scaler;
}

//LOADCLIP ACTIVITIES
_root.createEmptyMovieClip("looploop", -1000);
var my_mcl = new MovieClipLoader;
myListener = new Object  ;

myListener.onLoadStart=function (target_mc)
{
	var loadProgress = my_mcl.getProgress (target_mc);
};


myListener.onLoadProgress = function (target_mc, loadedBytes, totalBytes)
{

	// FOR PRELOADER PURPOSES
	loaded = loadedBytes;
	total = totalBytes;
	percentage = Math.round (100 * (loaded / total));
	progressbar_mc.progresser_mc._xscale = percentage;
	
	if (percentage = Math.round (100 * (loaded / total)) < 100)
		progressbar_mc.progresser_mc._alpha = 100;
	else
		progressbar_mc.progresser_mc._alpha = 0;
};


myListener.onLoadComplete = function (target_mc)
{
	var loadProgress = my_mcl.getProgress (target_mc);
	imageframe_mc.hold._alpha = 0;
	velo = 0;
	
	imageframe_mc.hold.onEnterFrame = function ()
	{
		w = imageframe_mc.hold._width;
		h = imageframe_mc.hold._height;
		
		if (w != 0 && h != 0)
		{
			scaler = scalerf (w, h);
			
			if (scaler != 100)
			{
				imageframe_mc.hold._xscale = scaler;
				imageframe_mc.hold._yscale = scaler;
			}
		
			imageframe_mc.hold.forceSmoothing = true;
			imageframe_mc.hold._x = (bigframew - (w * (scaler / 100))) / 2;
			imageframe_mc.hold._y = -1 + (bigframeh - (h * (scaler / 100))) / 2;
			
			if (imageframe_mc.hold._alpha < 100)
			{
				accel = 0.3;
				velo = velo + accel;
				imageframe_mc.hold._alpha += velo;
			}
		}
	};
};


myListener.onLoadError = function (target_mc, errorCode)
{
};

my_mcl.addListener(myListener);


//-------------------------------------------------------------------------------------------------
// XML PARSING
//-------------------------------------------------------------------------------------------------
function imageListLoaded (whichalbum)
{
	//clear stage
	for (var rr=0; rr < noofrow * noofcolumn; rr++)
	{
		rr=rr + pageindex;
		this["thumbframe" + rr].removeMovieClip();
		this["thumbframein_mc" + rr].removeMovieClip();
		rr=rr - pageindex;
	}
	//parameters
	param = this.imageList_xml.firstChild.firstChild;
	pc = int(param.attributes.noofcolumn);
	pr = int(param.attributes.noofrow);
	ptx = int(param.attributes.thumbxs);
	pty = int(param.attributes.thumbys);
	_global.ptw = int(param.attributes.thumbwidth);
	_global.ptl = int(param.attributes.thumbheight);
	_global.bigframew = int(param.attributes.bigframewidth);
	_global.bigframeh = int(param.attributes.bigframeheight);
	albumnamesx = int(param.attributes.albumnamesxs);
	albumnamesy = int(param.attributes.albumnamesys);
	albumnamescolor = param.attributes.albumnamescolor;

	var albumCountXML = this.imageList_xml.firstChild.childNodes;
	albumCount = albumCountXML.length - 1;
	var mainNode = this.imageList_xml.firstChild.childNodes[whichalbum].firstChild;
	var listBoxData = createResourceList(mainNode.childNodes, pc, pr, ptx, pty, ptw, ptl);

	albumtextbox.text = whichalbum;

	for (t=1; t <= albumCount; t++)
	{

		//Creating text box
		this.createEmptyMovieClip("albumnames" + t,900 + t);
		albumname_mc = this["albumnames" + t];
		albumname_mc.createTextField("albumnametxt" + t, 1000 + t, 0, 0, 210, 17);
		var my_fmt:TextFormat = new TextFormat  ;
		my_fmt.color = albumnamescolor;
		my_fmt.font = "Verdana";
		my_fmt.size = 20;
		my_fmt.bold = true;
		albumname_mc["albumnametxt" + t].text = this.imageList_xml.firstChild.childNodes[t].attributes.albumname;
		albumname_mc["albumnametxt" + t].antiAliasType = "advanced";
		albumname_mc["albumnametxt" + t].gridFitType = "pixel";
		albumname_mc["albumnametxt" + t].sharpness = 400;
		albumname_mc["albumnametxt" + t].setTextFormat(my_fmt);
		albumname_mc._x = albumnamesx;
		albumname_mc._y = albumnamesy + t * 17;
		albumname_mc.sett = t;

		albumname_mc.onRelease = function()
		{
			currentpage = 1;
			filename.text = "";

			for (var rr = 0; rr < noofrow * noofcolumn; rr++)
			{
				rr = rr + pageindex;
				this["thumbframe" + rr].removeMovieClip ();
				this["thumbframein_mc" + rr].removeMovieClip ();
				rr = rr - pageindex;
			}
			
			imageListLoaded (this.sett);
			_global.whichalbum = this.sett;
		};
	}
}


function createResourceList(resource_array, noofcolumn, noofrow, thumbxs, thumbys, thumbwidth, thumblength, bigimagewidth)
{
	_global.noofcolumn = noofcolumn;
	_global.noofrow = noofrow;
	var listData = new DataProviderClass;
	resourceCount = resource_array.length;
	noofpage = Math.ceil(resourceCount / noofcolumn * noofrow);
	ofof.text = "Página: " + currentpage + "/" + noofpage;
	var resource, image, tmb;
	images = new Array  ;
	infotexts = new Array  ;
	pageindex = currentpage - 1 * noofrow * noofcolumn;
	
	for (var r=0; r < noofrow; r++)
	{
		
		for (var c=0; c < noofcolumn; c++)
		{
			i = r * noofcolumn + c + pageindex;
			
			if (i < resourceCount)
			{
				nodigits = new String(resourceCount);
				resource = resource_array[i];
				images[i] = resource.attributes.imagename;
				infotexts[i] = resource.attributes.infotext;
				loadme="thumbs/" + images[i];
				findme = images[i];
				whichframe = "frame" + i;
				this.attachMovie("thumbframe", "thumbframe" + i, i + 1);
				this["thumbframe" + i]._x = c * thumbwidth + thumbxs;
				this["thumbframe" + i]._y = r * thumblength + thumbys;
				this.createEmptyMovieClip("thumbframein_mc" + i, i + 1 * 1000);
				
				onEnterFrame = function ()
				{
					for (var tr=0; tr < noofrow; tr++)
					{
						for (var tc=0; tc < noofcolumn; tc++)
						{
							ti = (tr * noofcolumn) + tc + pageindex;
				
							if (ti < resourceCount)
							{
								tw = this["thumbframein_mc" + ti]._width;
								th = this["thumbframein_mc" + ti]._height;
								this["thumbframein_mc" + ti]._x = this["thumbframe" + ti]._x + (thumbwidth - tw) / 3;
								this["thumbframein_mc" + ti]._y = this["thumbframe" + ti]._y + (thumblength - th) / 3;
							}
						}
					}
				};
				
				this["thumbframein_mc" + i].loadMovie(loadme);
				noofthumbs = currentpage - 1 * noofcolumn * noofrow;
				nom = noofthumbs;
				callbig(nom);
				this.filename.text = " " + images[nom];

				this["thumbframe" + i].onRelease = function ()
				{
					startsubstring = 10;
					endsubstring = startsubstring + nodigits.length;
					largeindex = this._name.substring (startsubstring, endsubstring);
					callbig (largeindex);
				};
			}
		}
	}
}


function callbig(index)
{
	filename.text = " " + images[index];
	info.text = infotexts[index];
	imageframe_mc.createEmptyMovieClip("hold", 0);
	imageframe_mc.pictoral._width = _global.bigframew + 3;
	imageframe_mc.pictoral._height = _global.bigframeh;
	my_mcl.loadClip("largeimages/" + images[index], this.imageframe_mc.hold);
}

imageList_xml = new XML  ;
imageList_xml.ignoreWhite = true;

imageList_xml.onLoad = function (success)
{
	if (success)
		imageListLoaded (whichalbum);
};


//-------------------------------------------------------------------------------------------------
//HERE IS WHERE YOU DECLARE YOUR XML FILE
//-------------------------------------------------------------------------------------------------
imageList_xml.load("albums.xml");

rightbt.onRelease = function ()
{
	if (currentpage != noofpage)
	{
		currentpage++;
		imageListLoaded (_global.whichalbum);
	}
};

leftbt.onRelease = function ()
{
	if (currentpage > 1)
	{
		currentpage--;
		imageListLoaded (_global.whichalbum);
	}
};

stop();