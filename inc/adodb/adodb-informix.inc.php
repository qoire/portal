<?php
/* 
V1.72 16 Feb 2002 (c) 2000-2002 John Lim. All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. 
  Set tabs to 4 for best viewing.
  
  Latest version is available at http://php.weblogs.com/
  
  First attempt at modifying Sybase driver to work with Informix by Mitchell T. Young (mitch@youngfamily.org)
*/
 
class ADODB_informix extends ADOConnection {
	var $databaseType = "informix";	
	var $replaceQuote = "''"; // string to use to replace quotes
	var $fmtDate = "'Y-m-d H:i:s'";
	var $fmtTimeStamp = "'Y-m-d H:i:s'";
	var $hasInsertID = false;
    var $hasAffectedRows = true;
	
	# needs PORT  -- list all tables in current database (including views)
  	var $metaTablesSQL="select name from sysobjects where type='U' or type='V'";
	
	# needs PORT  -- list all columns for a given table
	var $metaColumnsSQL = "select c.name,t.name,c.length from syscolumns c join systypes t on t.xusertype=c.xusertype join sysobjects o on o.id=c.id where o.name='%s'";
	var $concat_operator = '+'; 
	var $lastQuery = false;
	
	var $_autocommit = true;
	
	function ADODB_informix() {			
	}
 
    // might require begintrans -- committrans
    function _insertid()
    {
         return false;
    }

      // might require begintrans -- committrans
    function _affectedrows()
    {
if ($this->lastQuery) {
           return ifx_affected_rows ($this->lastQuery);
       } else 
 		return 0;
    }

    function BeginTrans()
	{       
        $this->Execute('BEGIN');
		$this->_autocommit = false;
    	return true;
	}
	
	function CommitTrans()
	{
        $this->Execute('COMMIT');
		$this->_autocommit = true;
		return true;
	}
	
	function RollbackTrans()
	{
         $this->Execute('ROLLBACK');
		 $this->_autocommit = true;
         return true;
	}


	/*	Returns: the last error message from previous database operation
		Note: This function is NOT available for Microsoft SQL Server.	*/	

	function ErrorMsg() {
		$this->_errorMsg = ifx_errormsg();
		return $this->_errorMsg;
	}

	// returns true or false
	function _connect($argHostname, $argUsername, $argPassword, $argDatabasename)
	{
		$dbs = $argDatabasename . "@" . $argHostname;
		$this->_connectionID = ifx_connect($dbs,$argUsername,$argPassword);
		if ($this->_connectionID === false) return false;
		#if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
	// returns true or false
	function _pconnect($argHostname, $argUsername, $argPassword, $argDatabasename)
	{
		$dbs = $argDatabasename . "@" . $argHostname;
		$this->_connectionID = ifx_pconnect($dbs,$argUsername,$argPassword);
		if ($this->_connectionID === false) return false;
		#if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
	
	// returns query ID if successful, otherwise false
	function _query($sql,$inputarr)
	{
		//sybase_free_result($this->_queryID);
		$this->lastQuery = ifx_query($sql,$this->_connectionID);
		if ($this->_autocommit) ifx_query('COMMIT',$this->_connectionID);
		return $this->lastQuery;
	}
	
	// returns true or false
	function _close()
	{ 
		$this->lastQuery = false;
		return ifx_close($this->_connectionID);
	}
	
	
}
	
/*--------------------------------------------------------------------------------------
	 Class Name: Recordset
--------------------------------------------------------------------------------------*/
//global $ADODB_informix_mths;
//$ADODB_sybase_mths = array('JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);

class ADORecordset_informix extends ADORecordSet {	

	var $databaseType = "informix";
	var $canSeek = true;
	// _mths works only in non-localised system
	var  $_mths = array('JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);	
	
	function ADORecordset_informix($id)
	{
		return $this->ADORecordSet($id);
	}
	

	# needs PORT  -- should use ifx_fieldproperties not ifx_fieldtypes
	
	/*	Returns: an object containing field information. 
		Get column information in the Recordset object. fetchField() can be used in order to obtain information about
		fields in a certain query result. If the field offset isn't specified, the next field that wasn't yet retrieved by
		fetchField() is retrieved.	*/
	function &FetchField($fieldOffset = -1) 
	{
		#$fieldOffset = -1;
		if ($fieldOffset != -1) {
			$o = @ifx_fieldtypes($this->_queryID, $fieldOffset);
		}
		else if ($fieldOffset == -1) {	/*	The $fieldOffset argument is not provided thus its -1 	*/
			$o = @ifx_fieldtypes($this->_queryID);
		}
		// older versions of PHP did not support type, only numeric
		if ($o && !isset($o->type)) $o->type = ($o->numeric) ? 'float' : 'varchar';
		return $o;
	}
	
	function _initrs()
	{
	global $ADODB_COUNTRECS;
	    $this->_numOfRows = -1; // not reliable, only returns estimate -- ($ADODB_COUNTRECS)? ifx_affected_rows($this->_queryID):-1;	
		$this->_numOfFields = ifx_num_fields($this->_queryID);
	}
	
	function _seek($row) 
	{
		return ifx_fetch_row($this->_queryID, $row);
	}		

	function _fetch($ignore_fields=false) {
		$this->fields = ifx_fetch_row($this->_queryID);
		#$this->fields = ifx_fetch_row($this->_queryID);
		return ($this->fields == true);
	}
	
	/*	close() only needs to be called if you are worried about using too much memory while your script
		is running. All associated result memory for the specified result identifier will automatically be freed.	*/
	function _close() {
		return ifx_free_result($this->_queryID);		
	}
	
	# needs PORT
	// sybase/mssql uses a default date like Dec 30 2000 12:00AM
	function NotUsedUnixDate($v)
	{
	global $ADODB_sybase_mths;
		//Dec 30 2000 12:00AM
		// added fix by Toni for day 15 Mar 2001
		if (!ereg( "([A-Za-z]{3})[-/\. ]([0-9 ]{1,2})[-/\. ]([0-9]{4})"
			,$v, $rr)) return parent::UnixDate($v);
			
		if ($rr[3] <= 1970) return 0;
		
		$themth = substr(strtoupper($rr[1]),0,3);
		$themth = $ADODB_sybase_mths[$themth];
		if ($themth <= 0) return false;
		// h-m-s-MM-DD-YY
		return  mktime(0,0,0,$themth,$rr[2],$rr[3]);
	}
	
	# needs PORT
	function NotUsedUnixTimeStamp($v)
	{
	global $ADODB_sybase_mths;
		//Dec 30 2000 12:00AM
		if (!ereg( "([A-Za-z]{3})[-/\. ]([0-9 ]{1,2})[-/\. ]([0-9]{4}) +([0-9 ]{1,2}):([0-9 ]{1,2}) *([apAP]{0,1})"
			,$v, $rr)) return parent::UnixTimeStamp($v);
		if ($rr[3] <= 1970) return 0;
		
		$themth = substr(strtoupper($rr[1]),0,3);
		$themth = $ADODB_sybase_mths[$themth];
		if ($themth <= 0) return false;
		
		if (strtoupper($rr[6]) == 'P') {
			if ($rr[4]<12) $rr[4] += 12;
		} else {
			if ($rr[4]==12) $rr[4] = 0;
		}
		// h-m-s-MM-DD-YY
		return  mktime($rr[4],$rr[5],0,$themth,$rr[2],$rr[3]);
	}

}
?>

