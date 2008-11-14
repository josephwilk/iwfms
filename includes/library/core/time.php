<?

/* class time {{{ */
/**
 * Functions dealing with outputing and processing time
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package core
 */
/* }}} */


class time{
	
	// Takes the passed date in the format YMD and converts it to DMY
	
	function arrangedate($datevalue){
	//pre:
	//post: r = day-month-year
		
		if($datevalue){
	
		list($datey,$datem,$dated) = explode('-',$datevalue);
		$datedone = "$dated-$datem-$datey";
		return $datedone;
		
		}
		return false;
	}
		
	
	// Converts unix timestamp to mysql timestamp
	
	function ts_unix_mysql($unix_timestamp){
	//pre:: unix_timestamp(ts)
	//post: r = mysql timestamp
		
		$date = getdate($unix_timestamp);  
		$year = $date["year"];  
		$month = $date["mon"];  
		$day = $date["mday"];  
		$hour = $date["hours"];  
		$minute = $date["minutes"];  
		$second = $date["seconds"];  
		return sprintf("%04d%02d%02d%02d%02d%02d",$year,$month,$day,$hour,$minute,$second);  
	}

	// Converts unix timestamp to mysql timestamp with only day month year
	
	function ts_unix_mysql_d($unix_timestamp){
	//pre:: unix_timestamp(ts)
	//post:	r = Year-Month-Day
		
		$d=getdate($unix_timestamp);  
		$yr=$d["year"];  
		$mo=$d["mon"];  
		$da=$d["mday"];  
		return sprintf("%04d-%02d-%02d",$yr,$mo,$da);  
	}

	// Converts mysql timestamp to unix timestamp
	
	function ts_mysql_unix_l($dt) {
	//pre: mysql_timestamp(dt)
	//post:	r = unix_timestamp
		
		$yr = substr($dt,0,4);
		$mon = substr($dt,4,2);
		$day = substr($dt,6,2);
		$hr = substr($dt,8,2);
		$min = substr($dt,10,2);
		$sec = substr($dt,12,2);
		$result = mktime($hr,$min,$sec,$mon,$day,$yr);
		return $result;
	}

	// converts mysql timestamp to mysql datetime
	
	function ts_mysql_mysql_d($dt) {
		
		$yr = substr($dt,0,4);
		$mon = substr($dt,4,2);
		$day = substr($dt,6,2);
		$hr = substr($dt,8,2);
		$min = substr($dt,10,2);
		$sec = substr($dt,12,2);
		
		$result = "$day-$mon-$yr $hr:$min:$sec";
		return $result;
	}

	function splitts($timestamp){

		$datetime = time::ts_mysql_mysql_d($timestamp); 
		list($date,$time) = explode(' ',$datetime);
		$result['time'] = $time;
		$result['date'] = $date;
		
		return $result;
		
	}

	function timestamp(){
	//pre: none
	//post: r = unix_timestamp
		
		return mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
	}
	
	
	function mysqldate_stamp(){
	//pre: none
	//post: r = mysql_timestamp with only month day year
		
		return mktime(date("m"),date("d"),date("Y"));
	}
	

	//Timing functions
	//providing the means to measure how long activities have taken
		
	function starttiming(){
		
		global $startTime;
				
		//Fetch current UNIX timestamp with microseconds
		$microtime = microtime();
		
		$microsecs = substr($microtime, 2, 8);
		$secs = substr($microtime, 11);
		$startTime = "$secs.$microsecs";
		
	}

	function stoptiming(){

		global $startTime;
		
		//Fetch current UNIX timestamp with microseconds
		$microtime = microtime();
		
		$microsecs = substr($microtime, 2, 8);
		
		$secs = substr($microtime, 11);
		
		$endTime = "$secs.$microsecs";
		
		return number_format(($endTime - $startTime),3) . " secs";
		
	} 
}
?>