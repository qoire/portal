<?php
/*---------------------------------------------------------------------*
** Licensing:                                                          *
** ^^^^^^^^^                                                           *
** php_lib_login - php web login/password implementation for the lazy  *.
** Copyright (C) 2001  grant "frymaster" horwood                       *
**                                                                     *
** This library is free software; you can redistribute it and/or       *
** modify it under the terms of the GNU Lesser General Public          *
** License as published by the Free Software Foundation; either        *
** version 2.1 of the License, or (at your option) any later version.  *
**                                                                     *
** This library is distributed in the hope that it will be useful,     *
** but WITHOUT ANY WARRANTY; without even the implied warranty of      *
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU   *
** Lesser General Public License for more details.                     *
**                                                                     *
** You should have received a copy of the GNU Lesser General Public    *
** License along with this library; if not, write to                   *
** the Free Software Foundation, Inc.,                                 *
** 59 Temple Place, Suite 330,                                         *
** Boston, MA                                                          *
** 02111-1307  USA                                                     *
**---------------------------------------------------------------------*/
	ob_start();
	session_start();
	include(dirname(__FILE__)."/login.inc.php");

	// find out where we came from, strip the GET tags off the URL
	$user 	= lib_login_protect_page_uber();
	$goback = GetReferer();
	$goback = explode("?", $goback);
	$goback = $goback[0];
	
	// don't let non-uber users run this page.
	if($user != $UBER_USER)
	{
		header("Location: $FAIL_PAGE");
		lib_login_no_browser_redirect("$goback?delerror=$error");
		die;
	}
	else
		{$error = lib_login_delete_user($delusername);}
		
	header("Location: $goback?delerror=$error");
	lib_login_no_browser_redirect("$goback?delerror=$error");
	ob_end_flush();
?>
