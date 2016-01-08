// == This file is fully configurable ==

/*** Default Action when you click a normal date ***/
//var gsAction="fDemoCheck();";	// This is for demo use.
 var gsAction=" ";	// This should be the normal config.


/*** add agendas here ***/
// Usage -- addEvent(date, message, color, action, imgsrc);
// Notice:
// 1. The format of event date is defined in fHoliday(). Current is D-M-Y.
// 2. In the action part you can use any javascript statement.
// 3. Assign "null" to action part will result in a line-through effect of that day, while " " not.
// 4. imgsrc is the URL of your image, you can omit it if no image to show.
// ---------------
//addEvent("13-5-2001", "Disabled Date!", gcBG, null);	
//addEvent("6-6-2001", "If you arrive on today, then your departure time will be confined!", "gray", "fDemoArrive()");
//addEvent("20-6-2001", "If you depart on today, then your arrival time will be confined!", "gray", "fDemoDepart()");
//addEvent("12-6-2001", " June 12, 2001 \n PopCalendarXP 3.0 Unleashed! ", "skyblue", "popup('readme.txt','main');"+gsAction);


/*** Holiday PLUG-IN FUNCTION, return [message,color,action,imgsrc] like agenda! ***/
function fHoliday(y,m,d) {
// uncomment any of the following two lines will give you special effect!
// if (m!=gCurMonth[1]||y!=gCurMonth[0]) return [,gcOtherDay,];	// hide the days of other months
// if (new Date(y,m-1,d+1)<gd) return [,gcBG];	// cross-over the past days

  var r=agenda[d+"-"+m+"-"+y]; // Define your agenda date format here!!
  if (r) return r;	// put this line to the end will lower the priority of agenda events.

  if (m==12&&d==25)
	r=["Merry Xmas!", "seagreen"];
  else if (m==12&&d==26)
	r=[" Boxing Day! \n Let's go shopping ... ", "skyblue", " "];
  else if (m==1&&d==1)
	r=["Happy New Year... ", "skyblue", " "];
  
  return r;
}


/*** add self-defined functions here ***/
function fDemoCheck() {
  if (gdCtrl.name=="dc1")
	parent.depRange=[];
  if (gdCtrl.name=="dc2")
	parent.arrRange=[];
}
function fDemoArrive() {
  if (gdCtrl.name=="dc1")
	parent.depRange=[[2001,6,10],[2001,6,20],[2001,6,13]];
}
function fDemoDepart() {
  if (gdCtrl.name=="dc2")
	parent.arrRange=[[2001,6,1],[2001,6,10]];
}

