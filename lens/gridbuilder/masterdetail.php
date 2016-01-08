<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
$arr = array();
require('./init.php');

if ($gDB && time() % 4 == 0) {
	$d = $gDB->DBTimeStamp(time() - 3600*24);
	$gDB->Execute("delete from phplens where id like 't_%' and lastmod<$d");
}

if (isset($HTTP_GET_VARS['table1'])) $lens_qb_master = $HTTP_GET_VARS['table1'];
if (isset($HTTP_GET_VARS['table2'])) $lens_qb_detail = $HTTP_GET_VARS['table2'];
if (isset($HTTP_GET_VARS['column1'])) $lens_qb_master_key = $HTTP_GET_VARS['column1'];
if (isset($HTTP_GET_VARS['column2'])) $lens_qb_detail_key = $HTTP_GET_VARS['column2'];
?>
<html>
<head>
<title>Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language=javascript>
function fetchtable1()
{
	var at=document.gettable1.table1.selectedIndex;
	var tab = document.gettable1.table1.options[at].text;
	var at=document.gettable1.col1.selectedIndex;
	var col = document.gettable1.col1.options[at].text;
       	window.location.href = 'masterdetail.php?table1='+escape(tab)+'&column1='+col+'&rnd='+Math.random()
}


function fetchtable2()
{
	var at=document.gettable2.table2.selectedIndex;
	var tab = document.gettable2.table2.options[at].text;
	var at=document.gettable2.col2.selectedIndex;
	var col = document.gettable2.col2.options[at].text;
       	window.location.href = 'masterdetail.php?table2='+escape(tab)+'&column2='+col+'&rnd='+Math.random()
}

function fetchdb()
{
	var at=document.getdriver.drivers.selectedIndex;
	var dr = document.getdriver.drivers.options[at].text;
	window.location.href = 'masterdetail.php?driver='+escape(dr)+'&rnd='+Math.random()
}

</SCRIPT>
</head>

<body bgcolor="lightyellow">
<h2>Database</h2>
	<FORM name=getdriver> <b>Database</b> 
	<?php
	$arr = array();
	foreach($PHPLENS_DATABASES as $k=>$v) {
		$arr[] = $k;
	}
	print PHPLensArrayMenu('drivers onchange=fetchdb() ',$arr,false,$lens_qb_drivername,false);
	?>
	</FORM>
	
<h2>Master</h2><FORM name=gettable1> 
<table border=0 width='100%'><tr><td>
	<b>Table</b> 
	<?php
	if ($gDB) $arr = $gDB->MetaTables();
	print PHPLensArrayMenu('table1 onchange=fetchtable1() ',$arr,true,$lens_qb_master,false);
	?>
	
</td><td width=50%> &nbsp; Primary Key
<?php
	if ($gDB) $colarr = $gDB->MetaColumns($lens_qb_master);
	if ($colarr) {
		$arr = array();
		foreach ($colarr as $k=>$v) $arr[] = $k;
		print PHPLensArrayMenu('col1 onchange=fetchtable1() ',$arr,true,$lens_qb_master_key,false);
	}
?></td>
</tr>
</table></FORM>
<h2>Detail</h2>
<FORM name=gettable2> 
<table border=0 width='100%'><tr><td>
	<b>Table</b> 
	<?php
	if ($gDB) $arr = $gDB->MetaTables();
	print PHPLensArrayMenu('table2 onchange=fetchtable2() ',$arr,true,$lens_qb_detail,false);
	?>
	
</td><td width=50%>
	&nbsp; Foreign Key
<?php
	if ($gDB) $colarr = $gDB->MetaColumns($lens_qb_detail);
	if ($colarr) {
		$arr = array();
		foreach ($colarr as $k=>$v) $arr[] = $k;
		print PHPLensArrayMenu('col2 onchange=fetchtable2() ',$arr,true,$lens_qb_detail_key,false);
	}
?>
</td></tr>
</table>
</FORM>
<?php
	if (!empty($lens_qb_master) && !empty($lens_qb_master_key)
		 && !empty($lens_qb_detail) && !empty($lens_qb_detail_key))
		print "<a href=masterdetail2.php?table=$lens_qb_master>Generate Master Detail Code</a>";
?>
</body>
</html>
