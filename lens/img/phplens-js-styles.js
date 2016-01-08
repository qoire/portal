/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
		
var PHPLENS_styles = new Array();

// opera doesn't recognise lightgrey=>#C0C0C0
// netscape doesn't work with white, so #FCFCFC
                          // name, menu bg, menu color, title, odd, even, currentrecno, recno,                                     group,subtotal, total, detailleft,detailright,bg)
PHPLENS_styles[0]=new Array('Default','gray','#C0C0C0','lightyellow','beige','#FCFCFC','yellow','#C0C0C0',                     'papayawhip','oldlace','yellow','lightyellow','white','ghostwhite');
PHPLENS_styles[1]=new Array('Amazon','gray','#C0C0C0','lightsteelblue','cornsilk','beige','yellow','#C0C0C0',                  'lightsteelblue','oldlace','yellow','cornsilk','beige','ghostwhite');
PHPLENS_styles[2]=new Array('Arizona Reds','indianred','#C0C0C0','orange','lightyellow','beige','yellow','#C0C0C0',            'bisque','oldlace','yellow','cornsilk','beige','ghostwhite');
PHPLENS_styles[3]=new Array('Blue Monday','darkblue','#C0C0C0','darkturquoise','powderblue','lightskyblue','yellow','#C0C0C0', 'dodgerblue','mediumturquoise','cyan','powderblue','lightskyblue','lightsteelblue');
PHPLENS_styles[4]=new Array('Color Crazy','darkred','coral','seagreen','powderblue','lightskyblue','yellow','#C0C0C0',          'plum','mediumturquoise','cyan','powderblue','lightskyblue','pink');
PHPLENS_styles[5]=new Array('Fruitty Orange','black','#C0C0C0','orange','lightyellow','blanchedalmond','yellow','#C0C0C0',     'papayawhip','gainsboro','silver','lightyellow','white','gray');
PHPLENS_styles[6]=new Array('Gray Drizzle','dimgray','#C0C0C0','darkgray','ghostwhite','#FCFCFC','yellow','#C0C0C0',           'papayawhip','#C0C0C0','silver','ghostwhite','white','gray');
PHPLENS_styles[7]=new Array('Jungle Fever','darkgreen','#C0C0C0','olive','darkkhaki','darkseagreen','yellow','#C0C0C0',        'mediumaquamarine','mediumturquoise','cyan','darkkhaki','darkseagreen','dimgray');
PHPLENS_styles[8]=new Array('Transparent','!','!','!','!','!','!','!',                                                         '!','!','!','!','!','!');
PHPLENS_styles[9]=new Array('Whistler','navy','orange','gold','#FCFCFC','ghostwhite','yellow','#C0C0C0',                       'lightskyblue','gainsboro','silver','beige','white','lightseagreen');
PHPLENS_styles[10]=new Array('Windows','navy','#C0C0C0','darkturquoise','#FCFCFC','ghostwhite','yellow','#C0C0C0',             'skyblue','gainsboro','silver','ghostwhite','white','lightseagreen');

// form items to update
var PHPLENS_idx = new Array('c20','c1','c2','c3','c4','c5','c6','c7','c8','c9','c11','c12','c100');

// the menu is not generated in Netscape 4.0.4 but works for 4.6.1 & 6
function PHPLens_styles_init()
{
var i,sel,val
	sel = document.phplens_colors.PHPLENS_styles_popup;
	sel =document.forms['phplens_colors'].PHPLENS_styles_popup;
	for (i=0;i<PHPLENS_styles.length;i++) {
		val = PHPLENS_styles[i][0]
		if (sel.options)
		sel.options[i] = new Option(val,val);
	}
}

function PHPLens_Style_Select()
{
var zform = document.phplens_colors;
var at = zform.elements['PHPLENS_styles_popup'].selectedIndex;
var arr,i=0,zobj
	//if (at == 0) return;
	
	arr = PHPLENS_styles[at];
	
	for (i=0;i<arr.length-1 && i<PHPLENS_idx.length;i++) {
		zobj = zform.elements[PHPLENS_idx[i]];
		if (zobj) zobj.value = arr[i+1]
	}
	arr = PHPLENS_styles[1];
	for (;i<PHPLENS_idx.length;i++) {
		zobj = zform.elements[PHPLENS_idx[i]];
		if (zobj) zobj.value = arr[i+1]
	}
	zform.submit()
}

/////////// IMPLEMENTATION

PHPLens_styles_init();
