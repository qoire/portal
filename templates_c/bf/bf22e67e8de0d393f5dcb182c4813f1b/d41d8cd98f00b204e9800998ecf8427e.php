<?php /* Smarty version 1.5.1, created on 2003-01-28 21:46:43
         compiled from standard.tpl */ ?>
<html>
<head>
<title><?php echo $this->_tpl_vars['source_title']; ?>
: <?php echo $this->_tpl_vars['title']; ?>
 - <?php echo $this->_tpl_vars['sub_title']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
">
<META NAME="ROBOTS" CONTENT="index, follow">
<META name="date" content="<?php echo $this->_tpl_vars['english_date_updated']; ?>
">
<META NAME="author" CONTENT="Rob Swigart">
<META NAME="author" CONTENT="Salim Fadhley">
<META NAME="revisit-after" CONTENT="60 days">
<link title="Our Style" rel=stylesheet href="/style.css" type="text/css">
</head>
<body>
<table width="100%" border=0>
<tr>
<td width="100%" ><h1><?php echo $this->_tpl_vars['title']; ?>
</h1></td>
<td rowspan=2 valign="top"><img alt="<?php echo $this->_tpl_vars['source_title']; ?>
" src="/img/ai/<?php echo $this->_tpl_vars['logo']; ?>
"></td>
</tr>
<tr>
<td  colspan="2"><h2><?php echo $this->_tpl_vars['sub_title']; ?>
</h2></td>
</tr>
</table>

<table border=0>
<tr>
<!-- Illustration and related links go here -->
<!-- Illustration -->
<td valign="top"><img alt="<?php echo $this->_tpl_vars['title']; ?>
" src="/img/ill/<?php echo $this->_tpl_vars['img']; ?>
">
<!-- Related Links -->
<table>
<tr><td align="center"><span class="related">[<a href="/">index</a>]</span></td></tr>
<?php if (isset($this->_sections["related"])) unset($this->_sections["related"]);
$this->_sections["related"]['name'] = "related";
$this->_sections["related"]['loop'] = is_array($this->_tpl_vars['rel_id']) ? count($this->_tpl_vars['rel_id']) : max(0, (int)$this->_tpl_vars['rel_id']);
$this->_sections["related"]['show'] = true;
$this->_sections["related"]['max'] = $this->_sections["related"]['loop'];
$this->_sections["related"]['step'] = 1;
$this->_sections["related"]['start'] = $this->_sections["related"]['step'] > 0 ? 0 : $this->_sections["related"]['loop']-1;
if ($this->_sections["related"]['show']) {
    $this->_sections["related"]['total'] = min(ceil(($this->_sections["related"]['step'] > 0 ? $this->_sections["related"]['loop'] - $this->_sections["related"]['start'] : $this->_sections["related"]['start']+1)/abs($this->_sections["related"]['step'])), $this->_sections["related"]['max']);
    if ($this->_sections["related"]['total'] == 0)
        $this->_sections["related"]['show'] = false;
} else
    $this->_sections["related"]['total'] = 0;
if ($this->_sections["related"]['show']):

            for ($this->_sections["related"]['index'] = $this->_sections["related"]['start'], $this->_sections["related"]['iteration'] = 1;
                 $this->_sections["related"]['iteration'] <= $this->_sections["related"]['total'];
                 $this->_sections["related"]['index'] += $this->_sections["related"]['step'], $this->_sections["related"]['iteration']++):
$this->_sections["related"]['rownum'] = $this->_sections["related"]['iteration'];
$this->_sections["related"]['index_prev'] = $this->_sections["related"]['index'] - $this->_sections["related"]['step'];
$this->_sections["related"]['index_next'] = $this->_sections["related"]['index'] + $this->_sections["related"]['step'];
$this->_sections["related"]['first']      = ($this->_sections["related"]['iteration'] == 1);
$this->_sections["related"]['last']       = ($this->_sections["related"]['iteration'] == $this->_sections["related"]['total']);
?>
<tr><td><span class="related"><?php echo $this->_tpl_vars['rel_source_title'][$this->_sections['related']['index']]; ?>
:<a alt="<?php echo $this->_tpl_vars['rel_sub_title'][$this->_sections['related']['index']]; ?>
" href="n<?php echo $this->_tpl_vars['rel_id'][$this->_sections['related']['index']]; ?>
.html"> <?php echo $this->_tpl_vars['rel_title'][$this->_sections['related']['index']]; ?>
</a></span></td></tr>
<?php endfor; else: ?>
<tr><td colspan=2><span style="related">Cannot Jump to any Articles!</span></tr>
<?php endif; ?>
</table>

<!-- End of related links -->
</td>
<td valign="top" width="100%">
<?php echo $this->_tpl_vars['body']; ?>

</td>
</tr>
</table>

<table>
<tr><td ><p>
<small><b>Keywords:</b></strong> <?php echo $this->_tpl_vars['keywords']; ?>
</small>
</p></td></tr>
<tr><td><hr>
<p>All text &copy; 1986 Rob Swigart. "<a href="http://shop.barnesandnoble.com/booksearch/results.asp?WRD=Rob+Swigart&userid=669LGNJUBC ">Portal : A Dataspace Retrieval</a>" is available courtesy of the Author's Guild Backprint Programme. ISBN: 0595197841</p>
 
<p></p>All programming and software &copy; 2002 <a href="mailto:scf@spamcop.net">Salim Fadhley</a>. Released under the GPL. Code available on request.</p>

<p>Updated: <?php echo $this->_tpl_vars['english_date_updated']; ?>
</p>
</p></td></tr>
</table>
</body>

</html>