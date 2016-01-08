<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/

#
# Note: testphplens.php and testtext.php are identical
#

error_reporting(63);
include_once('./phplens.inc.php');

session_start();
?>
<html>
<head>
	<title>Test phpLens Setup</title>
</head>

<body bgcolor=lightblue>
<h1>Test phpLens Setup</h1>
<p>If images are missing, then $PHPLENS_PATH in <i>phplens/config/phplens.config.inc.php</i> is wrong.</p>
<p>To enable dynamic editing, modify in the source code the $lens->dynEdit = 0; line to $lens->dynEdit = 1;</p>
<?php

/* 
 * This setup test retrieves data from an array so we don't have
 * so many database configuration errors to deal with.
 *
 * You might still get database connection errors because you
 * didn't configure PHPLENS_SESSION_* variables in 
 *           phplens/config/phplens.config.inc.php.
 */

$rt = array('FirstName','LastName','Num');
$r0 = array('John','Lim','1');
$r1 = array('Harry','Zee','2');
$r2 = array('Larry','Aaron','3');
$r3 = array('Baddy','Lim','4');
$r4 = array('John','Lee','5');
$r5 = array('Yee','Dee','16');
$rend = array('Last','Record','1000');

/* Create the 2 dimensional array */
$arr= array($r0,$r1,$r2,$r3,$r4,$r5,$r0,$r1,$r2,$r3,$r4,$r5,
	     //   $r0,$r1,$r2,$r3,$r4,$r5,$r0,$r1,$r2,$r3,$r4,$r5,
	     //   $r0,$r1,$r2,$r3,$r4,$r5,
			$r0,$r1,$r2,$r3,$r4,$r5,$rend);

/* load the 2D array into a text database */	
ADOLoadCode('text');
$db = &ADONewConnection();
if (empty($db)) die("Cannot create ADONewConnection");
if (!$db->PConnect($arr,false,array('1stName','Surname','ID'))) 
	print 'Error:'.$db->ErrorMsg();

/* 
 * The id is very important. 
 * All phpLens objects should have a different id 
 */
$id = 'text_test';
$lens = new PHPLens($id,$db,'select * from products');
if (empty($lens)) die("Cannot create lens object id=$id");

// always prevent dynamic editing for security reasons
$lens->dynEdit = 0;
$lens->Render();
$lens->Close();
include_once('./phplens-dynedit.inc.php');
$e = PHPLENS_DynEdit($lens);
if ($e) print $e->PrintV();
?>
<h3>Support</h3>
<p>For support goto the 
<a href=http://phplens.com/lens/lensforum/topics.php?id=1&name=Technical+Support+for+phpLens>phpLens support forums</a> or 
email 
<a href=mailto:support@phplens.com>support@phplens.com</a>.</p>
<h3>Links</h3><p> Try the <a href=gridbuilder/>Grid Builder</a>. 
Read the <a href=./help/>phpLens manual</a>.
Visit the <a href=http://phplens.com/>phpLens</a> Web site.</p>
<h3>Code</h3>
<pre>
<font color=darkgreen>/* 
 * This setup test retrieves data from an array so we don't have
 * so many database configuration errors to deal with.
 *
 * You might still get database connection errors because you
 * didn't configure PHPLENS_SESSION_* variables in 
 *           phplens/config/phplens.config.inc.php.
 */</font>

$rt = array('FirstName','LastName','Num');
$r0 = array('John','Lim','1');
$r1 = array('Harry','Zee','2');
$r2 = array('Larry','Aaron','3');
$r3 = array('Baddy','Lim','4');
$r4 = array('John','Lee','5');
$r5 = array('Yee','Dee','16');
$rend = array('Last','Record','1000');

<font color=darkgreen>/* Create the 2 dimensional array */</font>
$arr= array($r0,$r1,$r2,$r3,$r4,$r5,$r0,$r1,$r2,$r3,$r4,$r5,
	$r0,$r1,$r2,$r3,$r4,$r5,$r0,$r1,$r2,$r3,$r4,$r5,$rend);

<font color=darkgreen>/* load the 2D array into a text database */</font>
ADOLoadCode('text');
$db = &ADONewConnection();
if (empty($db)) die("Cannot create ADONewConnection");
if (!$db->PConnect($arr,false,array('1stName','Surname','ID'))) 
	print 'Error:'.$db->ErrorMsg();

<font color=darkgreen>/* 
 * The id is very important. 
 * All phpLens objects should have a different id 
 */</font>
$id = 'text_test';
$lens = new PHPLens($id,$db,'select * from products');
if (empty($lens)) die("Cannot create lens object id=$id");
$lens->Render();
</pre>
</body>
</html>
