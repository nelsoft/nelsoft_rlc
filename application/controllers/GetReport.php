<?php
date_default_timezone_set("Asia/Manila");

class GetReport extends CI_Controller{
	function __construct ()
	{
		parent::__construct();
        session_start();

        $this->load->helper('RLCFileServer');
        $this->load->helper('SftpCus');
	}

	function index ()
	{
		if( !isset($_SERVER['HTTP_TOKEN']) || $_SERVER['HTTP_TOKEN'] == "" ){
			$this->output->set_status_header('401');
			echo json_encode($this->config->item('http_err_msg')['401']);
			exit;
		}

		if( !isset($_SERVER['HTTP_DEVICEID']) || $_SERVER['HTTP_DEVICEID'] == "" ){
			$this->output->set_status_header('400');
			echo json_encode($this->config->item('http_err_msg')['400']);
			exit;
		}

		$token = $_SERVER['HTTP_TOKEN'];
		$head_deviceId = $_SERVER['HTTP_DEVICEID'];
		$raw_param = explode("&", $_SERVER['QUERY_STRING']);
		$param = [];

		foreach ($raw_param as $value) {
			$keyvalue = explode("=", $value);
			$param[$keyvalue[0]] = $keyvalue[1];
		}

		if( !isset($param['date']) || !isset($param['success'])){
			$this->output->set_status_header('400');
			echo json_encode($this->config->item('http_err_msg')['400']);
			exit;
		}

		if( $param['date']== "" || $param['success']== ""){
			$this->output->set_status_header('400');
			echo json_encode($this->config->item('http_err_msg')['400']);
			exit;
		}

		if($param['success'] == "1"){
			$settingsJson = json_decode(file_get_contents("assets/data/settings.json"));
			$remoteSettingsJson = json_decode(file_get_contents("assets/data/remote.json"));
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

			if ( $head_deviceId != $deviceId ){
				$this->output->set_status_header('400');
				echo json_encode($this->config->item('http_err_msg')['400']);
				exit;
			}

			if ( $flag ){
				$basefolder = "RLC";
				$year = date("Y", strtotime($param['date']));

				$filefolder = $directory.$basefolder."/".$settingsJson->clientName."/".$deviceId."/".$year;
				$file = $fs->getLatestFile( $filefolder, $param['date'] );
				$sentfolder = $filefolder."/sent/";

				if($file == ""){
					$this->output->set_status_header('404');
					echo json_encode($this->config->item('http_err_msg')['404']);
					exit;
				}

	        	sleep(5);
	        	// Send file to requester
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

			    // send to remote
			    $sftp = new SftpCus();
			    $sftp->send_file($remoteSettingsJson->host, $remoteSettingsJson->username, $remoteSettingsJson->password, $file, $filename, $remoteSettingsJson->dir.$deviceId."\\");
			    exit;
			}
			else{
				$this->output->set_status_header('401');
				echo json_encode( $this->config->item('http_err_msg')['401'] );
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