<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/
include_once(PHPLENS_DIR.'/phplens-lang-en_us.inc.php');

class PHPLens_en_uk extends PHPLens_en_us{
var $fmtDateInput="d/m/Y"; // this must be 5 chars long, with same separator character
var $fmtDateOutput="d-M-Y"; // format must match PHP date() function
var $fmtTimeStampOutput="d-m-Y h:i:s A"; // format must match PHP date() function
var $fmtTimeStampInput="d/M/Y h:i:s A";

}

?>