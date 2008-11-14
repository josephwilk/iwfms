<?

/* class formstyle {{{ */
/**
 * Form input style functions
 * Functions that define different styles for output of form elements.
 * This is where the HTML should live. Minimal logic should be used but again the line blurs here so some is acceptable.
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package forminputs
 */
/* }}} */

class formstyle{

	
	/**
	* @return void
	* @desc display text 'none' when empty parameters are passed
	*/
	function input_emptyparameter(){
		
		echo '<i>None</i>';	
	}



/**
	Select box style functions
	Formatting data for select boxes

*/

	/**
	* @return void
	* @param Array $selectbar
	* @desc default formatting for select box options
	*/
	function select_default($selectbar){
	
		echo '<option value="' . $selectbar['value'] . '"';
		if($selectbar['match']){
			echo ' selected';
		}
		echo '>' . $selectbar['displayvalue'] . '</option>' . "\n";
	}


	/**
	* @return void
	* @param Array $selectbar
	* @desc replace with space formatting for select box options
	*/
	function select_extra_space($selectbar){
		
		$selectbar['displayvalue'] = preg_replace('/&%&/',' ',$selectbar['displayvalue']);
		echo '<option value="' . $selectbar['value'] . '"';
		if($selectbar['match']){
			echo ' selected';
		}
		echo '>' . $selectbar['displayvalue'] .'</option>' . "\n";
	}



//	Text box and text area style functions
//	Formatting data for text boxes and text areas


	/**
	* @return void
	* @param Array $text
	* @desc  default text box
	*/
	function text_default($text){
	
		echo '<input type="text" name="' . $text['name'] . '" value="' . $text['value'] . '">';
	}


	

	/**
	* @return void
	* @param unknown $text
	* @param unknown $class
	* @param unknown $width
	* @param unknown $extra
	* @desc text box with maxlength set and class / extra properties capability
	*/
	function text_extra_default($text,$class,$width,$extra){

		echo '<input type="text" name="' . $text['name'] . '" value="' . $text['value'] . '" maxlength="' . $text['fieldlen'] . '" style="width: ' . $width . 'px"';
		if($class){
			echo ' class="' . $class . '"'; 
		}
		if(!is_int($extra)){ 
			echo ' ' . $extra;
		} 
		echo '>';
	}


	/**
	* @return void
	* @param Array $text
	* @desc display a password text box
	*/
	function text_password($text){
	
		echo '<input type="password" name="' . $text['name'] . '" value="' . $text['value'] . '">';
	}


	

	/**
	* @return void
	* @param unknown $text
	* @param unknown $class
	* @param unknown $width
	* @param unknown $extra
	* @desc password text box with maxlength set and class / extra properties capability
	*/
	function text_extra_password($text,$class,$width,$extra){
	
		echo '<input type="password" name="' . $text['name'] . '" value="' . $text['value'] . '" maxlength="' . $text['fieldlen'] . '" style="width: ' . $width . 'px"';
		if($class){
			echo ' class="' . $class . '"';
		}
		if($extra){
			echo ' ' . $extra;
		} 
		echo '>';
	}


	/**
	* @return void
	* @param Array $text
	* @desc display a readonly textbox
	*/
	function text_readonly($text){
	
		echo '<input type="text" readonly name="' . $text['name'] . '" value="' . $text['value'] . '">';
	}


	/**
	* @return void
	* @param unknown $text
	* @desc default text area 
	*/
	function textarea_default($text){
	
		echo '<textarea rows="5" cols="45" name="' . $text['name'] . '">' . $text['value'] . '</textarea>';
	}


	/**
	* @return void
	* @param unknown $text
	* @param unknown $rows
	* @param unknown $width
	* @desc  textarea with configurable rows and width
	*/
	function textarea_extra_default($text,$rows,$width){
	
		echo '<textarea rows="' . $rows . '" style="width: ' . $width . 'px" name="' . $text['name'] . '">' . $text['value'] . '</textarea>';
	}



//	Checkbox style functions
//	Formatting data for check boxes



	

	/**
	* @return void
	* @param Array $checkbox
	* @desc default formatting for checkbox
	*/
	function checkbox_default($checkbox){
		
		echo '<input type="checkbox" name="' . $checkbox['name'] . '" value="' . $checkbox['value'] . '"';
		if($checkbox['match']){
			echo ' checked';
		}
		echo '> ' . $checkbox['displayvalue'];
	}


	/**
	* @return void
	* @param Array $checkbox
	* @desc formatting for checkboxes with <br>s after displayvalue
	*/
	function checkbox_brs($checkbox){
		
		echo '<input type="checkbox" name="' . $checkbox['name'] . '" value="' . $checkbox['value'] . '"';
		if($checkbox['match']){
			echo ' checked';
		}
		echo '> ' . $checkbox['displayvalue'] . '<br>';
	}



//	Radio button style functions
//	Formatting data for radio buttons


	/**
	* @return void
	* @param unknown $radiobtn
	* @desc display default radio button
	*/
	function radiobtn_default($radiobtn){
	
		echo '<input type="radio" name="' . $radiobtn['name'] . '" value="' . $radiobtn['value'] . '"'; if($radiobtn['match']){
			echo ' checked';
		}
		echo '> ' . $radiobtn['displayvalue'];
	}
	
	
	/**
	* @return void
	* @param unknown $radiobtn
	* @param unknown $extra
	* @desc radio button with room for extra details
	*/
	function radiobtn_default_extra($radiobtn,$extra){
	
		echo '<input type="radio" name="' . $radiobtn['name'] . '" value="' . $radiobtn['value'] . '"';
		if($radiobtn['match']){
			echo ' checked';
		}
		if($radiobtn['extra']){
			echo ' ' . $extra;
		}
		echo '> ' .$radiobtn['displayvalue'];
	}


	/**
	* @return void
	* @param Array $radiobtn
	* @desc display radio buttons with <br>s
	*/
	function radiobtn_brs($radiobtn){
	
		echo '<input type="radio" name="' . $radiobtn['name'] . '" value="' . $radiobtn['value'] . '"';
		if($radiobtn['match']){
			echo "checked";
		}
		echo '> ' . $radiobtn['displayvalue'] . '<br>';
	}

		


//	Miscallaneous formatting functions
//	Specific/complex style for input structures


	

	/**
	* @return void
	* @param unknown $btn
	* @desc display a button
	*/
	function btn_default($btn){
	
		echo '<input type="' . $btn['type'] . '" name="' . $btn['name'] . '" value="' . $btn['value'] . '"';
		if($btn['onclick']){
			echo ' onclick="' . $btn['onclick'] . '"'; 
		}
		echo '>';
	}

}
		
?>