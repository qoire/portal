<html>
<head>
<title>{$source_title}: {$title} - {$sub_title}</title>
<meta name="keywords" content="{$keywords}">
<META NAME="ROBOTS" CONTENT="index, follow">
<META name="date" content="{$english_date_updated}">
<META NAME="author" CONTENT="Rob Swigart">
<META NAME="author" CONTENT="Salim Fadhley">
<META NAME="revisit-after" CONTENT="60 days">
<link title="Our Style" rel=stylesheet href="/style.css" type="text/css">
</head>
<body>
<table width="100%" border=0>
<tr>
<td width="100%" ><h1>{$title}</h1></td>
<td rowspan=2 valign="top"><img alt="{$source_title}" src="/img/ai/{$logo}"></td>
</tr>
<tr>
<td  colspan="2"><h2>{$sub_title}</h2></td>
</tr>
</table>

<table border=0>
<tr>
<!-- Illustration and related links go here -->
<!-- Illustration -->
<td valign="top"><img alt="{$title}" src="/img/ill/{$img}">
<!-- Related Links -->
<table>
<tr><td align="center"><span class="related">[<a href="/">index</a>]</span></td></tr>
{section name=related loop=$rel_id}
<tr><td><span class="related">{$rel_source_title[related]}:<a alt="{$rel_sub_title[related]}" href="n{$rel_id[related]}.html"> {$rel_title[related]}</a></span></td></tr>
{sectionelse}
<tr><td colspan=2><span style="related">Cannot Jump to any Articles!</span></tr>
{/section}
</table>

<!-- End of related links -->
</td>
<td valign="top" width="100%">
{$body}
</td>
</tr>
</table>

<table>
<tr><td ><p>
<small><b>Keywords:</b></strong> {$keywords}</small>
</p></td></tr>
<tr><td><hr>
<p>All text &copy; 1986 Rob Swigart. "<a href="http://shop.barnesandnoble.com/booksearch/results.asp?WRD=Rob+Swigart&userid=669LGNJUBC ">Portal : A Dataspace Retrieval</a>" is available courtesy of the Author's Guild Backprint Programme. ISBN: 0595197841</p>
 
<p></p>All programming and software &copy; 2002 <a href="mailto:scf@spamcop.net">Salim Fadhley</a>. Released under the GPL. Code available on request.</p>

<p>Updated: {$english_date_updated}</p>
</p></td></tr>
</table>
</body>

</html>