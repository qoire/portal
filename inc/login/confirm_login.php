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
** confirm_login.php                                                   *
** ^^^^^^^^^^^^^^^^^                                                   *
** accepts $username and $password from login.php, looks up whether    *
** its a valid l/p if it is, log session and redirect to main menu     *
** if it isn't, set $error and redirect to login.php?error=$error      *
**---------------------------------------------------------------------*/

include(dirname(__FILE__)."/login.inc.php");
ob_start();

// confirm l/p is valid will not proceed past here if  l/p is invalid  
lib_login_check_valid_lp($username, $password);
	
/*---------------------------------------------------------------------*
** register this variable and put it in the database.                  *
**---------------------------------------------------------------------*/
lib_login_log_session($username);

// get where we came from, strip the GET vars off the URL and redirect
$destination = lib_login_get_success_page($username);
$destination = explode("?", $destination);
$destination = $destination[0];	

header("Location: $destination");
lib_login_no_browser_redirect($destination);
ob_end_flush();
?>
