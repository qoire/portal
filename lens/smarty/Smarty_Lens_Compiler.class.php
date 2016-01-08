<?php

include_once dirname(__FILE__).'/Smarty_Compiler.class.php';

Global $Lens_SmartyVars;
$Lens_SmartyVars = false;
class Smarty_Lens_Compiler extends Smarty_Compiler {
var $_vars = array();

	function _compile_file($tpl_file, $template_source, &$template_compiled)
	{
	Global $Lens_SmartyVars;
	
		$rez = parent::_compile_file($tpl_file,$template_source,&$template_compiled);
		$Lens_SmartyVars = $this->_vars;
		return $rez;
	}

	/*function _parse_conf_var($conf_var_expr) {

		$parts = explode('|', $conf_var_expr, 2);
	    $var_ref = $parts[0];
	    $modifiers = isset($parts[1]) ? $parts[1] : '';
	
	    $var_name = substr($var_ref, 1, -1);
		print " v=$var_name ";
		
	
	    $output = "\$this->_config[0]['$var_name']";
	
	    $this->_parse_modifiers($output, $modifiers);
	
	    return $output;
	}*/
	
	function _parse_var($var_expr)
    {
        $parts = explode('|', substr($var_expr, 1), 2);
        $var_ref = $parts[0];
        $modifiers = isset($parts[1]) ? $parts[1] : '';

        preg_match_all('!\[\w+(\.\w+)?\]|(->|\.)\w+|^\w+!', $var_ref, $match);
        $indexes = $match[0];
        $var_name = array_shift($indexes);
		if (empty($this->_vars[$var_name]))$this->_vars[$var_name] = 1;
		else  $this->_vars[$var_name] += 1;
        $output = "\$this->_tpl_vars['$var_name']";

        foreach ($indexes as $index) {
            if ($index{0} == '[') {
                $parts = explode('.', substr($index, 1, -1));
                $section = $parts[0];
                $section_prop = isset($parts[1]) ? $parts[1] : 'index';
                $output .= "[\$this->_sections['$section']['properties']['$section_prop']]";
            } else if ($index{0} == '.') {
                $output .= "['" . substr($index, 1) . "']";
            } else {
                $output .= $index;
            }
        }

        $this->_parse_modifiers($output, $modifiers);

        return $output;
    }
};

?>