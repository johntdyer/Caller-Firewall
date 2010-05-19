<?

$config = parse_ini_file("../config.ini");
$base_url = str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname($_SERVER['PHP_SELF'])); 

/**
	 * Cleans log directory of files older then n days
	 *
	 * @param string $daysToExpung 
	 * @param string $fileTypes					Filetypes to check (you can also use *.*)
	 * @param string $logFolder 					Define the folder to clean (keep trailing slashes)
	 * @return null or record count
	 * @author John Dyer
	 */
	function cleanLogDir($daysToExpung,$fileTypes,$logFolder){
		$expire_days    = $daysToExpung;
			foreach (glob($logFolder . $fileTypes) as $Filename) {
				// Read file creation time
				$FileCreationTime = filectime($Filename);
				// Calculate file age in seconds
				$FileAge = time() - $FileCreationTime; 
				// Is the file older than the given time span?
				if ($FileAge > ($expire_days*60*60*24)){
						//print "The file $Filename is older than $expire_days days<br/>";
						// For example deleting files:
						unlink($Filename);
					}
				}
			}     
			
			function sendAlertEmail($sessionID,$phoneNumber){
				global $config;
				date_default_timezone_set($config['time_zone']);
			 $to = $config['admin_email_to'];
			 $subject = "*URGENT* - Firewall Application Error";
			 $message = "Something broke\nHere are the details:\n\nSession Info\n\n\tTime:\t\t" .date('H:i:s')." " . $config['time_zone'] . "\n\tSessionID:\t".$sessionID."\n\tPhone:\t\t". $phoneNumber."";
			 $headers = 'From: '.$config['admin_email_from'] . "\r\n" .
			    'Reply-To: '.$config['admin_email_from'] . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
			}
?>