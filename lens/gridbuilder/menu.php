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
?>
<html>
<head>
<title>Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language=javascript>
function fetchtable()
{
	var at=document.gettable.tables.selectedIndex;
	var tab = document.gettable.tables.options[at].text;
       	parent.data.location.href = 'data.php?table='+escape(tab)+'&columns[]=*&rnd='+Math.random()
}

function fetchdb()
{
	var at=document.getdriver.drivers.selectedIndex;
	var dr = document.getdriver.drivers.options[at].text;
	window.location.href = 'menu.php?driver='+escape(dr)+'&rnd='+Math.random()
	parent.data.location.href = 'clear.php'
}

</SCRIPT>
</head>

<body bgcolor="lightyellow">


<table border=0 width='100%'><tr><td>
	<FORM name=gettable> <b>Table</b> 
	<?php
	if ($gDB) $arr = $gDB->MetaTables();
	print PHPLensArrayMenu('tables onchange=fetchtable() ',$arr,true,false,false);
	?>
	</FORM>
</td><td>
	<FORM name=getdriver> <b>Database</b> 
	<?php
	$arr = array();
	foreach($PHPLENS_DATABASES as $k=>$v) {
		$arr[] = $k;
	}
	print PHPLensArrayMenu('drivers onchange=fetchdb() ',$arr,false,$lens_qb_drivername,false);
	?>
	&nbsp; &nbsp; <a href=sql.php target=_top><b>SQL Tool</b></a>
	</FORM>

</td><td align=right>
	<form>
	<a href=confighelp.html target=_confighelp>Builder Help</a>
	</form>
</td></tr>
</table>

</body>
</html>
