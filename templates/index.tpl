<HTML>
<HEAD>
<TITLE>{$title}</TITLE>
<link title="Our Style" rel=stylesheet href="/style.css"
type="text/css">
</HEAD>
<BODY>

<TABLE BGCOLOR="#FFFF66" WIDTH="100%" CLASS=navbar>
<TR>
<TD>
<SMALL>
<A HREF="/" TITLE="{$motto}"><STRONG><SPAN CLASS=useem>whereareyou.co.uk
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

<table>
{section name=clues loop=$clue_title}
<tr><td>{$smarty.section.clues.rownum}.</td><td><h2>{$clue_title[clues]}</h2></td><td>by: <a href="name.php?user={$by[clues]}">{$clue_username[clues]}</a></td></tr>
<tr><td>&nbsp;</td><td colspan=2>{$clue_body[clues]}</td></tr>
{sectionelse}
<tr><td colspan=2>There are no clues yet... why dont you add one?</tr>
{/section}

</table>

<hr>
</BODY>
</HTML>