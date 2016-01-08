<HTML>
<HEAD>
<TITLE>{$title}</TITLE>
<link title="Our Style" rel=stylesheet href="/style.css"
type="text/css">
</HEAD>
<BODY>

<TABLE BGCOLOR="#FFFF66" WIDTH="100%" CLASS="navbar">
<TR>
<TD>
<SMALL>
<A HREF="/" TITLE="{$motto}"><STRONG><SPAN CLASS=useem>blog.stodge.org
</SPAN></STRONG></A> <IMG
SRC="/images/arrow_yellow.gif"
WIDTH=13 HEIGHT=9 ALIGN=bottom ALT="-&gt;">
<A HREF="{$section_home_url}" TITLE="{$section_description}">{$section_title}</A> <IMG
SRC="/images/arrow_yellow.gif" WIDTH=13 HEIGHT=9 ALIGN=bottom ALT="-&gt;">
{$content_date} {$content_title}
</SMALL>
</TD>
<TD ALIGN=right>
<SMALL> |&nbsp;<A HREF="/search/">Search</A>
</SMALL></TD>
</TR>
</TABLE>
<h1>{$title}</h1>

<BLOCKQUOTE STYLE="background-color: #FFFFDD">
<STRONG>Summary:</STRONG>
<BR>{$summary}</BLOCKQUOTE>
{$body}

<!-- Links Table -->
<div class="bigbox">
<table cellspacing=0  >
{section name=link loop=$link_title}
<tr><td colspan=3 CLASS="linkbox"><b><a href="{$link_url[link]}">{$link_title[link]}</a></b>: {$link_description[link]} <b>{$link_date[link]}</b></td></tr>
{sectionelse}
<tr><td colspan=3 CLASS="linkbox">There are no links yet... why dont you add one?</tr>
{/section}
<tr>
<td align="left">&nbsp;<a href="index.php?page={$back_page}">{$back}</a></td>
<td align="center">Page #{$page_number}</td>
<td align="right"><a href="index.php?page={$next_page}">{$next}&nbsp;</td>
</tr>
</table>

<table cellspacing=5 width="100%">
<tr><td  CLASS="mlinkbox">Older Links: {section name=mlink loop=$mlink_title} [<a href="{$mlink_url[mlink]}">{$mlink_title[mlink]}</a>] {sectionelse} Empty! {/section}</td></tr>
</table>

</div>


<!-- Daily Links Table -->
<div CLASS="dailybox">
<table cellspacing=5  width=100%>
{section name=daily loop=$daily_title}
<tr><td colspan=3><b><a href="{$daily_url[daily]}">{$daily_title[daily]}</a></b></td></tr>
<tr><td class="dailytext">{$daily_description[daily]}</td></tr>
{sectionelse}
<tr><td colspan=3>There are no links yet... why dont you add one?</tr>
{/section}
</table>
<a href="http://www.slashdot.org"><img src="images/slashdotnow.gif" border="0"></a>
</div>



</BODY>
</HTML>