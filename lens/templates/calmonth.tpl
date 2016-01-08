<FORM NAME=changedate>
<!--onchange="document.changedate.submit()"-->
<table width=100%>
<tr><td width=50%>&nbsp;</td>
	<td align=right>{$navMenus}</td>

	<td align=right> Year <SELECT name=lens_year><OPTION><OPTION>1999<OPTION>2000<OPTION>2001<OPTION>2002<OPTION>2003</SELECT>
	Month <SELECT name=lens_month><OPTION><OPTION>1<OPTION>2<OPTION>3<OPTION>4<OPTION>5<OPTION>6
	<OPTION>7<OPTION>8<OPTION>9<OPTION>10<OPTION>11<OPTION>12</SELECT> &nbsp; <INPUT TYPE=SUBMIT VALUE=Go>
	</td>
</tr>
</table>
 </FORM>

<div align=center><h3><a href=?lens_year={$YEAR_BEFORE}&lens_month={$MONTH_BEFORE}>&lt;&lt;</a> {$MONTH} {$YEAR}  <a href=?lens_year={$YEAR_NEXT}&lens_month={$MONTH_NEXT}>>></a></h3></div>
<table width=100% border="1" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#C0C0C0">
  <tr bgcolor="#CCCC99"> 
    <td width="14%">{$LENSDAY1}</td>
    <td width="14%">{$LENSDAY2}</td>
    <td width="14%">{$LENSDAY3}</td>
    <td width="14%">{$LENSDAY4}</td>
    <td width="14%">{$LENSDAY5}</td>
    <td width="14%">{$LENSDAY6}</td>
    <td width="14%">{$LENSDAY7}</td>
  </tr>
     
 {section name=weeks loop=$LENSDATENUM}
  <tr>
  	{section name=day loop=$LENSDATENUM[weeks]}
 <td valign=top bgcolor=beige>

	{$LENSDATENUM[weeks][day]} {$LENSDATETEXT[weeks][day]}
 </td>
 	{/section}
</tr>
{/section}

 </tr>
</table>