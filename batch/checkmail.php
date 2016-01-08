<?

include("../inc/adodb/adodb.inc.php");
include("../inc/config.inc.php");


$mbox=imap_open('{localhost:143/imap}INBOX', 'blog', 'bl000g');
$headers = imap_headers ($mbox);
				
	if ($headers == false) 
		{
		echo "No headers found.<br>\n";
		} 
	else 
		{
	  	while (list ($key,$val) = each ($headers))
			{
			$msgnum = $key+1;
			$header = imap_header($mbox, $msgnum);
			
			$overview = imap_fetch_overview($mbox, $msgnum, 0);
			
			$result["date"]=$overview->date;
			$time=strtotime($date);
			$result["subject"] = $header->subject;

			$body=imap_8bit(imap_fetchbody($mbox, $msgnum,1));
			
			$patterns["body"]="/<body>(.*)<\/body>/";
			$patterns["url"]="/<url>(.*)<\/url>/";
			
			foreach ($patterns as $exp_name=>$reg_exp)
				{
				if (preg_match($reg_exp, $body))
					{
					// If there is at least one reg-expression match.
					preg_match_all ($reg_exp, $body, $matched_output , PREG_PATTERN_ORDER);
					$result[$exp_name]=$matched_output[0][0];
					}
				else
					{
					// Nowt
					}
				}

			
			echo "Subject: ";
			echo $result["subject"] . "<br>\n";
			
			echo "Date: ";
			echo $result["date"] . "<br>\n";
			
			echo "Body: ";
			echo $result["body"] . "<br>\n";
			
			echo "Url: ";
			echo $result["url"] . "<br>\n";
			
			if ( is_null($result["body"]) or is_null($result["url"]) or is_null($result["subject"]) )
				{
				// Do nothing
				}
			else
				{
				// Generate SQL
				$query1="insert into link (title, url, body, status) values ( \"".$result["subject"]."\",\"".$result["url"]."\",\"".$result["body"]."\",0 )";
				echo $query1."<br>";
				$rs = $connection[0]->execute($query1);
				
				// Clear variables
				$result = null; 
				
				// Now delete the email so we dont scan it again
				imap_delete($mbox, $msgnum);
				// Set the delete flag - this will cause the message to be
				// Expunged later.
				$delete= TRUE;
				}
			

			}
		}
	if($delete) 
		{
		imap_expunge($mbox);
		}
if ( ! (is_null($mbox)))
	{
	// If Mbox is not null, then try to close it.
	imap_close($mbox);
	}
?>