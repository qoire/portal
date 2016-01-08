<?

case "selectimg":
			// Select a single option from a combo.
			echo "\n\n\n<tr class=\"$rowstyle\"><td align=\"right\">".$params["title"].":</td><td>";
			echo "\n<select name=\"".$item."\" >";
			
			$file_list = array();
			
			// Get a list of images in the specified folder.
			
			/*
			echo "<!--Image Path = ".$params["path"]." -->";
			
			
			if ($dir = @opendir("/tmp")) 
				{
  				while (($file = readdir($dir)) !== false)
				 	{

					if (preg_match("/gif$/", $file))
					{
					$file_list[]=$file;
					}
					else
					{
					
  					}  
 			@closedir($dir);
				}
				
			*/

				foreach ($file_list as $key=>$filename)
					{
					echo "<option value=\"$filename\">$filename</option>";
					}
				
				// End of select box
				echo "</select>\n";
				echo "</td></tr>";
				
    			}

			break;
			
			?>