<?php

class Birthday {

    var $today;    // Today's date

    var $day;      // 1-31, -1 = undefined
    var $month;    // 1-12, -1 = undefined
    var $year;     // xxxx, -1 = undefined

    var $prefix = "";

    var $name_of_months = array( 'January' , 'February' , 'March'
                               , 'April'   , 'May'      , 'June'
                               , 'July'    , 'August'   , 'September'
                               , 'October' , 'November' , 'December');

    function __construct() {

    	$this->day   = -1;
    	$this->month = -1;
    	$this->year  = -1;

      $this->today = time();

      //
      //  Three different constructors
      //
      $num = func_num_args();
      $args = func_get_args();
      switch($num){
        case 0:
            break;
        case 1:
            $this->setDate(func_get_arg(0));
            break;
        case 2:
            $arg0 = func_get_arg(0);
            $arg1 = func_get_arg(1);
            $this->setDate($arg0, $arg1);
            break;
        case 3:
            $arg0 = func_get_arg(0);
            $arg1 = func_get_arg(1);
            $arg2 = func_get_arg(2);
            $this->setDate($arg0, $arg1,  $arg2);
            break;
        default:
            throw new Exception();
      }
    }
    
    function toDate() {
    	return mktime(0, 0, 0, $this->month, $this->day, $this->year);
    }
    

    public static function tryDelimDate($str, $delim) {

  	  preg_match('/([0-9]{4})'.$delim.'([0-9]{1,2})'.$delim.'([0-9]{1,2})/', $str, $matches);

  	  return $matches;
    }

    public static function isEmptyVal($val) {

    	return in_array($val, array(-1, 0, "", "-"));

    }

    function setDay($day) {

  	  $val = intval($day);
  	  if(1 <= $val && $val <= 31) {
  	    $this->day = $val;
  	    return true;
  	  } else {
  	    $this->day = -1;
    	  return self::isEmptyVal($day);
    	}
    }

    function setMonth($month) {

  	  $val = intval($month);
  	  if(1 <= $val && $val <= 12) {
  	    $this->month = $val;
  	    return true;
  	  } elseif(in_array($month, $this->name_of_months)) {
  	  	$this->month = array_search($month, $this->name_of_months)+1;
  	  } else {
  	    $this->month = -1;
    	  return self::isEmptyVal($month);
    	}
    }

    function setYear($year) {

  	  $val = intval($year);
  	  if(1800 <= $val && $val <= 2200) {
  	    $this->year = $val;
  	    return true;
  	  } else {
  	    $this->year = -1;
  	    return self::isEmptyVal($year);
  	  }
  	}

    function setDate($val0, $val1 = "", $val2 = "") {

    	if($val0 != "" && $val1 != "" && $val2 != "") {    		
    		$this->setDay  ($val0);
    		$this->setMonth($val1);
    		$this->setYear ($val2);    		
    	}
    	
    	if(is_array($val0)) {
    		$this->prefix = $val1;
    		$this->setDay(   $val0[$this->prefix.'day']);
    		$this->setMonth( $val0[$this->prefix.'month']);
    		$this->setYear(  $val0[$this->prefix.'year']);
    		
    		return true;
    	}

    	if(   is_int($val0) && $val0 > 0 
    	   && $val1 == "" && $val2 == "") {
    	   	
    		$this->setDay(date("d", $val0));
    		$this->setMonth(date("m", $val0));
    		$this->setYear(date("Y", $val0));
    		
    		return true;
    	}
    	    	//
    	// vCard: xxxx-yy-zz
    	//
    	$parse_date = self::tryDelimDate($val0, "-");
    	if(count($parse_date) == 4) {
    		$this->setDay  ($parse_date[3]);
    		$this->setMonth($parse_date[2]);
    		$this->setYear ($parse_date[1]);
    		
    		return true;
    	}
    }

    function setPrefix($prefix) {
    	 
    	 $this->prefix = $prefix;
    	 return $this;
    }
     
    function addToAddr($addr) {
 
    	 if($this->day   != -1) {
    	   $addr[$this->prefix."day"] = $this->day;
    	 }

    	 if($this->month != -1) {
    	   $addr[$this->prefix."month"] = $this->name_of_months[$this->month - 1];
    	 }

    	 if($this->year != -1) {
         $addr[$this->prefix."year"]  = $this->year;
       }
       
       return $addr;

    }
    
    function getAge() {

      $age =  date("Y", $this->today)  - $this->year;
      if(    (date("m", $this->today) <  $this->month)
          ||((date("m", $this->today) == $this->month) && (date("d", $this->today) < $this->day)))
      {
      	$age--;
      }

      return ($age < 150 ? $age : -1);
    }

}
?>