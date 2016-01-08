<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/ 

/*--------------------------------------------------------------------------------------------------*/
//                                        VERSION NUMBER
/*--------------------------------------------------------------------------------------------------*/
define('PHPLENS_VERSION', '1.3.4');

/*--------------------------------------------------------------------------------------------------*/
//                                           CHANGE LOG
/*---------------------------------------------------------------------------------------------------/
== 1.3.4
Added 2 new installation test scripts to aid in debugging config bugs. They are 
	testzendopt.php and testconfig.php. Also updated docs.

== 1.3.3
Fixed problem with spEdit and spNew and storing \, the \ not quoted properly. Fixed.

The paths in PHPLENS_GRAPHIC_SERVER not used when editing/new record. Fixed.

When lookupLens and readonlyLens is set for a column, the value is not shown in edit form. Fixed.

Export to text (rawExport property) no longer needs templateGrid. 
	Formerly, pageSize was reset to -1. Now we use whatever the user defines...

== 1.3b2
Fixed some bugs in the calculations of how many radio/check boxes to put per line, and now use nowrap attribute.  Added LENS_INPUT_WIDTH constant to help with this
Added mustFillMarker property.

Transparent coloring did not work properly because of the rowColorLens addition-fixed.

Fixed accidental printing of PHPLENS_GRAPHIC_SERVER variable.

==1.2.23 / 1.3b1

Added $INIT_GRID_FIELDS to set the number of cols to show if no gridLens defined. See phplens.inc.php.
Now nameLens allows {nbsp} to be embedded in the names.

Added new property to modify LIKE matching: filterLikeFunction. Given a column name, will return the 
	like code required. See filterLikeFunction in documentation.
Major rewrite of filtering - found a few bugs
	Added filterAllOr property - set to true  to force ORing of sql where clauses (default is to AND)
	Fixed saving of filter settings so they are retained for the session.

Added new value to showRecNo = 3. This will show RecNo and hide Details grid. 
	Child editor will override this setting.

	
== 1.2 launched 5th October 2001

	
==1.2b22
Fixed editLens/newLens not working when dynEdit=0. This was an optimization from earlier - did not 
	parse these properties when viewing grid - this does not work when a child editor is in place. 
	Removed this optimization.

Under some unusual conditions, the array of checkboxes can be unset. Now we check for this condition.

==1.2b21
Fixed phplens highlighting problem
Checkboxes not visible in search form under certain situations. Fixed.
Property spEdit did not handle keyCol of the form table.column properly. Fixed.
Fixed MD5 fingerprint problem when child editor visible in search form. Clear _editMap everytime before used.

==1.2b20
Fixed text database driver - now permitted in all phplens products, not merely Enterprise

==1.2b19
Fixed recno width to 4% in grid when showHeaders = false. This is because Netscape is brain-damaged
	about col widths.

==1.2b18
Cleaned up editbtn.gif, adding width and height to the img tag.
Cleaned up hide menus code.
ColorLens did not handle single-quotes properly. Fixed.
Improved builder - merged save applet and change id.
Added LAYOUT_ATTR to replace COLORBACKGROUND template variable

==1.2b17
Supporting double byte introduced some compat problems dealing with &amp; Now we convert
	text using LensStrTr() - which should convert ampersand correctly!
Made colorLens a first class citizen, supporting all powerLens vars

==1.2b16
Dynamic editor can manage hideMenus now.
Empty strings checked with strlen( ), to workaround "0" strings not displaying.
DynEdit checks for true, and we reset it to 1 now.
FileComboBox( ) now can handle incorrect paths without failing.
Force canEdit and canNew when childLens is set.
Property overrideFunction not working properly - fixed. 

==1.2b15
Search filter did not size the number of cols in select statement properly. Fixed.
ParseSQL regex did not work for php 4.0.3 - reported by jmzuzan. Patched by ignoring
	GLOBAL array bounds in 4.0.3.

==1.2b14
Added http and https support for varchar

==1.2b13
Added combo
Fixed javascript so mustfill matches whitespace properly
Added jsLens property

==1.2b12
Fixed NN6 problems with delete/edit icon wrapping around
Added support for automatic creatiion of anchor tags for https://abc.com
Must fill now works properly for textareas. Formerly, \n not recognised

==1.2b11
Removed "AAAA A" debug statement in phplens-core.inc.php.
Prototyped iframe support. Works with Mozilla 0.9 and IE 5.5.
Fixed some documentation stuff that was bugging me.
On errors in edit/save, the new form was displayed (should be edit) 
	when childLens new/edit enabled.

==1.2b10 
Cleaned up rowColorLens again and disabled hiliting when no detail grid to maintain compat
	with phpLens 1.0.
Fixed missing <TR> when menus hidden.
MySQL updates on empty char/text fields properly save as empty '' strings now. 1.2b9 fix did not work
Changed LensRowColor() use style.backgroundColor instead of runtimeStyle.backgroundColor
	to maintain compat with Netscape 6.0
Support for dreamweaver (see phplens-dreamweaver.zip file). 
	You can add a phpLens object from the dreamweaver toolbar.

== 1.2b9 30-Aug-2001
String primary keys did not work when updating. Fixed in this version.
	We now autodetect whether the keyVal is string and quote it if needed in sql stmt
Now mysql does not add an extra space to a string update/insert if the string length is zero.
Added templateFilter property when you want to modify the way the search form looks. 
	This completes all the possible template combinations.
Oci8 blob support stopped working because of accidental quoting. Fixed.
Blobs are only treated as images now if htmlLens not set for that column
Oci8 update statements no longer use bind for the primary key because of bug in oci8
The primary key is trimed before we md5 it during updates.
The dynamic editor now supports both only edit and edit+create in detail grid (childLens property).

== 1.2b8 26-Aug-2001
Added $lens->htmlLens = '*'; to mean do not encode any database columns - useful for double-byte chars.
Cleaned up the comments in this file.

== 1.2b7 24-Aug-2001
Resumed testing with NJStar Communicator. Gotta fix those double-byte blues.
	Because double-byte characters include '&', we cannot convert them using htmlspecialchars()
  	so we use strtr() with a patched translation table.
Added default rowColorLens = LensRowColor() function.
Added support for multiple select - egrau suggestion.
Fixed xml parsing bug - extra space added accidentally.

=== 1.2b6
Now  recno is always selected when childLens set.
Only if calendar is used is the iframe tag inserted now!
Problem - oci8 ocibindbyname sets var to null if storing ' '.

=== 1.2b5
Added xmlLens support
Bug fix: htmlspecialchars() called twice if rowColorLens used and powerLens not used (egrau reported).

=== 1.2b4
Added global variable support to powerLens. 
The errorHandler property added.
Added childLens property.

=== 1.2b3
Added rowColorLens property.
changed lookupLens and sql property variable parsing so that it is triggered by %.
Added _HILITE_RECNO_ variable in powerLens and rowColorLens
Made keyTable property dynamic

=== 1.2b2
Reverted oci8 to not use bind variables (set init.ora to CURSOR_SHARING=force instead) because
  blank strings are automatically changed to null -- not desired behaviour in most cases.
lookupLens sql allows variables now.
numeric fields did not become checkboxes when inputTypeLens set to checkbox - fixed
builder/grid now appears to work reliably
added 'LENS_SHOW_TOP_MIN_ITEMS' to control when the Save/Cancel buttons appear in both navbars

=== 1.2b1
added showCancel property.
added _ISEDIT_ set to 'N' or 'E' for new or edit in templates, and set to '' otherwise.
changed checkboxLens to inputTypeLens and added radio and submit support
moved save and cancel to top right when new/edit
added _EDIT_ -> _DYNEDIT_ for dynamic editing (_EDIT_ still means edit button)

=== 1.1b03
Nested templates support added by modifying rn GET variable.
_RECNO_ variable in powerLens added.
Extended textAreaHeader to support different textarea rows and cols for different fields.
Modified template support so that the template compiler works.
Applet concepts more fully fleshed out.

Added templateBaseDir, templateAssign, templateMode properties...

== 1.1b02
now if redirectoninsert and redirectoninsertcancel is set, then no viewing of grid is allowed
added == to lookup value handling for 1 dimensional arrays

=== 1.1b01
integrated popcalendarxp
property sqlBind, checkboxLens, displaySep
property powerEditLens -- if edit field is readonly, then we still update using hidden field. If field
is hidden, then the lens is not executed. Also all hidden input fields are checksummed for security now

added property templateSecure
readonly field is still editable on creating a new record if it is a must fill

== 1.0
reset '_' for $ctl
PHPLens_undomq needed for key in checkmd5 and % in default values disabled becoz no checksum
_InsertSQL set checkmd5 to true

=== 1.28b 
Oracle optimizations. Now we bind SQL variables for highest performance by maximizing
	shared SQL and reducing parsing of SQL statements to the minimum when editing/creating
	records.
Support for bpchar in postgresql.
Default color scheme not working in javascript. Fixed.
Gridbuilder PHP code generation bugs. Fixed.
Property dynUseSessions defaults to true now.

=== 1.27b 5-June-2001
include variables converted to constants for security
Added property templateShowErrors
move this->eventPreInsertField and eventPreUpdateField to Advanced/Ent
powerLensOff to escape powerLens
Changed filterShowGrid to filterShowForm
Add some images to help/img
Improved error handling in testtext.php.
Remove DEFAULT_GRAPHICS_SERVER so people don't change this.
Windows HELP CHM file.
Added toUpper property

=== 1.26b 19-May-2001  
Fixed recno problem in phplens-core2.inc.php

=== 1.25b 16-May-2001
Removed error_reporting(63). 

When in firstState == 'FILTER' mode, creating a new record doesn't reset() anymore.

Added includeHeader and includeFooter properties.

Planning to be IE 6 compatible. Tested - works fine!

Default values not saved properly in 1.24b. Fixed.

Added templateFilterGrid property.

=== 1.24b 14-May-2001
Calendar renderer

Fixed netscape popup bugs. Seems netscape requires the options to be predefined to
calculate the select menu width. So we put in a fake option.

=== 1.24b 11-May-2001
Scroll to end of recordset did not reset the recno properly for mysql. Fixed.

Rewritten mustFill properties to work with javascript.

Fields following text areas did not display correctly. Fixed.

Changed uploading images so that empty upload does nothing.

=== 1.23b
Column offset check did not work for defaultLens. Fixed.

==== 1.22b 7-May-2001
Added Smarty Template Engine support

Changed image labels to from TITLE to ALT tag to support NN.

==== 1.18b 2-May-2001
Htmlspecialchars() called twice in templates. Fixed.

Added multi-column detail table handling.

Fixed javascript validation problem with netscape.

Fixed $dyn2 and $noinput uninitialized var errors.

==== 1.17b: 30-April-2001
Generate PHP code: The first item in a property string is always converted to uppercase. This
is a bug. Fixed.

==== 1.16b: 30-April-2001
Fixed bug in lookups. Did not handle "0" properly because used empty(). Changed to strlen().

Changed eventPost*SQL properties to include primary key of affected record.

Default directory page not index.php on some systems. So set the pagename explicitly.

PageSize=0 to indicate show all records in one page broke in 1.15b. Fixed.

Improved docs.

==== 1.15b : 25-April-2001 
Select with limits properly implemented now. This improves efficiency of paged scrolling.

Clicking on Column Edit Icon bug fixed.

==== 1.14beta 23-April-2001
Hiding filter menu item was flawed. Fixed. 

Used isset() to check where clause string. A mistake. Changed to !empty().

==== 1.13beta  
Searching when the original $lens->sql statement had a where clause did not work. Fixed.

Phplens directory can now be placed anywhere on the web server (relative paths work better now). 
Formerly, had to be in /php/phplens

Double-click checking on the Save button when editing now timeouts after 3 seconds. 
This solves the problem of when you click on Save, then browser Stop, Save would be 
disabled permanently.

When saving illegal email addresses, phpLens now generates clearer error messages.

Error messages when must fill fields are empty now work again.


==== 1.12beta 19-April-2001
Saving of HTML text improved:
-anchor tags entered by user now preserved
-header tags do not have extra BR's appended to it

Bug in msgs.php in forums. Now body field selected correctly.

Error handling on saving of new records was flawed. Fixed.

Dynamic editing interface for charting improved.

==== 1.11beta 03-April-2001
Changed phpLens internals to make installation easier. 

Changed name of Query Builder to Grid Builder to make it easier to newbies to understand.

Making progress with docs. Added security, charting, etc. Edited setup.

==== 1.10beta 30-March-2001
Added anchorTags property to convert http://* and www.* and emails to links.

Fixed dynamic editing so autodetection of primary key works more reliably.

Docs are improving -- still a massive job to document 160+ properties and example code.

*/

/*--------------------------------------------------------------------------------------------------*/
//                                        FUNCTION DEFINITIONS
/*--------------------------------------------------------------------------------------------------*/


//---------------------------------------------------------
// Finds the DOCUMENT_ROOT - works with Apache, IIS and PWS
function PHPLENS_RootPath()
{
GLOBAL $HTTP_SERVER_VARS;

	if (isset($HTTP_SERVER_VARS['DOCUMENT_ROOT'])) { // APACHE and PWS
		$_p_file = (str_replace('\\\\','/',$HTTP_SERVER_VARS['DOCUMENT_ROOT'])); // compat for php4.02 on windows
		return (str_replace('\\','/',$_p_file));
	}
	if (isset($HTTP_SERVER_VARS['APPL_PHYSICAL_PATH'])) { // IIS
		$_p_file = (str_replace('\\\\','/',$HTTP_SERVER_VARS['APPL_PHYSICAL_PATH'])); // compat for php4.02 on windows
		return (str_replace('\\','/',$_p_file));
	}
} //function

//----------------------------------------------------------------------------
// Define code for coloring rows. You should modify this if you want to color 
// based on some other criteria.
//
// onMouseOverColor	The color to display when the mouse is over a row.
//						Defaults to #FF8080, a shade of pink.
// id				The $lens->id property
// recno			The record number that you are currently processing
// isSelected		Is this record the current selected record (boolean)
// selColor			The $lens->colorSelect property
// oddColor			The $lens->colorOdd property
// evenColor		The $lens->colorEven property
// hasDetails		Details grid/editor visible
//
// The default rowColorLens is
// $lens->rowColorLens = '=LensRowColor("#FF8080",{_LENSID_},{_RECNO_},{_RECNO_}=={_HILITE_RECNO_},{_SELECTC_},{_ODDC_},{_EVENC_},{_HASDETAILS_})';
//
function LensRowColor($onMouseOverColor,$id,$recNo,$isSelected,$selColor,$oddColor,$evenColor,$hasDetails)
{
GLOBAL $PHP_SELF;

	$color = ($recNo%2)? $oddColor : $evenColor;
	if($hasDetails) {
		if ($isSelected) $color = $selColor;
		$js =<<<DOC
 onclick="window.location='$PHP_SELF?lens_no_$id=$recNo'" 
 onmouseover="this.style.backgroundColor='$onMouseOverColor'" 
 onmouseout="this.style.backgroundColor=''"
DOC;
	} else {
		$js = '';
/*
	# formerly we also hilited even if you couldn't click,
	# but we have disabled it to maintain 100% compat with phpLens 1.0
		$js =<<<DOC
 onmouseover="this.style.backgroundColor='$onMouseOverColor'" 
 onmouseout="this.style.backgroundColor=''"
DOC;
*/
	}
	
	return "$color$js valign=top";
}



/*--------------------------------------------------------------------------------------------------*/
//                                        CONSTANT DEFINITIONS
/*--------------------------------------------------------------------------------------------------*/


//----------------------------------------------------------------------
// Set the PHPLENS directory - everything revolves around this directory
if (!defined('PHPLENS_DIR')) define('PHPLENS_DIR',dirname(__FILE__));

//--------------------------------------------------------------
// The following must be the first file loaded, so we do it here
include_once(PHPLENS_DIR.'/config/phplens.config.inc.php');

//-------------------------------------------------------------------------------
// Define constants for important subdirectories, such as the template engine dir
if (!defined('SMARTY_DIR')) define('SMARTY_DIR', PHPLENS_DIR.'/smarty/');

//-------------------------------------------------------------------
// Where we store applets - this will be very important in the future
if (!defined('APPLETS_DIR')) { // new to phplens 1.2
	define('APPLETS_DIR', PHPLENS_DIR.'/builder/applets');
	
	define('PHPLENS_MENU_COLOR','#FF9933');
	define('PHPLENS_MENUFONT_COLOR','white');
	define('PHPLENS_BKGD_COLOR','white');
	define('PHPLENS_SIDE_COLOR','#FFFFCC');
	define('PHPLENS_MENU2_COLOR','#FFCC99');
}


//--------------------------------------------
// This is the class used to create templates, 
// basicly a wrapper around Smarty currently.
$PHPLensTemplateClass = 'PHPLensTemplate';

//---------------------------------------------------
// Where the above $PHPLensTemplateClass can be found
define('PHPLensTemplateInclude',PHPLENS_DIR.'/phplens-template.inc.php');


//---------------------
// Error severity codes
if (!defined('LENSERROR')) {
define('LENSERROR_SEVERE',1);
define('LENSERROR',0);
define('LENSWARNING',-1);
}

//--------------------------------------------------
// No of items before showing save and cancel at top
define('LENS_SHOW_TOP_MIN_ITEMS',6);

define('NBSP', '&nbsp;');
define ('PHPLENS_MAX_ROWS',9999999); // 9.9 million
define ('PHPLENS_MAX_PAGESIZE',99999); // 99,999
define('PHPLENS_BANNED_TAGS', '/<\/*((SCRIPT)|(META)|(DIV)|(APPLET)|(OBJECT)|(TABLE)|(T[RDH])|(EMBED)|(INPUT)|(TEXTAREA)|(IFRAME)|(FRAME)|(SPAN))/i');
define('PHPLENS_MAX_ID_LEN',10); // length of phplens $id -- must match sizeof(phplens table field id)-2

//--------------------------------------------------------------
// sets the number of fields to show if no gridLens is defined
if (empty($INIT_GRID_FIELDS )) $INIT_GRID_FIELDS = 5;

//--------------------------------------------------------
// The default <SELECT MULTIPLE> tag has a height set to
//    SIZE= sqrt(#rows)+1, or 6, whichever is higher.
// If you prefer a fixed SIZE, then define the following...
//define('LENS_MULTIPLE_SELECT_SIZE',6);


/*
Regular Expression for Email Validation

com         commercial organization
edu         educational institution
gov         government
int         international organization
mil         U.S.military
net         networking organization
org         

ICANN approved 
.info for general use, 
.biz for businesses, 
.name for individuals,
.pro for professionals, 
.museum for museums, 
.coop for business cooperatives, and
.aero for the aviation industry."
*/
if (!defined('PHPLENS_EMAIL_REGEX')) {
	define ('PHPLENS_EMAIL_REGEX',
	## unfortunately, the proliferation of domains in the future 
	## will screw the following excellent regular expression in the future
	## '^(\S+@).+((\.[Cc][Oo][Mm])|(\.[Ee][Dd][Uu])|(\.[Gg][Oo][Vv])|(\.[Ii][Nn][Tt])|(\.[Mm][Ii][Ll])|(\.[Nn][Ee][Tt])|(\.[Oo][Rr][Gg])|(\.[Ii][Nn][Ff][Oo])|(\.[Bb][Ii][Zz])|(\.[Nn][Aa][Mm][Ee])|(\.[Pp][Rr][Oo])|(\.[Mm][Uu][Ss][Ee][Uu][Mm])|(\.[Cc][Oo][Oo][Pp])|(\.[Aa][Ee][Rr][Oo])|(\.[a-zA-Z]{2,2}))$'
	## so we use the following
	## based on http://developer.apple.com/internet/_javascript/validate_source.html 
	'^([^ @\r\n\t\(\)\<\>\,\;\:\\\"\[\]]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,6}|[0-9]{1,3})(\]?)$'
	);
}

//-----------------
// Year Validation
define('PHPLENS_FIRST_YEAR',1900); // first legal year for data entry validation
define('PHPLENS_LAST_YEAR',2037); // last legal year for data entry validation

//--------------------------------------------------------------
// Number of characters a line should be for data entry
// Used to calculate the number of checkboxes/radio buttons to 
// have in a line, based on the maximum length of the text label.
// So if the longest text label is 20 chars, we will fit 3 checkboxes
// into a line when LENS_INPUT_WIDTH = 64. We still limit to max of 16 items 
// per line. Note that this algorithm has a widow reducing feature
// that will reduce the number of columns used if it can, so the above
// is only 90% accurate (a widow is a dangling table cell).
define('LENS_INPUT_WIDTH',64);
//----------------------------------------------------------------------
// Multiuser warning timer in secs. If different client edits browser
// screen in last 5 minutes, we warn user
define('LENS_MULTIEDIT_TIMER',300);
//---------------------
// Load core libraries
require_once(PHPLENS_DIR.'/phplens-main.inc.php');



?>
