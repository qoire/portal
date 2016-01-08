<?
$table_name="narrative";

// The main SQL queries that will drive this form.
$f_sql["select"]="select $table_name.*, LEFT($table_name.body, 100) as body_left, RIGHT($table_name.body, 100) as body_right,  source.title as source_id from $table_name, source where $table_name.source_id = source.id order by %%orderby%%";
$f_sql["select_one"]="select * from $table_name where %%primary%%=%%id%%";
$f_sql["delete"]="delete from $table_name where %%primary%%=%%id%%";

// Type, Primary, Visiable, Writable, Subquery


// The pages of this form.

// The items on this form.
// L = List on listall 
// 0. Item title
// 1. type code can be text, textarea, option, hidden, static.
// 2. option can be an SQL Query or the length of the item.
// 3. 

$f_items["source_id"]=	array	(
								"page" 	=> 0,
								"title" => "Source",
								"style" => "option",
								"list"	=> "select %%id%%, %%title%% from %%table%% order by %%id%%",
								"lookup"=> "select %%title%% from %%table%% where %%id%%=%%index%% order by %%title%%",
								"opt_key" => "id",
								"opt_val" => "title",
								"table" => "source",
								"allownull" => 0, 
								"default" => 4,
								"type"		=> "number"
							);
						
$f_items["title"]=	array	( 	
								"page" 		=> 0,
								"title"		=>"Title",
								"style"		=>"input",
								"size"		=>80,
								"default"	=> "",
								"type"		=> "character"
							);
							
$f_items["sub_title"]=	array	( 	
								"page" 		=> 0,
								"title"		=>"Sub Title",
								"style"		=>"input",
								"size"		=>80,
								"default"	=> "",
								"type"		=> "character"
							);
							
$f_items["body"]=	array	(
								"page" 	=> 0,
								"title" => "Body Text",
								"style" => "textarea",
								"rows"	=> "10",
								"cols"	=> "80",
								"default" => "",
								"transform" => "fixup",
								"type"		=> "character"
							);
							


$f_items["img"]=	array	(
								"page" 	=> 0,
								"title" => "Illustration",
								"style" => "selectimg",
								"path" => "/var/www/html/portal/img/ill/",
								"baseurl" => "../img/ill/",
								"size"  => 80,
								"default"	=> "",
								"type"		=> "character"
							);
						
$f_items["id"]=		array	(
								"page"	=> 0,
								"orderby_default" => 1,
								"title" => "ID",
								"style" => "static",
								"pri-key" => 1,
								"type"		=> "number",
								"nodbwrite" => 1
							);
							
$f_items["body_left"]=		array	(
								"page"	=> 0,
								"title" => "ID",
								"style" => "hidden",
								"title_lookup" => "title",
								"type"		=> "number",
								"nodbwrite" => 1
							);
							
$f_items["date_updated"]=		array	(
								"page"	=> 0,
								"transform" => "ts_2_english",
								"title" => "Updated",
								"style" => "hidden",
								"sort_desc" => 1,
								"type"		=> "character",
								"nodbwrite" => 1
							);
							
$f_items["body_right"]=		array	(
								"page"	=> 0,
								"title" => "ID",
								"style" => "hidden",
								"pri-key" => 0,
								"type"		=> "number",
								"write_null" => 1
							);

// This is the header of a listing table. Use %% Values.
$f_tpl["header"]="<tr bgcolor=\"#eeeeee\" align=center><td> %%id%% </td><td>%%title%%</td><td>%%source_id%%<br>%%date_updated%%</td><td>%%tools%%</td></tr>	";

// Remember to include an id=\"id%%id%%\" in each row - this lets you jump back to the correct record in a list
// after making an edit.

// <a name=\"id%%id%%id\">

$f_tpl["row"]="\n\n<tr class=\"%%rowclass%%\"><td align=\"center\">%%id%%</td><td><a name=\"id%%id%%id\"><a href=\"../narr.php?id=%%id%%\">%%title%%</a><br><span class=\"lsample\">%%body_left%%</span><span class=\"dots\">...</span><span class=\"rsample\">%%body_right%%</span></td><td><small>%%source_id%%</small><br><small>%%date_updated%%</small></td><td align=\"right\" valign=\"top\">%%edit%%%%view%%%%delete%%</td></tr>";

// What page should I use to preview a completed entry (relative to formproc.php)? You can use %% codes.
$f_tpl["preview"]="../narr.php?id=%%id%%";

// Maximum number of items for page in a Listing
$f_tpl["items_per_page"]=15;

$f_tpl["rowclass"]=Array("row0", "row1", "row2");



?>
