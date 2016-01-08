<?
$table_name="source";

// The main SQL queries that will drive this form.
$f_sql["select"]="select $table_name.* from $table_name order by id";
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

$f_items["title"]=	array	( 	
								"page" 		=> 0,
								"title"		=>"Affiliate's Name",
								"style"		=>"input",
								"size"		=>80,
								"default"	=> "no title",
								"type"		=> "character"
							);
							
$f_items["url"]=	array	( 	
								"page" 		=> 0,
								"title"		=>"URL",
								"style"		=>"input",
								"size"		=>80,
								"default"	=> "http://",
								"type"		=> "character"
							);

$f_items["rank"]=	array	( 	
								"page" 		=> 0,
								"title"		=>"URL",
								"style"		=>"input",
								"size"		=>80,
								"default"	=> "http://",
								"type"		=> "number"
							);
							

$f_items["body"]=	array	(
								"page" 	=> 0,
								"title" => "Body Text",
								"style" => "textarea",
								"rows"	=> "3",
								"cols"	=> "80",
								"default" => "",
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

$f_tpl["header"]="<tr bgcolor=\"#eeeeee\"><td> %%id%% </td><td>%%title%%:%%url%%</td><td>%%rank%%</td><td>Tools</td></tr>";
$f_tpl["row"]="\n\n<tr bgcolor=\"#dddddd\"><td align=\"center\">%%id%%</td><td><a href=\"%%url%%\">%%title%%</a></td><td>%%function%%</td><td align=\"center\" >%%edit%%%%delete%%%%touch%%</td></tr>";
$f_tpl["preview"]="../index.php";

// Maximum number of items for page in a Listing
$f_tpl["items_per_page"]=20;

?>
