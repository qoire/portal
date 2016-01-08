<?
$table_name="department";

// The main SQL queries that will drive this form.
$f_sql["select"]="select * from $table_name order by title, active";
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
								"body"		=> "This form creates a new blog link",
								"type"		=> "character"
							);
							
$f_items["title"]=	array	( 	
								"page" 		=> 0,
								"title"		=>"Blog Title",
								"style"		=>"input",
								"size"		=>80,
								"default"	=> "no title",
								"type"		=> "character"
							);

							
$f_items["id"]=		array	(
								"page"	=> 0,
								"title" => "Article ID",
								"style" => "static",
								"pri-key" => 1,
								"title_lookup" => "title",
								"type"		=> "number",
								"nodbwrite" => 1
							);
							
$f_items["active"]=	array	(
								"page"		=> 0,
								"style"		=> "boolean",
								"title"		=> "Active Department",
								"type"		=> "number",
								0			=> "No.",
								1			=> "Yes."
							);

$f_tpl["header"]="<tr bgcolor=\"#eeeeee\"><td> %%id%% </td><td>%%title%%</td><td>%%active%%</td><td>Tools</td></tr>";
$f_tpl["row"]="<tr bgcolor=\"#dddddd\"><td align=\"center\">%%id%%</td><td>%%title%%</td><td>%%active%%</td><td align=\"center\" >%%edit%%%%delete%%%%touch%%</td></tr>";
$f_tpl["preview"]="../index.php";

?>
