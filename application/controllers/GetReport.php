<?php
date_default_timezone_set("Asia/Manila");

class GetReport extends CI_Controller{
	function __construct ()
	{
		parent::__construct();
        session_start();

        $this->load->helper('RLCFileServer');
	}

	function index ()
	{
		$token = $_SERVER['HTTP_TOKEN'];
		$raw_param = explode("&", $_SERVER['QUERY_STRING']);
		$param = [];

		if( !isset($token) || $token == "" ){
			$this->output->set_status_header('401');
			echo json_encode("Invalid token");
			exit;
		}

		foreach ($raw_param as $value) {
			$keyvalue = explode("=", $value);
			$param[$keyvalue[0]] = $keyvalue[1];
		}

		if( !isset($param['date']) || !isset($param['success'])){
			$this->output->set_status_header('400');
			echo json_encode("Incomplete headers");
			exit;
		}

		if( $param['date']== "" || $param['success']== ""){
			$this->output->set_status_header('400');
			echo json_encode("Incomplete headers");
			exit;
		}

		if($param['success'] == "1"){
			$settingsJson = json_decode(file_get_contents("assets/data/settings.json"));
			$directory = "";
			$deviceId = "";

			$flag = false;
			$fs = new RLCFileServer();
			foreach ( $settingsJson->devices as $value ) {
				if($fs->validate($token, md5($value->deviceId.$settingsJson->clientName))){
					$deviceId = $value->deviceId;
					$directory = $value->directory;
					$flag = true;
				}
			}

			if ( $flag ){
				$basefolder = "RLC";
				$year = date("Y", strtotime($param['date']));

				$filefolder = $directory.$basefolder."/".$settingsJson->clientName."/".$deviceId."/".$year;
				$file = $fs->getLatestFile( $filefolder, $param['date'] );
				$sentfolder = $filefolder."/sent/";

				if($file == ""){
					$this->output->set_status_header('404');
					echo json_encode("File not found");
					exit;
				}

	        	sleep(5);
	        	$this->output->set_status_header('200');
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="'.basename($file).'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    readfile($file);

			    $filename = substr( $file, strrpos($file, "/")+1 );
			    copy($file, $sentfolder.$filename); # copy to sent folder
			    echo json_encode("Success");
			    exit;
			}
			else{
				$this->output->set_status_header('401');
				echo json_encode("Invalid token");
			}
		}
		else{
			sleep(5);
			$this->output->set_status_header('404');
			echo json_encode("Failed");
		}
	}
}


?>