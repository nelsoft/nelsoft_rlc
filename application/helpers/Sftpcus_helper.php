<?php

set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH . 'third_party/phpseclib');
require_once(APPPATH . '/third_party/phpseclib/Net/SSH2.php');
require_once(APPPATH . '/third_party/phpseclib/Net/SFTP.php');
require_once(APPPATH . '/third_party/phpseclib/Crypt/Base.php'); 
require_once(APPPATH . '/third_party/phpseclib/Crypt/Rijndael.php'); 
require_once(APPPATH . '/third_party/phpseclib/Crypt/AES.php'); 
require_once(APPPATH . '/third_party/phpseclib/Crypt/RC4.php'); 
require_once(APPPATH . '/third_party/phpseclib/Crypt/Twofish.php'); 
require_once(APPPATH . '/third_party/phpseclib/Crypt/Blowfish.php');
require_once(APPPATH . '/third_party/phpseclib/Crypt/DES.php'); 
require_once(APPPATH . '/third_party/phpseclib/Crypt/TripleDES.php'); 
require_once(APPPATH . '/third_party/phpseclib/Crypt/Random.php'); 
require_once(APPPATH . '/third_party/phpseclib/Math/BigInteger.php');
require_once(APPPATH . '/third_party/phpseclib/Crypt/Hash.php');

use phpseclib\Net\SFTP;
use phpseclib\Crypt\Base;
use phpseclib\Crypt\RC4;
use phpseclib\Crypt\Twofish;
use phpseclib\Crypt\Blowfish;
use phpseclib\Crypt\DES;
use phpseclib\Crypt\TripleDES;
use phpseclib\Crypt\Random;
use phpseclib\Math\BigInteger;
use phpseclib\Crypt\Hash;

class SftpCus{
	function send_file($server, $user, $pass, $filepath, $filename, $remoteDir){ // using Phpseclib

		$sftp = new SFTP($server);
		if (!$sftp->login($user, $pass)) {
		    return false;
		    exit;
		}

		$dir = trim($remoteDir, "\\");
		$dir = explode("\\", $dir);
		$remoteDir = "\\";
		foreach ($dir as $value) {
			$remoteDir .= $value."\\";
			if(!$sftp->is_dir($remoteDir)){
				$sftp->mkdir($remoteDir);
			}
		}
		
		if(!$sftp->is_dir($remoteDir)){
			$sftp->mkdir($remoteDir);
		}

		return $upload = $sftp->put($remoteDir.$filename, $filepath, SFTP::SOURCE_LOCAL_FILE);
	}
}

?>