<?php
class excel_model extends CI_Model {
	function __construct() {
		parent::__construct();
		}	
				
	function isDate($val){
		if(isset($val[2])&&isset($val[4])&&isset($val[7])&&isset($val[9])&&isset($val[3])&&isset($val[8]))
			{
			$temp_str1= array($val[2], $val[4], $val[7], $val[9], '"');
			$temp_str2= array($val[3], $val[8], '/');
			if((strlen($val) === 14)&&(count(array_unique($temp_str1))===1)&&(count(array_unique($temp_str2))===1))
				return true;
			}
		return false;
	}
	
	function process_excel($server_copy, $filepath){
	
			$sSQL = "SELECT IFNULL(MAX(`biometricsid`),0) AS `biometricsid` FROM timeschedule";
			$query = $this->db->query($sSQL);
			$biometricsid = ($query->result()[0]->biometricsid) + 1;
			$sSQL = "INSERT INTO `biometrics`(`id`,`date`) VALUES ('".$biometricsid."','". date("Y-m-d H:i:s",time())."')";
			$this->db->query($sSQL);
			
			$query_array=array();
			$extension = $server_copy['file_ext'];
			if($extension == '.xlsx'){
				$fileType = 'Excel2007';
			}else if($extension == '.xls'){
				$fileType = 'Excel5';
			}
			$objReader = PHPExcel_IOFactory::createReader($fileType);
			$objPHPExcel = $objReader->load($filepath.$extension);
			$objSheet = $objPHPExcel->getActiveSheet();		
			$rows = count($objSheet->toArray()); 
			date_default_timezone_set('Asia/Manila');
			for($h=1;$h<$rows;$h++){
				$cell_value =  $objSheet->getCell('A'.$h)->getFormattedValue();
				if(strpos($cell_value, 'Employee:') !== false){
					$cell_value = strrev($cell_value);
					$id_length = strpos($cell_value, '(') - strpos($cell_value, ')') - 1;
					$cell_value = substr($cell_value, strpos($cell_value, ')')+1, $id_length);
					$employeeid = strrev($cell_value);
					for($i=$h;;$i++){ 
						$cell_value =  $objSheet->getCell('A'.$i)->getFormattedValue();
						if((strpos($cell_value, 'Total')!==false))
							break;
						if($this->isDate($cell_value)){
							$cell_value = str_replace('"','', $cell_value);
							$date= date('Y-m-d', strtotime($cell_value));
							for($j = 'B';$j!='L';$j++){
								$timein_cell = $objSheet->getCell($j++.$i)->getFormattedValue();
								$timeout_cell = $objSheet->getCell($j.$i)->getFormattedValue();
								$timein_cell_next = $objSheet->getCell(chr(ord($j)+1).$i)->getFormattedValue();
								//IF empty IN cell is seen (A) skip the row if there's nothing else
								//(B) there's some more data in other cells: issue error.
								if(strlen($timein_cell) == 0){
									for($k = ord($j);$k < ord('L');$k++){
										if(strlen($objSheet->getCell(chr($k).$i)->getFormattedValue())>0)
											return 'ERROR: Missing cell(s) for employee ID: '. $employeeid.' on cell: '.chr(ord($j)-1).$i;
									}								
									break;
								}
								//IF empty OUT cell is seen after a populated IN cell, exit function, issue error
								if(strlen($timeout_cell) == 0){
									return "ERROR: Empty \'timeout\' for employee ID: ". $employeeid." on cell: ".$j.$i;
								}
								//IF out cell is greater than next in cell: error
								if ((strlen($timein_cell_next != 0)) &&(date ('H:i:s', strtotime($timeout_cell)) > date ('H:i:s', strtotime($timein_cell_next)))){
									return "ERROR: Conflict on timein for employee ID: ". $employeeid." on cell: ".chr(ord($j)+1).$i;
								}
								
								//IF timein exceeds the timeout (timeout rolled over after 23:59:59)
								if(date ('H:i:s', strtotime($timein_cell)) > date ('H:i:s', strtotime($timeout_cell))){
									//LOOK AHEAD TO TIMEIN OF NEXT DAY, CHECK IF CONFLICT EXISTS 
									for($k = ord($j)+1;$k < ord('L');$k++){
										if(strlen($objSheet->getCell(chr($k).$i)->getFormattedValue())>0)
											return 'ERROR: Cell found after 24-hour rollover for Employee id: '. $employeeid.' on cell: '.chr($k).$i;
									}	
									
									$timein_cell_nextday = $objSheet->getCell('B'.($i+1))->getFormattedValue();
									if( date ('H:i:s', strtotime($timeout_cell)) > date('H:i:s', strtotime($timein_cell_nextday)))
										return "ERROR: Conflict on next day timein for employee ID: ". $employeeid." on cell: ".$j.$i;
									$timein = $date.' '.date ('H:i:s', strtotime($timein_cell));
									$timeout = $date.' 23:59:59';
									$datemodified = date("Y-m-d H:i:s",time());
									$datecreated = $datemodified;	
									array_push($query_array,  "('".$employeeid."','".$date."','".$timein."','".$timeout."','".$datemodified."','".$datecreated."','".$biometricsid."')");			
									$next_date = date('Y-m-d',strtotime($date .'+1 days'));
									$timein = $next_date.' '.date ('H:i:s', strtotime('00:00:00'));
									$timeout = $next_date.' '.date ('H:i:s', strtotime($timeout_cell));
									array_push($query_array,  "('".$employeeid."','".$next_date."','".$timein."','".$timeout."','".$datemodified."','".$datecreated."','".$biometricsid."')");		
								}
								else{
									$timein = $date.' '.date ('H:i:s', strtotime($timein_cell));
									$timeout = $date.' '.date ('H:i:s', strtotime($timeout_cell));
									$datemodified = date("Y-m-d H:i:s",time());
									$datecreated = $datemodified;	
									array_push($query_array,  "('".$employeeid."','".$date."','".$timein."','".$timeout."','".$datemodified."','".$datecreated."','".$biometricsid."')");						
								}				
							}
						}
					}
				}
			}
			$length = count($query_array);
			$sSQL = "INSERT INTO `timeschedule`(`employeeid`,`date`,`timein`,`timeout`, `datemodified`, `datecreated`, `biometricsid`) VALUES ";
			for($u=0;$u<$length;$u++){
					$sSQL .= $query_array[$u].',';
			}
			$sSQL = substr($sSQL,0,-1);	
			$this->db->query($sSQL);
			return;
	}
	
	
	
}


?>