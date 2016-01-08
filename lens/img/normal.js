// --------------- From here you can config the options freely! ----------------
var gsPopConfig="top=200,left=200,width=400,height=200,scrollbars=1,resizable=1";	// the look of popup window

var gMonths=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
var gWeekDay=new Array("S","M","T","W","T","F","S");
var gsToday="Today : "+gToday[2]+" "+gMonths[gToday[1]-1]+" "+gToday[0];	// The expression of Today-Part.

var giCellWidth=18;	// Calendar cell width;
var giCellHeight=18;	// Calendar cell height;
var gbHideDC=false;	// Replace the Date Controls at the top with gsCalTitle. If set true, gbCMFocus should be set to false!!
var gbHideToday=false;	// Remove the Today Part from the bottom
var gsCalTitle="(gMonths[gCurMonth[1]-1]+' '+gCurMonth[0])";	// dynamic statement to be eval-ed

var gBegin=[1940,1,1];	// Valid Range begin from [Year,Month,Date]
var gEnd=[2038,1,1];	// Valid Range end at [Year,Month,Date]
var gsOutOfRange="The date is out of valid range!";	// Range Error Message

var gbEuroCal=false;	// Show European Calendar Layout - Sunday goes after Saturday
var gsSplit="-";	// Separator of date string, AT LEAST one char.
var giDatePos=0;	// Date format  0: D-M-Y ; 1: M-D-Y; 2: Y-M-D
var gbDigital=false;	// true: 01-05-2001 ; false: 1-May-2001
var gbShortYear=false;   // Set the year format in short, i.e. 79 instead of 1979

var gpicBG=null;	// url of background image
var gsBGRepeat="no-repeat";// repeat mode of background image, except NN4. [no-repeat,repeat,repeat-x,repeat-y]
var gcBG="#dddddd";	// Background color of the cells. Use "" for transparent!
var gcFrame="teal";	// Frame color
var gsCalTable="border=0 cellpadding=2 cellspacing=2";	// the properties of calendar <table> tag
var gcCalBG="#6699cc";	// Background color of the calendar

var gcTodayBG="white";	// The background highlight color of today
var gcSat="darkcyan";	// Saturday color
var gcSun="red";	// Sunday color
var gcWorkday="black";	// Workday color
var gcOtherDay="silver";	// The day color of other months
// gcOtherDay must be set in literal format, digital & rgb() format will not work in either NN6 or NN4!
var gcToggle="yellow";	// highlight color of focused cell
