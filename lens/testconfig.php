<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/

///////////////////////////////////////////////////////////////////
function error_die($msg)
{
	die("<font color=darkred>$msg</font>");
}
///////////////////////////////////////////////////////////////////
	
	error_reporting(63);

//////////////////////////////////
// Check configuration file exists
	
	define('PHPLENS_DIR',dirname(__FILE__));
	$config = PHPLENS_DIR.'/config/phplens.config.inc.php';
	if (!file_exists($config)) {
		error_die("<h3>Configuration file <i>$config</i> not found</h3>");
	}
	include_once($config);
	
/////////////////////////////////
// Check session stuff works

	include_once("./adodb/adodb.inc.php");
	
	print "<h3>Testing \$PHPLENS_SESSION_DRIVER</h3>";
	$conn = ADONewConnection($PHPLENS_SESSION_DRIVER);
	if (empty($conn)) error_die("<h3>\$PHPLENS_SESSION_DRIVER has an invalid value</h3> Possible legal values are mysql, postgres7, ibase, oci8, mssql, odbc, sybase, db2, access, etc. in the phplens.config.inc.php file.");
	else print "<p>Passed</p>";
	
	$connect_ok = $conn->Connect(
		$PHPLENS_SESSION_CONNECT, 
		$PHPLENS_SESSION_USER, 
		$PHPLENS_SESSION_PWD, 
		$PHPLENS_SESSION_DB);
		
	if (!$connect_ok) error_die("<h3>Connection failed</h3>
	Check your \$PHPLENS_SESSION_CONNECT, \$PHPLENS_SESSION_USER, \$PHPLENS_SESSION_PWD, \$PHPLENS_SESSION_DB settings in the phplens.config.inc.php file.");
	
	$rs = $conn->Execute('select count(*) from phplens');
	if (empty($rs)) die("<h3>SQL query failed</h3> SQL: select count(*) from phplens<p>This could mean that the phplens table is not created (consult <a href=http://phplens.com/lensman/setup.htm>setup.htm</a>)");

/////////////////////////////////
// Check PHPLENS_PATH
	if (dirname($PHP_SELF) != $PHPLENS_PATH) 
		print "<h3>\$PHPLENS_PATH error?</h3>This value in phplens.config.inc.php should be: '".dirname($PHP_SELF)."'<p>";

/////////////////////////////////
// Passed basic tests
	print "<h1>Configuration of phplens.config.inc.php Seems OK</h1> Try <a href=testtext.php>testtext.php</a> to test phpLens.";
?>
