<?php

# http://zend.com/codex.php?id=276&single=1 by SolFolango 

# This script formats a xml file according to some rules. These rules  
# are processed in the function that xml_set_character_data_handler 
# defines. We have to remember, in which element we are, and furthermore, 
# which ancestor elements the current element has. 

/*
With this easy to use classes (Node and XML) you can parse a XML file into a 
tree-equivalent instead of using the event-based parsing that PHP provides. 
All nodes (=elements) are inserted in an array, with data and attributes stored. 
This array can be then accessed. As an example, I wrote a function "print_nodes()" 
that prints the nodes in a nicely formatted way (similar to what IE5.5 does, when 
it encounters a XML file). Based on this example, you should easily work with the 
class (extending it). I hope, there are enough comments on this. Ah, forgot to 
mention: The print_nodes() can be formated with the vars $format_X in the XML-class. 
There are formatting possibilities for the element name, attributes, attribute values, 
the brackets, the identation etc. Fixed in v0.2 Node-print_name bug. 
*/

class LensXMLNode { 
    var $name; 
    var $attributes = ''; 
    var $ancestors = "/";
    var $data = ''; 
    var $type; 

    function LensXMLNode($tree) { 
        $this->name = array_pop($tree); 
        $this->ancestors .= implode("/", $tree); 
    } 

    function add_data($value) { 
        $this->data .= $value; 
    } 

    function get_type() { 
        if (strlen($this->data) > 0) { 
            return "with CDATA"; 
        } else { 
            return "without CDATA";
        } 
    } 

    function level() { 
        if ($this->ancestors == "/") return 0; 
      if (preg_match_all("/(\/{1})/", $this->ancestors, $result,PREG_PATTERN_ORDER)) { 
        return (count($result[0])); 
      } else { 
        return 0; 
        } 
    } 

    function has_attributes() { 
        return (is_array($this->attributes)); 
    } 

    function print_name() { 
        return "$this->name"; 
    } 
     
    function is_child($node) { 
        $result = preg_match("/^$ancestors/", $node->ancestors, $match); 
        if ($node->ancestors == $this->ancestors) $result = false; 
        return $result; 
    } 
} 

class LensXML { 
    var $file; 
    var $tree = array(); 
    var $nodes = array(); 
    var $PIs; 
    var $format_body = "font-family:Verdana;font-size:10pt;" ;
    var $format_bracket = "color:blue;" ;
    var $format_element = "font-family:Verdana;font-weight:bold;font-size:10pt;"; 
    var $format_attribute = "font-family:Courier;font-size:10pt;" ;
    var $format_data = "font-size:12pt;"; 
    var $format_attribute_name = "color:#444444;";
    var $format_attribute_value = "font-family:Courier;font-size:10pt;color:red;"; 
    var $format_blanks = "&nbsp;&nbsp;&nbsp;"; 
	var $skipEnd = true;
	
    function LensXML($filename) { 
        $this->file = $filename; 
        $xml_parser = xml_parser_create(); 
        xml_set_object($xml_parser,$this); 
        xml_set_element_handler($xml_parser, "startElement", "endElement"); 
        xml_set_character_data_handler($xml_parser, "characterData"); 
        xml_set_processing_instruction_handler ($xml_parser, "process_instruction"); 
 		# Why should one want to use case-folding with XML? 
 		# XML is case-sensitiv, I think this is nonsense 
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false); 
     
	 	if ($filename[0] == '<') {
		
			if (!xml_parse($xml_parser,$filename,false)){
				LensDie(sprintf("XML error: %s at line %d\n", 
	              xml_error_string(xml_get_error_code($xml_parser)), 
	              xml_get_current_line_number($xml_parser)),'XML'); 
	          } 
		} else {
	        if (!($fp = @fopen($this->file, "r"))) { 
	            LensDie("Couldn't open file: $this->file\n",'XML'); 
	        } 

	        while ($data = fread($fp, 4096)) { 
	          if (!xml_parse($xml_parser, $data, feof($fp))) { 
	            LensDie(sprintf("XML error: %s at line %d\n", 
	              xml_error_string(xml_get_error_code($xml_parser)), 
	              xml_get_current_line_number($xml_parser)),'XML'); 
	          } 
	        }   // while fread
			fclose($fp);
		} // is file
	
    } 

    function startElement($parser, $name, $attribs) { 
        # Adding the additional element to the tree, including attributes 
        $this->tree[] = $name; 
        $node = new LensXMLNode($this->tree); 
        while (list($k, $v) = each($attribs)) { 
            $node->attributes[$k] = $v; 
      } 
        $this->nodes[] = $node; 
    } 

    function endElement($parser, $name) { 
        # Adding a new element, describing the end of the tag 
        # But only, if the Tag has CDATA in it! 
         
        # Check 
        if (!$this->skipEnd && count($this->nodes) >= 1) { 
            $prev_node = $this->nodes[count($this->nodes)-1]; 
            if (strlen($prev_node->data) > 0 || $prev_node->name != $name) { 
                $this->tree[count($this->tree)-1] = "/".$this->tree[count($this->tree)-1]; 
                $this->nodes[] = new LensXMLNode($this->tree, NULL); 
            } else { 
                # Adding a slash to the end of the prev_node 
                $prev_node->name = $prev_node->name."/"; 
                $this->nodes[count($this->nodes)-1]->name = 
			$this->nodes[count($this->nodes)-1]->name."/" ;
            } 
        } 

        # Removing the element from the tree 
        array_pop($this->tree); 
    } 

    function characterData($parser, $data) { 
        $data = ltrim($data); 
        if ($data != "") $this->nodes[count($this->nodes)-1]->add_data($data); 
    } 
     
    function process_instruction($parser, $target, $data) { 
        if (preg_match("/xml:stylesheet/", $target, $match) 
		&& preg_match("/type=\"text\/xsl\"/", $data, $match)) { 
            preg_match("/href=\"(.+)\"/i", $data, $this->PIs); 
#            print "<b>found xls pi: $PIs[1]</b><br>\n" 
        } 
    } 

    function print_nodes() { 
        # Printing the header 
        print "<html><head><title>".$this->nodes[0]->name."</title></head>" ;
        print "<body style=\"".$this->format_body."\">\n" ;

        # Printing the XML  Data 
        for ($i = 0; $i < count($this->nodes); $i++) { 
            $node = $this->nodes[$i]; 
             
            # Checking: Empty element 
            if ($node->name[strlen($node->name)-1] == "/") { 
                $end_char = "/"; 
                $node->name = substr($node->name, 0, strlen($node->name)-1); 
            } else { 
                $end_char = ""; 
            } 
             
            # Writing whitespaces, but only if it's _no_ closing element that follows 
            # directly on it's opening element 
            if ($i > 0 && !("/".$this->nodes[$i-1]->name == $node->name)) { 
                for ($j = 0; $j < $node->level(); $j++) echo $this->format_blanks; 
            } 
            echo "\n<span style=\"".$this->format_bracket."\">&lt;</span><span style=\"".
	    	$this->format_element."\">".
	    	$node->name."</span>" ;
            if ($node->has_attributes()) { 
                $keys = array_keys($node->attributes); 
                for ($j = 0; $j < count($keys); $j++) { 
                    printf(" <span style=\"%s\">%s=\"</span><span style=\"%s\">%s</span><span style=\"%s\">\"</span>",
		    	 $this->format_attribute_name, $keys[$j], $this->format_attribute_value, 
			 $node->attributes[$keys[$j]], $this->format_attribute_name); 
                } 
                echo " "; 
            } 

            echo "<span style=\"".$this->format_element."\">$end_char</span><span style=\"".
	    	$this->format_bracket."\">&gt;</span>"; 

            if (strlen($node->data) > 0) 
	    	echo "<span style=\"".$this->format_data."\">".ltrim($node->data)."</span>"; 
            else echo "<br>\n"; 
        } 

        # Printing the footer 
        print "</body></html>\n" ;
    } 
} 

/*
	function Lens_Array2XML($arr,$tarr=false,$rootname='ROW')
	{
		$s = '<?xml version="1.0"?>';
		$s .= "\n<$rootname>\n";
		foreach($arr as $k => $v) {
			if (isset($tarr[$k])) $t= ' t="'.$tarr[$k].'"';
			else $t = '';
			$s .= "  <E$k$t>$v</E$k>\n";
		}
		$s .= "</$rootname>\n";
		return $s;
	}
*/
	
?>