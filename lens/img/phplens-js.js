/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
var phplens_upgrade='Configuring phpLens requires Internet Explorer 4.0+ or Netscape 4.0+.'
var phplens_win1
var phplens_reload='Please click on Refresh. Some data was not loaded properly.';
if (parseInt(navigator.appVersion) < 4) alert(phplens_upgrade);

function phplens_set_text(form,self,zto)
{
	var zform = eval("document."+form);
	var at  = zform.elements[self].selectedIndex;
	zform.elements[zto].value = zform.elements[self].options[at].text
}	


/*open a url in a new window */
function phplens_openwin(zurl,norand)
{
var invalidwin,r,url

	r = Math.random()
	url = ''+zurl
	if (!norand) {
		if (url.match(/\?/)) url += '&rnd='+r
		else url += '?rnd='+r
	}
	if (phplens_win1 && phplens_win1.open && !phplens_win1.closed) {
		phplens_win1.document.open();
		if (phplens_win1.location.href != url) 
			phplens_win1.location.href = url;
	}else {
		phplens_win1 = window.open(url,'phplensmsgwindow',"height=400,width=700,scrollbars=yes,resizable=yes") 
	}
	phplens_win1.focus()
	
}

function phplens_swap(parent,pos1,pos2)
{
var opt1,opt2

	opt1 = new Option(parent.options[pos1].text);
	opt2 = new Option(parent.options[pos2].text);
	parent.options[pos1] = opt2;
	parent.options[pos2] = opt1;
	parent.selectedIndex = pos2;
}

function phplens_append(parent,child)
{
	parent.options[parent.length] = child;
}

// move option up and down listbox
function phplens_move(obj,dir) // dir is -1(up) or 1(down)
{
var sel,opt,i,opt,zdoc;
	
	sel = eval('document.'+obj);
	if (sel==null) {
		alert(phplens_reload);
		return;
	}
	i = sel.selectedIndex;
	if (i<0) return;

	if (dir>0) if (sel.length==i) return;	
	if (dir<0) if (i==0) return;
	
	if (i+dir<sel.length) phplens_swap(sel,i,i+dir);
}



// move from left listbox to right listbox
function phplens_gridadd()
{
var vcols,gcols,zdoc;
	gcols = document.phplens_columnmover.PHPLENS_GRIDCOLS;
	vcols = document.phplens_columnmover.PHPLENS_GRIDVIS;
	phplens_mover(gcols,vcols);
}
// move from right listbox to left listbox
function phplens_gridremove()
{
var vcols,gcols,zdoc;
	gcols = document.phplens_columnmover.PHPLENS_GRIDCOLS;
	vcols = document.phplens_columnmover.PHPLENS_GRIDVIS;
	phplens_mover(vcols,gcols);
}
function phplens_mover(from,to)
{
if (from==null ||to==null) {
	alert(phplens_reload);
	return;
}
var s = navigator.appVersion,arr,isie5,i;
arr = new Array();
if (document.all && s.match(/MSIE 5.0[; A-Z]/i)) {// special case ie5.0 bug
var cnt = 0,arr;
	isie5 = true;
	for (i=0;i<from.length;i++)
		if (from.options[i].selected) {
			cnt += 1; 
			if (cnt > 1) {
				from.options[i].selected = false;
				arr[cnt] = i;
			}
		}
	if (cnt>1)document.all.messagefield.value=('Please upgrade to newer version of IE5 to copy multiple items');
}
var agent = navigator.userAgent
while (from.selectedIndex>=0) {
	newopt=new Option(from.options[from.selectedIndex].text);
	if (newopt.text.length==0) break;
	from.options[from.selectedIndex]=null;
	phplens_append(to,newopt);
	if (agent.match(/Opera/i)) break; // opera selectedIndex always>=0, so copy 1 only
}

if (isie5) {
	for (i=2; i <= cnt; i++) {
		from.options[arr[i]-1].selected = true;
	}
}
}

function phplens_savegrid(action,id,state)
{
var zz,i,j=0,max,o,s='',url,zdoc;

	o = document.phplens_columnmover.PHPLENS_GRIDVIS;
	if (o==null) {
		alert(phplens_reload);
		return false;
	}
	max = o.length;
	for (i=0;i<max;i++) {
		
		zz = ''+o.options[i].text;		
		if (zz.length>0) {
			if (j>0) s+=';';
			s += zz;
			j += 1;
		}
	}//for
	url = window.location.pathname
	if (url.match(/\?/)) {// opera returns invalid pathname with ?
		url = url.split('?') 
		url = url[0]
	}
	url += '?resetsess=1&lens_e_'+id+'=savegrid&grid='+action+'&lens_e_p1='+escape(s);
	if (state.length) url += '&state='+state;
	window.location.href=url
	return true;
}
