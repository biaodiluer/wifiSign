<?php

	$method=$_GET['method'];
	//$data=$GLOBALS['HTTP_RAW_GET_DATA'];
	//echo json_encode($data);
	//echo $re;
	//$obj=json_decode($re)
	//echo $obj->{'userId'};
	//file_get_contents("php://input")
	//如何获得$json
	//var jsonArray=json_decode($json,true);
	//var_dump($method);

	$jsonRet=array();
	$ret;
	switch($method)
	{
		case "register":
		$userId=$_GET['userId'];
		$userName=$_GET['userName'];
		$macAddress=$_GET['macAddress'];
		$jsonRet[0]["userId"]=$userId;
		$jsonRet[0]["userName"]=$userName;
		$jsonRet[0]["macAddress"]=$macAddress;

		$jsonRet[1]["userId"]="2";
		$jsonRet[1]["userName"]="22";
		$jsonRet[1]["macAddress"]="22:22:22";
		break;
	}
	echo json_encode($jsonRet);
	//echo json_encode($jsonRet);
?>
