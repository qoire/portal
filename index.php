<?

include("inc/adodb/adodb.inc.php");
include("inc/functions.inc.php");
include("inc/config.inc.php");
include("inc/smarty/Smarty.class.php");

// Get a list of content.
if ($_GET["list"]=="all")
	{
	$narrative=get_all_content( $connection[0] );
	}
else
	{
	$narrative=get_non_ai_content( $connection[0] );
	}

// Get the affiliates list.
$affiliate=get_affiliates( $connection[0] );
	
// Call Smarty
$smarty=new Smarty();

// Assign variables
foreach ($narrative as $key=>$value)
	{
	$smarty->assign($key, $value);
	}

// Affiliates
foreach ($affiliate as $key=>$value)
	{
	$smarty->assign($key, $value);
	}

// Display

$smarty->display("chapters.tpl");

$title="Index";
//include("hitbox.php");

// Close DB connections
foreach ($connection as $index => $handle)
	{
	$handle->close();
	}

?>