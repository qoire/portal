
			
			<?
				if($action=='refresh')
				{
					$mbox=imap_open('{fletch:143/imap}INBOX', 'andy', 'delphine');
					$headers = imap_headers ($mbox);
				
					if ($headers == false) 
					{
					    // echo "No headers found.<br>\n";
					} 
					else 
					{
					  while (list ($key,$val) = each ($headers))
						{
							$msgnum=$key+1;
							$header = imap_header($mbox, $msgnum);
							
							if (!(strpos($header->subject, 'YAC Voice Message from')===false))
							{
								$words = explode(' ', $header->subject);
								echo $header->subject;
								$number = 'unknown';
								
								// get the phone number
								foreach($words as $word)
								{
									if($lastword=='from'){ $number = $word; break; }
									$lastword = $word;
								}

								list($overview)=imap_fetch_overview($mbox, $msgnum, 0);
								$date=$overview->date;
								$time=strtotime($date);
								$data=imap_base64(imap_fetchbody($mbox, $msgnum, 2));
								
								$filename = $time.'_'.$number.'.wav';
								$fh=fopen("./wav/$filename", "w");
								fputs($fh, $data);
								fclose($fh);
								
								imap_delete($mbox, $msgnum);
								$delete=true;
							}
					  }
						if($delete) { imap_expunge($mbox); }
					}
				}
			?>

			<p>
			Aaaah... Paeuw... such a powerful mantra...
			
			<p>
			How <i>does</i> one pronounce it?  Share your vision with
			the world (or at least, the portion of the world that
			visits this site), by telephoning 07092 370082. 
			
			<p>At the correct 
			moment (you'll know when), simply take a deep breath and pronouce... no more, no less.
			
			<p>
			Within a couple of minutes your efforts will be available on this page 
			for all to marvel at.
			
			<br>&nbsp;
			
			
			
			<p class=header_howsay>I THANK YOU FOR SHARING
			
			<p>
			<?
				if(!isset($tp)) { $page=1; } else { $page=$tp; }
				$ct=0;
				$num_to_view=10;
				
				if ($dir=@opendir("./wav/"))
				{
					while ($file = readdir($dir))
					{
						if(!strpos($file,".wav")===false)
						{
							list($filename, $ext)=explode('.', $file);
							$files[]=$filename;
						}
					}  
					closedir($dir);
				}
				
				if($files)
				{
					arsort($files);
					foreach($files as $filename)
					{
						list($time, $number) = explode('_', $filename);
						$ct++;
						if($ct>($page-1)*$num_to_view && $ct<=$page*$num_to_view)
						{
							if($number){ $number = '&laquo; '.substr($number, 0, strlen($number)-2) . "**"; }
							echo "<a href=\"paeuw.m3u?before=$time\">".date("d.m.Y | H:i", $time)."</a> $number<br>";
						}
					}
				}
				
				$pages=intval($ct/$num_to_view);
				if ($ct%$num_to_view)
				{
				    // has remainder so add one page
			    	$pages++;
				}
				
				if($pages>0)
				{
	
					$first_page=floor(($page-1)/10)*10+1;
					$last_page=$first_page+9;
					if($last_page>$pages) { $last_page=$pages; }
				
					// print back link
					echo "<p class=pagelinks>\n";
					if($page>1)
					{
						echo "<a class=pagelink href='./?s=howsay&tp=".($page-1)."'>&lt;</a>";
					}
					else
					{
						echo "&lt;";
					}
				
					if($pages>10)
					{
						// print previous page range link
						echo " | ";
						if($first_page!=1)
						{
							echo "<a class=pagelink href='./?s=howsay&tp=".($first_page-1)."'>&lt;&lt;</a></a>";
						}
						else
						{
							echo "&lt;&lt;";
						}
					}
			
					// print page numbers
					for($p=$first_page; $p<=$last_page; $p++)
					{
						echo " | ";
				
						if($p==$page)
						{
							echo "$p";
						}
						else
						{
							echo "<a class=pagelink href='./?s=howsay&tp=$p'>$p</a>";
						}
					}
					
					// print next page range link
					if($pages>10)
					{
						echo "<span> | </span>";
						if($pages>$last_page)
						{
							echo "<a class=pagelink href='./?s=howsay&tp=".($last_page+1)."'>&gt;&gt;</a>";
						}
						else
						{
							echo "<span>&gt;&gt;</span>";
						}
					}
			
					// next link
					echo " | ";
					if($page<$pages)
					{
						echo "<a class=pagelink href='./?s=howsay&tp=".($page+1)."'>&gt;</a>";
					}
					else
					{
						echo "<span>&gt;</span>";
					}
					
					if($page*$num_to_view>$ct) { $last_item=$ct; } else { $last_item=$page*$num_to_view; }
					echo "<p>[ ".(($page-1)*$num_to_view+1)." to ".$last_item." of $ct items ]";
	
				}
			?>

			<p>
			You may need to
			<a href="./?s=howsay&action=refresh<? if($show) { echo "&show=$show"; } ?>">refresh</a> the list. 
			
			 