<?

include("inc/adodb/adodb.inc.php");
include("inc/functions.inc.php");
include("inc/config.inc.php");
include("inc/smarty/Smarty.class.php");

// Get the narrative id!
$current_narrative_id=$_GET["id"];

// Retrieve an array that contains all the information about that Narrative.
$narrative=get_narrative_content($current_narrative_id, $connection[0] );
$related=get_related_content($current_narrative_id, $connection[0] );

// Write Document Headers

// Call Smarty
$smarty=new Smarty();

// Find keywords

// Assign all the variables from the associative array into the template.
foreach ($narrative as $key=>$value)
	{
	$smarty->assign($key, $value);
	
	}
	
foreach ($related as $key=>$value)
	{
	$smarty->assign($key, $value);
	}
// Display Content

$smarty->display($narrative["template"].".tpl");

// Include a footer

// 

// Close the connection.

foreach ($connection as $index => $handle)
	{
	$handle->close();
	}

$title=$narrative["title"];
//include("hitbox.php");
?>