<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
/*

TODO: 
	1. Type of primary key needs to be set so we can handle chars
	2. Generation of master-detail code is still impossible
*/
GLOBAL $HTTP_GET_VARS,$PHP_SELF;

if (isset($HTTP_GET_VARS['clear'])) die();

include('./init.php');
include(ADODB_DIR.'/tohtml.inc.php');
include(PHPLENS_DIR.'/phplens.inc.php');


session_register('gLens_Cols');
session_register('gLens_Table');
session_register('lens_qb_at');
session_register('lens_qb_id2');
/* 
	there is a bug in PHP -- given a page frame, 
	the session id is not propagated if js open window under IIS - PWS ok
	
	so we restore all session variables we can if they are in the GET vars
*/


if (!empty($HTTP_GET_VARS['table'])) {
	if ($gLens_Table != $HTTP_GET_VARS['table']) {
		$lens_qb_id = lens_qb_gen_id();
		$isnew = true;
		$gLens_Table = $HTTP_GET_VARS['table'];
	}
}


if (isset($HTTP_GET_VARS['cols'])) {
	$gLens_Cols = $HTTP_GET_VARS['cols'];
}

if (isset($HTTP_GET_VARS['qb_id'])) {
	$lens_qb_id = $HTTP_GET_VARS['qb_id'];
}

if (isset($HTTP_GET_VARS['lens_qb_at']))
	$lens_qb_at = $HTTP_GET_VARS['lens_qb_at'];

$tab = $gLens_Table;

?>
<html>
<head>
<title>PHPLens</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<SCRIPT language=javascript>
var phplens_upgrade='Configuring phpLens requires Internet Explorer 4.0+ or Netscape 4.0+.'
var phplens_win1
if (parseInt(navigator.appVersion) < 4) alert(phplens_upgrade);

/*open a url in a new window */
function phplens_openwin(zurl)
{
var invalidwin,r,url

	r = Math.random()
	url = ''+zurl
	if (url.match(/\?/)) url += '&rnd='+r
	else url += '?rnd='+r
	
	if (phplens_win1 && phplens_win1.open && !phplens_win1.closed) {
		phplens_win1.document.open();
		if (phplens_win1.location.href != url) 
			phplens_win1.location.href = url;
	}else {
		phplens_win1 = window.open(url,'phplensmsgwindow',"height=400,width=700,scrollbars=yes,resizable=yes") 
	}
	phplens_win1.focus()
	
}

</SCRIPT>
<?php
//print_r($HTTP_GET_VARS);

if (!$gDB) {
	print "<h3>Cannot connect to ($lens_qb_driver): $lens_qb_server $lens_qb_database</h3>";
}

if (!empty($tab) && $gDB) {
	$sep = '^';
	
	if (!$gLens_Cols) $gLens_Cols = '*';
	$lens = new PHPLens($lens_qb_id,$gDB,"select $gLens_Cols from $tab");
	$lens->_idprefix = 't_';
	$lens->powerLens = $lens_qb_master_key.'^<a href="$PHP_SELF?lens_qb_at={'.$lens_qb_master_key.'}">{'.$lens_qb_master_key.'}</a>';

	if (!empty($colsarr)) {
$help=<<<EOD
<h4>
To control which columns are visible, click on $lens->dynEditTabIcon on the far left.<br>
To edit column titles and other column stuff, click on $lens->dynEditColIcon next to the column titles.<br> 
For global changes, click on $lens->dynEditIcon in the navigation bar on the right.
</h4>
EOD;
		print $help;
		$lens->Reset();
	}
	
	ob_start();
		$cols = urlencode($gLens_Cols);
		print "<div align=center><a href='javascript:phplens_openwin(\"$PHP_SELF?lens_e_$lens->id=code&table=$tab&qb_id=$lens_qb_id&cols=$cols\")'><b>Generate PHP Source Code</b></a> &nbsp; <a href=$PHPLENS_PATH/help/ target=lensgridhelp>Help</a></div>";
		$lens->dynEdit = 2;
		$lens->Render();
		
	$rendered = ob_get_contents();
	ob_end_clean();
	$lens->Verify();
	print $rendered;
	$lens->Close();
}
print "<br>";

if ($isnew) $lens_qb_id2 = lens_qb_gen_id();
$lens2 = new PHPLens($lens_qb_id2,$gDB,"select * from $lens_qb_detail where $lens_qb_detail_key=$lens_qb_at");
$lens2->_idprefix = 't2';
$lens2->Render();
$lens2->Close();

?>
</body>
</html>
