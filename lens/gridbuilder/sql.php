<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
include("./init.php");
include(ADODB_DIR."/tohtml.inc.php");
error_reporting(63);

$sql = isset($HTTP_GET_VARS['sql']) ? $HTTP_GET_VARS['sql'] : '';
$sql = undomq($sql);
?>
<html>

<head>
<title></title>
</head>
 <SCRIPT>
function fetchdb()
{
	var at=document.getdriver.drivers.selectedIndex;
	var dr = document.getdriver.drivers.options[at].text;
	window.location.href = 'sql.php?driver='+escape(dr)+'&rnd='+Math.random()
}

</SCRIPT>
<body bgcolor=white>

<FORM name=getdriver> <b>Database</b> 
	<?php
	$arr = array();
	foreach($PHPLENS_DATABASES as $k=>$v) {
		$arr[] = $k;
	}
	print PHPLensArrayMenu('drivers onchange=fetchdb() ',$arr,false,$lens_qb_drivername,false);
	?>
&nbsp; <a href="sql.php?doListTables=1">List Tables</a> &nbsp; &nbsp; <a href=index.php target=_top>Grid Builder</a>
</FORM>
	
<H3>Enter SQL: </H3>
<form method="GET" action="<?php echo $PHP_SELF ?>">
  <p><textarea rows="3" name="sql" cols="64"><?php print htmlspecialchars($sql) ?></textarea></p>
  <p><input type="submit" value="Submit" name="B1"><input type="reset" value="Reset"  name="B2"></p>
</form>

<?php
 
if (isset($HTTP_GET_VARS['doListTables'])) {
	$arr = $gDB->MetaTables();
	if (is_array($arr)) {
		for ($i=0; $i < sizeof($arr); $i++) {
			$s = urlencode("select * from {$arr[$i]}");
			$arr[$i] = "<a href=$PHP_SELF?sql=$s&tab={$arr[$i]}>".$arr[$i].'</a>';
		}
		arr2html($arr);
	}
}
			
if ($sql) {
	$rs = $gDB->Execute($sql);
	if ($rs && !$rs->EOF) rs2html($rs);
	else if ($gDB->ErrorNo()) {
		print $gDB->ErrorMsg();
	} else {
		$err =  $gDB->ErrorMsg();
		print "<p>No Recordset returned<br>$err</p>";
	}
}

if (isset($HTTP_GET_VARS['tab'])) {
	$arr = $gDB->MetaColumns($HTTP_GET_VARS['tab']);
	print "<p>";
	foreach($arr as $k)  {
		print "<b>$k->name</b> $k->type $k->max_length<br>";
	}
}
?> 
</body>
</html>