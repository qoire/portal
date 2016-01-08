<?
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/


//-----------------------------------------------------------------
// javascript validator code when editing
//-----------------------------------------------------------------
function LensSetupValidator(&$lens)
{
// EOD not allowed in class string initialisation, so we do the setup here.
$field = $lens->lang->txtField;
//$txterr = $lens->lang->txtJSValidationErr;
$txtexp = $lens->lang->txtExpected;
$lentxtexp = strlen($txtexp);
/*
o = javascript dom object
r = regular expression
col = input tag name
err = error message to display
*/

//var msg='';
//if (err.substr(0,$lentxtexp)=='$txtexp') msg ='$txterr\\n';

return <<<EOD
function PHPLENS_val(o,r,col,err){
if (!r || !o) return true;
err = unescape(err);r=unescape(r);col=unescape(col);
upper = err.match(/\>/); lower = err.match(/\</);
err=err.replace(/[\<\>]/g,'');
var s=new String(o.value);
var re = new RegExp(r,'gi');
//alert(' regexp="'+r+'"\\n obj='+o.name+'\\n val="'+o.value+'"');
// patch for NN4.77 - select popup is null
if (s == 'null' && o.type && (new String(o.type)).substr(0,6)=='select') {return true;}
if (! re.test(s)) {if (s.length>0) col += ':\\n'+s+'\\n';else col='';alert('$field = '+err+'\\n\\n'+col);
if (o.style) {o.style.backgroundColor='#FFC0C0';o.style.color='black';}
//&& o.style.backgroundColor
return false;}
if (upper=='>') o.value=s.toUpperCase();
if (lower=='<') o.value=s.toLowerCase();
return true;
}
EOD;
}

function PHPLENS_RenderDynEdit(&$t)
{

	$t->RenderErrors();
	include_once(PHPLENS_DIR.'/phplens-edit.inc.php');
	
	// warning PHP 4.0.3 incompatible if using =&
	$e = new PHPLensEdit($t);
	$e->Render();
}

function PHPLENS_DynEdit(&$t)
{
	$t->RenderErrors();
	include_once(PHPLENS_DIR.'/phplens-edit.inc.php');
	
	// warning PHP 4.0.3 incompatible if using =&
	return new PHPLensEdit($t);
}

function &PHPLENS_GetDataEditor(&$lens)
{

static $gEditor;

	if (empty($gEditor))  {
		include_once(PHPLENS_DIR.'/phplens-sql.inc.php');
		// warning PHP 4.0.3 incompatible if using =&
		$gEditor = new PHPLensDataEditor();
	}
	$gEditor->lens = &$lens;
	return $gEditor;
}

?>
