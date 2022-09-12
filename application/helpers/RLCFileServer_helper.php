<?php

class RLCFileServer{
	function validate ( $token, $client ){
		return $token == $client ? true : false;
	}

	function getFilesOfDate ( $path, $date ) {
		$md =  date("md", strtotime($date));
		$content = array_diff( scandir( $path ), array('.', '..' ) );
		$files = [];

		foreach ( $content as $value ) {
			if( is_file( $path."/".$value ) ){

				$name = substr( $value, 0, strpos($value, ".") );
				$fileDate = substr( $name, strlen($name)-4 );

				if($md == $fileDate){
					array_push( $files, $path."/".$value );
				}
				
			}
		}

		return $files;
	}

	function getLatestFile ( $path, $date ){
		$filesPath = $this->getFilesOfDate( $path, $date );
		$minbatch = 0;
		$latestFile = "";

		foreach ($filesPath as $value) {

			$batchno = intval(substr($value, -1));
			if( $batchno > $minbatch ){
				$minbatch = $batchno;
				$latestFile = $value;
			}
		}

		return $latestFile;
	}
}