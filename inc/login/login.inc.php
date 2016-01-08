<?php

/*---------------------------------------------------------------------*
** php_lib_login 0-9b - passable security for the lazy                 *
**---------------------------------------------------------------------*/

/* new in 0-9b
 * ^^^^^^^^^^^
 * lib_login_get_gid
 * lib_login_set_gid
 * lib_login_protect_page_group
 * lib_login_protect_page_heirarchy_group
 * lib_login_do_group_change
 * lib_login_show_group_management_form
 * lib_login_get_users_groups_html
 * - group functionality is at the request of (many) specific users
 */

/* new in 0-8-2b
 * ^^^^^^^^^^^^^
 * $QA_SIGNUP
 * lib_login_boolean_check_expire
 * lib_login_boolean_check_valid_lp
 * lib_login_show_uber_change_passwd_form_art
 * lib_login_show_uber_change_passwd_form
 * - most of these changes are specific requests.
 */

/*	new in 0-8-1b
 *	^^^^^^^^^^^^^
 *	this release is a bug fix.
 */

/*---------------------------------------------------------------------*
** 0-9b credits:                                                       *
**---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*
** 0-8-2b credits:                                                     *
** per Inge Mathisen provided a norweigan translation (i will be the   *
** vikings in all my games of freeciv this year by way of thanks) -fm  *
**---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*
** 0-8-1b credits:                                                     *
** Wojciech Kalka & David Mummery found the create-login bug. Leif     *
** Jakob found a big security hole in the adodb library. John Lim,     *
** creator of adodb, plugged it. Navic Wiesbaden provided german lang- *
** uage support. translation credits in languages.inc.php     -fm      *
**---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*
** 0-8b credits:                                                       *
** ryan crumb - pointed out lack of dots-echo.                         *
** per egil kummervold - found all instances of double-slash bug       *
** guigrrrl - talked me out of making a very bad database decision     *
** translation credits in languages.inc.php   -fm                      *
**---------------------------------------------------------------------*/

@include("php_lib_login_includes/adodb/adodb.inc.php");
@include("adodb/adodb.inc.php"); //ugly but prevents user from fiddling with paths

@include("php_lib_login_includes/languages.inc.php");
@include("languages.inc.php");



/*#####################################################################*
**                              START                                  *
**                          CONFIGURATION                              *
**#####################################################################*/

$DATABASE_SOFTWARE  	= "mysql"; 
$DB_LOCATION			= "localhost";
$DB_ACCOUNT				= "root";
$DB_PASSWORD			= "";
$DB_DATABASE 			= 'logindb'; // new in 0-6-xb

$TIMEOUT_IN_SECONDS 	= 600;
$MIN_PASSWORD_LENGTH 	= 5;

$SUCCESS_PAGE			= "http://localhost/login_php_0-9/index.php"; // s/b in http:// format
$FAIL_PAGE				= "http://localhost/login_php_0-9/index.php";
$LOGOUT_PAGE			= "http://localhost/login_php_0-9/index.php";
$TIMEOUT_PAGE			= "http://localhost/login_php_0-9/index.php";
							// you may wish to use the page sample_admin.php found in the 
							// php_lib_login_includes directory for your $SUCCESS_UBER_PAGE
$SUCCESS_UBER_PAGE		= "http://localhost/login_php_0-9/sample_admin.php";
$LIB_LOGIN_BASEDIR		= "php_lib_login_includes";

// new in 0-7-1
$CREATE_SUCCESS_PAGE	= "http://localhost/login_php_0-9/index.php";

// new in 0-8-2 must be "TRUE" or "FALSE"
$QA_SIGNUP				= "FALSE";

$UBER_USER				= "admin"; 	// uber user is account that can
$UBER_PASS				= "puppy";	// create new users

$MY_EMAIL_DOMAIN		= "ihateclowns.com"; // this is only used to prevent
						     				// people from spoofing email.
$ADMIN_EMAIL			= "frymaster@ihateclowns.com";

$PUBLIC_SIGNUP			= "TRUE"; // new in 0-6-xb must be "TRUE" or "FALSE"
$LOG					= "TRUE"; // new in 0-7b

$PUNISH_BAD_ATTEMPTS	= "FALSE"; 	// new in 0-8b - must be "TRUE" or "FALSE"
$BAD_ATTEMPTS_MAX		= 3;		// new in 0-8b
$BAD_ATTEMPTS_WAIT		= 200;		// new in 0-8b - time in seconds

$THIS_SITE				= "localhost";

// new in 0-7-5
$LANGUAGE				= "en"; // only en, fr, no or de supported as of 09-29-01

$HEADER_TAG_OPEN		= "<font face=\"Helvetica\" color=\"#000000\" size=\"6\">";
$HEADER_TAG_CLOSE		= "</font>";
$SUB_HEAD_TAG_OPEN		= "<font face=\"Helvetica\" color=\"#000000\" size=\"4\"><b>";
$SUB_HEAD_TAG_CLOSE		= "</b></font>";
$BODY_TAG_OPEN			= "<font face=\"Helvetica\" color=\"#000000\" size=\"2\">";
$BODY_TAG_CLOSE			= "</font>";

/*#####################################################################*
**                               END                                   *
**                          CONFIGURATION                              *
**                          ^^^^^^^^^^^^^                              *
**    Do _not_ adjust anything below this line unless you are delib-   *
**          erately altering the source for performance or feature     *
**                          modification                               *
**#####################################################################*/

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
**  Fucntion Table of Contents:                                        *
**  ^^^^^^^^^^^^^^^^^^^^^^^^^^^                                        *
**  USER-FUNCTIONALS 
**  lib_login_valid_user
**  lib_login_protect_page
**  lib_login_protect_page_uber
**  lib_login_protect_page_userarray
**  lib_login_protect_page_ip
**  lib_login_check_expire
**  lib_login_boolean_check_expire
**  lib_login_count_online_users
**  lib_login_print_count_online_users
**  lib_login_get_users_html
**  lib_login_list_online_users
**  SHOWERS 
**  lib_login_show_login_form
**  lib_login_show_login_form_art
**  lib_login_show_logout_link_art
**  lib_login_show_logout_link
**  lib_login_return_logout_link
**  lib_login_forgot_password
**  lib_login_forgot_password_art
**  lib_login_show_create_acct_form
**  lib_login_show_create_acct_form_art
**  lib_login_show_create_account_mailback_form
**  lib_login_show_create_account_mailback_form_art
**  lib_login_show_update_pass_form
**  lib_login_show_update_pass_form_art
**  lib_login_show_delete_user_form
**  lib_login_show_delete_user_form_art
**  lib_login_show_log_form
**  lib_login_show_logs
**  lib_login_show_ip_ban_form
**  INTERNAL-FUNCTIONALS 
**  lib_login_do_ip_ban
**  lib_login_get_username_by_session
**  lib_login_log_session
**  lib_login_refresh_timestamp
**  lib_login_update_password
**  lib_login_boolean_check_valid_lp
**  lib_login_check_valid_lp
**  lib_login_write_log
**  lib_login_create_account
**  lib_login_account_exists
**  lib_login_remove_account
**  lib_login_delete_user
**  lib_login_validate_account_data
**  lib_login_nuke_session
**  lib_login_add_banned_ip
**  lib_login_delete_banned_ip
**  lib_login_write_bad_attempt
**  lib_login_clear_bad_attempts
**  lib_login_enact_bad_attempt_punishment
**  lib_login_test_bad_attempt_punishment
**  lib_login_test_bad_attempts
**  lib_login_no_browser_redirect
**  GETTERS 
**  GetReferer
**  lib_login_get_this_site
**  lib_login_get_admin_email
**  lib_login_get_success_page
**  lib_login_whois_uberuser
**  lib_login_protect_signup
**  getgString
**  GENERATORS 
**  lib_login_create_random_passwd
**  lib_login_sanity_check
**  lib_login_db_failure
**  END OF FILE 
**---------------------------------------------------------------------*/

// the above function table of conetents can be generated with
// the following command... ugly but it works.
// cat login.inc.php | grep -e '^function' -e '\/\*\=' | grep -v '\^' | sed -e 's/\/\*\=*//g' | sed -e 's/\=*\*\/$//g' | sed -e 's/^function//g' | cut -d\( -f1 | sed -e 's/^ /**  /g'

/*---------------------------------------------------------------------*
**	welcome hackers:                                                   *
**  1. credit is given to contributors in comment boxes below. however *
**  frymaster can answer any questions about the code base in general  *
**  regardless of the contributor                                      *
**  2. don't try and add any strings you use to languages.inc.php...   *
**  it's a bit messy. i'll take care of it provided you follow         *
**	steps 3 through 5                                                  *
**  3. if possible, build in english. if i can't read your contri-     *
**  bution i'll cry                                                    *
**  4. please comment your changes thoroughly                          *
**  5. please provide a short synopsis of the changes you made or bugs *
**  fixed... it makes doing the documentation much easier              *
**  6. have fun.                                                       *
**---------------------------------------------------------------------*/

/*============================ GLOBAL-STUFF ===========================*/
/*============================ ^^^^^^^^^^^^ ==========================*/

/*---------------------------------------------------------------------*
**  establish a persistant connection and a global session var gUser   *
**    --added j lim 06-10-01                                           *
**---------------------------------------------------------------------*/

$gDB = NewADOConnection($DATABASE_SOFTWARE);
if(!@$gDB->PConnect($DB_LOCATION, $DB_ACCOUNT, $DB_PASSWORD, $DB_DATABASE)) {lib_login_db_failure();}

//$gDB->debug = true; //update
session_register('gUser');
if (empty($gUser)) $gUser = '';


if(empty($gString)) $gString = build_vocab($LANGUAGE, $THIS_SITE);


$LOG_MESSAGE = 	array(	$gString[0], 
						$gString[4], 
						$gString[5],
						$gString[6], 
						$gString[7], 
						$gString[8], 
						$gString[9]);

						
lib_login_sanity_check();
						

/*========================== USER-FUNCTIONALS =========================*/
/*========================== ^^^^^^^^^^^^^^^^ =========================*/

/*---------------------------------------------------------------------*
** lib_login_valid_user                                                *
** returns true if viewing user is logged in, false otherwise.         *
**    --added j lim 06-10-01                                           *
**---------------------------------------------------------------------*/
function lib_login_valid_user()
{
	GLOBAL $gUser;

	return !empty($gUser);
}

/*---------------------------------------------------------------------*
** lib_login_protect_page                                              *
** polls if user is logged in... on fail force a logout                *
**---------------------------------------------------------------------*/
function lib_login_protect_page()
{
	GLOBAL $FAIL_PAGE;
	GLOBAL $TIMEOUT_IN_SECONDS;
	GLOBAL $TIMEOUT_PAGE;
	GLOBAL $gUser;
	GLOBAL $gDB;
	
	$db 	 = $gDB;
	
	if(!lib_login_valid_user())
	{
		header("Location: $FAIL_PAGE");
		lib_login_no_browser_redirect($FAIL_PAGE); 
		die;
	}
		
	$expired = time() - $TIMEOUT_IN_SECONDS;
	
	$sql_check_expiry =<<<SQL
		SELECT	count(*)
		FROM	tbl_users
		WHERE	username = '$gUser'
		AND		lastlogin<$expired;
SQL;

	$result = $db->Execute($sql_check_expiry);
	
	if(!$result->fields[0] < 1) // this index will survive a new ddl
	{
		lib_login_nuke_session(); 	// kill from database
		session_destroy();
		header("Location: $TIMEOUT_PAGE?error=timeout"); 
		lib_login_no_browser_redirect("$TIMEOUT_PAGE?error=timeout");
		die;
	}
	else
	{
		lib_login_refresh_timestamp();
	}
		
	return $gUser;
}

/*---------------------------------------------------------------------*
** lib_login_protect_page_uber                                         *
** protects page so that only uber user can access it.                 *
**---------------------------------------------------------------------*/
function lib_login_protect_page_uber()
{
	GLOBAL	$UBER_USER;
	GLOBAL	$FAIL_PAGE;
	GLOBAL 	$TIMEOUT_IN_SECONDS;
	GLOBAL 	$TIMEOUT_PAGE;
	GLOBAL	$LOG_MESSAGE;
	GLOBAL 	$gUser;
	GLOBAL 	$gDB;
	
	
	$db = $gDB;
	
	if(!($UBER_USER == $gUser))
	{
		lib_login_write_log($LOG_MESSAGE[3], $gUser);
		header("Location: $FAIL_PAGE");
		lib_login_no_browser_redirect($FAIL_PAGE);
		die;
	}
		
	$expired = time() - $TIMEOUT_IN_SECONDS;
	
	$sql_check_expiry =<<<SQL
		SELECT	count(*)
		FROM	tbl_users
		WHERE	username = '$gUser'
		AND		lastlogin<$expired;
SQL;
	
	$result = $db->Execute($sql_check_expiry);
		
	if(!$result->fields[0] < 1)
	{
		lib_login_nuke_session(); 	// kill from database
		session_destroy();
		header("Location: $TIMEOUT_PAGE?error=timeout");
		lib_login_no_browser_redirect("$TIMEOUT_PAGE?error=timeout"); 
		die;
	}
	else
	{
		lib_login_refresh_timestamp();
	}
	
	return lib_login_valid_user(); 
}


/*---------------------------------------------------------------------*
** lib_login_protect_page_userarray                                    *
** accepts an array of usernames. if user viewing protected page is    *
** in said array, page is dispalyed, otherwise, redirect to $FAIL_PAGE *
**---------------------------------------------------------------------*/
function lib_login_protect_page_userarray($userarray)
{
	GLOBAL $FAIL_PAGE;
	GLOBAL $gUser;
	
	while(list(,$user) = each($userarray))
	{
		if($user == $gUser)
			{return lib_login_validate_user();}
	}
	
	header("Location: $FAIL_PAGE");
	lib_login_no_browser_redirect($FAIL_PAGE);
	die; 
}

/*---------------------------------------------------------------------*
** lib_login_protect_page_group                                        *
** accepts a group id (postive integer). if user viewing protected     *
** page is not a member of that group, user is redirected to $FAIL_PAGE*
**---------------------------------------------------------------------*/
function lib_login_protect_page_group($gid)
{
	GLOBAL $FAIL_PAGE;
	GLOBAL $gUser;
	GLOBAL $ADMIN_EMAIL;
	GLOBAL $gDB;
	$db  = $gDB;
	
	// first we must protect page so only logged-in users can view it
	lib_login_protect_page();
	
	// gid must be an integer, we should check that!
	if(!is_int($gid))
	{
		$message = "the page ".__FILE__." on line ".__LINE__." uses the call ".
					"lib_login_protect_page_group() and passes the argument $gid ".
					"this argument is not an integer an is causing the page not to load";
		@mail($ADMIN_EMAIL, "php_lib_login group protection error", $message); // no fail msg.
		echo "error on line ".__LINE__.". gid $gid is not an integer.";
		die;
	}
	
	$sql_group =<<<SQL
		SELECT	*
		FROM	tbl_group
		WHERE	gid='$gid'
		AND		username='$gUser'
SQL;

	$result = $db->Execute($sql_group);
	
	// if no data from the query, there is no user/group combo in tbl_group
	// so give 'em the boot!
	if($result->fields[0]=="")
	{
		header("Location: $FAIL_PAGE");
		lib_login_no_browser_redirect($FAIL_PAGE);
		die;
	}
	
	return $gUser;
}

/*---------------------------------------------------------------------*
** lib_login_protect_page_heirarchy_group                              *
** accepts a group id (postive integer). if user viewing protected     *
** page is not a member of that group or any other group with a group  *
** id higher than $gid, the viewer is bounced to $FAIL_PAGE.           *
**---------------------------------------------------------------------*/
function lib_login_protect_page_heirarchy_group($gid)
{
	GLOBAL $FAIL_PAGE;
	GLOBAL $gUser;
	GLOBAL $ADMIN_EMAIL;
	GLOBAL $gDB;
	$db  = $gDB;
	
	// first we must protect page so only logged-in users can view it
	lib_login_protect_page();
	
	// gid must be an integer, we should check that!
	if(!is_int($gid))
	{
		$message = "the page ".__FILE__." on line ".__LINE__." uses the call ".
					"lib_login_protect_page_group() and passes the argument $gid ".
					"this argument is not an integer an is causing the page not to load";
		@mail($ADMIN_EMAIL, "php_lib_login group protection error", $message); // no fail msg.
		echo "error on line ".__LINE__.". gid $gid is not an integer.";
		die;
	}
	
	$sql_group =<<<SQL
		SELECT	*
		FROM	tbl_group
		WHERE	gid>='$gid'
		AND		username='$gUser'
SQL;

	$result = $db->Execute($sql_group);
	
	// if no data from the query, there is no user/group combo in tbl_group
	// so give 'em the boot!
	if($result->fields[0]=="")
	{
		header("Location: $FAIL_PAGE");
		lib_login_no_browser_redirect($FAIL_PAGE);
		die;
	}
	
	return $gUser;
}

/*---------------------------------------------------------------------*
** lib_login_protect_page_ip                                           *
** protects page from banned ips. checks to see which ips are in tbl_  *
** banned and bounces banned users.                                    *
**---------------------------------------------------------------------*/
function lib_login_protect_page_ip($this_ip)
{
	GLOBAL 	$FAIL_PAGE;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL 	$gDB;
	GLOBAL	$gString;
	$db  = $gDB;
	
	// get the count of all the times this ip is in the banned table
	$result = $db->Execute("SELECT COUNT(*) FROM tbl_banned WHERE ip='$this_ip'");
	
	// if the count is not zero, give the viewer the boot!
	if($result->fields[0] != 0)
	{
		header("Location: $FAIL_PAGE");
		lib_login_no_browser_redirect($FAIL_PAGE);	
		die;
	}
		
	// some browsers don't do redirects well. so we give them a message
	// gStrings[10] = "this ip address has been banned!"
	// gStrings[11] = "continue"
	echo $HEADER_TAG_OPEN . $gString[10] . $HEADER_TAG_CLOSE;
	echo "<br><a href=\"$FAIL_PAGE\">".$gString[11]."</a>";
}

/*---------------------------------------------------------------------* 
** lib_login_check_expire                                              * 
** Check to see if the session have expired. allows for checking for   *
** expiry without having to call a page protector.                     * 
** added Steen Rabøl 08/15/01                                          *
**---------------------------------------------------------------------*/ 
function lib_login_check_expire() 
{ 
	GLOBAL $FAIL_PAGE; 
	GLOBAL $TIMEOUT_IN_SECONDS; 
	GLOBAL $TIMEOUT_PAGE; 
	GLOBAL $gUser; 
	GLOBAL $gDB; 

	$db = $gDB; 

	$expired = time() - $TIMEOUT_IN_SECONDS; 

	$sql_check_expiry =<<<SQL
		SELECT count(*) 
		FROM tbl_users 
		WHERE username = '$gUser' 
		AND lastlogin <$expired
SQL;

	$result = $db-> Execute($sql_check_expiry); 
	
	if(!$result-> fields[0] < 1) // this index will survive a new ddl 
	{ 
		lib_login_nuke_session(); 
		// kill from database 
		session_destroy(); 
		header("Location: $TIMEOUT_PAGE?error=timeout");
		lib_login_no_browser_redirect("$TIMEOUT_PAGE?error=timeout"); 
		die; 
	} 
	else 
	{ 
		lib_login_refresh_timestamp(); 
	} 

	return $gUser; 
}

/*---------------------------------------------------------------------* 
** lib_login_boolean_check_expire                                      * 
** Check to see if the session have expired. returns false if they     *
** have expired and true if the login is still valid. added at the     *
** request of john chow.                                               *
**---------------------------------------------------------------------*/ 
function lib_login_boolean_check_expire() 
{ 
	GLOBAL $FAIL_PAGE; 
	GLOBAL $TIMEOUT_IN_SECONDS; 
	GLOBAL $gUser; 
	GLOBAL $gDB; 

	$db = $gDB; 
	
	// if you aren't logged in, you're expired!
	if(!lib_login_valid_user())
		return false;

	$expired = time() - $TIMEOUT_IN_SECONDS; 

	$sql_check_expiry =<<<SQL
		SELECT count(*) 
		FROM tbl_users 
		WHERE username = '$gUser' 
		AND lastlogin <$expired
SQL;

	$result = $db-> Execute($sql_check_expiry); 
	
	if(!$result-> fields[0] < 1) // this index will survive a new ddl  
		return false;
	else 
		return true; 

	return $gUser; 
}

/*---------------------------------------------------------------------*
** lib_login_count_online_users                                        *
** counts number of users who are in tbl_users with a lastlogin time   *
** recent enough to not be timed out... returns in html format         *
**---------------------------------------------------------------------*/
function lib_login_count_online_users()
{
	//GLOBAL	$SUB_HEAD_TAG_OPEN;  
	//GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL 	$TIMEOUT_IN_SECONDS;
	GLOBAL 	$gDB;
	
	$db 	 = $gDB;
	$expired = time() - $TIMEOUT_IN_SECONDS;

	$sql_count =<<<SQL
		SELECT	COUNT(*)
		FROM	tbl_users where lastlogin>$expired;
SQL;
	
	$result = $db->Execute($sql_count);

	$count	= $result->fields[0]; // this index will survive a new ddl
	
	return $count;
}

/*---------------------------------------------------------------------*
** lib_login_print_count_online_users                                  *
** counts number of users who are in tbl_users with a lastlogin time   *
** recent enough to not be timed out... returns in html format         *
**---------------------------------------------------------------------*/
function lib_login_print_count_online_users()
{
	GLOBAL 	$gString;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL 	$SUB_HEAD_TAG_CLOSE;
	
	$count = lib_login_count_online_users();
	
	if($count == 0)
		{$count_sentence = $gString[12];}
	if($count == 1)
		{$count_sentence = $gString[13];}
	if($count > 1)
		{$count_sentence = $gString[14] . " $count " . $gString[15];}
		
	echo $SUB_HEAD_TAG_OPEN . $count_sentence . $SUB_HEAD_TAG_CLOSE;

}

/*---------------------------------------------------------------------*
** lib_login_get_users_html                                            *
** generates an <option> list of all registered users and returns it   *
** handy for building selects                                          *
**---------------------------------------------------------------------*/
function lib_login_get_users_html()
{
	GLOBAL	$UBER_USER;	
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	
	$sql_all_usernames =<<<SQL13
		SELECT 	username
		FROM	tbl_users
SQL13;

	$result = $db->Execute($sql_all_usernames);
	
	// cook up a string of <options> with all usernames
	// retreived.
	while(!$result->EOF)
	{											// this index will survive new ddl
		if($result->fields[0] != $UBER_USER) 	// don't list UBER_USER
		{
		$option_list .= "<option value=\"" .
						$result->fields[0] . 
						"\">" .
						$result->fields[0] .
						"</option>\n";
		}
		$result->MoveNext();
	}
	
	return $option_list;

}

/*---------------------------------------------------------------------*
** lib_login_get_users_groups_html                                     *
** returns an option delimited list of usernames with thier group ids. *
** this list is suitable for using in a <select> tag and has the form: *
** username (0)                                                        *
** where 0 is the group id.                                            *
**---------------------------------------------------------------------*/
function lib_login_get_users_groups_html($orderby)
{
	GLOBAL	$gString;
	GLOBAL	$gDB;
	$db = $gDB;
	
	if($orderby != "gid")
		$orderby = "username";
	
	$sql_group =<<<SQL
		SELECT		username, gid
		FROM		tbl_group
		ORDER BY	$orderby
SQL;

	$result = $db->execute($sql_group);
	
	// cook up a string of <options> with all usernames
	// retreived.
	while(!$result->EOF)
	{											// this index will survive new ddl
		if($result->fields[0] != $UBER_USER) 	// don't list UBER_USER
		{
		$option_list .= "<option value=\"" .
						$result->fields[0] . 
						"\">" .
						$result->fields[0] . " (" . $result->fields[1] . ")";
						"</option>\n";
		}
		$result->MoveNext();
	}
	
	return $option_list;
}


/*---------------------------------------------------------------------*
** lib_login_list_online_users                                         *
** returns a list of all non-timed-out users who are currently logged  *
** in in <br> delimited html with mailto: tags                         *
**---------------------------------------------------------------------*/
// oops (06-13-01)
// this function will return users with a valid lastlogin whether they
// are logged in or not! ** fixed 06-19-01
function lib_login_list_online_users()
{
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL 	$TIMEOUT_IN_SECONDS;
	GLOBAL 	$gDB;
	$db = 	$gDB;
	$expired = time() - $TIMEOUT_IN_SECONDS;
	
	$sql_list =<<<SQL10
		SELECT	username, email
		FROM	tbl_users 
		WHERE	lastlogin>$expired
SQL10;

	$result = $db->Execute($sql_list);
	
	while(!$result->EOF)
	{
		$html .= 	"<a href=\"mailto:" .
					$result->Fields["email"] . "\">" . 
					$SUB_HEAD_TAG_OPEN .
					$result->Fields["username"] .
					$SUB_HEAD_TAG_CLOSE . "</a><br>\n";
		$result->MoveNext();
	}
	
	return $html;
}


/*============================== SHOWERS ==============================*/
/*============================== ^^^^^^^ ==============================*/

/*---------------------------------------------------------------------*
** lib_login_show_login_form                                           *
** lib_login_show_login_form_art
** displays the login form. lib_login_show_login_form_art is an over-  *
** load that takes a second argument $artpath. $artpath is the path to *
** the gif, png or jpeg that will be used as the submit button.        *
**---------------------------------------------------------------------*/
function lib_login_show_login_form($error)
	{lib_login_show_login_form_art($error, "");}

function lib_login_show_login_form_art($error, $artpath)
{
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$gString;
	
	
	// check and see if user is already logged in.
	// if they are, no need to show the login form so we
	// display "logged in as $username" and return
	
	$username = lib_login_get_username_by_session();
	if($username != "")
	{
		// gStrings[16] = "logged in as" gStrings[1] = "logout"
		print $SUB_HEAD_TAG_OPEN . $gString[16] .  " $username" . $SUB_HEAD_TAG_CLOSE . "<br>";
		lib_login_show_logout_link($gString[1]);
		print "<p>";
		return 1;
	}
	
	// deals with redirect resulting from login error
	// gStrings[17] = "session has timed out"
	// gStrings[18] = "invalid username or password"
	// gStrings[83] = "you have exceeded the maximum number of login attempts..."
	if($error=="timeout")
		{print $SUB_HEAD_TAG_OPEN . $gString[17] . $SUB_HEAD_TAG_CLOSE;}
	if($error=="invalid")
		{print $SUB_HEAD_TAG_OPEN . $gString[18] . $SUB_HEAD_TAG_CLOSE;}
	if($error=="punished")
		{print $SUB_HEAD_TAG_OPEN . $gString[83] . $SUB_HEAD_TAG_CLOSE;}
	
	$form_target = $LIB_LOGIN_BASEDIR . "confirm_login.php";
	// gStrings[2] = "username"
	// gStrings[3] = "password"
	print <<<HTML1
	<form method="POST" action="$form_target">
		$SUB_HEAD_TAG_OPEN $gString[2] $SUB_HEAD_TAG_CLOSE<br>
		<input type="text" name="username" value=""><br><br>
		$SUB_HEAD_TAG_OPEN $gString[3] $SUB_HEAD_TAG_CLOSE<br>
		<input type="password" name="password"><br>
HTML1;
	
	if($artpath == "")
	{
		echo "<input type=\"submit\" name=\"submit\" value=\"submit\"></form>";
	}
	else
	{
		echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";
	}

}

/*---------------------------------------------------------------------*
** lib_login_show_logout_link                                          *
** lib_login_show_logout_link_art                                      *
** shows link to log out. lib_login_show_logout_link_art takes one arg *
** the path to the gif, png or jpeg to show as the logout button.      *
** lib_login_show_logout_link takes a string arg which is the link text*
**---------------------------------------------------------------------*/
function lib_login_show_logout_link_art($artpath)
	{lib_login_show_logout_link("<img src=\"$artpath\" border=\"0\">");}

function lib_login_show_logout_link($linktext)
{	
	GLOBAL $gUser;
	if (! $gUser) return;
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	print "<a href=\"$LIB_LOGIN_BASEDIR"."do_logout.php\">$BODY_TAG_OPEN$linktext$BODY_TAG_CLOSE</a>";
}

/*---------------------------------------------------------------------*
** lib_login_return_logout_link                                        *
** returns the first half of an <a href> tag that links to the logout  *
** function. usage should be something like:                           *
** print lib_login_return_logout_link() . "text or art here" . "</a>"; *
**---------------------------------------------------------------------*/
function lib_login_return_logout_link()
{
	GLOBAL $gUser;
	if (! $gUser) return;
	GLOBAL	$LIB_LOGIN_BASEDIR;
	
	return "<a href=\"$LIB_LOGIN_BASEDIR"."do_logout.php\">";
}

/*--------------------------------------------------------------------*
** lib_login_forgot_password                                          *
** lib_login_forgot_password_art                                      *
** if user's forget their password and have filled in a question/     *
** answer during signup, they can get a new password via email by     *
** answering the question. this function calls it's residing          *
** page 3 times, incrementing  $iteration. first call shows the       *
** "forgot password" href link. second iteration displays form to     * 
** poll user for their login name third iteration retreives the       *
** question with a form to poll for answer. third iteration tests the *
** answer and if true generates a new password and emails it to the   *
** user's logged email. This call reloads its calling page and        *
** substitutes following forms and data in place.                     *
** the art version accepts an extra arg for the path to the gif, png  *
** or jpeg to be used for the submit buttons.
**--------------------------------------------------------------------*/
// better but still clunky...
function lib_login_forgot_password($iteration, $reminduser, $answer)
	{lib_login_forgot_password_art($iteration, $reminduser, $answer, "");}
	
function lib_login_forgot_password_art($iteration, $reminduser, $answer, $artpath)
{
	GLOBAL	$REQUEST_URI;
	GLOBAL 	$THIS_SITE;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL 	$LOG_MESSAGE;
	GLOBAL	$QA_SIGNUP;
	GLOBAL	$gString;
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	// first, if $QA_SIGNUP is false, there are no questions for users to answer, so we
	// should probably not permit the password reminder to run. bail now.
	if($QA_SIGNUP == "FALSE")
		return 1;
	
	$right_here .= $REQUEST_URI; // does this work with IIS ????

	/*
	 * First Iteration ----------------------------------------------
	 */
	if($iteration == "")  //show link to reload
	{
		// the URI may have GET vars on the URL that will cause probs
		// so strip off all data after ? in URL (including ?)
		$right_here	 = explode("?", $right_here);
		$right_here  = $right_here[0];
		
		// gStrings[19] = "forgot your password?"
		print 	"<a href=\"$right_here?iteration=1\">".
				$BODY_TAG_OPEN . $gString[19] . $BODY_TAG_CLOSE ."</a>"; 
		return 1;
	}
	else // only print header if we're _not_ showing the link...
	{
		// gStrings[20] = "password reminder step "
		print $HEADER_TAG_OPEN . $gString[20] . " " . $iteration . $HEADER_TAG_CLOSE . "<br>";
	}
	
	/*
	 * Second Iteration ---------------------------------------------
	 */
	if($iteration == "1")
	{
		// strip GET info off URI
		$right_here = substr($right_here, 0, strpos($right_here, '?'));
		
		// gStrings[21] = "enter your username"
		print <<<HTML
			<form method="POST" action="$right_here?iteration=2">
			$SUB_HEAD_TAG_OPEN $gString[21] $SUB_HEAD_TAG_CLOSE<br>
				<input type="text" name="reminduser"><p>
HTML;
		// deal with the art button vs. form button stuff.
		if($artpath == "")
			{echo "<input type=\"submit\" value=\"submit\" name=\"submit\"></form>";}
		else
			{echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";}
		
		return 1; // arbitrary value
	}
	
	
	/*
	 * Third Iteration ----------------------------------------------
	 */
	if($iteration == "2")
	{
		// Strip GET info off URI
		$right_here = substr($right_here, 0, strpos($right_here, '?'));
		
		// Retreive question for user
		
		$sql_get_question =<<<SQL
			SELECT	*
			FROM	tbl_users
			WHERE	username='$reminduser'
SQL;
		$result = $db->Execute($sql_get_question);
		$question = $result->fields[3]; // this index will NOT survive new ddl
										// WARNING!!
		
		
		// No question entered, bail
		// gStrings[22] = "you did not supply a question when you..."
		if($question == "")
		{	print 	$BODY_TAG_OPEN . 
					$gString[22] . 
					$BODY_TAG_CLOSE;
			return 1;
		}
		
		$url_reminduser = urlencode($reminduser);
		
		// Poll for an answer
		// gString[23] = "question for "
		// gString[24] = "answer"
		print <<<HTML2
			<form method="POST" action="$right_here?iteration=3&reminduser=$url_reminduser">
			$SUB_HEAD_TAG_OPEN
			$gString[23] $reminduser:
			$SUB_HEAD_TAG_CLOSE<br>
			$BODY_TAG_OPEN
			$question 
			$BODY_TAG_CLOSE<p>
			$SUB_HEAD_TAG_OPEN
			$gString[24]
			$SUB_HEAD_TAG_CLOSE<br>
				<input type="text" name="answer"><p>
HTML2;
		if($artpath == "")
			{echo "<input type=\"submit\" value=\"submit\" name=\"submit\"></form>";}
		else
			{echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";}
		
		return 1;
	}
	
	
	/*
	 * Fourth Iteration ----------------------------------------------
	 */
	if($iteration == "3")
	{
		$reminduser = urldecode($reminduser);
		
		// Get answer and email at once
		
		$sql_get_answer_email =<<<SQL2
			SELECT	answer, email
			FROM	tbl_users
			WHERE	username='$reminduser'
SQL2;

		$result = $db->Execute($sql_get_answer_email);
		
		$correct_answer = $result->fields[0];	// easier to remember and
		$user_email		= $result->fields[1];	// works in strings
		
		// gString[25] = "wrong answer"
		// gString[26] = "try again?"
		if($correct_answer != $answer)
		{
			$right_here = substr($right_here, 0, strpos($right_here, '?'));
			print "<br>" . $SUB_HEAD_TAG_OPEN . $gString[25] . $SUB_HEAD_TAG_CLOSE . "<br>";
			print "<a href=\"$right_here?iteration=1\">";
			print $gString[26] . "</a><br>";
		}
		else
		{
			$new_pass = lib_login_create_random_passwd();
			$md5password = md5($new_pass);
			
			$sql_update_password =<<<SQL3
				UPDATE	tbl_users
				SET		password='$md5password'
				WHERE	username='$reminduser'
SQL3;

			
			$result = $db->Execute($sql_update_password);
			
			// gString[27] = "your new password for $THIS_SITE is"
			// gString[28] = "new password for $THIS_SITE"
			// gString[29] = "your new password has been mailed to you"
			if($result)
			{
				$message = $gString[27] . "<p>\n $new_pass";				
				@mail($user_email, $gString[28], $message); // no fail msg.
				lib_login_write_log($LOG_MESSAGE[5], $reminduser);
				print 	$SUB_HEAD_TAG_OPEN .
						"<p>" . $gString[29] . 
						$SUB_HEAD_TAG_CLOSE;
			
			}
			else
			{
				print 	$SUB_HEAD_TAG_OPEN .
						$gString[30] .
						$SUB_HEAD_TAG_CLOSE;
			}
		}
		return 1;
	}
}

/*---------------------------------------------------------------------*
** lib_login_show_create_acct_form                                     *
** lib_login_show_create_acct_form_art                                 *
** shows form to create user account. art version accepts extra arg    *
** as the path to the gif, png or jpeg to be used for the submit button*
**---------------------------------------------------------------------*/
function lib_login_show_create_acct_form($error)
	{lib_login_show_create_acct_form_art($error, "");}
	
function lib_login_show_create_acct_form_art($error, $artpath)
{
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$UBER_USER;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$QA_SIGNUP;
	GLOBAL	$gString;
	
	$error = urldecode($error);
	
	// deal with error or success message from redirect
	// gStrings[31] = "error"
	if(($error != "") && ($error != "success"))
	{
		print 	$SUB_HEAD_TAG_OPEN . $gString[31] . "<p>" . $SUB_HEAD_TAG_CLOSE .
				$SUB_HEAD_TAG_OPEN . $error  . $SUB_HEAD_TAG_CLOSE;
	}
	else if($error == "success")
	{
		// gStrings[78] = "the account has been created"
		print 	$SUB_HEAD_TAG_OPEN . 
				$gString[78] . 
				$SUB_HEAD_TAG_CLOSE;
	}
	
	$form_target = $LIB_LOGIN_BASEDIR . "do_create_login.php";
	//print the form...
	// gStrings[2] = "username"
	// gStrings[3] = "password"
	// gStrings[32] = "repeat password"
	// gStrings[33] = "email"
	// gStrings[34] = explanation of mailback password resetting
	// gStrings[24] = "answer"
	// gStrings[35] = "question"
	print <<<HTML2
		<form method="POST" action="$form_target">
		$SUB_HEAD_TAG_OPEN $gString[2]: $SUB_HEAD_TAG_CLOSE<br>
			<input type="text" name="username"><p>
		$SUB_HEAD_TAG_OPEN $gString[3]: $SUB_HEAD_TAG_CLOSE<br>
			<input type="password" name="password"><p>
		$SUB_HEAD_TAG_OPEN $gString[32]:$SUB_HEAD_TAG_CLOSE<br>
			<input type="password" name="passwordagain"><p>
		$SUB_HEAD_TAG_OPEN $gString[33]:$SUB_HEAD_TAG_CLOSE<br>
			<input type="text" name="email"><p>
HTML2;
	
	// if $QA_SIGNUP is set to true then we want to show fields for 
	// the new user to enter a question and answer.
	if($QA_SIGNUP == "TRUE")
	{
		print <<<HTML3
			$BODY_TAG_OPEN $gString[34] $BODY_TAG_CLOSE<p>
			$SUB_HEAD_TAG_OPEN $gString[35]:$SUB_HEAD_TAG_CLOSE<br>
				<input type="text" name="question"><p>
			$SUB_HEAD_TAG_OPEN $gString[24]:$SUB_HEAD_TAG_CLOSE<br>
				<input type="text" name="answer"><p>
HTML3;
	}

	
	if($artpath == "")
		{echo "<input type=\"submit\" value=\"submit\" name=\"submit\"></form>";}
	else
		{echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";}
		
	return 1;
}

/*---------------------------------------------------------------------*
** lib_login_show_create_account_mailback_form                         *
** lib_login_show_create_account_mailback_form_art                     *
** show the form that creates an account and mails the password to the *
** user-submitted email address. the art version accepts an extra arg  *
** that is the path to the gif, png or jpeg to be used for the submit  *
** button.                                                             *
**---------------------------------------------------------------------*/
function lib_login_show_create_account_mailback_form($error, $email)
	{lib_login_show_create_account_mailback_form_art($error, $email, "");}
	
function lib_login_show_create_account_mailback_form_art($error, $email, $artpath)
{
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$UBER_USER;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$QA_SIGNUP;
	GLOBAL	$gString;
	
	// deal with error or success message from redirect
	// gStrings[31] = "error"
	// gStrings[29] = "your new password has been mailed to you"
	if(($error != "") && ($error != "success"))
		{print $HEADER_TAG_OPEN . $gString[31] . $HEADER_TAG_CLOSE . $SUB_HEAD_TAG_OPEN . $error . $SUB_HEAD_TAG_CLOSE . "\n";}
	else if($error == "success")
		{print $HEADER_TAG_OPEN . $gString[29] . "$HEADER_TAG_CLOSE \n";}
	
	$form_target = $LIB_LOGIN_BASEDIR . "do_create_login.php";
	print <<<HTML3
		<form method="POST" action="$form_target">
		<input type="hidden" name="cache" value="random">
		$SUB_HEAD_TAG_OPEN $gString[2]:$SUB_HEAD_TAG_CLOSE<br>
			<input type="text" name="username"><p>
		$SUB_HEAD_TAG_OPEN $gString[33]:$SUB_HEAD_TAG_CLOSE<br>
			<input type="text" name="email"><p>
HTML3;

	// if $QA_SIGNUP is set to true then we want to show the fields for question and answer
	if($QA_SIGNUP == "TRUE")
	{
		print <<<HTML4
			$BODY_TAG_OPEN $gString[34]: $BODY_TAG_CLOSE <p>
			$SUB_HEAD_TAG_OPEN $gString[35]$SUB_HEAD_TAG_CLOSE<br>
				<input type="text" name="question"><p>
			$SUB_HEAD_TAG_OPEN $gString[24]:$SUB_HEAD_TAG_CLOSE<br>
				<input type="text" name="answer"><p>
HTML4;
	}
			


	if($artpath == "")
		{echo "<input type=\"submit\" value=\"submit\" name=\"submit\"></form>";}
	else
		{echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";}
}

/*---------------------------------------------------------------------*
** lib_login_show_update_pass_form                                     *
** lib_login_show_update_pass_form_art                                 *
** shows form users uses to change password, art version accepts extra *
** arg which is the path to the gif, png or jpeg to use for the submit *
** button.                                                             *
**---------------------------------------------------------------------*/
function lib_login_show_update_pass_form($error)
	{lib_login_show_update_pass_form_art($error, "");}
	
function lib_login_show_update_pass_form_art($error, $artpath)
{
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$LANGUAGE;
	GLOBAL	$gString;
	
	// deal with error or success message from
	// redirect.
	if(($error != "") && ($error != "success"))
	{
		print 	$HEADER_TAG_OPEN . "<br>$gString[31].<br>" . $HEADER_TAG_CLOSE . 
				$BODY_TAG_OPEN . 
				urldecode($error) . "<p>" .
				$BODY_TAG_CLOSE;
	}
	else if ($error == "success")
	{
		print 	$HEADER_TAG_OPEN . "<br>$gString[36].<br>" . $HEADER_TAG_CLOSE .
				$BODY_TAG_OPEN . 
				"$gString[37]<p>" .
				$BODY_TAG_CLOSE;
	}
	
	$form_target = $LIB_LOGIN_BASEDIR . "update_password.php";
	// display the form itself
	// $gString[38] = "new password"
	// $gString[39] = "repeat password"
	print <<<HTML3
		<form method="POST" action="$form_target">
		$SUB_HEAD_TAG_OPEN $gString[38] $SUB_HEAD_TAG_CLOSE<br>
		<input type="password" name="newpassword"><p>
		$SUB_HEAD_TAG_OPEN $gString[39] $SUB_HEAD_TAG_CLOSE<br>
		<input type="password" name="newpasswordagain"><p>
HTML3;
	
	if($artpath == "")
		{echo "<input type=\"submit\" value=\"submit\" name=\"submit\"></form>";}
	else
		{echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";}
		
	return 1; //arbitrary
}


/*---------------------------------------------------------------------*
** lib_login_show_uber_change_passwd_form                              *
** lib_login_show_uber_change_passwd_form_art                          *
** shows a form that allows the uberuser to change the password of an  *
** user. form points to uber_change_password.php which is protected    *
** for the uber user. art version takes a path to the gif, jpg or png  *
** to be used as the submit button
**---------------------------------------------------------------------*/
function lib_login_show_uber_change_passwd_form($error)
	{lib_login_show_uber_change_passwd_form_art($error, "");}

function lib_login_show_uber_change_passwd_form_art($error, $artpath)
{
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$gString;
	
	$option_list = lib_login_get_users_html();
	
	// deal with error or success message from
	// redirect.
	if(($error != "") && ($error !="success"))
	{
		print 	$HEADER_TAG_OPEN . "$gString[31].<br>" . $HEADER_TAG_CLOSE .
				$SUB_HEAD_TAG_OPEN . urldecode($error) . $SUB_HEAD_TAG_CLOSE .
				"<p>";
	}
	else if($error == "success")
	{
		// gStrings[40] = "the user has been deleted"
		print 	$HEADER_TAG_OPEN . "success<br>" . $HEADER_TAG_CLOSE .
				$SUB_HEAD_TAG_OPEN . "the password has been updated" . $SUB_HEAD_TAG_CLOSE .
				"<p>";
	}
	
	$form_target = $LIB_LOGIN_BASEDIR . "uber_change_password.php";
	
	print <<<HTML4
		<form method="POST" action="$form_target">
		$SUB_HEAD_TAG_OPEN change password:$SUB_HEAD_TAG_CLOSE<p>
		<select name="username">
			<option>
			$option_list
		</select>
		<br>
		<input type="password" name="newpassword">
		<p>
HTML4;

	if($artpath == "")
		{echo "<input type=\"submit\" value=\"submit\" name=\"submit\"></form>";}
	else
		{echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";}
}

/*---------------------------------------------------------------------*
** lib_login_show_delete_user_form                                     *
** lib_login_show_delete_user_form_art                                 *
** shows form to delete user account. art version takes an extra arg   *
** which is the path to the gif, png, jpeg to be used for the submit   *
** button                                                              *
**---------------------------------------------------------------------*/
function lib_login_show_delete_user_form($error)
	{lib_login_show_delete_user_form_art($error, "");}
	
function lib_login_show_delete_user_form_art($error, $artpath)
{
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$gString;
	
	$option_list = lib_login_get_users_html();
	
	// deal with error or success message from
	// redirect.
	if(($error != "") && ($error !="success"))
	{
		print 	$HEADER_TAG_OPEN . "$gString[31]." . $HEADER_TAG_CLOSE .
				$SUB_HEAD_TAG_OPEN . urldecode($error) . $SUB_HEAD_TAG_CLOSE .
				"<p>";
	}
	else if($error == "success")
	{
		// gStrings[40] = "the user has been deleted"
		print 	$HEADER_TAG_OPEN . "$gString[36]." . $HEADER_TAG_CLOSE .
				$SUB_HEAD_TAG_OPEN . "$gString[36]" . $SUB_HEAD_TAG_CLOSE .
				"<p>";
	}
	
	$form_target = $LIB_LOGIN_BASEDIR . "delete_user.php";
	// $gString[41] = "delete user:"
	print <<<HTML4
		<form method="POST" action="$form_target">
		$SUB_HEAD_TAG_OPEN $gString[41]:$SUB_HEAD_TAG_CLOSE<p>
		<select name="delusername">
			<option>
			$option_list
		</select>
		<p>
HTML4;
	
	if($artpath == "")
		{echo "<input type=\"submit\" value=\"submit\" name=\"submit\"></form>";}
	else
		{echo "<input type=\"image\" src=\"$artpath\" border=\"0\" name=\"submit\"></form>";}
	
}

/*---------------------------------------------------------------------*
** lib_login_show_log_form                                             *
** shows the form that the uber user uses to display the log info.     *
** this function is by default protected for the uberuser.             *
**---------------------------------------------------------------------*/
function lib_login_show_log_form()
{
	GLOBAL	$UBER_USER;
	GLOBAL	$gUser;
	GLOBAL	$gDB;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$gString;
	GLOBAL	$LIB_LOGIN_BASEDIR;
	$db = 	$gDB;

	// bail if not uber user
	if($gUser != $UBER_USER)
		return 0; // arbitrary
	
	$form_target = $LIB_LOGIN_BASEDIR . "show_logs.php";
	// print the form
	// $gString[42] = "show logs for:"
	// $gString[43] = "today"
	// $gString[44] = "yesterday"
	// $gString[45] = "last"
	print <<<FORM
		<form method="POST" action="$form_target">
		<table border="0">
		<tr>
			<td colspan="2">$SUB_HEAD_TAG_OPEN $gString[42] $SUB_HEAD_TAG_CLOSE</td>
		</tr><tr>
			<td><input type="radio" name="viewdates" value="today"></td>
			<td>$BODY_TAG_OPEN $gString[43] $BODY_TAG_CLOSE</td>
		</tr><tr>
			<td><input type="radio" name="viewdates" value="yesterday"></td>
			<td>$BODY_TAG_OPEN $gString[44] $BODY_TAG_CLOSE</td>
		</tr><tr>
			<td><input type="radio" name="viewdates" value="range"></td>
			<td>
				$BODY_TAG_OPEN $gString[45] $BODY_TAG_CLOSE
				<input type="text" size="3" name="daterange"> 
			</td>
		</tr><tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" name="submit" value="submit"></td>
		</tr>
		</table>
		</form>
FORM;

}

/*---------------------------------------------------------------------*
** lib_login_show_logs                                                 *
** displays in html format the logs for the dates specified in         *
** viewdates (either "today", "yesterday" or x days ago), ordered by   *
** the field $orderby.                                                 *
**---------------------------------------------------------------------*/
function lib_login_show_logs($viewdates, $daterange, $orderby, $bannedip)
{
	GLOBAL	$gUser;
	GLOBAL	$gDB;
	GLOBAL	$HTTP_HOST;
	GLOBAL	$REQUEST_URI;
	GLOBAL	$gString;
	GLOBAL	$SUCCESS_UBER_PAGE;
	$db = $gDB;
	
	// must order the log by something, timestamp by default
	if(!isset($orderby))
		$orderby = "timestamp";
	
	// when user clicks on ban button, ip to ban is passed here on reload.
	// lets call lib_login_add_banned_ip to ban the ip
	if($bannedip != "")
		lib_login_add_banned_ip($bannedip);
	
	// if the user doesn't select a date range to view we set to "today"
	// $gString[46] = "warning"
	// $gString[47] = "no days selected for viewing, defaulting to today"
	if(!isset($viewdates))
	{
		$viewdates = "today";
		echo "<b>$gString[46]</b>$gString[47]<p>";
	}
	
	// this is the latest timestamp we will retreive logs for
	$rightnow = time(); 

	// this is an array of units (ie month, day, year, hour...) for right now
	$today_array = getdate($rightnow);

	/* these are the timestamps we need.
	 *		$today_mn_timestamp			-> a timestamp for today at midnight
	 *		$yesterday_mn_timestamp		-> a timestamp for yesterday at midnight
	 *		$startday_mn_timestamp		-> a timestamp for x days ago at midnight where x is the 
	 *										variable $daterange passed by the form
	 */
	$today_mn_timestamp = mktime(0, 0, 0, $today_array['mon'], $today_array['mday'], $today_array['year']);
	$yesterday_mn_timestamp = mktime(0, 0, 0, $today_array['mon'], ($today_array['mday']-1), $today_array['year']);
	$startday_mn_timestamp = $today_mn_timestamp - (86400 * $daterange); 


	// today: select all data from midnight today and right now
	if($viewdates == "today")
	{
		$get_log_sql =<<<SQL1
			SELECT *
			FROM	tbl_log
			WHERE	timestamp < '$rightnow'
			AND		timestamp > '$today_mn_timestamp'
			ORDER BY '$orderby'
SQL1;
	echo "<h3>log of activity from " .
		date("M d Y H:i:s",$today_mn_timestamp) .
		" to " .
		date("M d Y H:i:s",$rightnow) .
		"</h3>";
	}
	
	// $gString[48] = "go back"
	echo "<br><center><a href=\"$SUCCESS_UBER_PAGE\">$gString[48]</a></center><br>";

	// yesterday: select everything from midnight yesterday and midnight today
	if($viewdates == "yesterday")
	{
			$get_log_sql =<<<SQL2
			SELECT *
			FROM	tbl_log
			WHERE	timestamp < '$today_mn_timestamp'
			AND		timestamp > '$yesterday_mn_timestamp'
			ORDER BY '$orderby'
SQL2;
	echo "<h3>log of activity from " .
		date("M d Y H:i:s",$yesterday_mn_timestamp) .
		" to " .
		date("M d Y H:i:s",$today_mn_timestamp) .
		"</h3>";
	}

	// range: select everything from midnight x days ago and right now.
	if($viewdates == "range")
	{
			$get_log_sql =<<<SQL3
			SELECT *
			FROM	tbl_log
			WHERE	timestamp < '$rightnow'
			AND		timestamp > '$startday_mn_timestamp'
			ORDER BY '$orderby'
SQL3;
	echo "<h3>log of activity from " .
		date("M d Y H:i:s",$startday_mn_timestamp) .
		" to " .
		date("M d Y H:i:s",$rightnow) .
		"</h3>";
	}
	
	$result = $db->Execute($get_log_sql);
	
	// we need the url of the viewing page so we can call it with the new
	// $orderby on the GET line... this is done so users can reorder the listing
	// by clicking on the column name they want to reorder by
	$url = sprintf("%s%s%s","http://",$HTTP_HOST,$REQUEST_URI);

	// Strip GET info off $url to avoid annoying double ? urls
	if(strpos($url, '?') > 0)
		$url = substr($url, 0, strpos($url, '?'));
	
	// print out the header with links on each column name to re-order the data by that column
	// $gString[49] = "timestamp"
	// $gString[50] = "ip address"
	// $gString[2] = "username"
	// $gString[51] = "message"
	// $gString[52] = "ban this ip"
	print <<<HTML
		<table width="100%" align="left" border="2">
		<tr>
			<td align="center"><b>
				<a href="$url?orderby=timestamp&viewdates=$viewdates&daterange=$daterange">
					$gString[49]
				</a>
			</b></td>
			<td align="center"><b>
				<a href="$url?orderby=ip&viewdates=$viewdates&daterange=$daterange">
					$gString[50]
				</a>
			</b></td>
			<td align="center"><b>
				<a href="$url?orderby=username&viewdates=$viewdates&daterange=$daterange">
					$gString[2]
				</a>
			</b></td>
			<td align="center"><b>
				<a href="$url?orderby=action&viewdates=$viewdates&daterange=$daterange">
					$gString[51]
				</a>
			</b></td>
			<td align="center"><b>
					$gString[52]
				</a>
			</b></td>
		</tr>
HTML;
	
	
	// loop through all our data and format it
	while(!$result->EOF)
	{
		$the_date = date("M d Y H:i:s", $result->fields[0]);
		
		if($result->fields[1] == "")
		{
			$ip = "not logged";
			$ipban = "";
		}
		else
		{
			$ip = $result->fields[1];
			$ipban = "bannedip=$ip";
		}
			
		if($result->fields[2] == "")
			$username = "not logged";
		else
			$username = $result->fields[2];
			
		if($result->fields[3] == "")
			$message = "not logged";
		else
			$message = $result->fields[3];
			
		print "<tr>\n";
		print "<td align=\"left\"><b>" . $the_date . "</b></td>\n";
		print "<td align=\"left\"><b>" . $ip . "</b></td>\n";
		print "<td align=\"left\"><b>" . $username . "</b></td>\n";
		print "<td align=\"left\"><b>" . $message . "</b></td>\n";
		print "<td align=\"left\"><b>" . 
		"<a href=\"$url?$ipban&orderby=action&viewdates=$viewdates&daterange=$daterange\">" . 
		"ban</a></b></td>\n";
		print "</tr>\n";
		$result->MoveNext();
	}
	
	echo "</table>"; // close our table.
	
}


/*---------------------------------------------------------------------*
** lib_login_show_ip_ban_form                                          *
** shows the form used to ban and unban ips                            *
**---------------------------------------------------------------------*/
function lib_login_show_ip_ban_form($error)
{
	GLOBAL	$gUser;
	GLOBAL	$gDB;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$gString;
	$db = $gDB;
	
	// we may have an error message.. we should display that:
	if(isset($error))
		echo $SUB_HEAD_TAG_OPEN . urldecode($error) . $HEADER_TAG_CLOSE. "<br>";
	
	// get a list of all unbanned ips in option tags
	$sql_unbanned =<<<SQL
		SELECT	distinct(ip)
		FROM	tbl_log
SQL;

	// get list of all banned ips in option tags
	$sql_banned =<<<SQL2
		SELECT 	distinct(ip)
		FROM	tbl_banned
SQL2;


	$result  = $db->Execute($sql_unbanned);
	$result2 = $db->Execute($sql_banned);
	
	// cook up the list of ips that are in the log and are not already
	// banned and put them in <option> tags. this is not the easiest
	// way to do this but it allows for the most neutral sql... which
	// is important for database neutrality.
	while(!$result->EOF)
	{
		// remove ips that are in banned
		while(!$result2->EOF)
		{
			if($result2->fields[0] == $result->fields[0])
				$removeflag = 1;
				
			$result2->MoveNext();
		}
		
		if(($removeflag == 0) && ($result->fields[0] != ""))
			$unbanned_opts .= 	"<option value=\"".$result->fields[0]."\">" .
								$result->fields[0] . "</option>";
		$result->MoveNext();
		$result2->MoveFirst();
		$removeflag = 0;
	}
	
	// cook up a list of ips that are banned. in option tags.
	while(!$result2->EOF)
	{
		$banned_opts .= 	"<option value=\"".$result2->fields[0]."\">" .
							$result2->fields[0] . "</option>";
		$result2->MoveNext();
	}
	
	// $gString[53] = "ip banning"
	// $gString[54] = "logged ips"
	// $gString[55] = "banned ips"
	// $gString[55] = "ban"
	// $gString[55] = "unban"
	print <<<FORM
	<form action="php_lib_login_includes/do_ip_ban.php" method="POST">
		<table>
			<tr>
				<td colspan="3" align="center">
				$HEADER_TAG_OPEN
					$gString[53]:
				$HEADER_TAG_CLOSE
				</td>
			</tr>
			<tr>
				<td>$SUB_HEAD_TAG_OPEN $gString[54] $SUB_HEAD_TAG_CLOSE</td>
				<td></td>
				<td>$SUB_HEAD_TAG_OPEN $gString[55] $SUB_HEAD_TAG_CLOSE</td>
			</tr>
			<tr>
				<td align="left" valign="top">
					<select name=unbannedips[] multiple size=9>
						$unbanned_opts
					</select>
					<br>
				</td>
				<td align="center">
					<input type="submit" value="$gString[56] &gt;&gt;" name="submitban">
					<p>
					<input type="submit" value="&lt;&lt; $gString[57]" name="submitunban">
				</td>
				<td align="right" valign="top">
					<select name=bannedips[] multiple size=9>
						$banned_opts
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				$SUB_HEAD_TAG_OPEN
					$gString[58]
				$SUB_HEAD_TAG_CLOSE
				<br>
				<input type="text" name="ip_to_ban" value="" size="15">
				</td>
				<td>
				</td>
			</tr>
		</table>
	</form>
FORM;
}

/*---------------------------------------------------------------------*
** lib_login_show_group_management_form                                *
** displays the form used by the admin to change the group ids for any *
** given user or users                                                 *
**---------------------------------------------------------------------*/
function lib_login_show_group_management_form($giderror)
{
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$gString;
	

	echo $SUB_HEAD_TAG_OPEN . urldecode($giderror) . $SUB_HEAD_TAG_CLOSE . "<p>";
	
	// get an <option> delimited list of all users and their group id	
	$option_list = lib_login_get_users_groups_html("gid");
	
	// $gString[84] = "group management"
	// $gString[85] = "new group id"
	print <<<FORM
	$SUB_HEAD_TAG_OPEN $gString[84] $SUB_HEAD_TAG_CLOSE <p>
	<form method="POST" action="php_lib_login_includes/do_update_group.php">
		<select name=usernames[] multiple size=9>
		$option_list
		</select>
		<br><br>
		$BODY_TAG_OPEN <b> $gString[85] </b> $BODY_TAG_CLOSE
		<input type="text" name="newgid" value="0" size="3"><br><br>
		<input name="submit" value="sumit" type="submit">
	</form>
	<br>
FORM;

}


/*======================== INTERNAL-FUNCTIONALS =======================*/
/*======================== ^^^^^^^^^^^^^^^^^^^^ =======================*/

/*---------------------------------------------------------------------*
** lib_login_do_group_change                                           *
** accepts an array of usernames and a group id which is a positive    *
** integer. updates tbl_group so that all users in the array of user-  *
** names have the gid of $gid. this function should be only called by  *
** do_update_group.php                                                 *
**---------------------------------------------------------------------*/
function lib_login_do_group_change($users, $gid)
{
	GLOBAL	$gUser;
	GLOBAL	$gDB;
	GLOBAL	$gString;
	$db = $gDB;
	
	// gid must be an int so return an error if it isn't
	// $gString[86] = "gid must be an integer"
	for($i=0;$i<strlen($gid);$i++)
		if(strpos("0123456789", $gid[$i])=="")
			return $gString[86];
	
	// loop through each of the usernames in the $users array
	// build an update sql and execute it. if an error ocurrs then
	// add that username to the $usererrors array for error reporting
	for($i=0;$i<count($users);$i++)
	{
		$thisuser = $users[$i];
		
		$sql_group =<<<SQL
			UPDATE	tbl_group
			SET		gid='$gid'
			WHERE	username='$thisuser'
SQL;
		$result = $db->execute($sql_group);
		
		if(!$result)
			$usererrors.= " ".$thisuser;
	}
	
	// return either success or the "error" plus the list of usernames that errored.
	if(count($usererrors)==0)
		return "success";
	else
		return $gString[31].$usererrors;
	
}

function lib_login_do_ip_ban($submitban, $submitunban, $unbannedips, $bannedips, $ip_to_ban)
{
	GLOBAL	$gUser;
	GLOBAL	$gDB;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$gString;
	$db = $gDB;
	
	// build our return url
	$goback = GetReferer();
	if(strpos($goback, '?')>0)
		$goback = substr($goback, 0, strpos($goback, '?'));
	
	// first we insert the ip entered manually. if the ban button is hit
	// and there is an ip_to_ban we insert it.
	if(isset($submitban) && isset($ip_to_ban))
		$db->Execute("INSERT INTO tbl_banned (ip) VALUES ('".$ip_to_ban."')");
	
	// do our ban/unban. we have received two submit buttons and two
	// arrays from multiple selects. if the banned button is set run a
	// set of inserts from the unbannedips array. if the unban button
	// is set run a set of deletes from the bannedips array. if 
	// neither are set, modify goback to have an error on the get line.
	if(isset($submitban) && isset($unbannedips))
		while(list(,$ip) = each($unbannedips))
			$db->Execute("INSERT INTO tbl_banned (ip) VALUES ('".$ip."')");
	
	else if(isset($submitunban) && isset($bannedips))
			while(list(,$ip) = each($bannedips))
				$db->Execute("DELETE FROM tbl_banned WHERE ip='".$ip."';");	
	else
		$goback = $goback . "?error=" . 
		urlencode($gString[59]);
	// $gString[59] = "no ips selected"
	
	// go back to the page that called show_ip_ban_form()
	header("Location: $goback"); 
	lib_login_no_browser_redirect($goback);
}

/*---------------------------------------------------------------------*
** lib_login_get_username_by_session                                   *
** returns the gUser var... a global of username if user logged in     *
**---------------------------------------------------------------------*/
function lib_login_get_username_by_session()
{
	GLOBAL $gUser;
		return $gUser;
}

/*---------------------------------------------------------------------*
** lib_login_get_gid                                                   *
** returns the group id number of the current viewing user. if the     *
** current user is not in tbl_group then s/he automatically has a gid  *
** of zero.                                                            *
**---------------------------------------------------------------------*/
function lib_login_get_gid()
{
	GLOBAL 	$gDB;
	GLOBAL 	$gUser;
	$db = 	$gDB;
	
	$sql_gid =<<<SQL
		SELECT	gid
		FROM	tbl_group
		WHERE	username='$gUser'
SQL;

	$result = $db->Execute($sql_gid);
	
	if($result->fields[0] == "")
		return 0;
	else
		return $result->fields[0];
}

/*---------------------------------------------------------------------*
** lib_login_set_gid                                                   *
** sets the gid of the current user to $gid                            *
**---------------------------------------------------------------------*/
function lib_login_set_gid($gid)
{
	GLOBAL 	$gDB;
	GLOBAL 	$gUser;
	$db = 	$gDB;
	
	// zero is default gid, so no sense running the setter if $gid is 0
	if($gid==0)
		return 0;
	
	// rather than messing with deciding to insert or update, we'll just
	// delete then insert.	
	$sql_delete =<<<SQL
		DELETE
		FROM	tbl_group
		WHERE	username='$gUser'
SQL;
	
	$sql_insert =<<<SQL2
		INSERT
		INTO	tbl_group
				(username, gid)
		VALUES	('$gUser', '$gid')
SQL2;

				$db->execute($sql_delete);
	$result =	$db->execute($sql_insert);
	
	if($result)
		return true;
	else
		return false;
}

/*---------------------------------------------------------------------*
** lib_login_log_session                                               *
** updates lastlogin so that user is now considered logged in          *
**---------------------------------------------------------------------*/
function lib_login_log_session($username)
{
	GLOBAL 	$TIMEOUT_IN_SECONDS;
	GLOBAL 	$gDB;
	GLOBAL 	$gUser;
	$db = 	$gDB;
	
	$timestamp = time();
	$expired = $timestamp - $TIMEOUT_IN_SECONDS;
	
	$sql_update_session =<<<SQL2
		UPDATE tbl_users set lastlogin=$timestamp
		WHERE	username='$username'
SQL2;

	$db->Execute($sql_update_session);
	$gUser = $username;
}

/*---------------------------------------------------------------------*
** lib_login_refresh_timestamp                                         *
** updates lastlogin to current time thus refreshing the "idle time"   *
** timer and preventing timeouts as long as the user is loading        *
** protected pages or pages calling this function. called by all       *
** page protecting functions.                                          *
** -added frymaster 06-16-01
**---------------------------------------------------------------------*/
function lib_login_refresh_timestamp()
{
	GLOBAL	$gUser;
	GLOBAL	$gDB;
	$db = 	$gDB;
	
	$timestamp = time();
	
	$sql_refresh_timestamp =<<<SQL
		UPDATE 	tbl_users
		SET		lastlogin=$timestamp
		WHERE	username='$gUser'
SQL;

	$db->Execute($sql_refresh_timestamp);
}

/*---------------------------------------------------------------------*
** lib_login_update_password                                           *
** accepts a password twice (for validation checking) and updates the  *
** current users password in tbl_users                                 *
**---------------------------------------------------------------------*/
function lib_login_update_password($newpassword, $newpasswordagain)
{
	GLOBAL	$LIB_LOGIN_BASEDIR;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$LOGOUT_PAGE;
	GLOBAL	$LOG_MESSAGE;
	GLOBAL	$MIN_PASSWORD_LENGTH;
	GLOBAL	$gUser;
	GLOBAL 	$gDB;
	GLOBAL	$gString;
	$db = 	$gDB;
	
	$goback = GetReferer();

	if(strpos($goback, '?') != "")
		$goback = substr($goback, 0, strpos($goback, '?'));
	
	$md5password	= md5($newpassword);
	
	// $gString[60] = "passwords do not match"
	if($newpassword != $newpasswordagain)
	{
		header ("Location: $goback?error=" . 
				urlencode($gString[60]));
		lib_login_no_browser_redirect("$goback?error=".urlencode($gString[60]));
		die;
	}
	
	// $gString[61] = "password too short"	
	if(strlen($newpassword)<$MIN_PASSWORD_LENGTH)
	{
		header ("Location: $goback?error=" . 
				urlencode($gString[61]));
		lib_login_no_browser_redirect("$goback?error=".urlencode($gString[61]));
		die;
	}
	
	// $gString[62] = "password same as username"
	if($newpassword == $gUser)
	{
		header ("Location: $goback?error=" . 
				urlencode($gString[62]));
		lib_login_no_browser_redirect("$goback?error=".urlencode($gString[62]));
		die;
	}
	
	
	$sql_update_pass =<<<SQL9
		UPDATE	tbl_users
		SET	password='$md5password'
		WHERE	username='$gUser'
SQL9;

	$result = $db->Execute($sql_update_pass);	
	
	// return to calling page with error either success
	// or fail message.
	if($result)
	{
		lib_login_write_log($LOG_MESSAGE[4], $username);
		header ("Location: $goback?error=success");
		lib_login_no_browser_redirect("$goback?error=success");
		die;
	}
	else
	{
		// $gString[63] = "failed updating password"
		header ("Location: $goback?error=" . 
				urlencode($gString[63]));
		lib_login_no_browser_redirect("$goback?error=".urlencode($gString[63]));
		die;
	}
}

/*---------------------------------------------------------------------*
** lib_login_boolean_check_valid_lp                                    *
** accepts a username/password combo and checks to see if it is in the *
** table of users. returns true if it is, false if it is not. added at *
** the request of john chow.
**---------------------------------------------------------------------*/
function lib_login_boolean_check_valid_lp($username, $password)
{
	$username = trim("$username");
	$password = trim("$password");
	
	$password = md5($password); //store encrypted passwords only
	
	$sql_valid_lp_test =<<<SQL
		SELECT 	* 
		FROM 	tbl_users 
		WHERE 	username='$username' 
		AND 	password='$password'
SQL;

	$result  = $db->Execute($sql_valid_lp_test);
	
	if($result->EOF)
		return false;
	else
		return true;
}

/*---------------------------------------------------------------------*
** lib_login_check_valid_lp                                            *
** accepts a username and password, confirms their validity. redirects *
** on failure with $error set to nature of error                       *
**---------------------------------------------------------------------*/
// added bad attempt punishment 0-8
function lib_login_check_valid_lp($username, $password)
{
	GLOBAL	$UBER_USER;
	GLOBAL	$UBER_PASS;
	GLOBAL 	$ADMIN_EMAIL;
	GLOBAL	$LOG_MESSAGE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$PUNISH_BAD_ATTEMPTS;
	GLOBAL	$BAD_ATTEMPTS_MAX;
	GLOBAL 	$gDB;
	$db = $gDB;
	/*----------------------------------*
	** uberuser account starts with     *
	** $UBER_PASS as a password. when   *
	** that combo is called we test to  *
	** see if an account for it already *
	** exists. if not, we make one.     *
	** otherwise we pass on to the rest *
	** of the function...               *
	**----------------------------------*/
	
	// this is not as insecure as it looks...
	if (($username == $UBER_USER) && 
		($password == $UBER_PASS) && 
		!lib_login_account_exists($UBER_USER))
	{
		$foo = lib_login_create_account($UBER_USER, $UBER_PASS, $UBER_PASS, $ADMIN_EMAIL, "", "");
		if($foo != "success")
		{	
			// $gString[64] = "a serious error has ocurred in creating the uber user account"
			// $gString[65] = "php_lib_login was unable to create the uber user account with 
			//                "the data given. the following exception has been thrown:"
			// $gString[66] = "please consult your configuration and try again. this system 
			//                is completely insecure"
			echo "$HEADER_TAG_OPEN $gString[64] $HEADER_TAG_CLOSE";
			echo "$HEADER_TAG_OPEN $gString[65]:<p> <b>$foo</b><p>";
			echo $gString[66] . $HEADER_TAG_CLOSE;
		}
		return $UBER_USER;
	}
	
	
	$username = trim("$username");
	$password = trim("$password");
	
	$password = md5($password); //store encrypted passwords only
		
	// this the link back to the login page...
	// strip GET off of URL
	$login_page = GetReferer(); // oops... maybe referer not login page...
	$login_page = explode("?", $login_page);
	$login_page = $login_page[0];
	
	// first we should check to see if the user is on punishment time. if they are, they
	// are not allowed to login and should be bounced. if they aren't we should check and
	// see if they should be put on punishment time because they have exceeded their max
	// failed login attempts and punish them if necessary.
	if($PUNISH_BAD_ATTEMPTS == "TRUE" && $username != $UBER_USER)
	{
		if(lib_login_test_bad_attempt_punishment($username))
		{
			header("Location: $login_page?error=punished");
			lib_login_no_browser_redirect("$login_page?error=punished");
			die;
		}
		if(lib_login_test_bad_attempts($username))
			lib_login_enact_bad_attempt_punishment($username);
		
		
	}
	
	$sql_valid_lp_test =<<<SQL
		SELECT 	* 
		FROM 	tbl_users 
		WHERE 	username='$username' 
		AND 	password='$password'
SQL;
	/*----------------------------------*
	** test for valid l/p               *
	**----------------------------------*/
	$result  = $db->Execute($sql_valid_lp_test);
	

	// if the field is NULL, no rows were returned and,
	// therefor the l/p is wrong so we redirect to the login page

	if($result->EOF)
	{
		
		
		if($username == $UBER_USER)
			lib_login_write_log($LOG_MESSAGE[2], $username);
		else
			lib_login_write_log($LOG_MESSAGE[1], $username);
		
		
		// if we have set a max on bad login attempts then we should log
		// this bad attempt!
		if($PUNISH_BAD_ATTEMPTS == "TRUE" && $username != $UBER_USER)
			{lib_login_write_bad_attempt($username);}
		
		header("Location: $login_page?error=invalid");
		lib_login_no_browser_redirect("$login_page?error=invalid");
		die; // don't let the rest of the code run if login fails!!
	}
	
	// a successful login - clear the bad attempts, write the log, return the username
	if($PUNISH_BAD_ATTEMPTS == "TRUE")
			{lib_login_clear_bad_attempts($username);}
			
	lib_login_write_log($LOG_MESSAGE[0], $username);
	return ($result->Fields["username"]);
}

/*---------------------------------------------------------------------*
** lib_login_write_log                                                 *
** certain actions will be logged if $LOG is set to "TRUE". this fun-  *
** ction accepts an array of log messages and a username. note that    *
** the username is usually passed as null and the username of the the  *
** currently logged in user is used. explicit passing of a username is *
** only done when loggin in failures. the action is passed as an       *
** element of the global array $LOG_MESSAGES. the array is defined as  *
** 		login					0                                      *
** 		FAILED LOGIN			1                                      *
**		FAILED LOGIN UBER		2                                      *
**   	UBER USER VIOLATION		3                                      *
** 		change password			4                                      *
** 		mailback password		5                                      *
** 		create account			6                                      *
**---------------------------------------------------------------------*/
function lib_login_write_log($action, $username)
{	
	GLOBAL	$gUser;
	GLOBAL	$LOG;
	GLOBAL 	$gDB;
	$db = $gDB;
	
	// if no logging, return
	if($LOG != "TRUE")
		return 0; // arbitrary
	
	// if passed username is null, user current logged in user
	if($username == "")
		$username = $gUser;
	
	$ip = getenv('REMOTE_ADDR');
		
	$rightnow = time();
	
	$sql_log =<<<SQL
		INSERT 
		INTO 	tbl_log 
				(timestamp, ip, username, action)
		VALUES	('$rightnow', '$ip', '$username', '$action')
SQL;
	
	
	$db->Execute($sql_log);
	
	return 1; // arbitrary
}

/*---------------------------------------------------------------------*
** lib_login_create_account                                            *
** takes name, password, email, question and answer and makes an acct  *
** of it.                                                              *
**---------------------------------------------------------------------*/
function lib_login_create_account(	$username, 
									$password, 
									$passwordagain,
									$email,
									$question,
									$answer)
{
	GLOBAL	$MIN_PASSWORD_LENGTH;
	GLOBAL 	$MY_EMAIL_DOMAIN;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$LOG_MESSAGE;
	GLOBAL	$LOG;
	GLOBAL 	$gDB;
	GLOBAL  $gString;
	$db = $gDB;
	
	// $gString[67] = "is already taken"
	if(lib_login_account_exists($username))
		{return "$username  $gString[67]"; die;}
	
	/*----------------------------------*
	** end users cannot be trusted to   *
	** choose appropriate passwords!    *
	**----------------------------------*/
	
	$returnval = lib_login_validate_account_data($username, 
												 $password, 
												 $passwordagain, 
												 $email);
	if(isset($returnval))
		{return $returnval; die;}
	
	/*----------------------------------*
	** md5 hash here means we don't have*
	** to store a plaintext password on *
	** the system...                    *
	**----------------------------------*/
	$md5password = md5($password);
	
	/*----------------------------------*
	** insert the l/p and return NULL   *
	**----------------------------------*/
	$sql_insert_lp =<<<SQL5
		INSERT
		INTO	tbl_users
				(username, 
				 password,
				 email,
				 question,
				 answer)
		VALUES 	('$username', 
				 '$md5password',
				 '$email',
				 '$question',
				 '$answer');
SQL5;
	
	$result = $db->Execute($sql_insert_lp);
	
	
	if($result)
	{
		if($LOG == "TRUE")
			lib_login_write_log($LOG_MESSAGE[6], $username);
		return "success";
	}
}

/*---------------------------------------------------------------------*
** lib_login_account_exists                                            *
** determines whether the account with $username already exists in the *
** database. true if it does, false if it doesn't                      *
**---------------------------------------------------------------------*/
function lib_login_account_exists($username)
{
	GLOBAL 	$gDB;
	$db = $gDB;
	
	$sql_account_exists =<<<SQL7
		SELECT 	* 
		FROM	tbl_users
		WHERE	username='$username'
SQL7;

	$result = $db->Execute($sql_account_exists);
	
	
	
	if($result->RecordCount() > 0)
		{return true;}
	else
		{return false;}
	
}

/*---------------------------------------------------------------------*
** lib_login_remove_account                                            *
** removes the account for $username from the database.                *
**---------------------------------------------------------------------*/
function lib_login_remove_account($username)
{
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	$sql_delete_account =<<<SQL6
		DELETE
		FROM	tbl_users
		WHERE	username='$username'
SQL6;

	$result = $db->Execute($sql_delete_account);
	
	if($result)
		{return true;}
	else
		{return false;}
}

/*---------------------------------------------------------------------*
** lib_login_delete_user                                               *
** a wrapper for lib_login_remove_account. adds error checking and re- *
** turning with html formatting                                        *
**---------------------------------------------------------------------*/
function lib_login_delete_user($username)
{
	GLOBAL	$UBER_USER;
	GLOBAL	$HEADER_TAG_OPEN;
	GLOBAL	$HEADER_TAG_CLOSE;
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$BODY_TAG_OPEN;
	GLOBAL	$BODY_TAG_CLOSE;
	GLOBAL	$gString;
	
	// $gString[68] = "cannot delete the uber user account"
	if($username == $UBER_USER)
	{	
		return $gString[68];
	}
	else
	{
		$result = lib_login_remove_account($username);
	}
	
	if($result)
	{
		return urlencode("success");
	}
	else
	{
		// $gString[69] = "unable to delete this user "
		return ($gString[69] . " - " . $username);
	}
}


/*---------------------------------------------------------------------*
** lib_login_validate_account_data                                     *
** takes a name, password and email address and sees if they meet the  *
** criteria for a valid login account. returns an error message if     *
** they don't or null if they do                                       *
** -added frymaster 06-12-01
**---------------------------------------------------------------------*/
function lib_login_validate_account_data($username, $password, $passwordagain, $email)
{
	GLOBAL	$SUB_HEAD_TAG_OPEN;
	GLOBAL	$SUB_HEAD_TAG_CLOSE;
	GLOBAL	$MIN_PASSWORD_LENGTH;
	GLOBAL	$UBER_USER;
	GLOBAL	$MY_EMAIL_DOMAIN;
	GLOBAL	$gString;
	
	// $gString[60] = "passwords do not match"
	// $gString[70] = "password is too short. minimum length
	// $gString[62] = "password same as username"
	// $gString[31] = "error"
	// $gString[71] = "localhost is not a valid domain for email "
	// $gString[72] = "email is a mandatory field "
	// $gString[73] = "invalid email address "

	if($password != $passwordagain)
		{$returnval = 	$gString[60];}
		
	if(strlen($password)<$MIN_PASSWORD_LENGTH)
		{$returnval = 	$gString[70] . $MIN_PASSWORD_LENGTH;}
		
	if($password == $username)
		{$returnval = 	$gString[31] . " " . $gString[62];}
		
	if($email == "")
		{$returnval = 	$gString[72];}
		
	if(!strstr($email, '@'))
		{$returnval = 	$gString[73];}
	
	if(trim(substr($email, strrpos($email, '@') + 1)) == "127.0.0.1")	
		{$returnval = 	$gString[71];}
	
	if(trim(substr($email, strrpos($email, '@') + 1)) == "localhost")	
		{$returnval = 	$gString[71];}
	
	// this can be deactivated by setting $MY_EMAIL_DOMAIN to NULL
	// the uber user is allowed to have an email address in this domain!
	if((trim(substr($email, strrpos($email, '@') + 1)) == $MY_EMAIL_DOMAIN)	&& ($username != $UBER_USER))
		{$returnval = 	$gString[71];}
	
	return $returnval;
}

/*---------------------------------------------------------------------*
** lib_login_nuke_session                                              *
** lots of functions (ie lib_login_count_online_users, lib_login_get_  *
** users_html, lib_login_list_online_users) determine who is logged in *
** by checking the lastlogin timestamp against the current time. if    *
** a user logs out they will still have a valid lastlogin time. this   *
** call erases lastlogin.                                              *
** -changed fm 
**---------------------------------------------------------------------*/
function lib_login_nuke_session()
{
	GLOBAL 	$gDB;
	GLOBAL	$gUser;
	$db = 	$gDB;
	
	$sql_nuke_session =<<<SQL
		UPDATE	tbl_users
		SET		lastlogin=NULL
		WHERE	username='$gUser'
SQL;
	
	$db->Execute($sql_nuke_session);
}

/*---------------------------------------------------------------------*
** lib_login_add_banned_ip                                             *
** takes an ip address called bannedip and adds it to the database of  *
** banned ips. returns a success or fail message.                      *
**---------------------------------------------------------------------*/
function lib_login_add_banned_ip($bannedip)
{
	GLOBAL 	$gDB;
	GLOBAL	$gUser;
	GLOBAL 	$UBER_USER;
	$db = 	$gDB;
	
	
	// don't let plebs ban ips!
	// $gString[74] = "only administrator can ban ips"
	if($gUser != $UBER_USER)
		return $gString[74];
		
	$ban_sql =<<<SQL
		INSERT	
		INTO	tbl_banned
				(ip)
		VALUES	('$bannedip')
SQL;

	$result = $db->Execute($ban_sql);
	
	// $gString[10] = "this ip has been banned"
	// $gString[75] = "there was an error banning this ip"
	if($result)
		return $bannedip . " - " . $gString[10];
	else
		return $gString[75] . " - " . $bannedip;
}

/*---------------------------------------------------------------------*
** lib_login_delete_banned_ip                                          *
** removes the ip bannedip from the banned ip database. this ip is now *
** no longer banned.                                                   *
**---------------------------------------------------------------------*/
function lib_login_delete_banned_ip($bannedip)
{
	GLOBAL 	$gDB;
	GLOBAL	$gUser;
	GLOBAL	$gString;
	$db = 	$gDB;
	
	// don't let plebs ban ips!
	// $gString[74] = "only administrator can ban ips"
	if($gUser != $UBER_USER)
		return $gString[74];
	
	$sql_unban =<<<SQL
		DELETE
		FROM	tbl_banned
		WHERE	ip='$bannedip'
SQL;

	$result = $db->Execute($ban_sql);
	
	// $gString[76] = "this ip has been un-banned "
	// $gString[77] = "there was an error un-banning this ip "
	if($result)
		return $gString[76] . " - " . $bannedip;
	else
		return $gString[77] . " - " . $bannedip;	
}


/*---------------------------------------------------------------------*
**  lib_login_write_bad_attempt                                        *
**  this function is called if the user has made a bad login attempt.  *
** 	it increments tries in tbl_tries by one for that user.             *
**---------------------------------------------------------------------*/
function lib_login_write_bad_attempt($username)
{
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	// if this is not a valid username then there's no point
	// in continuing...
	if(!lib_login_account_exists($username))
		{return 1;}
	
	// first we are going to select the current tries count
	// then increment then update it. this is far from the most
	// efficient approach, but we need to keep the sql to the lowest
	// common denominator to ensure database neutrality. sorry.	
	$sql_get_tries	=<<<SQL
		SELECT	tries
		FROM	tbl_users
		WHERE	username='$username'
SQL;

	$result = $db->Execute($sql_get_tries);
	$tries_increment = $result->fields[0] + 1;
	
	$sql_bad_attempt =<<<SQL2
		UPDATE	tbl_users
		SET		tries='$tries_increment'
		WHERE	username='$username'
SQL2;
	
	$result = $db->Execute($sql_bad_attempt);
}

/*---------------------------------------------------------------------*
**  lib_login_clear_bad_attempts                                       *
**  when a user logs on successfully, his or her bad attempt counts    *
** 	should be set to zero. this function does that                     *
**---------------------------------------------------------------------*/
function lib_login_clear_bad_attempts($username)
{
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	// if this is not a valid username then there's no point
	// in continuing...
	if(!lib_login_account_exists($username))
		{return 1;}
		
	$sql_clear_tries =<<<SQL
		UPDATE	tbl_users
		SET		tries='0'
		WHERE	username='$username'
SQL;

	$result = $db->Execute($sql_clear_tries);
}

/*---------------------------------------------------------------------*
**  lib_login_enact_bad_attempt_punishment                             *
**  this function is only called if the user has exceeded his or her   *
** 	maximum number of consecutive failed login attempts. the number of *
**	seconds in $BAD_ATTEMPTS_WAIT is added to the current timestamp.   *
**	the user cannot attempt to login again until that timestamp expires*
**---------------------------------------------------------------------*/
function lib_login_enact_bad_attempt_punishment($username)
{
	GLOBAL	$BAD_ATTEMPTS_WAIT;
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	$nextlogin = time() + $BAD_ATTEMPTS_WAIT;
	
	
	$sql_punish =<<<SQL
		UPDATE	tbl_users
		SET		nextlogin='$nextlogin'
		WHERE	username='$username'
SQL;

	$result = $db->Execute($sql_punish);
}

/*---------------------------------------------------------------------*
**  lib_login_test_bad_attempt_punishment                              *
**	when a user exceeds the maximum number of consecutive bad login    *
**	attempts s/he is suspended from login in for $BAD_ATTEMPTS_WAIT    *
**	seconds. this function tests to see whether the current timestamp  *
**	is earlier than the timestamp set by the punishment. if it is,     *
**	login is forbidden and true is returned. otherwise false           *
**---------------------------------------------------------------------*/
function lib_login_test_bad_attempt_punishment($username)
{
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	$sql_test =<<<SQL
		SELECT	nextlogin
		FROM	tbl_users
		WHERE	username='$username'
SQL;

	$result = $db->Execute($sql_test);
	
	if(time() < $result->fields[0])
		return true;
		
	return false;
}

/*---------------------------------------------------------------------*
**  lib_login_test_bad_attempts                                        *
**  tests whether the account of $username has equalled or exceeded    *
** 	the maximum number of bad login attempts as defined in $BAD_AT-    *
**	TEMPTS_MAX. returns true if they have, false if they haven't       *
**---------------------------------------------------------------------*/
function lib_login_test_bad_attempts($username)
{
	GLOBAL	$BAD_ATTEMPTS_MAX;
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	// if this is not a valid username then there's no point
	// in continuing...
	if(!lib_login_account_exists($username))
		{return 1;}
		
	$sql_test =<<<SQL
		SELECT	tries
		FROM	tbl_users
		WHERE	username='$username'
SQL;

	$result = $db->Execute($sql_test);
		
	if($result->fields[0] >= $BAD_ATTEMPTS_MAX)
		{return true;}
		
	return false;
}

/*---------------------------------------------------------------------*
**  lib_login_no_browser_redirect                                      *
**	some people are still using netscape 3 (believe it or not!) that   *
**	doesn't properly support the header() redirect. this function will *
** 	show a polite message with a continue link to get them on their    *
** 	way.
**---------------------------------------------------------------------*/
function lib_login_no_browser_redirect($url)
{
	//phpinfo();die;
	$agent = getenv('HTTP_USER_AGENT');
	
	if(substr($agent, 0, 5) == "Opera")
	{
		$note =<<<NOTE1
			you appear to be using the Opera web browser. in order
			for Opera to work properly with this site, you will need
			to enable automatic redirection. this can be done by:
			<ol>
				<li>opening your preferences (under the file menu)</li>
				<li>clicking on the &quot;sequrity tab&quot;</li>
				<li>checking the box labeled &quot;enable automatic redirection&quot;</li>
				<li>clicking &quot;OK&quot;</li>
				<li>clicking on the reload button on your browser</li>
			</ol>
			or you can continue by clicking the &quot;continue&quot; link below.
NOTE1;
	}
	else
	{
		$note =<<<NOTE2
			you appear to be using a browser that does not support
			url redirection which is necessary for this site. you can
			click on the &quot;continue&quot; link below to continue,
			although it is highly recommended that you upgrade to a
			browser that is capable of redirection.
NOTE2;
	}

	print <<<HTML
		<head><title>oops!</title><head>
		<body bgcolor="#FFFFFF" text="#000000">
			<font face="Arial, Helvetica, sans-serif" size="4">
			<strong>
				$note
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<a href="$url">click here to continue</a>
			</strong>
			</font>
		</body></html>
HTML;
	
	die;
}

/*---------------------------------------------------------------------*
**  lib_login_change_password_by_uber                                  *
**  takes a username and a password and updates the password for that  *
** 	username. returns true on success and false on fail.               *
**---------------------------------------------------------------------*/
function lib_login_change_password_for_user($username, $newpassword)
{
	GLOBAL 	$gDB;
	$db = 	$gDB;
	
	$md5newpassword = md5($newpassword);
	
	$sql_change =<<<SQL
		UPDATE	tbl_users
		SET		password='$md5newpassword'
		WHERE	username='$username'
SQL;

	$result = $db->Execute($sql_change);
	
	if($result)
		return true;
	else
		return false;
}

/*============================== GETTERS ==============================*/
/*============================== ^^^^^^^ ==============================*/

/*---------------------------------------------------------------------*
**  GetReferer                                                         *
**  returns http_referer page... works with iis                        *
**    --added j lim 06-10-01                                           *
**---------------------------------------------------------------------*/
function GetReferer()
{
	global $HTTP_SERVER_VARS;
	$goback = getenv('HTTP_REFERER');
	if (empty($goback)) 
		$goback = $HTTP_SERVER_VARS['HTTP_REFERER'];
	return $goback;
}

/*---------------------------------------------------------------------*
**  lib_login_get_this_site                                            *
**  returns variable for this site                                     *
**---------------------------------------------------------------------*/
function lib_login_get_this_site()
{
	GLOBAL $THIS_SITE;
	return $THIS_SITE;
}

/*---------------------------------------------------------------------*
**  lib_login_get_admin_email                                          *
**  returns variable for admin's email                                 *
**---------------------------------------------------------------------*/
function lib_login_get_admin_email()
{
	GLOBAL $ADMIN_EMAIL;
	return $ADMIN_EMAIL;
}

/*---------------------------------------------------------------------*
**  lib_login_get_success_page                                         *
** returns the page for redirect on successful login. note that it is  *
** different for the uberuser than for normal users                    *
**---------------------------------------------------------------------*/
function lib_login_get_success_page($username)
{
	GLOBAL $SUCCESS_PAGE;
	GLOBAL $SUCCESS_UBER_PAGE;
	GLOBAL $UBER_USER;
	
	if($username == $UBER_USER)
		{return $SUCCESS_UBER_PAGE;}
	else
		{return $SUCCESS_PAGE;}
}

/*---------------------------------------------------------------------*
** lib_login_whois_uberuser                                            *
** returns the login name of $UBER_USER                                *
**---------------------------------------------------------------------*/
function lib_login_whois_uberuser()
{
	GLOBAL $UBER_USER;
	return $UBER_USER;
}

/*---------------------------------------------------------------------*
** lib_login_protect_signup                                            *
** this call is used to protect do_create_login.php. if $PUBLIC_SIGNUP *
** is set to false, only uber user can create new accounts. this func  *
** checks these requirements and bounces accordingly.                  *
**---------------------------------------------------------------------*/
function lib_login_protect_signup()
{
	GLOBAL	$PUBLIC_SIGNUP;
	GLOBAL	$UBER_USER;
	GLOBAL	$FAIL_PAGE;
	GLOBAL	$gUser;
	
	
	if(($PUBLIC_SIGNUP == "FALSE") && ($gUser != $UBER_USER))
	{
		
		header("Location: $FAIL_PAGE");
		lib_login_no_browser_redirect($FAIL_PAGE);
		die;
	}
}

/*---------------------------------------------------------------------*
** getgString                                                          *
** returns the language-specific string array                          *
**---------------------------------------------------------------------*/
function getgString()
{
	GLOBAL $LANGUAGE;
	GLOBAL $THIS_SITE;
	GLOBAL	$gString;
	
	if(empty($gString)) $gString = $gString = build_vocab($LANGUAGE, $THIS_SITE);
	
	return $gString;
}



/*============================ GENERATORS =============================*/
/*============================ ^^^^^^^^^^ =============================*/

/*---------------------------------------------------------------------*
** lib_login_create_random_passwd                                      *
** cooks up a reasonably random password                               *
**---------------------------------------------------------------------*/
function lib_login_create_random_passwd()
{
	$first = rand(0, 100);
	$second = $first * (int)time();
	$third = md5($second);
	$fourth = substr($third, 0, 6);
	
	return $fourth;
}

/*---------------------------------------------------------------------*
** lib_login_sanity_check                                              *
** people might set some config  variables to values that will         *
** make this library unusable. although i have the highest regard for  *
** the ability of users, mistakes do happen... we should do a check.  *
**---------------------------------------------------------------------*/
// added 0-8
function lib_login_sanity_check()
{
	GLOBAL	$PUNISH_BAD_ATTEMPTS;
	GLOBAL	$BAD_ATTEMPTS_MAX;
	GLOBAL	$BAD_ATTEMPTS_WAIT;
	GLOBAL	$MIN_PASSWORD_LENGTH;
	GLOBAL	$TIMEOUT_IN_SECONDS;
	GLOBAL	$ADMIN_EMAIL;
	GLOBAL	$LIB_LOGIN_BASEDIR;
	
	$warning =<<<WARN
		<html><head><body bgcolor="red">
		<font face="Arial, Helvetica, sans-serif" color="#FFFFFF">
			<font size="5">
			configuration sanity failure!
			</font><p>
			<font size="3">
			one or more of the configuration variables for php_lib_login
			has failed a sanity check. please contact the adminstrator of
			this site by clicking <a href="mailto:$ADMIN_EMAIL">here</a>
			</font>
			<p>
		</font>
WARN;

	// before we go crazy, we should check and make sure that $LIB_LOGIN_BASEDIR
	// ends with a slash... if it doesn't we'll add one!
	$LIB_LOGIN_BASEDIR = trim($LIB_LOGIN_BASEDIR);
	if($LIB_LOGIN_BASEDIR[strlen($LIB_LOGIN_BASEDIR)-1] != "/")
		$LIB_LOGIN_BASEDIR .= "/";
	

	if($PUNISH_BAD_ATTEMPTS == "TRUE")
	{
		if($BAD_ATTEMPTS_MAX < 2)
			{echo "$warning\$BAD_ATTEMPTS_MAX is not a sane value!";die;}
		if($BAD_ATTEMPTS_WAIT <=0 )
			{echo "$warning\$BAD_ATTEMPTS_WAIT is not a sane value!";die;}
	}
	
	if(($MIN_PASSWORD_LENGTH > 12) || ($MIN_PASSWORD_LENGTH < 0))
		{echo "$warning\$MIN_PASSWORD_LENGTH is not a sane value!";die;}
		
	if($TIMEOUT_IN_SECONDS < 15)
		{echo "$warning\$TIMEOUT_IN_SECONDS is not a sane value!";die;}
}

/*---------------------------------------------------------------------*
** lib_login_db_failure                                                *
** a little better onscreen reporting if adodb can't find or use the   *
** database. added 0-8
**---------------------------------------------------------------------*/
function lib_login_db_failure()
{
	GLOBAL	$ADMIN_EMAIL;
	GLOBAL	$DB_LOCATION;
	GLOBAL	$DB_ACCOUNT;
	GLOBAL	$DB_PASSWORD;
	GLOBAL	$DB_DATABASE;
	GLOBAL	$DATABASE_SOFTWARE;
	
	$warning =<<<WARN
		<html><head><body bgcolor="red">
		<font face="Arial, Helvetica, sans-serif" color="#FFFFFF">
			<font size="5">
			database failure!
			</font><p>
			<font size="3">
			there has been a database failure in php_lib_login.
			please contact your system adminstrator <a href="mailto:$ADMIN_EMAIL">here</a>
			and include the error message below:
			</font>
			<p>
		</font>
WARN;

	$warningtwo =<<<WARN2
		\$DB_LOCATION $DB_LOCATION<br>
		\$DB_ACCOUNT $DB_ACCOUNT<br>
		\$DB_PASSWORD *******<br>
		\$DB_DATABASE $DB_DATABASE<br>
		\$DATABASE_SOFTWARE $DATABASE_SOFTWARE<br>
WARN2;

	echo $warning;
	$gDB = NewADOConnection($DATABASE_SOFTWARE);
	$gDB->PConnect($DB_LOCATION, $DB_ACCOUNT, $DB_PASSWORD, $DB_DATABASE);
	echo $warningtwo;


	die;
}

/*============================ END OF FILE =============================*/
/*============================ ^^^^^^^^^^^ =============================*/
?>
