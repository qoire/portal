<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/


class PHPLens_en_us {
// first array element is a filler -- 13 elements in array
var $txtMonths = array('??','January','February','March','April','May','June','July','August','September','October','November','December');
var $txtWeekDays = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");  


var $fmtDateInput="m/d/Y"; // this must be 5 chars long, with same separator character
var $fmtDateOutput="M-d-Y"; // format must match PHP date() function
var $fmtTimeStampOutput="M-d-Y h:i:s A"; // format must match PHP date() function
var $fmtTimeStampInput="m/d/Y h:i:s A";
var $fmtThousands = ',';
var $fmtDecimal = '.';

// Icon text
var $dynEditIcon = '<img src="$PHPLENS_PATH/img/editbtn.gif" border=0 width=14 height=13 alt="phpLens Settings">';
var $dynEditColIcon = '<img src="$PHPLENS_PATH/img/editcol.gif" border=0 width=14 height=13 alt="Column Settings">';
var $dynEditTabIcon = '<img src="$PHPLENS_PATH/img/edittab.gif" border=0 width=14 height=13 alt="Choose Visible Columns">';
var $menuPrev = '<img src="$PHPLENS_PATH/img/prev.gif" width=20" height=20 border=0 alt=Previous>';
var $menuNext = '<img src="$PHPLENS_PATH/img/next.gif" width=20" height=20 border=0 alt=Next>';
var $menuBegin = '<img src="$PHPLENS_PATH/img/begin.gif" width=20 height=20 border=0 alt=Begin>';
var $menuEnd = '<img src="$PHPLENS_PATH/img/end.gif" width=20 height=20 border=0 alt=End>';
var $menuFilter = '<img src="$PHPLENS_PATH/img/filter.gif" width=20 height=20 border=0 alt=Search>';
var $menuFilterReset = '<img src="$PHPLENS_PATH/img/filterreset.gif" width=20 height=20 border=0 alt="Reset Search">';
var $menuClear = '<img src="$PHPLENS_PATH/img/dot.gif" width=20 height=20 border=0>';
var $menuNew = '<img src="$PHPLENS_PATH/img/new.gif" width=20 height=20 border=0 alt="New Record">';

var $iconDel = '<img src="$PHPLENS_PATH/img/del.gif" width=13 height=13 alt=Delete border=0>';
var $iconEdit = '<img src="$PHPLENS_PATH/img/edit.gif" width=17 height=15 alt=Edit border=0>';

// Warnings
var $txtWarnNewRecord = "Warning: you cannot create new records till you select some <a href=%s?lens_e_%s=new>New Record Columns</a><br>";
var $txtWarnEditRecord = "Warning: you cannot create edit records till you select some <a href=%s?lens_e_%s=edit>Edit Record Columns</a><br>";
var $txtWarnKeyCol = "Warning: Editing and New Record might not work. Key Column <i>%s</i> not found in among the selected columns. <a href=%s?lens_e_%s=nav>Edit Here</a><br>";
var $txtWarnEmail =  'Expected email format such as info@phplens.com or info@natsoft.com.my';
var $txtWarnRedirect = "<H3>Redirecting web page. If the redirection does not work, click on the link below</H3>";
// Javascript Text -- not used
// var $txtJSValidationErr='\\n\\n X: A-Z or 0-9 must fill\\n x: A-Z or 0-9 optional\\n #: 0-9 must fill\\n 9: 0-9 optional\\n ?: A-Z must fill';

// Search Text
var $txtMatchExact = "Match Exactly &nbsp; ";
var $txtMatchBegin = "Match From Beginning &nbsp; ";
var $txtMatchAnywhere ="Match Anywhere &nbsp; <BR>";

//captions
var $topCaption = '<b><font color=white> &nbsp; PHPLens</font></b>';
var $bottomCaption = '<font color=white> &nbsp; <b>00&gt;</b> <font size=2>Visualize your Information &nbsp; (Page $PageNo) &nbsp;</font></font>';

// Error Txt
var $txtInvalidDate = 'Invalid Date ';	
var $txtInvalidTimeStamp = 'Invalid TimeStamp ';	
var $txtInvalidNumber = 'Invalid Number ';
var $txtMustFill = 'Must Fill: ';
var $txtErrGroupLens = 'Invalid Group Column ($this->groupLens): ';
var $txtErrID = 'Invalid $id passed to PHPLens constructor. Must be alphanumeric chars only and max length: ';
var $txtErrChartSQL = 'Error in SQL to find min,max for chart';
var $txtErrSessions = 'Cannot save variable. Sessions not available.';
var $txtErrSpaceInName = "Cannot handle column name with embedded spaces: ";
var $txtErrAuth = "You need to set a phpLens property. You are not authorised to carry out this action: ";
var $txtErrNoRecords = "No records found";
var $txtImageNotFound = "Image";
var $txtNoDataOrSQLError = 'No data returned (sql error?)';
var $txtErrModified = 'Cannot save. Data has just been modified by another user. Please retry.';

// Misc Text
var $txtMatchPassword = "PASSWORD"; // text to match for password input fields. Uppercase please
var $txtError = "Error "; // make sure there is a space at the end of this string...
var $txtClearAll = '<font size=1>Clear All</font>';
var $txtCheckAll = '<font size=1>Check All</font>';
var $txtPrev = 'Prev';
var $txtNext = 'Next';	
var $txtBegin = 'Begin'	;
var $txtEnd = 'End';
var $txtEdit = 'Edit';
var $txtFilter = 'Search';
var $txtFilterReset = 'Clear Search';
var $txtCancel = 'Cancel';
var $txtNew = ' &nbsp; New &nbsp; ';
var $txtSave = ' &nbsp; Save &nbsp; ';
var $txtDel = 'Delete';
var $txtTotal = 'Total:';
var $txtSubTotal = 'Subtotal:';
var $txtExpected='Expected format';
var $txtSubmit = 'Submit';
var $txtTrue = 'Yes';
var $txtFalse = 'No';
var $txtUndefined = 'Undefined';
var $txtShortTimeStamp = 'Day/Mth/Yr/Hr/Min/Sec/AM/PM'; // always use / separator
var $txtField = 'Field';

// NEW TO PHPLENS 1.2
var $editCaption = '<b>Edit Record</b>';
var $newCaption = '<b>New Record</b>';
}; 
?>