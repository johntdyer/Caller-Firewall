<?php 
header ("content-type: text/xml"); 

echo('<?xml version="1.0" encoding="UTF-8"?>');
$return = "<data>";

	if(!isset($_REQUEST['callerID'])){
		$return = $return . "<error>no callerID provided</error>";
	}else{
		$phoneNumber = $_REQUEST['callerID'];
	}
        
$xml =  simplexml_load_file("data.xml");



	$recordsFound = count($xml->xpath('//*[@phone ="'.$phoneNumber.'"]'));
		if($recordsFound==0){ 
				$return = $return . "<match/>";
			}elseif($recordsFound>1){ 
				$return = $return . "<error>more then 2 records</error>";
			}else{
				foreach($xml->xpath('//*[@phone ="'.$phoneNumber.'"]') as $item) {
					$row = simplexml_load_string($item->asXML());
					echo $row;
					$v = $row->xpath('//*[@phone ="'.$phoneNumber.'"]');
					if($v[0]){ 
						$return = $return .	"<match>";
						$return = $return .	"<name>"	.	$item->name	.	"</name>";
						$return = $return .	"<type>"	.	$item->type	.	"</type>";
						$return = $return .	"</match>";
					}
				}
			}
			$return = $return ."</data>";   
			echo $return;
?>