{if strlen($ERRORMESSAGES)>0}
{$ERRORMESSAGES}
{/if}
<table {$LAYOUT_ATTR} border=0 cellspacing=0 cellpadding=1>
<tr><td>
	<table bgcolor={$COLORNAVBORDER} width=100% border=0 cellspacing=0 cellpadding=0>
	<tr><td> &nbsp; {$TOPCAPTION}</td><td align=right>{$NAVMENUS}</td></tr>
	</table>
</td></tr>
<tr><td>
<table border=0 width=100% cellspacing=0 cellpadding=0>
<tr>
 	{section name=cols loop=$GRIDDATA}
 <td valign=top>
	{$GRIDDATA[cols]}
 </td>
 	{/section}
 {if strlen($DETAILDATA)>0}
 <td valign=top>{$DETAILDATA}</td>
 {/if}
 </tr>
</table>
</td></tr>
<tr><td>
	<table bgcolor={$COLORNAVBORDER} width=100% border=0 cellspacing=0 cellpadding=0>
	<tr><td> &nbsp; {$BOTTOMCAPTION}</td><td align=right>{$NAVMENUS}</td></tr>
	</table>
</td></tr>
</table>