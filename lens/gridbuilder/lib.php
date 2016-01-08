<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/

function PHPLENS_qb_RootPath()
{
GLOBAL $HTTP_SERVER_VARS;
GLOBAL $HTTP_ENV_VARS;

	$_p_url = '';
	//print_r($HTTP_SERVER_VARS);
	//print_r($HTTP_ENV_VARS);
	
	if (!$_p_url && isset($HTTP_SERVER_VARS['DOCUMENT_ROOT'])) { // APACHE and PWS
		$_p_file = $HTTP_SERVER_VARS['DOCUMENT_ROOT'];
		$_p_file = (str_replace('\\\\','/',$_p_file)); // compat for php4.02 on windows
		return (str_replace('\\','/',$_p_file));
	}
	if (!$_p_url && isset($HTTP_ENV_VARS['PATH_TRANSLATED'])) { // IIS
		$_p_file = $HTTP_ENV_VARS['PATH_TRANSLATED'];
		$_p_url = $HTTP_ENV_VARS['PATH_INFO'];
	}

	if (!$_p_url) return '';
	
	$_p_file = (str_replace('\\\\','/',$_p_file)); // compat for php4.02 on windows
	$_p_file = (str_replace('\\','/',$_p_file));
	$_p_url = ($_p_url);
	$_p_at = strpos(strtolower($_p_file),strtolower($_p_url));
	return  ($_p_at !== false) ? substr($_p_file,0,$_p_at) : '';
} //function

function undomq(&$m) 
{
	if (get_magic_quotes_gpc()) {
		// undo the damage
		$m = str_replace('\"','"',$m);
		$m = str_replace('\\\'','\'',$m);
	}
	return $m;
}

function lens_qb_gen_id()
{
	$t = sprintf("%x",time());

	$t .= sprintf("%x",rand());
	return substr(md5($t),0,8);
}

function start_sessions()
{
session_start();

session_register('lens_qb_id');
session_register('lens_qb_drivername');
session_register('lens_qb_driver');
session_register('lens_qb_server');
session_register('lens_qb_database');
session_register('lens_qb_user');
session_register('lens_qb_pwd');
session_register('lens_qb_master');
session_register('lens_qb_detail');
session_register('lens_qb_master_key');
session_register('lens_qb_detail_key');
}

?>