<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
GLOBAL $HTTP_GET_VARS;
if (isset($HTTP_GET_VARS['table'])) $tab = $HTTP_GET_VARS['table'];
else $tab = '';

if ($tab) {
	include('./init.php');
	$cols = $gDB->MetaColumns($tab);
}

$isquery = isset($HTTP_GET_VARS['query']);

//print_r($HTTP_GET_VARS);

function genselect()
{
	$arr = array('=','<','>','<=','>=','Begins with');
	$s = '<SELECT>';
	$i = 0;
	foreach ($arr as $a) {
		$s .= "<OPTION value=$i>$a";
		$i += 1;
	}
	return  $s. '</SELECT>';
}

?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<?php
if ($isquery) {
	$colstxt = '';
	$colsarr = array();
	foreach($cols as $c) {
		$name = $c->name;
		if (isset($HTTP_GET_VARS["c_$name"]))
			$colstxt .= "&columns[]=$name";
	}
	
	
	$path= "data.php?table=$tab$colstxt";
	$path = "'".$path."&rnd='+Math.random()";
?>
<SCRIPT>
 parent.data.location.href = <?php print$path?>
</SCRIPT>
<?php
}

if ($tab) {
?>
<form name=cols>
<input type=submit>
<table border=1><tr valign=top><td>
<b>Select...</b><br>
<?
	$t = new PHPLensTable();
	foreach($cols as $c) {
		if ($isquery) $checked=($HTTP_GET_VARS["c_$c->name"]) ? ' checked':'';
		else $checked = ' checked';
		$t->AddRow( "<input type=checkbox name='c_$c->name'$checked>","$c->name<br>");
	}
	print $t->Render('border=0');
?>
</td><td>
<b>Where Columns Match (this part is not working)</b><br>
<?php

	$t = new PHPLensTable();
	$t->_idprefix = 't_';
	$t->debug =1;	
	foreach($cols as $c) {
		$t->AddTD('nowrap','nowrap');
		$t->AddRow($c->name,
			genselect('s1_'.$c->name)."<input type=text name='t1_$c->name'> &nbsp; &nbsp;"
			.genselect('s2_'.$c->name)."<input type=text name='t2_$c->name'>"
			);
	}
	print $t->Render('border=0');
	
	print "<input type=hidden name=table value='$tab'>";
	print "<input type=hidden name=query value=1>";
?>
</td></tr></table>
<input type=submit>
</form>
<?
}
?>
<pre>
To Do

1. Allow the user to choose col to be primary key, sum(), count()
2. Show only first 8 cols in grid the 1st time.
</body>
</html>
