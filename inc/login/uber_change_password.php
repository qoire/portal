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

/*---------------------------------------------------------------------*
**  this page is called  from lib_login_show_uber_change_passwd_form   *
** 	it does some sanity testing and then updates the given user's      *
** 	password to $newpassword                                           *
**---------------------------------------------------------------------*/
	ob_start();
	session_start();
	include(dirname(__FILE__)."/login.inc.php");
	
	$user 	= lib_login_protect_page_uber();
	$goback = GetReferer();
	$goback = explode("?", $goback);
	$goback = $goback[0];
	
	$string = getgString();
	
	// we must do some testing before we change anything!
	// $string[61] = "password is too short"
	// $string[62] = "password same as username"
	// $string[18] = "invalid username or password"
	
	$error = "success";
	
	if($username=="")
		$error=urlencode($string[18]);
		
	if(!lib_login_account_exists($username))
		$error=urlencode($string[18]);
		
	if(strlen($newpassword)<$MIN_PASSWORD_LENGTH)
		$error=urlencode($string[61]);
		
	if($username == $newpassword)
		$error=urlencode($string[62]);
	
	if($error == "success")
		lib_login_change_password_for_user($username, $newpassword);

	header("Location: $goback?error=$error");
	lib_login_no_browser_redirect("$goback?delerror=$error");
	ob_end_flush();
?>
