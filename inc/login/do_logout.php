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
	lib_login_nuke_session(); 	// kill from database
	session_destroy();			// kill the session
	header("Location: $LOGOUT_PAGE");
	lib_login_no_browser_redirect($LOGOUT_PAGE);
	ob_end_flush();
?>
