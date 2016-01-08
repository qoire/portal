<?
$table_name="source";

// The main SQL queries that will drive this form.
$f_sql["select"]="select $table_name.* from $table_name order by %%orderby%%";
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

$f_items["intro"]=	array	(
								"page"		=> 0,
								"style"		=> "explain",
								"body"		=> "This form describes one of the characters or voices in the story.",
								"type"		=> "character"
							);
							
$f_items["title"]=	array	( 	
								"page" 		=> 0,
								"title"		=>"Name of Source",
								"style"		=>"input",
								"size"		=>80,
								"default"	=> "no title",
								"type"		=> "character"
							);
$f_items["function"]=	array	(
								"page" 	=> 0,
								"title" => "Role of Source",
								"style" => "input",
								"size"  => 80,
								"default"	=> "http://",
								"type"		=> "character"
							);
							
$f_items["type"]=	array	(
								"page" 	=> 0,
								"title" => "Is an AI",
								"style" => "boolean",
								"default" => "1",
								"type"		=> "number"
							);

$f_items["logo"]=	array	(
								"page" 	=> 0,
								"title" => "Logo",
								"style" => "selectimg",
								"path" => "/var/www/html/portal/img/ai/",
								"baseurl" => "../img/ai/",
								"size"  => 80,
								"default"	=> "",
								"type"		=> "character"
							);
						
$f_items["id"]=		array	(
								"page"	=> 0,
								"title" => "ID",
								"style" => "static",
								"pri-key" => 1,
								"title_lookup" => "title",
								"type"		=> "number",
								"nodbwrite" => 1
							);
$f_tpl["rowclass"]=Array("row0", "row1", "row2");
$f_tpl["header"]="<tr bgcolor=\"#eeeeee\"><td> %%id%% </td><td>%%title%%:%%function%%</td><td>%%type%%</td><td align=\"right\" width=\"0%\">%%tools%%</td></tr>";
$f_tpl["row"]="\n\n<tr class=\"%%rowclass%%\"><td align=\"center\">%%id%%</td><td><a href=\"%%url%%\">%%title%%</a> %%function%%</td><td>%%type%%</td><td align=\"right\" width=\"0\">%%edit%%%%delete%%%%view%%</td></tr>";
$f_tpl["preview"]="../index.php";

// Maximum number of items for page in a Listing
$f_tpl["items_per_page"]=20;

?>
