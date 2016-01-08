<?
// Function collection for Form Processor.

class Formproc
{

// Runtime Variables
var $f_sql; // Collection of SQL queries
var $f_items; // List of items in the thing we are modifying.
var $connection; // ADODB connection class we are going to use.
var $form_name; // Current form name - used to make things pretty
var $f_tpl; // Templates

// Button Related
var $button_counter=0;
var $button_helptext; // Assoc Array of helpfull comments.
var $button_mouseover;
var $button_mouseout;
var $button_caption;

// Version information
var $version="0.1"; // Version ID.
var $versionstatus="alpha"; // Version ID.
var $progname="Form Processor"; // Program Name.
var $author="Salim Fadhley"; // The creator of this wonderous class
var $authors_email="scf@spamcop.net"; // and how to contact him.
var $authors_organisation="The Stodge Organisation"; // Who he works for
var $authors_site="http://blog.stodge.org";

function Formproc($f_sql, $f_items, $f_tpl, $connection, $form_name)
	{
	// Constructor
	
	// Definition of fields that must not be null.
	$required["f_sql"]="List of SQL Templates";
	$required["f_items"]="Definition of items in this form";
	$required["f_tpl"]="Definition form templates.";
	$required["connection"]="ADODB Connection object";
	$required["form_name"]="Form Name";
	
	foreach ($required as $key=>$value)
		{
		if (is_null($$key))
			{
			die ("Could not initialise Formproc - missing data: ".$value);
			}
			else
			{
			$this->$key=$$key;
			}
		}
		

	//echo ("The form is called:".$this->form_name);
	}

function submit()
	{	
	
		$number_of_rowstyles=0;
	
		foreach($this->f_tpl["rowclass"] as $key=>$classname)
		{
		$rowclass[$number_of_rowstyles]=$classname;
		$number_of_rowstyles++;
		}
	
	// To avoid a division by 0
	if ($number_of_rowstyles==0)
		{
		$number_of_rowstyles=1;
		$rowclass[0]="row0";
		}
	
	// Display values so that the user can confirm submit.
	//phpinfo();
	
	// Find the primary key and it's value
	foreach ($this->f_items as $item=>$params)
		{
		if ($params["pri-key"]==1)
			{
			// We have found the primary key:
			
			$primary_key_value=$_POST[$item];
			
			}
		}
		
	?><table cellspacing="0" cellpadding="2" class="report"><form method="post" action="formproc.php?form=<?=$this->form_name?>&action=confirm&id=<?=$primary_key_value?>">
	<?
	$counter=0;
	foreach ($this->f_items as $item=>$params)
		{
		echo "\n\n<!--$item ".$params["style"]." -->\n";
		switch ($params["style"])
			{
			case "option":
				// We have to look up the options's value.
				
				// Values come from an SQL query, but first we need to form the query from the template.
				
				// Clear the holders.
				$match=null;
				$replace=null;
				
				$match[]="/%%id%%/";
				$replace[]=$params["opt_key"];
				
				$match[]="/%%title%%/";
				$replace[]=$params["opt_val"];
				
				$match[]="/%%table%%/";
				$replace[]=$params["table"];
				
				$match[]="/%%index%%/";
				$replace[]=$_POST[$item];
				
				$query=preg_replace($match, $replace, $params["lookup"]);
				$rs3=$this->connection->execute($query);
				
				if ($rs3 == null)
					{
					die ("Could not list options for $item q=".$query );
					}
		
				$lookup_result=$rs3->fields[$params["opt_val"]];
				
				echo "<tr class=\"".$rowclass[$counter % $number_of_rowstyles]."\"><td valign=\"top\" align=\"right\">".$params["title"].":</td><td>[<b>".$lookup_result."</b>]<input type=\"hidden\" name=\"".$item."\" value=\"".$_POST[$item]."\"></td></tr>";
				
				break;
			
			case "selectimg":
				echo "<tr class=\"".$rowclass[$counter % $number_of_rowstyles]."\"><td valign=\"top\" align=\"right\">".$params["title"].":</td><td><img src=\"".$params["baseurl"].$_POST[$item]."\"><input type=\"hidden\" name=\"".$item."\" value=\"".$_POST[$item]."\"></td></tr>";
			break;
			
			case "explain":
				// We dont bother with these.
			
			case "boolean":
				// If a boolean is not checked then the value will not be passed.
				// So if it is not defined, then we must initialise it with the value 0.
				
				if (is_null($_POST[$item]))
					{
					$_POST[$item]=0;
					}
				
				echo "<tr class=\"".$rowclass[$counter % $number_of_rowstyles]."\"><td valign=\"top\" align=\"right\">".$params["title"].":</td><td width=\"600\"><b>".$params[$_POST[$item]]."</b>";
				echo "<input type=\"hidden\" name=\"".$item."\" value=\"".$_POST[$item]."\">";
				echo "</td></tr>";
				break;
					
			case "textarea":
			case "input":
			case "static":
				
				if (is_null($params["transform"]))
					{
					$textarea_text = $_POST[$item];
					}
				else
					{
					$transform_function = $params["transform"];
					$textarea_text=$transform_function($_POST[$item]);
					}
				
				echo "<tr class=\"".$rowclass[$counter % $number_of_rowstyles]."\"><td valign=\"top\" align=\"right\">".$params["title"].":</td><td width=\"600\">".((stripslashes($textarea_text)));
				echo "\n\n<input type=\"hidden\" name=\"".$item."\" value=\"".urlencode(stripslashes($_POST[$item]))."\">\n\n";
				echo "</td></tr>";
				break;
				
			case "hidden":
				echo "<input type=\"hidden\" name=\"".$item."\" value=\"".$_POST[$item]."\">";
				break;
			}
		$counter ++ ;
		}
	?>
	<tr><td align=\"right\">&nbsp;</td><td><input name="submit" value="submit" type="submit"></td></tr>
	
	</form></table><?
	
	}
	
function showform($key_val)
	{
	// This block works out what colours are available for each row.
	$number_of_rowstyles=0;
	
		foreach($this->f_tpl["rowclass"] as $key=>$classname)
		{
		$rowclass[$number_of_rowstyles]=$classname;
		$number_of_rowstyles++;
		}
	
	// To avoid a division by 0
	if ($number_of_rowstyles==0)
		{
		$number_of_rowstyles=1;
		$rowclass[0]="row0";
		}
	
	// Work out what page we are on
	// If no page is defined then we are on page 0.
	
	if (!( isset($form_page)))
		{
		// Form page is not set, so assume 0.
		$form_page=0;
		}
	else
		{
		// Form page is set, so it should contain a number.
		// Later on, add some code to check that it is numeric.
		}
	
	// If this is the first page then we need to run a query:
	
	if ($form_page==0)
		{
		// Form the query from the template.
	
		// First we have to identify the primary key.
	
		foreach ($this->f_items as $item=>$value)
			{
			// Is it a primary key?
			if ($value["pri-key"]==1)
				{
				// Yes it is
				
				// Primary Key Name
				$match[]="/%%primary%%/";
				$replace[]=$item;
				
				// Primary Key Value
				$match[]="/%%id%%/";
				$replace[]=$key_val;
								
				echo "<!--Found Pri-Key $item = $key_val -->";
				break;
				}
			}
			// Substitute the values into the query template.
			$query= preg_replace($match, $replace, $this->f_sql["select_one"]);
			
			// And now run the query!
			$rs=$this->connection->execute($query);
			
			
		}
	// Step through the items creating the headings and fields in a table.
	// Table Header
	echo "<table cellspacing=0 class=\"report\">";
	?><form method="post" action="formproc.php?action=submit&form=<?=$this->form_name ?>&id=<?=$key_val ?>"><?
	
	// We will use this counter to count the number
	// of rows we have been through. 
	$counter = 0;
	foreach ($this->f_items as $item=>$params)
		{
		$rowstyle=$rowclass[$counter % $number_of_rowstyles];
		
		// echo "<!--Found Item: Item= ".$item." Type= ".$params["style"]." -->";
		switch ($params["style"])
			{
			case "input":
				// Display a Single line text entry box.
				echo "<tr class=\"$rowstyle\"><td align=\"right\">".$params["title"].":</td>";
				echo "<td><input type=\"text\" size=\"".$params["size"]."\" name=\"".$item."\" value=\"".stripslashes($rs->fields[$item])."\"></td></tr>";
				break;
			
			case "static":
				//Display a non-editable value.
				echo "<tr class=\"$rowstyle\"><td align=\"right\">".$params["title"].":</td><td>".$rs->fields[$item]."<input type=\"hidden\" name=\"".$item."\" value=\"".$rs->fields[$item]."\"></td></tr>";
				break;
			
			case "hidden":
				// A hiden value, display nothing.
				echo "<input type=\"hidden\" name=\"".$item."\" value=\"".$rs->fields[$item]."\">";
				break;
						
			case "boolean":
				// A checkbox.
				echo "<tr class=\"$rowstyle\"><td align=\"right\">".$params["title"].":</td>";
				echo "<td><input type=\"checkbox\" size=\"".$params["size"]."\" name=\"".$item."\" value=\"".stripslashes($rs->fields[$item])."\"";
				// Now determine if checked:
				if (($rs->fields[$item])==1)
					{
					echo " checked";
					}
				echo "></td></tr>";
				break;
			
			case "option":
				// Select a single option from a combo.
				echo "<tr class=\"$rowstyle\"><td align=\"right\">".$params["title"].":</td><td>";
				echo "\n<select name=\"".$item."\" >";
				// Print out list of options
				
				// Values come from an SQL query, but first we need to form the query from the template.
				
				// Clear the holders.
				$match=null;
				$replace=null;
				
				$match[]="/%%id%%/";
				$replace[]=$params["opt_key"];
				
				$match[]="/%%title%%/";
				$replace[]=$params["opt_val"];
				
				$match[]="/%%table%%/";
				$replace[]=$params["table"];

				$rs2=$this->connection->execute(preg_replace($match, $replace, $params["list"]));
				if ($rs2 == null)
					{
					die ("\n\nCould not list options for $item q=".$params["sql"]."\n\n");
					}
				// Step through the options
				while ( ! ($rs2->EOF)  )
					{
					echo "\n<option value=\"".$rs2->fields[$params["opt_key"]]."\"";
					
					// Is this selected?
					if ( $rs2->fields[$params["opt_key"]] == $rs->fields[$item] )
						{
						// This must be the selected value.
						echo " selected ";
						}

					echo ">";
					echo $rs2->fields[$params["opt_val"]];
					echo "</option>\n";
					$rs2->MoveNext();
					}
				
			
				echo "</select>\n";
				echo "</td></tr>";
				break;
			
			case "selectimg":
				// Select a single option from a combo.
				echo "\n\n\n<tr class=\"$rowstyle\"><td align=\"right\">".$params["title"].":</td><td>";
				echo "\n<select name=\"".$item."\" >";
			
				$file_list = array();
				
				if ($dir = @opendir($params["path"]))
					{
  					while (($file = readdir($dir)) !== false)
						{
    					if (preg_match("/[gif|jpg|png]$/i", $file))
							{
							echo "<option value=\"$file\"";
							
							if ($rs->fields[$item]==$file)
								{
								echo " selected";
								}
							
							echo ">";
							echo "$file";
							echo "</option>";
							
							}
  						}  
  					closedir($dir);
					}

				
				// End of select box
				echo "</select>\n";
				echo "</td></tr>";
				
				break;
			
			case "textarea":
				// Displays a bigger input text box.
				echo "<tr class=\"$rowstyle\"><td align=\"right\">".$params["title"].":</td>";
				echo "<td><textarea name=\"".$item."\" rows=\"".$params["rows"]."\" cols=\"".$params["cols"]."\">";
				echo $rs->fields[$item];
				echo "</textarea></td>";
				echo "</tr>";
				break;
			
			case "explain":
				// Displays body text
				echo "<tr class=\"$rowstyle\"><td></td><td>".$params["body"]."</td></tr>";
				break;
			
			}
		$counter++;
		}
	?>
	<tr><td></td><td><input type="submit" name="Submit" value="Submit">&nbsp;<input type="Reset"></td></tr>
	<?
	echo "</form>";
	echo "</table>";
	
	}
	
function listall ($order, $page, $desc)
	{

	// Work out the value of $current_page
	
	if (is_null($page))
		{
		// Page is null
		$current_page=0;
		}
	else
		{
		$current_page=$page;
		}
	// Now we know what page we need to look at.
	
	// If no orderby is specified then we need to find the default ordering.
	
	if (is_null($order))
		{
		// Okay, $order is null so we have to search for the default.
		
		foreach ($this->f_items as $item=>$property)
			{
			if ($property["orderby_default"]==1)
				{
				$order_by = $item;
				}
			
			if ($property["pri-key"]==1)
				{
				$primary_key_name = $item;
				}
			
			}
		// But what if we went through all that and couldnt find an order by string
		// ie. the user has forgotten to specify?
		// In that case we use the primary key. We have to order by something!
		
		if (is_null($order_by))
			{
			$order_by = $primary_key_name;
			}
		
		}
		else
			{
			// $order is not null
			$order_by = $order;
			}
	
	// Print out a create new option:
	
	// $tools contains the strings for the create, and filter 
	// buttons.
	$tools=$this->button("images/new.png", "images/mo/new.png", "formproc.php?action=create&form=".$this->form_name, "New ".$rs->fields[$item], "Create a new $this->form_name.");
	
	// Filtering is disabled.
	//$tools.=$this->button("images/filter.png", "images/mo/filter.png", "formproc.php?action=filter&form=".$this->form_name, "Filter ".$rs->fields[$item], "Filter the $this->form_name table.");

	$patterns[]="/%%tools%%/";
	$replace[]=$tools;
	
	// Now print out a table of results with the standard controls.
	
	// Substitute the field titles into the table header template.
	// First, start by assembling a substitution table.
	foreach ($this->f_items as $item=>$property)
		{
		$patterns[]="/%%".$item."%%/";
		if ($item==$order_by)
			{
			// Allready selected!
			if (is_null($desc))
				{
				$replace[]=
			"[<strong><a  href=\"formproc.php?form=".$this->form_name."&action=list&page=0&orderby=$item&desc=1\">".$property["title"]."</a></strong>]";
				}
			else
				{
				$replace[]=
			"[<strong><a  href=\"formproc.php?form=".$this->form_name."&action=list&page=0&orderby=$item\">".$property["title"]."</a></strong>]";
				}
			}
		else
			{
			// Not selected, so decide wether to default to an ascending or descending type sort.
			
			if ($property["sort_desc"]==1)
				{
				// Default is descending
				$replace[]=
			"[<a <a  href=\"formproc.php?form=".$this->form_name."&action=list&page=0&orderby=$item&desc=1\">".$property["title"]."</a>]";
				}
			else
				{
				// Default is not descending i.e. ascending.
				$replace[]=
			"[<a <a  href=\"formproc.php?form=".$this->form_name."&action=list&page=0&orderby=$item\">".$property["title"]."</a>]";
				}
			}	
		}
	// Write out a table header:
	echo "<table  border=1 class=\"report\" cellspacing=\"0\" cellpadding=\"1\">";
	
	// And then apply and print the reg-exp substutution.
	echo preg_replace($patterns, $replace, $this->f_tpl["header"]);
	
	// Free up patterns & Replace
	$patterns= null;
	$replace= null;
	
	// We need to substitute the orderby value into the listing query.
	$patterns[]="/%%orderby%%/";
	
	// Check if the order is descending, and if so modify the order by string accordingly!
	if ($desc==1)
		{
		$replace[]=$order_by." desc";
		}
	else
		{
		$replace[]=$order_by;
		}
	
	// Run the query.
	$query=preg_replace($patterns, $replace, $this->f_sql["select"]);
	
	// If a query has been defined (last minute sanity check).
	if (isset($query))
		{
		// Remember the PageExecute function is +1 biased wrt page number!
		
		$rs=$this->connection->PageExecute($query, $this->f_tpl["items_per_page"], $current_page + 1);
		if ($rs === false) die("Failed to run query: ".$query);
		}
	else
		{
		die("Query is null.");
		}
	
	// Free up patterns & Replace
	$patterns= null;
	$replace= null;
	
	$counter=0;
	$number_of_rowstyles=0;
	
	// This counter keeps track of the number of rows we have printed so far:
	// And builds up an array containing the names of the rowclasses we will use.
	foreach($this->f_tpl["rowclass"] as $key=>$classname)
		{
		$rowclass[$number_of_rowstyles]=$classname;
		$number_of_rowstyles++;
		}
	
	// To avoid a division by 0
	if ($number_of_rowstyles==0)
		{
		$number_of_rowstyles=1;
		$rowclass[0]="";
		}
	

	

	
	while (! $rs->EOF )
        {
		// Match the rowclass
		// So for example, if there are three rowstyles and we are on the 5th row.
		// 5 % 3 = 2 remainder
		// So it should select $rowclass[2]
		// So lets hope it was defined in $f_tpl!
	
		$patterns[]="/%%rowclass%%/";
		$replace[]=$rowclass[ $counter % $number_of_rowstyles ];
		// Substitute the field values into the table row template.
		
		// Now, start by by assembling a substitution table:
		
		foreach ($this->f_items as $item=>$property)
			{
			$patterns[]= "/%%".$item."%%/";
			
			if (is_null($property["transform"]))
				{
				$replace[]= $rs->fields[$item];
				}
			else
				{
				$replace[]= $property["transform"]($rs->fields[$item]);
				}

			// Is this item the primary key? If so, we use it to define the tools links.
			// Tools are Edit, Delete and Touch.
			
			if (1==$property["pri-key"])
				{
				// We have a primary key!
				$patterns[]="/%%edit%%/";
				$replace[]=	$this->button("images/edit.png", "images/mo/edit.png", "formproc.php?form=".$this->form_name."&action=edit&id=".$rs->fields[$item], "Edit ".$rs->fields[$item], "Edit this $this->form_name.");
				
				$patterns[]="/%%view%%/";
				$replace[]=	$this->button("images/view.png",  "images/mo/view.png", ("formproc.php?form=".$this->form_name."&action=view&id=".$rs->fields[$item]), "View ".$rs->fields[$item], "View this $this->form_name.");
				
				$patterns[]="/%%delete%%/";
				$replace[]= $this->button("images/delete.png",  "images/mo/delete.png",
				"javascript:deleterecord('".
								$this->form_name."', '".
								$item."','".
								$rs->fields[$item]."', '".
								$rs->fields[$property["title_lookup"]]."')", "Delete ".$rs->fields[$item], "Delete this $this->form_name..");
								
				$patterns[]="/%%touch%%/";
				$replace[]=$this->button("images/touch.png",  "images/mo/touch.png",
				"formproc.php?form=".$this->form_name."&action=touch",
				"Touch ".$rs->fields[$item], "Touch this $this->form_name.."
				);

				}
			}
			
		// And now apply the regexp replace to the template and then print it.
		
		echo preg_replace($patterns, $replace, $this->f_tpl["row"])."\n";
		
		$rs->MoveNext();
        $counter ++;
		
		// Free up patterns & replace
		$patterns= null;
		$replace= null;
		}
	
	// End of table
	echo "</table>";
	
	// Pager
	
	
	if ( ! ($rs->AtFirstPage() and $rs->AtLastPage() ) )
		{
		//We are not in a single page set.
		echo "\n\n<table border=0><tr>";
		
		// Back Link
		if (! ($rs-> AtFirstPage() ))
			{
			echo "\n<td>[<a href=\"formproc.php?form=";
			echo $this->form_name;
			echo "&action=list&page=";
			echo $current_page-1;
			echo "&orderby=$order_by\">";
			echo "Previous</a>]</td>";
			}
		// Current Page
		echo "<td>[Page $current_page]</td>";

		// Forwards link.
		if (! ($rs-> AtLastPage() ))
			{
			echo "\n<td>[<a href=\"formproc.php?form=";
			echo $this->form_name;
			echo "&action=list&page=";
			echo $current_page+1;
			echo "&orderby=$order_by\">";
			echo "Next</a>]</td>";
			}
		echo "</tr></table>";
		
		// Page Jumper

		?>
		<table>
		<tr>
		<td nowrap>
		<form method=get action="formproc.php">
		[Jump to: <input width="3" name="page" value="<?= $current_page ?>">]
		<input type=hidden name="action" value="list">
		<input type=hidden name="orderby" value="<?= $order_by ?>">
		<input type=hidden name="form" value="<?= $this->form_name ?>">
		</form>
		</td>
		</tr>
		</table>
		<?
		
		// Instant Edit

		?>
		<table>
		<tr>
		<td nowrap>
		<form method=get action="formproc.php">
		[Instant Edit: <input width="3" name="id" value="">]
		<input type=hidden name="action" value="edit">
		<input type=hidden name="form" value="<?= $this->form_name ?>">
		</form>
		</td>
		</tr>
		</table>
		<?
		}
	
	
	}
	

	


function confirm()
	{
	//phpinfo();
	// Writes the actual values to the database and displays a confirmation screen with some kind of feedback.
	
	// This function reads in all the values from f_items, and identifies all the records that do not
	// have nodbwrite.
	
	// We use the ADODB $conn->GetUpdateSQL($rs, $record) method
	// http://php.weblogs.com/adodb_manual#ex7
	
	$name_value_pairs = "";
	$counter = 0;
	
	foreach ($this->f_items as $item=>$params)
		{
		// Debug Code
		//echo "<!--Item is: $item -->";
		// First of all, if we have found the key, then do something special with it.
		if ($params["pri-key"]==1)
			{
			// This is a primary key.
			$match[]="/%%primary%%/";
			$replace[]=$item;
			
			$match[]="/%%id%%/";
			$replace[]=$_POST[$item];
			
			// Debug Code
			//echo "<!--ID is: $row_id -->";
			}
		else
			{
		
			if ($params["nodbwrite"]==1)
				{
				// We skip this value, because we have been
				// requested not to write it by config file.
				}
			else
				{
				// Build up pairs of names & values.
				
				// In SQL we need to seperate name-value pairs with commas.
				

				
				// See if this is a style of thingamy that needs to be written into the DB!
				switch ($params["style"])
					{
					// These are all styles that must be written back to the DB.
					case "option":
					case "input":
					case "boolean":
					case "textarea":
					case "selectimg":
						// That was simple, 
						// All we are doing is building up an associative array of the values we want to keep
						// Remember that we have allready ID'd the primary key and it's value earlier.
						
						// Check if this item has "write_null" set, that is used typically for timestamps that
						// are set automatically by the database, otherwise just write the value.
						
						if (!($params["write_null"]==1))
							{
							$new_record[$item]=urldecode($_POST[$item]);
							}
						else
							{
							$new_record[$item]="";
							}

						break;
					case "static":
					case "hidden":
					case "explain":
					// These styles are never written back to the db.

					}
				}
			}
		}
	
	$query = preg_replace($match, $replace, $this->f_sql["select_one"]);
	
	// Run the query:
	
	if ($rs3=$this->connection->execute($query))
		{
		Echo "<!--Query Okay: $query -->";
		}
	else
		{
		die ("<b>Warning</b> - Update failed for $query");
		}
	// Generate update SQL
	$updateSQL = $this->connection->GetUpdateSQL($rs3, $new_record);

	// Now execute the update SQL
	$this->connection -> execute($updateSQL);
	
	}
	
function view($primary_key_value)
	{
	
	foreach ($this->f_items as $item=>$params)
		{
		// Debug Code
		//echo "<!--Item is: $item -->";
		// First of all, if we have found the key, then do something special with it.
		
		if ($params["pri-key"]==1)
			{
			// This is a primary key.
			$match[]="/%%primary%%/";
			$replace[]=$item;
			
			// We need this later on for forming the re-edit link
			$row_id=$primary_key_value;
			
			$match[]="/%%id%%/";
			$replace[]=$row_id;
			}
		}
	
	// Run a query so that we have the current recordset.
	$query= preg_replace($match, $replace, $this->f_sql["select_one"]);
	
	// And now run the query!
	$rs=$this->connection->execute($query);

	// Now go through the items again in order to extend the substitution arrays - we will use these later to
	// make the final substution on the preview string.
	
	foreach ($this->f_items as $item=>$params)
		{
		$match[]="/%%$item%%/";
		$replace[]=$rs->fields["$item"];
		}
	
	// Display handy options.
	?>
	<table>
	<tr><td>[<a href="formproc.php?form=<?=$this->form_name ?>&id=<?=$row_id ?>&action=edit">Edit</a>]</td><td>[<a href="formproc.php?form=<?=$this->form_name ?>&action=list#id<?=$row_id ?>id">Browse <?=$this->form_name ?></a>]</td><td>[<a href="formproc.php?form=<?=$this->form_name ?>&action=create">Create another <?=$this->form_name ?></a>]</td></tr>
	</table>
	<?
		
	
	
	// The user can re-edit the data if they like, or view a list of similar entities in the database.
	
	// The user is shown a 800 x 300 preview of a page in an iFrame to show the results.
	
	// Prepare the preview URL
	
	$preview=preg_replace($match,$replace,$this->f_tpl["preview"]);
	?>
	<p>
	<IFRAME align="center" NAME="Preview" width="900" height="400" SRC="<?=$preview ?>">Preview requires Floating Frames.</IFRAME></p>
<p>800 x 600 preview: <a href="<?=$preview?>"><?=$preview?></a></p>
	<?
	
	}

function create_new ( )
	{
	$match=null;
	$replace=null;
	
	// Insert a new blank row according to defaults.
	
	// First of all, we need to find all the default values and composee an insert statment.
		
	foreach ($this->f_items as $item => $params)
		{
		//echo $item. " ". $params["pri-key"]."<br>";
		if ($params["pri-key"]==1)
			{
			//echo "Found the prmary: $item<br>";
			// We have found the primary key!
			$match[]="/%%primary%%/";
			$replace[]=$item;
			
			$match[]="/%%id%%/";
			$replace[]="-1";
			}
		else
			{
			if ( $params["nodbwrite"] != 1 )
				{
				switch ($params["style"])
					{
					case "input":
					case "option":
					case "textarea":
					case "boolean":
					// These styles have defaults set. 
				
					$defaults[$item]=$params["default"];
					break;
				
					case "title":
					case "explain":
					case "static":
					case "hidden":
					// For now we do not set defaults on these values.
					}
				}
			}
		}
	// buld the matching strings
	
	// Substitute the variables into the template.
	$query=preg_replace($match, $replace, $this->f_sql["select_one"]);
	$rs= $this->connection->execute($query);
	
	$insertSQL = $this->connection->GetInsertSQL($rs, $defaults);
	
	$rs2 = $this->connection->execute($insertSQL);
	
	$new_row = $this->connection->Insert_ID( );
	
	// Now return the id of the row we just created.
	return $new_row;
	}
	
function delete_record($to_be_deleted)
	{
	$match=null;
	$replace=null;
	
	// Deletes a row

	foreach ($this->f_items as $item => $params)
		{
		//echo $item. " ". $params["pri-key"]."<br>";
		if ($params["pri-key"]==1)
			{
			//echo "Found the prmary: $item<br>";
			// We have found the primary key!
			$match[]="/%%primary%%/";
			$replace[]=$item;
			
			$match[]="/%%id%%/";
			$replace[]=$to_be_deleted;
			}

		}
	// buld the matching strings
	
	// Substitute the variables into the template.
	$query=preg_replace($match, $replace, $this->f_sql["delete"]);
	$rs= $this->connection->execute($query);
	header("Location: formproc.php?form=".$this->form_name."&action=list"); 
	}
	

function button_helper_functions()
	{
	?>
	<div name="overDiv" id="overDiv" style="z-index:110;position:absolute;">&nbsp;</div>
	
	<script language="javascript" src="overlib.js"></script>
	<script language=javascript>

function button_m_out( button_id )
	{
	// This will hold our list of objects
	buttonlist=new Array();
	// This will be the name of the object we tinker with.
	button_name="button_"+button_id;
	
	<?
	foreach ($this->button_helptext as $key => $helptext)
		{
		$caption = $this->button_caption[$key];
		$over 	= $this->button_mouseover[$key];
		
		echo "\nbuttonlist[ $key ] = new Array(\"".$helptext."\",\"$caption\",\"$over\");";
		}
	?>
	//alert(button_name+".src='"+buttonlist[ button_id ][2]+"'");
	eval(""+button_name+".src='"+buttonlist[ button_id ][2]+"'");

	}

function button_m_over( button_id )
	{
	// This will hold our list of objects
	buttonlist=new Array();
	// This will be the name of the object we tinker with.
	button_name="button_"+button_id;
	
	<?
	foreach ($this->button_helptext as $key => $helptext)
		{
		$caption = $this->button_caption[$key];
		$over 	= $this->button_mouseout[$key];
		
		echo "\nbuttonlist[ $key ] = new Array(\"".$helptext."\",\"$caption\",\"$over\");";
		}
	?>
	//alert(button_name+".src='"+buttonlist[ button_id ][2]+"'");
	eval(button_name+".src='"+buttonlist[ button_id ][2]+"'");

	}
	
function deleterecord(form_name, key_name, key_value, record_title)
	{
	var rows=new Array();
	
	// From PHP, generate 
	
	if ( confirm ("Do you want to delete \""+record_title+"\" ( "+key_name+"="+key_value+" ) ?") )
		{
		window.location="formproc.php?action=delete&form="+form_name+"&id="+key_value;
		}
	}

</script>
	<?
	}
	
function button($normal_img, $mouseover_img, $url, $caption, $helptext)
	{
	
	$chumpo = "<a onmouseout=\"javascript:button_m_over(".$this->button_counter.");\" onmouseover=\"javascript:button_m_out(".$this->button_counter.");\"";

	$chumpo .= " href=\"".$url."\"><img id=\"button_".$this->button_counter."\" src=\"".$normal_img."\" border=\"0\"></a>";
	
	
	$this->button_helptext[$this->button_counter]=$helptext;
	$this->button_mouseover[$this->button_counter]=$mouseover_img;
	$this->button_mouseout[$this->button_counter]=$normal_img;
	$this->button_caption[$this->button_counter]=$caption;
	
	// Increment the button counter so we do not use this number again.
	$this->button_counter ++ ;

	return $chumpo;
	}

function license()
	{
	echo "<table><tr><td>".$this->progname." version ".$this->version.$this->versionstatus." by <a href=\"$this->authors_email\">$this->author</a></smaller></td></tr></table><smaller>";
	}

// End of Class
}

function formproc_form_menu($f_include, $current_form)
	{
	echo "<table cellpadding=\"0\" cellspacing=\"0\" width=100%><tr>";
	
	echo "<td  >Menu: [<a href=\"formproc.php\">Main</a>]</td>";
	
	foreach ($f_include as $formname => $params)
		{
		if ($current_form == $formname)
			{
			echo "<td bgcolor=\"#eeeeee\" align= \"center\"><strong>[<a href=\"formproc.php?form=".$formname."&action=list\">".$params["title"]."</a>]</strong></td>";
			}
		else
			{
			echo "<td align= \"center\" bgcolor=\"#dddddd\" >[<a href=\"formproc.php?form=".$formname."&action=list\">".$params["title"]."</a>]</td>";
			}
		}
	echo "</tr></table>";
	}
	
function formproc_includstyle()
	{
	// Writes a header.
	?>
	<head>
	<meta name="robots" content="noindex, nofollow">
	<link title="Our Style" rel=stylesheet href="style.css"
type="text/css">
	</head>
	<body leftmargin=2 topmargin=2 rightmargin=2 marginheight=2 marginwidth=2>
	<!--
	<script>
	function button_m_out( button_id )
		{
		// Dummy Function	
		}
	function button_m_over( button_id )
		{
		// Dummy Function	
		}
	</script>
	-->
	<?
	}
	
?>