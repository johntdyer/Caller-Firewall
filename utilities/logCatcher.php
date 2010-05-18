<?
include('../functions.inc');
cleanLogDir(30,'*.txt','../logs/');

date_default_timezone_set('GMT');

$myFile 		=	"../logs/LOGS__".date('Y-m-d-H00').".csv";
$year 			=	date('Y');
$timeStamp	=	date('H:i:s');

$callerID=$_REQUEST['callerID'];
$sessionID=$_REQUEST['sessionID'];
$callDisposition=$_REQUEST['callDisposition'];

if(!file_exists($myFile)){
	touch ($myFile);
	$fh = fopen($myFile, 'a');
	fwrite($fh,"CONFIDENTIAL INFORMATION\n");
	fwrite($fh,"CDR - "	.	date('H00')	.	" GMT "	.	$year	.	"\n\n");
	fwrite($fh,"TimeStamp,SessionID,Caller ID,Call Result\n");
	fwrite($fh,
		$timeStamp				.",".
		$sessionID				.",".
		$callerID					.",".
		$callDisposition	."\n"
		);
	fclose($fh);
	
}else{
	$fh = fopen($myFile, 'a');
	fwrite($fh,
		$timeStamp				.",".
		$sessionID				.",".
		$callerID					.",".
		$callDisposition	."\n"
		);
	fclose($fh);
	}

?>
