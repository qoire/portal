<?php
/**
* (c) 2000, 2001 Remistech Sdn Bhd. All Rights Reserved.
*  Developed by John Lim
*  Licensed to Natsoft (M) Sdn Bhd to distribute and support. Refer to LICENSE document.
*/

include_once(PHPLENS_DIR.'/smarty/Smarty.class.php');

/*======================================================================*\
    Function: smarty_func_print_global -- jlim
    Purpose:  print a global
\*======================================================================*/
function phplens_func_print_global()
{
	extract(func_get_arg(0));
	print $GLOBALS[$name];
}



class PHPLensTemplate {
var $templateObj;
//var $lens;

	function PHPLensTemplate(&$lens)
	{
	global $PHP_SELF;
	
		$dirname = $lens->templateBaseDir;
		$this->templateObj = &new Smarty();
		$o = &$this->templateObj;
		$o->compile_check = ($lens->dynEdit != 0);
		$o->register_function('print_global','phplens_func_print_global');
		$o->assign('PHP_SELF',$PHP_SELF);
		$o->assign('_ISEDIT_','');
		if (is_array($lens->templateAssign))
		    $o->assign($lens->templateAssign);
		if ($dirname) {
			$o->compile_dir = $dirname.'/templates_c';
			$o->config_dir = $dirname.'/configs';
			$o->cache_dir = $dirname.'/cache';
			$o->template_dir = $dirname.'/templates';
		}
	}
	
	function Assign($var) // accepts array
	{
		$this->templateObj->assign($var);
	}
	
	function &Fetch($file)
	{	
		return $this->templateObj->fetch($file);
	}
	
	function Close()
	{
		
		$this->templateObj->clear_all_assign();
		$this->templateObj = false;
	}
}


class PHPLensExportText { // CSV
	var $vars;
	var $quote = "'";
	var $sep = ',';
	var $escquote = "'";
	var $replaceNewLine = " ";
	function PHPLensExportText(&$lens)
	{
		$vars = array();
		$lens->templateDetail = 'D';
		$lens->templateGrid = 'G';
		$lens->templateLayout = 'L';
		$lens->columns = 1;
	}
	
	function Assign($var)
	{
		if (is_array($var)) {
			foreach($var as $k => $v) {
				if (($k[0] != '_' && $k[strlen($k)-1] != '_') and 
					(substr($k,strlen($k)-2) != '_T'))
					$this->vars[$k] = $v;
			}
		}
	}
		
	function &Fetch($file)
	{
		if ($file == 'L') {
			$arr = $this->vars['GRIDDATA'];
			if (headers_sent())	return '<pre>'.$arr[0].'</pre>';
			else {
				header( "Content-type: text/plain" ); 
				print $arr[0];
				die();
			}
		} else {
			if (!headers_sent()) {
				header("Content-Type: text/tab-separated-values");
				header("Content-Disposition: attachment; filename=\"output.csv\"");
				
			}
			$s = '';
			$quote = $this->quote;
			$escquote = $this->escquote;
			$sep = $this->sep;
			$escquotequote = $escquote.$quote;
			$replaceNewLine = $this->replaceNewLine;
			
			foreach($this->vars as $k=>$v) {
				if (is_numeric($v)) $s .= "$v$sep";
				else {
					if ($escquote) $v = str_replace($quote,$escquotequote,$v);
					$v = str_replace("\n",$replaceNewLine,$v);
					$v = str_replace('&nbsp;',' ',$v);
					$s .= "$quote$v$quote$sep";
				}
			}
			return substr($s,0,strlen($s)-1)."\n";
		}
	}
}

   

$LENS_EXCEL = false;
/*
	The following code does not work becoz cookies do not appear to be allowed in an excel attachment
	so we would need to disable session variables for it to work :-(
*/
class PHPLensExportExcel extends PHPLensExportText { 
	
	function PHPLensExportExcel(&$lens)
	{
	global $LENS_EXCEL;

		if (empty($LENS_EXCEL)) $LENS_EXCEL = new PhpSimpleXlsGen(); 
		PHPLensExportText::PHPLensExportText($lens);
	}
		
	function &Fetch($file)
	{
	global $LENS_EXCEL;

		if ($file == 'L') {
			if (headers_sent()) print "<h1>Error, headers sent</h1>";
			else {
				$LENS_EXCEL->filename = 'test';
			//	$LENS_EXCEL->End(); 
			//	print $LENS_EXCEL->xls_data; 
				
				$LENS_EXCEL->SendFile();
				die();
			}
		} else {
			$LENS_EXCEL->totalcol = sizeof($this->vars);
			foreach($this->vars as $k=>$v) {
				if (is_numeric($v)) $LENS_EXCEL->InsertNumber((double)$v);
				else $LENS_EXCEL->InsertText($v);
			}
			return '';
		}
	}
}

?>