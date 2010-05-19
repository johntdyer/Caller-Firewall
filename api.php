<?php  
$config = parse_ini_file("config/config.ini");
$showExtraData=false;

header ("content-type: text/xml"); 
echo('<?xml version="1.0" encoding="UTF-8"?>');
$return = "<data>";

	if(!isset($_REQUEST['callerID'])){
		$return = $return .	'<matchcount="0">';		
		$return = $return . "<reason>no callerID provided</reason>";
	}else{
		$phoneNumber = $_REQUEST['callerID'];
	}

	$xml =  simplexml_load_file("db/data.xml");
	$recordsFound = count($xml->xpath('//*[@phone ="'.$phoneNumber.'"]'));

	$return = $return . '<match count="'.$recordsFound.'">';	


		if($recordsFound==0){
			$showExtraData=true;
			}elseif($recordsFound>1){
				$return = $return . "<reason>more then 2 records</reason>";
			}else{    
				$showExtraData=true;
				foreach($xml->xpath('//*[@phone ="'.$phoneNumber.'"]') as $item) {
					$row = simplexml_load_string($item->asXML());
					echo $row;
					$v = $row->xpath('//*[@phone ="'.$phoneNumber.'"]');
				 	 if($v[0]){ 
							$return = $return .	"<name><![CDATA["	.	$item->name	.	"]]></name>";
							$return = $return .	"<callerID><![CDATA["	.	$item->attributes()	.	"]]></callerID>";
							$return = $return .	"<type><![CDATA["	.	$item->type	.	"]]></type>";
						}
				}
			}
	$return = $return ."</match>";

// Dont want to show this extra data unless we actually have a record

 	if($showExtraData){
		$return = $return ."<applicationData>";
		$return = $return ."<redirectURL>".$config['redirect_application_url']."</redirectURL>";
		$return = $return ."<redirectMessage><![CDATA[".strtolower($config['reject_message'])."]]></redirectMessage>"; 
		$return = $return ."<matchAction>".strtolower($config['on_redirect_match'])."</matchAction>";   
		$return = $return ."</applicationData>"; 
 	} 

	$return = $return ."</data>";
echo $return;
?>