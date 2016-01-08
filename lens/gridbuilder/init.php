<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
srand(microtime());

include_once('./lib.php');

if (!defined('PHPLENS_DIR')) define('PHPLENS_DIR','..');
include_once(PHPLENS_DIR."/phplens.inc.php");

//===============================================================================

start_sessions();

/* 
# sample
$PHPLENS_DATABASES = 
array(			//driver, server, userid, pwd, database
	'logos' => array('odbc','logos','','',''),
	'logos2' => array('odbc','logos2','','',''),
	'nwind' => array('access','nwind','','',''),
	'mysqlnwind' => array('mysql','192.168.0.1','root','','northwind')
);
*/
if (empty($PHPLENS_DATABASES)) {
	die("You must define the array PHPLENS_DATABASES to use the Grid Builder");
}
if (isset($HTTP_GET_VARS['driver'])) {
	$lens_qb_drivername = $HTTP_GET_VARS['driver'];
}
		
if (empty($lens_qb_drivername) || empty($PHPLENS_DATABASES[$lens_qb_drivername])) {
	$lens_qb_arr = reset($PHPLENS_DATABASES);
	$lens_qb_drivername = key($PHPLENS_DATABASES);
} else
	$lens_qb_arr = $PHPLENS_DATABASES[$lens_qb_drivername];
	
$lens_qb_driver = $lens_qb_arr[0];
$lens_qb_server =  $lens_qb_arr[1];
$lens_qb_user =  $lens_qb_arr[2];
$lens_qb_pwd =  $lens_qb_arr[3];
$lens_qb_database =  $lens_qb_arr[4];
		
if (empty($lens_qb_id)) {
	$lens_qb_id = lens_qb_gen_id();
}

ADOLoadCode($lens_qb_driver);

$gDB = NewADOConnection();
if (!$gDB->PConnect($lens_qb_server,$lens_qb_user,$lens_qb_pwd,$lens_qb_database))
	$gDB = false;

?>