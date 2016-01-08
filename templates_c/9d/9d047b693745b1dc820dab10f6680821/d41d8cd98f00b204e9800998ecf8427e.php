<?php /* Smarty version 1.5.1, created on 2003-01-28 21:42:08
         compiled from chapters.tpl */ ?>
<html>
<head>
<title>Portal: A Dataspace Retrieval</title>
<meta name="Fiction, Interactive, Sci, Fi, Cyberpunk">
<META NAME="ROBOTS" CONTENT="index, follow">
<link title="Our Style" rel=stylesheet href="/style.css" type="text/css">
<META NAME="author" CONTENT="Rob Swigart">
<META NAME="author" CONTENT="Salim Fadhley">
<META NAME="revisit-after" CONTENT="60 days">
</head>
<body>

<table>

<tr>
<td valign="top"><img alt="Portal: A Dataspace Retrieval" src="img/pdr.jpg"></td>

<td valign="top">
<h1>Portal: A Dataspace Retrieval</h1>
<small>
<p>Originally published as an interactive novel on computer disk in 1986, Portal is the story of an astronaut who returns to earth from a mysteriously aborted mission prematurely awakened from suspended animation. One hundred years have passed; animals and plants thrive, cities stand intact. Every human being however has disappeared.</p>

<p>With the help of a slowly-reviving computer network, the astronaut begins to piece together the events of the last century. He learns of the child prodigy Peter Devore, of a world orchestrated by stunning new technologies, and of Peter's race against time to unlock the secrets of the Portal.</p></small>
<h2>Index</h2>
<table>
<?php if (isset($this->_sections["chapters"])) unset($this->_sections["chapters"]);
$this->_sections["chapters"]['name'] = "chapters";
$this->_sections["chapters"]['loop'] = is_array($this->_tpl_vars['id']) ? count($this->_tpl_vars['id']) : max(0, (int)$this->_tpl_vars['id']);
$this->_sections["chapters"]['show'] = true;
$this->_sections["chapters"]['max'] = $this->_sections["chapters"]['loop'];
$this->_sections["chapters"]['step'] = 1;
$this->_sections["chapters"]['start'] = $this->_sections["chapters"]['step'] > 0 ? 0 : $this->_sections["chapters"]['loop']-1;
if ($this->_sections["chapters"]['show']) {
    $this->_sections["chapters"]['total'] = min(ceil(($this->_sections["chapters"]['step'] > 0 ? $this->_sections["chapters"]['loop'] - $this->_sections["chapters"]['start'] : $this->_sections["chapters"]['start']+1)/abs($this->_sections["chapters"]['step'])), $this->_sections["chapters"]['max']);
    if ($this->_sections["chapters"]['total'] == 0)
        $this->_sections["chapters"]['show'] = false;
} else
    $this->_sections["chapters"]['total'] = 0;
if ($this->_sections["chapters"]['show']):

            for ($this->_sections["chapters"]['index'] = $this->_sections["chapters"]['start'], $this->_sections["chapters"]['iteration'] = 1;
                 $this->_sections["chapters"]['iteration'] <= $this->_sections["chapters"]['total'];
                 $this->_sections["chapters"]['index'] += $this->_sections["chapters"]['step'], $this->_sections["chapters"]['iteration']++):
$this->_sections["chapters"]['rownum'] = $this->_sections["chapters"]['iteration'];
$this->_sections["chapters"]['index_prev'] = $this->_sections["chapters"]['index'] - $this->_sections["chapters"]['step'];
$this->_sections["chapters"]['index_next'] = $this->_sections["chapters"]['index'] + $this->_sections["chapters"]['step'];
$this->_sections["chapters"]['first']      = ($this->_sections["chapters"]['iteration'] == 1);
$this->_sections["chapters"]['last']       = ($this->_sections["chapters"]['iteration'] == $this->_sections["chapters"]['total']);
?>
<tr><td><span class="related"><a alt="" href="n<?php echo $this->_tpl_vars['id'][$this->_sections['chapters']['index']]; ?>
.html"> <?php echo $this->_tpl_vars['title'][$this->_sections['chapters']['index']]; ?>
</a> <?php echo $this->_tpl_vars['sub_title'][$this->_sections['chapters']['index']]; ?>
</span></td></tr>
<?php endfor; else: ?>
<tr><td><span style="related">No Narratives found, this menu is broken!</span></tr>
<?php endif; ?>
</table>

</td>
</tr>

</table>

<table>
<tr><td>
<strong>Affiliates, Bloggers and Linkers</strong>: This site has been 
re-hosted on a <a href="http://deskforce.stodge.org">Deskforce</a> 
web-server. We finally have big bandwidth!</tr></td>
<tr><td>
<span class="related"> These sites are friends or	 have kindly linked to us: </span><?php if (isset($this->_sections["affiliates"])) unset($this->_sections["affiliates"]);
$this->_sections["affiliates"]['name'] = "affiliates";
$this->_sections["affiliates"]['loop'] = is_array($this->_tpl_vars['aff_id']) ? count($this->_tpl_vars['aff_id']) : max(0, (int)$this->_tpl_vars['aff_id']);
$this->_sections["affiliates"]['show'] = true;
$this->_sections["affiliates"]['max'] = $this->_sections["affiliates"]['loop'];
$this->_sections["affiliates"]['step'] = 1;
$this->_sections["affiliates"]['start'] = $this->_sections["affiliates"]['step'] > 0 ? 0 : $this->_sections["affiliates"]['loop']-1;
if ($this->_sections["affiliates"]['show']) {
    $this->_sections["affiliates"]['total'] = min(ceil(($this->_sections["affiliates"]['step'] > 0 ? $this->_sections["affiliates"]['loop'] - $this->_sections["affiliates"]['start'] : $this->_sections["affiliates"]['start']+1)/abs($this->_sections["affiliates"]['step'])), $this->_sections["affiliates"]['max']);
    if ($this->_sections["affiliates"]['total'] == 0)
        $this->_sections["affiliates"]['show'] = false;
} else
    $this->_sections["affiliates"]['total'] = 0;
if ($this->_sections["affiliates"]['show']):

            for ($this->_sections["affiliates"]['index'] = $this->_sections["affiliates"]['start'], $this->_sections["affiliates"]['iteration'] = 1;
                 $this->_sections["affiliates"]['iteration'] <= $this->_sections["affiliates"]['total'];
                 $this->_sections["affiliates"]['index'] += $this->_sections["affiliates"]['step'], $this->_sections["affiliates"]['iteration']++):
$this->_sections["affiliates"]['rownum'] = $this->_sections["affiliates"]['iteration'];
$this->_sections["affiliates"]['index_prev'] = $this->_sections["affiliates"]['index'] - $this->_sections["affiliates"]['step'];
$this->_sections["affiliates"]['index_next'] = $this->_sections["affiliates"]['index'] + $this->_sections["affiliates"]['step'];
$this->_sections["affiliates"]['first']      = ($this->_sections["affiliates"]['iteration'] == 1);
$this->_sections["affiliates"]['last']       = ($this->_sections["affiliates"]['iteration'] == $this->_sections["affiliates"]['total']);
?>
<span class="related">[<a href="<?php echo $this->_tpl_vars['aff_url'][$this->_sections['affiliates']['index']]; ?>
"><?php echo $this->_tpl_vars['aff_title'][$this->_sections['affiliates']['index']]; ?>
</a>] </span>
<?php endfor; else: ?>
<span style="related">Email <a href="mailto:scf@spamcop.net">scf@spamcop.net</a> to get yourself on the list of affilites.</span></tr>
<?php endif; ?>
</td></tr></table>

<table>
<tr>
<td><hr>
<p>All text &copy; 1986 Rob Swiggart. "<a href="http://shop.barnesandnoble.com/booksearch/results.asp?WRD=Rob+Swigart&userid=669LGNJUBC ">Portal : A Dataspace Retrieval</a>" is available courtesy of the Author's Guild Backprint Programme.</p>
 
<p></p>All programming and software &copy; 2002 <a href="mailto:scf@spamcop.net">Salim Fadhley</a>. Released under the GPL. Code available on request.</p>

</p></td></tr>
</table>
</body>

</html>
