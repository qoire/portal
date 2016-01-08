<?
include("../inc/adodb/adodb.inc.php");
//include("inc/login/login.inc.php")
include("../inc/functions.inc.php");
include("../inc/config.inc.php");

// Form Processor Functions.
require("formproc.inc.php");

// Form Catalog
require("formproc.catalogue.php");

//require("inc/smarty/Smarty.class.php");

// Form Processor:
// Main Script.

// *************** No User configurable options below this line!
//
//
// DOnT M3S5

// Identify and include the code required for the current form.
if ( ! (isset($f_include[$_GET["form"]]["config"])))
	{
	}
	else
	{
	// We know of this form so lets try to include it.
	require($f_include[$_GET["form"]]["config"]);
	}

// Identify mode

switch ($_GET["action"])
	{
	// List all records in the chosen table.
	case "list":
	formproc_includstyle();
	formproc_form_menu($f_include, $_GET["form"]);
	
	echo "<strong>List: ".$f_include[$_GET["form"]]["title"]."</strong>";
	
	$Admin = new Formproc($f_sql, $f_items, $f_tpl, $connection[0], $_GET["form"] );
	
	$Admin->listall($_GET["orderby"], $_GET["page"], $_GET["desc"]);
	$Admin->button_helper_functions();
	$Admin->license();
	break;
	
	case "edit":
	formproc_includstyle();
	formproc_form_menu($f_include, $_GET["form"]);
	echo "<strong>Editing: ".$f_include[$_GET["form"]]["title"]."</strong>";
	$Admin = new Formproc($f_sql, $f_items, $f_tpl, $connection[0], $_GET["form"] );
	
	$Admin->showform($_GET["id"] );
	break;
	
	case "submit":
	formproc_includstyle();
	formproc_form_menu($f_include, $_GET["form"]);
	echo "<strong>Submit: ".$f_include[$_GET["form"]]["title"]."</strong>";
	$Admin = new Formproc($f_sql, $f_items, $f_tpl, $connection[0], $_GET["form"] );
	$Admin->submit();
	break;
	
	case "confirm":
	formproc_includstyle();
	formproc_form_menu($f_include, $_GET["form"]);
	echo "<strong>Confirm: ".$f_include[$_GET["form"]]["title"]."</strong>";
	$Admin = new Formproc($f_sql, $f_items, $f_tpl, $connection[0], $_GET["form"] );
	$Admin->confirm();
	$Admin->view($_GET["id"]);
	break;
	
	case "view":
	formproc_includstyle();
	formproc_form_menu($f_include, $_GET["form"]);
	echo "<strong>View: ".$f_include[$_GET["form"]]["title"]."</strong>";
	$Admin = new Formproc($f_sql, $f_items, $f_tpl, $connection[0], $_GET["form"] );
	$Admin->view($_GET["id"]);
	break;
	
	case "create":
	formproc_includstyle();
	formproc_form_menu($f_include, $_GET["form"]);
	echo "<strong>List: ".$f_include[$_GET["form"]]["title"]."</strong>";
	$Admin = new Formproc($f_sql, $f_items, $f_tpl, $connection[0], $_GET["form"] );
	$new_id = $Admin->create_new();
	$Admin->showform($new_id);
	break;
	
	case "delete":
	// Deletes a new record and then re-directs to the list page.
	$Admin = new Formproc($f_sql, $f_items, $f_tpl, $connection[0], $_GET["form"] );
	$Admin->delete_record($_GET["id"]);
	break;
	
	case "":
	default:
	formproc_includstyle();
	formproc_form_menu($f_include, $_GET["form"]);
	break;

	}



?>
