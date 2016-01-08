<?
// Settings

$host_info["name"]="funsters";

function get_narrative_content( $content_id, $connection )
	{
	// Takes a content ID number and returns an array containing the content from that row.
	
	if ( !(is_null($content_id)))
		{
		// Define the query template
		$query = "select narrative.*, source.title as source_title, source.template, source.logo from narrative, source where narrative.id=$content_id and narrative.source_id=source.id";
		}
	else
		{
		die ("\nNo Content id.");
		}
	
	// Run the query
	if (!($rs0 = $connection->execute($query)))
		{
		die ("Failed to get Narrative Content id $content_id: <b>$query</b>");
		}
	
	$resultset=$rs0->GetAssoc(1);
	
	// Now fixup any items from that recordset that need to be fixed:
	
	$fixuplist=array(
				body=>1
					);
	
	// Special Values
	$final_result["keywords"]=find_keywords($resultset[$content_id]["body"]);
	$final_result["english_date_updated"]=ts_2_english($resultset[$content_id]["date_updated"]);
	
	foreach ($resultset[$content_id] as $item=>$value)
		{
		
		if ($fixuplist[$item]==1)
			{
			$final_result[$item]=fixup($value);
			}
		else
			{
			$final_result[$item]=$value;
			}
		}
	return $final_result;
	} 

function get_non_ai_content( $connection )
	{
	// Returns an odered list of the non-ai narratives
	// That means Prologues, Eplilogues and Narration.
	
	$query2 = "select narrative.*, source.title as source_title, source.template, source.logo from narrative, source where narrative.source_id=source.id and source.title='introduction' order by id";

	if (!($rs = $connection->execute($query2)))
		{
		die ("Failed to get List: <b>$query</b>");
		}
	
	$counter = 0;
	while ( ! ($rs->EOF)  )
		{
		
			foreach ($rs->fields as $fieldname=>$fieldvalue)
				{
				// Note rel_ is to distinguish from main content when we pump all of this
				// into smarty.
				$final_result[$fieldname][$counter]=$fieldvalue;
				}

		$rs->MoveNext();
        $counter ++;
		}
	
	return $final_result;
	
	}

function get_all_content( $connection )
	{
	// Returns a list of all content.
	
	$query2 = "select narrative.*, source.title as source_title, source.template, source.logo from narrative, source where narrative.source_id=source.id order by id";

	if (!($rs = $connection->execute($query2)))
		{
		die ("Failed to get List: <b>$query2</b>");
		}
	
	$counter = 0;
	while ( ! ($rs->EOF)  )
		{
		
			foreach ($rs->fields as $fieldname=>$fieldvalue)
				{
				// Note rel_ is to distinguish from main content when we pump all of this
				// into smarty.
				$final_result[$fieldname][$counter]=$fieldvalue;
				}

		$rs->MoveNext();
        $counter ++;
		}
	
	return $final_result;
	
	}

function get_affiliates( $connection )
	{
	// Returns a list of all content.
	
	$query2 = "select * from affiliate order by rank desc";

	if (!($rs = $connection->execute($query2)))
		{
		die ("Failed to get List: <b>$query2</b>");
		}
	
	$counter = 0;
	while ( ! ($rs->EOF)  )
		{
		
			foreach ($rs->fields as $fieldname=>$fieldvalue)
				{
				// Note rel_ is to distinguish from main content when we pump all of this
				// into smarty.
				$final_result["aff_".$fieldname][$counter]=$fieldvalue;
				}

		$rs->MoveNext();
        $counter ++;
		}
	
	return $final_result;
	
	}
	
function get_related_content( $content_id, $connection )
	{
		if ( !(is_null($content_id)))
		{
		
		}
	else
		{
		die ("\nNo Content id.");
		}
		
	// Try to find the back and next values.
	
	// Ugh, a hard coded variable
	$look_ahead = 8;
	$look_behind = 2;
	
	$min_id = $content_id - $look_behind;
	$max_id = $content_id + $look_ahead;
	
	// Define the query template
	$query2 = "select narrative.*, source.title as source_title, source.template, source.logo from narrative, source where narrative.source_id=source.id and narrative.id >= $min_id and narrative.id <= $max_id and narrative.id <> $content_id order by id";
		
	if (!($rs1 = $connection->execute($query2)))
		{
		die ("Failed to get Other Articles  $content_id: <b>$query2</b>");
		}
	
	$counter = 0;
	while ( ! ($rs1->EOF)  )
		{
		
			foreach ($rs1->fields as $fieldname=>$fieldvalue)
				{
				// Note rel_ is to distinguish from main content when we pump all of this
				// into smarty.
				$final_result["rel_".$fieldname][$counter]=$fieldvalue;
				}

		$rs1->MoveNext();
        $counter ++;
		}
	
	return $final_result;
	}
	
function fixup( $input )
	{
	$lines=preg_split("/\n/", $input);
	
	$patterns = array(
					 "/\"([`´\d\w,\s\.\?'!;:-]+)\"/",
					 "/\(([`´\d\w,\s\.\?'!;:-]+)\)/"
					);
					
	$replace = array(
					"\"<span class=\"quotes\">\\1</span>\"",
					"(<span class=\"brackets\">\\1</span>)"
					);
	
	foreach ($lines as $line_no=>$line)
		{
		$new_lines[$line_no] = "<p>".preg_replace($patterns, $replace, stripslashes($line))."</p>";
		}
	
	$output=implode("\n",$new_lines);
	
	return $output;
	}

function find_keywords ( $input )
	{
	$words = preg_split("/[%\d#\\/\•,\(\)\"\s':;\.\?-]+/i", stripslashes($input));
	
	foreach ($words as $word)
		{
		$word_count[strtolower($word)]++;
		}
	

	
	$common_words = array ( null, "a", "the", "he", "she", "is", "was", "they", "and", "as", "of", "with", "them", "too", "said", "in", "into", "that", "kind", "to", "I", "re", "", "said", "they", "for", "we", "it", "all", "then", "up", "no", "at", "be", "or", "no", "up", "it", "his", "her", "s", "t", "but", "what", "it", "this", "are", "there", "that", "our", "yes", "ve", "by", "on", "under", "not", "one", "two", "three", "four", 0, "0", "off", "had", "ll", "us", "when", "out", "you", "if", "m", "so", "am", "have", "its", "any", "an", "yet", "has", "d", "were", "once", "back", "very", "can", "say", "thing", "now", "over", "under", "behind", "came", "above", "below", "down", "can", "day", "saw", "him", "far", "near", "inside", "outside", "only", "which", "what", "when", "did", "do", "done", "way", "than", "means", "from", "for", "through", "more", "asked", "told", "let", "own", "why", "me", "my", "our", "put", "these", "after", "went", "tell", "set", "just", "still", "o", "called", "been", "could", "your", "know", "first", "many", "left" );
	
	foreach ($common_words as $common_word)
		{
		$word_count[strtolower($common_word)]=0;
		}
	
	asort($word_count);
	
	$biggest_first=array_reverse($word_count);

	// Now extract a list of the indexes.
	
	foreach ($biggest_first as $key=>$value)
		{
		if ($value>1)
			{
			$final_wordlist[]=$key;
			}
		}
	
	if (count ($final_wordlist) > 0 )
		{
		return(implode(", ", $final_wordlist));
		}
	else
		{
		return "";
		}
	}
	
function nodify($body_text)
   {
   $patterns = array (
                      "/\[g\[([\' \w]+)\]\]/",
                      "/\[g\[([\'\, \w]+)\|([\'\, \w]+)\]\]/",
                      "/\[([ \w]+)\]/",
                      "/\[([ \w]+)\|([ \w]+)\]/",
					  "/\[l\[([\'\, \w]+)\|([\/\-\\\.\'\, \w]+)\]\]/"
                      );

   $replace = array (
              "<a href=\"http://www.google.com/search?hl=en&q=\\1&btnG=Google+Search\">\\1</a>",
              "<a href=\"http://www.google.com/search?hl=en&q=\\2&btnG=Google+Search\">\\1</a>",
              "<a href=\"node.php?nodeshell_name=\\1\">\\1</a>",
              "<a href=\"node.php?nodeshell_name=\\1\">\\2</a>",
              "<a href=\"http://\\2\">\\1</a>"
              );

   $new_body= preg_replace ($patterns, $replace, stripslashes($body_text));

   return $new_body;
   }
   
// Converts MySQL timestamps into Unix Epoch numbers.
function revertTimeStamp($timestamp)
    {
    $year=substr($timestamp,0,4);
    $month=substr($timestamp,4,2);
    $day=substr($timestamp,6,2);
    $hour=substr($timestamp,8,2);
    $minute=substr($timestamp,10,2);
    $second=substr($timestamp,12,2);
    $newdate=mktime($hour,$minute,$second,$month,$day,$year);
    RETURN ($newdate);
    }

function EnglishDate($epoch)
         {
         $english_date=date("D M j Y",$epoch);
         return $english_date;
         }

function ts_2_english($timestamp)
         {
         $unix_date=revertTimeStamp($timestamp);
         return EnglishDate($unix_date);
         }


// Given a $host_string, this calculates the embedded name.
//
function calculate_name ( $hostname, $server_string )
         {

         $names= split('\.', $server_string, 10);

         foreach ($names as $key => $value)
                  {
                  if ($value == $hostname)
                      {
                      break;
                      }

                  if ($been_round_once)
                      {
                      $name .= " ";
                      }

                  $name .= ucfirst(strtolower( $value )); ;

                  $been_round_once=1;
                  }

         return $name;


         }

?>