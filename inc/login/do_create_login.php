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
** this page is called by create_login.php and is responsible for      *
** inserting the l/p into tbl_users.                                   *
** NOTE: this page is only accessible by the account which is          *
** defined in $UBER_USER in login.inc                                  *
**---------------------------------------------------------------------*/
//ob_start();

//@include("php_lib_login_includes/languages.inc.php");
//@include("languages.inc.php");

session_start();
include(dirname(__FILE__)."/login.inc.php");

$gString = getgString();


// protect if public signup is false
lib_login_protect_signup();

// mailback account creation requires building a random password
if($cache == "random")
{
	$password = lib_login_create_random_passwd();
	$passwordagain = $password;
}

/*---------------------------------------------------------------------*
** it is the uber user... so we take $username, $password and          *
** $passwordagain and use it to create can account... then we redirect *
** back to create_login.php                                            *
**---------------------------------------------------------------------*/
$error = lib_login_create_account($username, $password, $passwordagain, $email, $question, $answer);

$error = urlencode($error);

// find out where we came from, sript all GET vars off the URL
$goback = GetReferer();
$goback = explode("?", $goback);
$goback = $goback[0];



if(($cache=="random") && ($error=="success"))
{
	// do mail stuff here... and make an attempt at error checkin? huh?
	$this_site = lib_login_get_this_site();
	$admin_email = lib_login_get_admin_email();
	
	// $gString[79] = "an account has been created for you at $this_site with
	//                 the following details"
	// $gString[2] = "username"
	// $gString[3] = "password"
	// $gString[80] = "your password reset question is:"
	// $gString[81] = "with the answer"
	// $gString[82] = "if you have not requested this account or have done so in error please contact the administrator by email"
	
	$message =<<<MSG
		$gString[79]
		
		$gString[2]: $username
		$gString[3]: $password
MSG;

if($QA_SIGNUP == "TRUE")
{
	$message .=	"\n\n".$gString[80]."\n".
				stripslashes($question)."\n".
				$gString[81]."\n".
				stripslashes($answer)."\n";
}

$message .=	" \n\n".$gString[82]."\n".$admin_email;

	@mail($email, "Account for $THIS_SITE", $message); // don't show fail if fail
	
	//echo "<h1>$email $THIS_SITE <P> $message </h1>";die;
	
	header("Location: $goback?error=$error");
	lib_login_no_browser_redirect("$goback?error=$error");
	die;	
}

// if they have set the $CREATE_SUCCESS_PAGE and the account creation was a success
// then we go to $CREATE_SUCCESS_PAGE. otherwise we go back to the referer!

if(($error == "success") && (strlen($CREATE_SUCCESS_PAGE)>1))
	$goback = $CREATE_SUCCESS_PAGE;
	
	
header("Location: $goback?error=$error");

// opera doesn't do so hot a job on this redirect so we'll show a link..

lib_login_no_browser_redirect("$goback?error=$error");
//ob_end_flush();
die;
?>
