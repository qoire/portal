<?php

/*
	Load a picture from the directory stored in $TMPDIR.
	$TMPDIR must match beginning of the picture directory for security.
*/


//-----------------------------------------------------------------------------
// USE THE FOLLOWING TO DEBUG -- uncomment the mail line and set the address 
//-----------------------------------------------------------------------------
function err($msg)
{
	// mail('webmaster','phplens-img.php error',$msg);
	die();
}


//-----------------------------------------------------------------------------
// CODE BEGINS
//-----------------------------------------------------------------------------
if (empty($HTTP_GET_VARS['f'])) die();
$fname= $HTTP_GET_VARS['f'];


if (substr($fname,0,1) == '/') $TMPDIR = '/tmp/';  # unix
else $TMPDIR = 'E:/TMP/';               		 # windows


//------------------------------------------------------
// Clean up \ and / handling by changing everything to /
if (strpos($fname,'\\\\') !== FALSE) {
	$fname = str_replace('\\\\','\\',$fname);
}
$TMPDIR = str_replace('\\','/',$TMPDIR);
$fname = str_replace('\\','/',$fname);


//-------------------------------------------------------------
// hacker check 1. Do not allow them to access parent directory
if (strpos($fname,'..') !== false) err('parent directory hack='.$fname);
//---------------------------------------------------------------------
// hacker check 2. We must access a base directory that matches $TMPDIR
if (strtoupper($TMPDIR) != strtoupper(substr($fname,0,strlen($TMPDIR)))) err('base directory hack="'.$fname.'", should be ='.$TMPDIR);
//---------------------------------------
// hacker check 3. It must have len in it
if (strpos($fname,'len') === false) err('filename hack='.$fname);


$f = fopen($fname,'rb');
if ($f) {
	$val = fread($f,9999999);
	fclose($f);
	unlink($fname);
} else 
	$val = '';


if (isset($HTTP_GET_VARS['t'])) {
	$ctype = $HTTP_GET_VARS['t'];
} else {
	if (substr($val,0,3) == 'GIF') $ctype = 'image/gif';
	else if (substr($val,6,4) == 'JFIF') $ctype = 'image/jpeg';
	else if (substr($val,1,3) == 'PNG') $ctype = 'image/png'; 
	else {
		$suffix = '';
		if (substr($val,0,5) == '%PDF-') $suffix = '.pdf';

		$ctype = 'Content-Type: application/octet-stream';
		Header( "Content-Disposition: attachment; filename=RENAME_FILE$suffix"); 
	}
}

if (isset($ctype)) {
	Header("Content-Length: " . strlen($val));
	Header("Content-type: ".$ctype);
}
	print $val;
?>
